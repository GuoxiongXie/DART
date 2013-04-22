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
		header('Location: Viewresults.php');	
	}
	else if ($role == "user"){
		header('Location: Viewresults.php');
	}
	else {	//TA
		header('Location: Viewresults.php');
	}
}
?>
