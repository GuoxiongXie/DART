<?php
//note that this file is only for admin to setup new proj; Manager can only modify the description of the proj, see managerModifyProjDescription.php
//session_start();
include_once 'include/conn.php';
//session_save_path('/Applications/XAMPP/htdocs/dartSession');	//this is the path to save session variables
session_start();

/*process the login request and store the necessary information
*/

$authority = (string)$_SESSION['authority'];
$authority = trim($authority);

//$projName = $_SESSION['project'];		//debug: $projName is empty!!!
//$projectname = $_POST['projectname'];

$projectdesc = $_POST['projectdesc'];

$username = (string)$_SESSION['username'];
$username = trim($username);
//echo "the username is ".$username;		//this one works
$sql1 = "SELECT project FROM ProjMem WHERE member = '$username'";
$proj=$conn->Execute($sql1) or die($conn->errorMsg());
//echo "proj is $proj"; //the output is "project Team 2 risk"
$proj = trim($proj);
//echo "shit is $proj";
$proj = substr($proj, 9);	//to remove the "project " part of $proj
//echo "shit is $proj";

//$sql1 = "insert into Project (projectname, projectdesc) values ('$projName', '$projectdesc')";
$sql2 = "UPDATE Project SET projectdesc = '".$projectdesc."' WHERE projectname = '$proj'";
//echo "query is ".$sql2;
$rst2=$conn->Execute($sql2) or die($conn->errorMsg());
//$sql2 = "insert into ProjMem (project, member) values ('$projectname', '$username')";
//$rst2=$conn->Execute($sql2) or die($conn->errorMsg());

if($rst2 == false)
{
	echo "<script>alert('Fail');</script>";
}
else
{
	echo "<script>alert('Success');</script>";
	//added the following line for Sprint I demo
	echo "<script language='javascript'>window.location.href='setup.html';</script>";
}
?>