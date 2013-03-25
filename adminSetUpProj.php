<?php
//note that this file is only for admin to setup new proj; Manager can only modify the description of the proj, see managerModifyProjDescription.php
//session_save_path('/Applications/XAMPP/htdocs/dartSession');	//this is the path to save session variables
session_start();

include_once 'include/conn.php';

/*process the login request and store the necessary information
*/

$projectName = $_POST['projectName'];
$projectDesc = $_POST['projectDesc'];	
$assignedManager = $_POST['managerName'];

$managerPassword = $_POST['managerPassword'];
$encriptedManPwd = md5($managerPassword);	

$confirmManPwd = $_POST['confirmManPwd'];

//$userName = $_SESSION['username'];
//if($managerPassword != $confirmManPwd)
//{
	//echo "<script language='javascript'>alert('Password and confirm password fields are not matched');</script>";
	//echo "<script language='javascript'>window.location.href='adminSetUpProj.html';</script>";	//debug: change the name of the front end page 
//}


//create a new project
$sql1 = "insert into Project (projectname, projectdesc) values ('$projectName', '$projectDesc')";
$rst1=$conn->Execute($sql1) or die($conn->errorMsg());

//associate the proj with the manager
$sql2 = "insert into ProjMem (project, member) values ('$projectName', '$assignedManager')";
$rst2=$conn->Execute($sql2) or die($conn->errorMsg());

//create an account for the manager
$sql3 = "INSERT INTO Manager (name, pwd) VALUES ('$assignedManager', '$encriptedManPwd')";
$rst3 = $conn->Execute($sql3) or die($conn->errorMsg());

if(($rst1 == false) || ($rst2 == false) || ($rst3 == false))
{
	echo "<script>alert('Sorry! Project Setup Fails! Please try again!');</script>";
	echo "<script language='javascript'>window.location.href='adminSetUpProj.html';</script>";
}
else
{
	echo "<script>alert('A New Project Has Been Set Up! Now you can setup another one or log out!');</script>";
	//added the following line for Sprint I demo
	echo "<script language='javascript'>window.location.href='adminSetUpProj.html';</script>"; //debug:where should I direct this to?
}
?>