<?php
//This action happens after manager clicks on "close session" button.
//note that this file is only for manager to close voting period.
//The authority will be checked immediately.

include_once 'include/conn.php';
session_start();

$role = $_SESSION['authority']; //manager, admin, user; here it only can be manager

if ($role != "manager"){
	echo "<script>alert('Sorry, but you have to be one of the project managers to close a voting period!');</script>";
	echo "<script language='javascript'>window.location.href='setup.html';</script>";	//debug: go where??
}

$managerName = $_SESSION['username'];
$sql = "SELECT * FROM ProjMem WHERE member='".$managerName."'";
$rst = $conn->execute($sql);
$projName = $rst->fields['project'];

//-------update last assessment date-------------------
$lastAssessmentDate = date("Y-m-d");
$updateAssessDateSQL = "UPDATE Project SET lastAssessmentDate = '$lastAssessmentDate' WHERE projectname='$projName'";		//debug: check the type of closed. update the last assessment date and close the voting session
$updateAssessDateRST = $conn->execute($updateAssessDateSQL);

//-------UPDATE the info in ProjRiskDesc, do calculations here-----------
$sql1 = "select * from ProjRiskDesc";	//get all the rows in ProjRiskDesc, where (projName, riskName) is unique.
$rst1 = $conn->execute($sql1);

while (!$rst1->EOF) {	//for every row in ProjRiskDesc
	$projName = $rst1->fields['projName'];
	$riskName = $rst1->fields['riskName'];
	
	//copy lastRE to lastButOneRE
	$lastRE = $rst1->fields['lastRE'];
	$updateLastButOneRE = "UPDATE ProjRiskDesc SET lastButOneRE = '$lastRE' WHERE projName='$projName' AND riskName='$riskName'";	//copy lastRE to lastButOneRE
	$updateLastButOneRERST = $conn->execute($updateLastButOneRE);
	
	//for each (projName, riskName), look up in IndividualVote, then do calculation.
	$sql2 = "SELECT * FROM IndividualVote WHERE projName='$projName' AND riskName='$riskName'";
	$rst2 = $conn->execute($sql2); //this returns multiple rows, each row is for one stakeholder with specific (projName, riskName)
	$counter = 0; //this counts the number of users for a particular (projName, riskName) in IndividualVote
	$PUOsum = 0;
	$LUOsum = 0;
	$lastREsum = 0;
	
	while (!$rst2->EOF){	//for every row in IndividualVote with particular (projName, riskName)
		$PUO = $rst2->fields['PUO'];
		$LUO = $rst2->fields['LUO'];
		
		$PUOsum = $PUOsum + $PUO;
		$LUOsum = $LUOsum + $LUO;
		$lastREsum = $lastREsum + $PUO * $LUO;
		
		if ($PUO != 0 && $LUO != 0){	//not counting those who astains voting on a risk item or those who has not voted yet.
			$counter = $counter + 1;	
		}
		
		$rst2->movenext();
	}
	
	if ($counter != 0){
		$averagePUO = $PUOsum / $counter;
		$averageLUO = $LUOsum / $counter;
		$averageLastRE = $lastREsum / $counter;
	}
	else {
		$averagePUO = 0;
		$averageLUO = 0;
		$averageLastRE = 0;		
	}
	
	$sql3 = "UPDATE ProjRiskDesc SET lastRE='$averageLastRE', averagePUO='$averagePUO', averageLUO='$averageLUO' WHERE projName='$projName' AND riskName='$riskName'";
	$updateProjRiskDesc = $conn->execute($sql3);	//update for a particular (projName, riskName) in ProjRiskDesc
	
	$rst1->movenext();	//move on to the next (projName, riskName) in ProjRiskDesc
}

	echo "<script>alert('Voting session closed. Now you can click on View Results to see the voting result.');</script>";
	echo "<script language='javascript'>window.location.href='about.html';</script>";	//debug: go where??

?>