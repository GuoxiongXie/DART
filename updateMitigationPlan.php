<?php
session_start();
include_once 'include/conn.php';

$projName = $_SESSION['project'];
$riskname = $_POST['name'];
if ($riskname == null) {
	echo "<script language='javascript'>alert('Please select a project before updating!');</script>";
	echo "<script language='javascript'>window.location.href='editrisks.php';</script>";
}
	
$plan = $_POST['plan'];
$updateTime = date("Y-m-d");

$sql = "UPDATE ProjRiskDesc SET mitigation='$plan', mitigationUpdateTime='$updateTime' WHERE projName='$projName' AND riskName='$riskname'";

$rst = $conn->execute($sql);
if($rst==false) {
	//echo "<script>alert('Fail');window.history.back(-1);</script>";
	echo "<script language='javascript'>alert('Mitigation Update Fails! Please try again!');</script>";
	echo "<script language='javascript'>window.location.href='editrisks.php';</script>";
}

//echo "<script>alert('Success');window.navigate(\"editstakeholder.php\");</script>";
echo "<script language='javascript'>alert('Mitigation Update Successful!');</script>";
echo "<script language='javascript'>window.location.href='Manager_setup.html';</script>";
?>