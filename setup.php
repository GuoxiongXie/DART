<?php
session_start();

include_once 'include/conn.php';

/*process the login request and store the necessary information
*/

$projectname = $_POST['projectname'];
$projectdesc = $_POST['projectdesc'];
$username = $_SESSION['username'];

$sql1 = "insert into Project (projectname, projectdesc) values ('$projectname', '$projectdesc')";
$rst1=$conn->Execute($sql1) or die($conn->errorMsg());
$sql2 = "insert into ProjMem (project, member) values ('$projectname', '$username')";
$rst2=$conn->Execute($sql2) or die($conn->errorMsg());

if(($rst1 == false) || ($rst2 == false))
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