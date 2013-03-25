<?php
session_start();
include_once 'include/conn.php';

$username = $_POST['name'];
if ($username == null) {
	echo "<script language='javascript'>alert('Please select a stakeholder before editing!');</script>";
	echo "<script language='javascript'>window.location.href='editstakeholder.php';</script>";
}
$newpwd = $_POST['pwd'];

$cnewped = md5($newpwd);
$sql = "update RegularUser set pwd = '$cnewpwd' where name = '$username'";
$rst = $conn->execute($sql);
if($rst==false) {
	echo "<script language='javascript'>alert('Fail!');</script>";
	echo "<script language='javascript'>window.location.href='editstakeholder.php';</script>";
}
else {
	//echo "<script>alert('Success');window.navigate(\"editstakeholder.php\");</script>";  //this is the original
	echo "<script language='javascript'>alert('Success!');</script>";
	echo "<script language='javascript'>window.location.href='setup.html';</script>";
}
?>