<?php
// Place the host name for the MySQL database here
$db_host = "someHostName"; 
// Place the username for the MySQL database here 
$db_username = "someUserName";  
// Place the password for the MySQL database here 
$db_pass = "somePassword";  
// Place the name for the MySQL database here 
$db_name = "someDatabaseName"; 

// Run the actual connection here  
mysql_connect("$db_host","$db_username","$db_pass") or die ("could not connect to mysql");
mysql_select_db("$db_name") or die ("no database");
?>
