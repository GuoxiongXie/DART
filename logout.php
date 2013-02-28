<?php
/*destroy the session and logout to the index.php
*/
session_start();
unset($_SESSION['username']);
unset($_SESSION['authority']);
session_destroy();

//added the following two lines for sprint I demo
echo "<script language='javascript'>alert('Logout successfully!');</script>";
echo "<script language='javascript'>window.location.href='about.html';</script>";
//header("location:about.html");	//the original code
?>