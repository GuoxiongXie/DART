<?php
session_start();
include_once 'include/conn.php';

$riskname = $_POST['name'];
if ($riskname == null) {
	echo "<script language='javascript'>alert('Please select a project before deleting!');</script>";
	echo "<script language='javascript'>window.location.href='editrisks.php';</script>";
}
$sql = "delete from ProjRiskDesc where riskName = '$riskname'";
$rst = $conn->execute($sql);
if($rst==false) {
	//echo "<script>alert('Fail');window.history.back(-1);</script>";
	echo "<script language='javascript'>alert('Deletion Fails! Please try again!');</script>";
	echo "<script language='javascript'>window.location.href='editrisks.php';</script>";
}

//echo "<script>alert('Success');window.navigate(\"editstakeholder.php\");</script>";
echo "<script language='javascript'>alert('Deletion Success!');</script>";
echo "<script language='javascript'>window.location.href='setup.html';</script>";
?>