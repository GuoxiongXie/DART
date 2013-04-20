<?php
//This action happens after manager clicks on "close session" button.
//note that this file is only for manager to close voting period.
//The authority will be checked immediately.

include_once 'include/conn.php';
session_start();

$role = $_SESSION['authority']; //manager, admin, user; here it only can be manager

if ($role != "manager"){
	echo "<script>alert('Sorry, but you have to be one of the project managers to close a voting period!');</script>";
	echo "<script language='javascript'>window.location.href='setup.html';</script>";	//debug: go where??
}

$managerName = $_SESSION['username'];	//get the name of manager, this managerName can actually be username too
//$sql = "select * from RegularUser where name='".$username."' and pwd='".$pwdmd5."'";
$findProjQuery = "SELECT project FROM ProjMem WHERE member='".$managerName."'";
$strangeProjName = $conn->Execute($findProjQuery) or die($conn->errrorMsg()); //debug: the output is actually "project sth".
$projName = trim(substr($strangeProjName, 8)); //get the actual input name, trim removes all the whitespaces in the front and at the end


$riskName = $_POST['riskName'];	//debug: make sure this names are correct in the front end form
$riskDesc = $_POST['riskDesc'];	//debug: make sure this names are correct in the front end form

//insert a new risk to table ProjRiskDesc
$sql1 = "insert into ProjRiskDesc (projName, riskName, riskDesc) values ('$projName', '$riskName', '$riskDesc')";
$rst1=$conn->Execute($sql1) or die($conn->errorMsg());


?>