<?php
session_start();
include_once 'include/conn.php';

$username = $_POST['name'];
$password = $_POST['pw'];
$projname = $_SESSION['project'];
$role = $_POST['Stakeholder'];

$cPassword = md5($password);
if ($role == 'sm') {
	$sql = "insert into Manager(name, pwd) values ('$username', '$cPassword')";
	$rst = $conn->execute($sql);
	if($rst==false) {
		//echo "<script>alert('Fail');window.history.back(-1);</script>";
		echo "<script language='javascript'>alert('Fail!');</script>";
		echo "<script language='javascript'>window.location.href='addstakeholderFrontEnd.php';</script>";
	}
	
	$sql = "insert into ProjMem(project, member) values ('$projname', '$username')";
	$rst = $conn->execute($sql);
	if($rst==false) {
		//echo "<script>alert('Fail');window.history.back(-1);</script>";
		echo "<script language='javascript'>alert('Fail!');</script>";
		echo "<script language='javascript'>window.location.href='addstakeholderFrontEnd.php';</script>";
	}
	echo "<script language='javascript'>alert('Success!');</script>";
	echo "<script language='javascript'>window.location.href='Manager_setup.html';</script>";
}
else if ($role == 'sn') {
	$sql = "insert into RegularUser(name, pwd) values ('$username', '$cPassword')";
	$rst = $conn->execute($sql);
	if($rst==false) {
		//echo "<script>alert('Fail');window.history.back(-1);</script>";
		echo "<script language='javascript'>alert('Fail!');</script>";
		echo "<script language='javascript'>window.location.href='addstakeholderFrontEnd.php';</script>";
	}
	
	$sql = "insert into ProjMem(project, member) values ('$projname', '$username')";
	$rst = $conn->execute($sql);
	if($rst==false) {
		//echo "<script>alert('Fail');window.history.back(-1);</script>";
		echo "<script language='javascript'>alert('Fail!');</script>";
		echo "<script language='javascript'>window.location.href='addstakeholderFrontEnd.php';</script>";
	}
	echo "<script language='javascript'>alert('Success!');</script>";
	echo "<script language='javascript'>window.location.href='Manager_setup.html';</script>";
}

?>