<?php
//This action happens after manager clicks on "close Voting Period" in the navigation bar on the left.
//Note that this file is only for manager to close voting period.
//The authority will be checked immediately.

include_once 'include/conn.php';
session_start();

$role = $_SESSION['authority']; //manager, admin, user; here it only can be manager

if ($role != "manager"){
	echo "<script>alert('Sorry, but you have to be one of the project managers to close a voting period!');</script>";
	echo "<script language='javascript'>window.location.href='setup.html';</script>";	//debug: go where??
}

$managerName = $_SESSION['username'];
$sql = "SELECT * FROM ProjMem WHERE member='".$managerName."'";
$rst = $conn->execute($sql);
$projName = $rst->fields['project'];
$today = date("Y-m-d");

//get the current last assessment date. Debug: This session of code probably include in html on next page to get the date to be displayed (should also include some code from above).
$getLastAssessmentDate = "SELECT * FROM Project WHERE projectname='$projName'";
$getLastAssessmentDateRST = $conn->execute($getLastAssessmentDate);
$curLastAssessmentDate = $getLastAssessmentDateRST->fields['lastAssessmentDate'];

//two things can happen after pressing "close Voting Period" in the navigation bar on the left.
//1. Last assessment date is not today, then allow the manager to close session.
if (strcmp($curLastAssessmentDate, $today) != 0) {	//not the same day
	header("location:closeVotingPeriodPage.php");	//debug: make sure the name is correct
}
//2. Last assessment date is today, then display "A voting session has already been closed today".
else {	//the same day
	header("location:votesHaveBeenClosedPage.php");	//debug: make sure the name is correct.
}


?>