<?php
    include_once("adodb5/adodb.inc.php");
	$conn = ADONewConnection('mysql');
	//You should change the line below and set up database accordingly before running
	$conn->PConnect('something server like localhost','DB admin name','some password','some DB name') or die('connection error');
	$conn->Execute('set names gb2312');
	$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
?>
