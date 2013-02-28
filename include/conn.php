<?php
    include_once("adodb5/adodb.inc.php");
	$conn = ADONewConnection('mysql');
	$conn->PConnect('localhost','root','Phoenix1218118','DART') or die('connection error');
	$conn->Execute('set names gb2312');
	$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
?>