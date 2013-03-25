<?php
session_start();
include_once 'include/conn.php';

$projName = $_SESSION['project'];
$riskname = $_POST['name'];
if ($riskname == null) {
	echo "<script language='javascript'>alert('Please select a project before editing!');</script>";
	echo "<script language='javascript'>window.location.href='editrisks.php';</script>";
}
	
$riskDesc = $_POST['riskdesc'];
if ($riskDesc == "") {
	echo "<script language='javascript'>alert('Please enter the risk description!');</script>";
	echo "<script language='javascript'>window.location.href='editrisks.php';</script>";
}

$sql = "UPDATE ProjRiskDesc SET riskDesc='$riskDesc' WHERE projName='$projName' AND riskName='$riskname'";

$rst = $conn->execute($sql);
if($rst==false) {
	//echo "<script>alert('Fail');window.history.back(-1);</script>";
	echo "<script language='javascript'>alert('Risk Description Update Fails! Please try again!');</script>";
	echo "<script language='javascript'>window.location.href='editrisks.php';</script>";
}

//echo "<script>alert('Success');window.navigate(\"editstakeholder.php\");</script>";
echo "<script language='javascript'>alert('Risk Description Update Successful!');</script>";
echo "<script language='javascript'>window.location.href='setup.html';</script>";
?>