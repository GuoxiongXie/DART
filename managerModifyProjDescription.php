<?php
include_once 'include/conn.php';
require_once "include/connect_to_mysql.php";	//the reason I include this is because $conn->execute() doesn't work

session_start();
$projName = "";
$projDesc = "";
//$authority = $_SESSION['authority'];
//$projName = $_SESSION['project'];
	
function displayProjInfo() {
	global $projName;
	$projName = (string)$_SESSION['project'];	//$projName is of type object of no string casting
	//echo gettype($projName);
	global $projDesc;
	
	//$projDescQuery = "select * from Project where projectname = '$projName'";	//this one doesn't work
	$projDescQuery = "select * from Project";
	$query = mysql_query($projDescQuery) or die (mysql_error());	//$query is type of resource
	
	// Output the data here using a while loop, the loop will return all members 
	
	while ($row = mysql_fetch_array($query)) { 
    // Gather all $row values into local variables for easier usage in output
    	if (strcmp(trim($row['projectname']), trim($projName))==0) {	//string can't == object. $row['projectname'] is of string type. trim remove all the spaces at the begining and end
    		$projDesc = $row['projectdesc'];
		}
	} 
	// Free the result set if it is large 
	mysql_free_result($query);  
	// close mysql connection 
	mysql_close();
}	

/*	
function displayProjDesc() {
	//$projName = $_SESSION['project'];	//this is empty string
	$projName = displayProjName();
	
	//remove the following: for testing only
	if (isset($_SESSION['project'])) {
		echo "The type is ".gettype($projName);
		echo $projName;	//this outputs nothing
	}
	//remove the above
	
	$projDescQuery = "SELECT projectdesc FROM Project WHERE projectname = '" . $projName . "'";
	//echo $projDescQuery;
	$projDesc = $conn->Execute($projDescQuery) or die($conn->errorMsg());
	return $projDesc;
}
*/

?>