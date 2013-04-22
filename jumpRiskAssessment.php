<?php
include_once 'include/conn.php';
session_start();

$role = $_SESSION['authority']; //manager, admin, user; here it only can be manager

if ($role == null){
	echo "<script language='javascript'>alert('Please log in on the upper-right corner');</script>";
	echo "<script language='javascript'>window.location.href='about.html';</script>";
}
else { //already login; check role
	if ($role == "manager"){
		header('Location: RiskAssessment.html');	
	}
	else if ($role == "user"){
		header('Location: RiskAssessment.html');
	}
	else {	//TA
		echo "<script language='javascript'>alert('Sorry but you have to be a manager or member in the project to vote');</script>";
		echo "<script language='javascript'>window.location.href='about.html';</script>";
	}
}
?>
