<?php
//This action happens after users press save votes after entering their votes. The info they entered will be updated to IndividualVote.

include_once 'include/conn.php';
session_start();

$role = $_SESSION['authority']; //manager, admin, user; here it only can be manager

$userName = $_SESSION['username'];
$sql = "SELECT * FROM ProjMem WHERE member='".$userName."'";
$rst = $conn->execute($sql);
$projName = $rst->fields['project'];
//echo "the projName is ".$projName;
//echo "      ";

$sql1 = "SELECT * FROM ProjRiskDesc WHERE projName='".$projName."'";	//this returns many rows since many risks
$rst1 = $conn->execute($sql1);
//echo "the rst1 is ".$rst1;

while (!$rst1->EOF) {	//for every row in ProjRiskDesc
	$riskName = $rst1->fields['riskName'];
	//echo "the riskName is ".$riskName;
	
	//insert votes for (projName, riskName, userName)
	
	$arr = $_POST['arr'];
	
	$PUO = $arr["pvalue"][$riskName];
	
	$LUO = $arr["lvalue"][$riskName];
	
	$rationale = $arr["rationale"][$riskName];
	
	$updateVoteSQL = "UPDATE IndividualVote SET PUO='$PUO', LUO='$LUO', rationale='$rationale' WHERE projName='$projName' AND riskName='$riskName' AND userName='$userName'";
	//echo "the SQL is ".$updateVoteSQL;
	
	$updateRST = $conn->execute($updateVoteSQL);
	
	$rst1->movenext();	//move on to the next (projName, riskName) in ProjRiskDesc
}

//take the user back to main page
echo "<script language='javascript'>alert('Thanks for submitting your vote! Please check View Results later!');</script>";
echo "<script language='javascript'>window.location.href='about.html';</script>";

?>