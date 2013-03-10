<?php
//This adminLogin.php is only for admin log in. For manager and TA login, see login.php
session_start();

include_once 'include/conn.php';

/*process the login request and store the necessary information
*/

$username = $_POST['username'];	//debug: make sure the name in the submit form matches
$password = $_POST['password']; //debug: make sure the name in the submit form matches

$pwdmd5 = md5($password);
$sql = "select * from SysAdmin where name='".$username."' and pwd='".$pwdmd5."'";
$rst=$conn->Execute($sql) or die($conn->errrorMsg());
if($rst->RecordCount() == 1)
{
	$_SESSION['username'] = $username;
    $_SESSION['authority'] = "admin";
	header("location:adminSetUpProj.html");	//debug: make sure the front end page name matches. Change the file name of TAsetup.html to adminSetUpProj.html
}
else
{
	echo "<script language='javascript'>alert('Incorrect Username OR Password!');</script>";
	echo "<script language='javascript'>window.location.href='login.html';</script>";
}