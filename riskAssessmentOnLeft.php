<?php
//This action happens after manager or regular users clicks on "Risk Assessment" in the navigation bar on the left.
//This file can be integrated with html to generate ballot table! (maybe this file is included in html file??)
//The authority will be checked immediately.

include_once 'include/conn.php';
session_start();

$role = $_SESSION['authority']; //manager, admin, user; here it only can be manager

if ($role != "manager" && $role != "user"){
	echo "<script>alert('Sorry, but you have to be one of the project managers or regular users to vote!');</script>";
	echo "<script language='javascript'>window.location.href='setup.html';</script>";	//debug: go where?? This one should be for TA's
}

$username = $_SESSION['username'];
$sql = "SELECT * FROM ProjMem WHERE member='".$username."'";
$rst = $conn->execute($sql);
$projName = $rst->fields['project'];

//lookup (projName, riskName) in ProjRiskDesc
$sql1 = "SELECT * FROM ProjRiskDesc WHERE projName='".$projName."'";	//this returns many rows since many risks
$rst1 = $conn->execute($sql1);

while (!$rst1->EOF) {	//for every row in ProjRiskDesc
	//$projName = $rst1->fields['projName'];
	$riskName = $rst1->fields['riskName'];
	
	//look up member in ProjMem for the project
	$sql2 = "SELECT * FROM ProjMem WHERE project='$projName'";	//this returns many rows due to many members in a proj
	$rst2 = $conn->execute($sql2);
	
	while (!$rst2->EOF){	//for every row in ProjMem with particular projName
		$member = $rst2->fields['member'];
		
		//look up (projName, riskName, username) in IndividualVote, if no match, then insert it; if matched, do nothing.
		$sql3 = "SELECT * FROM IndividualVote WHERE projName='$projName' AND riskName='$riskName' AND userName='$member'";
		$rst3 = $conn->execute($sql3);
		
		if ($rst3->RecordCount() == 0){	//no matched, insert it
			$sql4 = "insert into IndividualVote (projName, riskName, userName) values ('$projName', '$riskName', '$member')";
			$rst4 = $conn->execute($sql4);
		}
		
		//do nothing if matched.
		
		$rst2->movenext();
	}
	
	
	$rst1->movenext();	//move on to the next (projName, riskName) in ProjRiskDesc
}


//The following function generates the Risk Assessment Ballot
function generateBallot() {
	global $conn;
	global $projName;	//$projName is the proj being voted on
	global $username;	//$username is who is voting
	
	$getRiskSQL = "SELECT * FROM ProjRiskDesc WHERE projName='".$projName."'";	//this returns many rows since many risks
	$getRiskRST = $conn->execute($getRiskSQL);
	
	$number = 1;	//used as the leftmost column in table
	while (!$getRiskRST->EOF) {	//for every row in ProjRiskDesc
		$riskItem = $getRiskRST->fields['riskName'];	
		
		//echo table here!!! Give each field a proper "name" to identify 
		//see http://www.phpsuperblog.com/php/create-a-html-form-with-php-for-loop-and-table/
		
		
		
		$number = $number + 1;
		$getRiskRST->movenext();	//move on to the next (projName, riskName) in ProjRiskDesc
	}
	
	//****this is an example for generating selection, remove below******
	echo "<select name=\"name\" size=\"2\">";
	while (!$rst->EOF) {
		echo "<option value=\"".$rst->fields['riskName']."\">".$rst->fields['riskName']."</option>";
		$rst->movenext();	//move down to next row in table
	}
	echo "</select>";
	//****this is an example for generating selection, remove above******
}

?>