<?php
//This login.php is only for manager and regular user. For admin/TA login, see adminLogin.php
include_once 'include/conn.php';
//session_save_path('/Applications/XAMPP/htdocs/dartSession');	//this is the path to save session variables
session_start();


/*process the login request and store the necessary information
*/

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

if($role == "manager") {
	$pwdmd5 = md5($password);
	$sql = "select * from Manager where name='".$username."' and pwd='".$pwdmd5."'";
	$rst=$conn->Execute($sql) or die($conn->errorMsg());
	if($rst->RecordCount() == 1)
	{
		$_SESSION['username'] = $username;
        $_SESSION['authority'] = "manager";
		
		//get the proj info and store in session for later use
		$findProjQuery = "SELECT project FROM ProjMem WHERE member='".$username."'";
		$projName=$conn->Execute($findProjQuery) or die($conn->errorMsg());
		//echo gettype($projName);
		//$_SESSION['project'] = $projName;	//this does not work in later pages. debug: this is the original.
		$_SESSION['project'] = $projName->fields['project'];
		
		
		header("location:Manager_setup.html");		//debug: setup is the main page
	}
	else
	{
		echo "<script language='javascript'>alert('Incorrect Username OR Password!');</script>";
		echo "<script language='javascript'>window.location.href='login.html';</script>";
	}
}
else {	//regular user login
	$pwdmd5 = md5($password);
	$sql = "select * from RegularUser where name='".$username."' and pwd='".$pwdmd5."'";
	$rst=$conn->Execute($sql) or die($conn->errorMsg());
	if($rst->RecordCount() == 1)
	{
		$_SESSION['username'] = $username;
        $_SESSION['authority'] = "user";	//"user" means regular user
        
        //get the proj info and store in session for later use
		$findProjQuery = "SELECT project FROM ProjMem WHERE member='".$username."'";
		$projName=$conn->Execute($findProjQuery) or die($conn->errorMsg());
		//echo gettype($projName);
		//$_SESSION['project'] = $projName;	//this does not work in later pages. debug: this is the original.
		$_SESSION['project'] = $projName->fields['project'];
        
        header("location:user_setup.html");		//debug: regular user should not be able to set up projects!!!
	}
	else
	{
		echo "<script language='javascript'>alert('Incorrect Username OR Password!');</script>";
		echo "<script language='javascript'>window.location.href='login.html';</script>";
	}
}
?>