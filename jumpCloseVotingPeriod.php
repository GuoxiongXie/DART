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
		header('Location: closeVotingPeriodOnLeft.php');	
	}
	else if ($role == "user"){
		echo "<script language='javascript'>alert('Sorry but you have to be a manager to close a voting session');</script>";
		echo "<script language='javascript'>window.location.href='about.html';</script>";
	}
	else {	//TA
		echo "<script language='javascript'>alert('Sorry but you have to be a manager to close a voting session');</script>";
		echo "<script language='javascript'>window.location.href='about.html';</script>";
	}
}
?>
