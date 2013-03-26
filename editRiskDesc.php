<?php
session_start();
include_once 'include/conn.php';

$projName = $_SESSION['project'];
$riskname = $_POST['name'];


$newRiskName = $_POST['newRiskName'];	
$riskDesc = $_POST['riskdesc'];

//update the description before updating the risk name
$sql = "UPDATE ProjRiskDesc SET riskDesc='$riskDesc' WHERE projName='$projName' AND riskName='$riskname'";

$rst = $conn->execute($sql);
if($rst==false) {
	echo "<script language='javascript'>alert('Risk Description Update Fails! Please try again!');</script>";
	echo "<script language='javascript'>window.location.href='editrisks.php';</script>";
}



//now update the risk name
$sql = "UPDATE ProjRiskDesc SET riskName='$newRiskName' WHERE projName='$projName' AND riskName='$riskname'";

$rst = $conn->execute($sql);
if($rst==false) {
	echo "<script language='javascript'>alert('Risk Name Update Fails! Please try again!');</script>";
	echo "<script language='javascript'>window.location.href='editrisks.php';</script>";
}

echo "<script language='javascript'>alert('Risk Update Successful!');</script>";
echo "<script language='javascript'>window.location.href='setup.html';</script>";

//debug: for sprint 3, should change other tables too
?>