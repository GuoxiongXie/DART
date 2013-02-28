<?php
session_start();

include_once 'include/conn.php';

/*process the login request and store the necessary information
*/

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

if($role == "manager") {
	$pwdmd5 = md5($password);
	$sql = "select * from Manager where name='".$username."' and pwd='".$pwdmd5."'";
	$rst=$conn->Execute($sql) or die($conn->errrorMsg());
	if($rst->RecordCount() == 1)
	{
		$_SESSION['username'] = $username;
        $_SESSION['authority'] = "manager";
		header("location:setup.html");
	}
	else
	{
		echo "<script language='javascript'>alert('Incorrect Username OR Password!');</script>";
		echo "<script language='javascript'>window.location.href='login.html';</script>";
	}
}
else {
	$pwdmd5 = md5($password);
	$sql = "select * from RegularUser where name='".$username."' and pwd='".$pwdmd5."'";
	$rst=$conn->Execute($sql) or die($conn->errrorMsg());
	if($rst->RecordCount() == 1)
	{
		$_SESSION['username'] = $username;
        $_SESSION['authority'] = "user";
        header("location:setup.html");		//debug: regular user should not be able to set up projects!!!
	}
	else
	{
		echo "<script language='javascript'>alert('Incorrect Username OR Password!');</script>";
		echo "<script language='javascript'>window.location.href='login.html';</script>";
	}
}
?>