<?php
/* This code will make a connection with database */
session_start();

include_once 'include/conn.php';
//debug: For the submit form in the front end adminSignUp.html, the action should be adminSignUp.php. eg. action="adminSignUp.php"
 
/* Now we will store the values submitted by form in variable */
$username=$_POST['username']; //debug: should change the name of front end
$pass=$_POST['password'];	//debug: should change the name of the front end
/* we are now encrypting password while using md5() function */
$password=md5($pass);
$confirm_password=$_POST['confirm_password'];
 
/* Now we will check if username is already in use or not */
//$queryuser=mysql_query("SELECT * FROM login WHERE username='$username' ");
//$checkuser=mysql_num_rows($queryuser);

$sql = "SELECT * FROM SysAdmin WHERE name='$username' ";
$rst=$conn->Execute($sql) or die($conn->errrorMsg());

if($rst->RecordCount() != 0) {
	echo "<script language='javascript'>alert('Sorry, the user name you chose has already been taken.');</script>";
	echo "<script language='javascript'>window.location.href='adminSignUp.html';</script>";	//debug: change the name of the front end page
}
else { 
/* now we will check if password and confirm password matched */
if($pass != $confirm_password)
{
	echo "<script language='javascript'>alert('Password and confirm password fields are not matched');</script>";
	echo "<script language='javascript'>window.location.href='adminSignUp.html';</script>";	//debug: change the name of the front end page 
}

//everything works fine, then insert user info to database
else { 
	/* Now we will write a query to insert user details into database */
	$insert_admin_query = "INSERT INTO SysAdmin (name, pwd) VALUES ('$username', '$password')";	//debug: note that $password has been encripted.
	//$insert_user=mysql_query("INSERT INTO login (username, password) VALUES ('$username', '$password')");
 	$result=$conn->Execute($insert_admin_query) or die($conn->errorMsg());
 	
	if($result)	//if $result is true, then sign up successful and admin is log in automatically.
	{
		//log in admin automatically. Debug: you should test the session.
		$_SESSION['username'] = $username;
        $_SESSION['authority'] = "admin";
		
		echo "<script language='javascript'>alert('Registration Successful! Now you can set up new projects for the class!');</script>";
		echo "<script language='javascript'>window.location.href='adminSetUpProj.html';</script>";	//debug: change the name of the front end page TASetUp
	}
	else //can't insert new record, prompt the user try again
	{
		//echo "error in registration".mysql_error();
		echo "<script language='javascript'>alert('Oops! Error in registration! Please try again!');</script>";
		echo "<script language='javascript'>window.location.href='adminSignUp.html';</script>";	//debug: change the name of the front end page
	}
 
	/* closing the if else statements */
}}
 
mysql_close($conn);
?>