<?php
//note that this file is only for manager to add new risk items; other people can't do this.
//The authority will be check immediately.


include_once 'include/conn.php';
//session_save_path('/Applications/XAMPP/htdocs/dartSession');	//this is the path to save session variables
session_start();
/*process the login request and store the necessary information
*/

$role = $_SESSION['authority']; //manager, admin, user; here it only can be manager

if ($role != "manager" || $role != "user"){
	echo "<script>alert('Sorry, but you have to be one of the project managers or regular users to add a risk item!');</script>";
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

//debug: todo: for sprint 3, also insert records in Vote table here.






// end of todo

if ($rst1 == false)
{
	echo "<script>alert('Sorry! Fail to add the risk! Please try again!');</script>";
	echo "<script language='javascript'>window.location.href='addrisksFrontEnd.php';</script>";
}
else
{
	echo "<script>alert('A New Risk Item Has Been Added!');</script>";
	//added the following line for Sprint I demo
	echo "<script language='javascript'>window.location.href='setup.html';</script>"; //debug:where should I direct this to?
}

?>