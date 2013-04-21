<?php
//This action happens after users press save votes after entering their votes. The info they entered will be updated to IndividualVote.

include_once 'include/conn.php';
session_start();

$role = $_SESSION['authority']; //manager, admin, user; here it only can be manager

$userName = $_SESSION['username'];
$sql = "SELECT * FROM ProjMem WHERE member='".$userName."'";
$rst = $conn->execute($sql);
$projName = $rst->fields['project'];

//get the riskName from table then "Update IndividualVote ...where projName=$projName AND riskName=$riskName AND userName=$userName"


?>