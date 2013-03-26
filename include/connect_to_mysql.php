<?php
$db_host = "localhost"; 
// Place the username for the MySQL database here 
$db_username = "root";  
// Place the password for the MySQL database here 
$db_pass = "Phoenix1218118";  
// Place the name for the MySQL database here 
$db_name = "DART"; 

// Run the actual connection here  
mysql_connect("$db_host","$db_username","$db_pass") or die ("could not connect to mysql");
mysql_select_db("$db_name") or die ("no database");
?>
