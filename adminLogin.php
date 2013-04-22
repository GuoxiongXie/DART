<?php
//This adminLogin.php is only for admin log in. For manager and TA login, see login.php
//session_save_path('/Applications/XAMPP/htdocs/dartSession');	//this is the path to save session variables
session_start();

include_once 'include/conn.php';

/*process the login request and store the necessary information
*/

$username = $_POST['username'];
$password = $_POST['password'];

$pwdmd5 = md5($password);
$sql = "select * from SysAdmin where name='".$username."' and pwd='".$pwdmd5."'";
$rst=$conn->Execute($sql) or die($conn->errrorMsg());
if($rst->RecordCount() == 1)
{
	$_SESSION['username'] = $username;
    $_SESSION['authority'] = "admin";
	header("location:TA_setup.html");	//sign in successfully, go to proj set up page
}
else
{
	echo "<script language='javascript'>alert('Incorrect Username OR Password!');</script>";
	echo "<script language='javascript'>window.location.href='adminSignUp.html';</script>";	//incorrect info entered, go back to sign in page
}