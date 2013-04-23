<?php
session_start();
include_once 'include/conn.php';

$username = $_POST['name'];
if ($username == null) {
	echo "<script language='javascript'>alert('Please select a stakeholder before editing!');</script>";
	echo "<script language='javascript'>window.location.href='editstakeholder.php';</script>";
}
$sql = "delete from RegularUser where name = '$username'";
$rst = $conn->execute($sql);
if($rst==false) {
	//echo "<script>alert('Fail');window.history.back(-1);</script>";
	echo "<script language='javascript'>alert('Fail!');</script>";
	echo "<script language='javascript'>window.location.href='editstakeholder.php';</script>";
}

$sql = "delete from projMem where member = '$username'";
$rst = $conn->execute($sql);
if($rst==false) {
	//echo "<script>alert('Fail');window.history.back(-1);</script>";
	echo "<script language='javascript'>alert('Fail!');</script>";
	echo "<script language='javascript'>window.location.href='editstakeholder.php';</script>";
}
//echo "<script>alert('Success');window.navigate(\"editstakeholder.php\");</script>";
echo "<script language='javascript'>alert('Success!');</script>";
echo "<script language='javascript'>window.location.href='Manager_setup.html';</script>";
?>