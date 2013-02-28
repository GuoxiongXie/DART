<?php
$pwd = $_POST["pwd"];
$pwdmd5 = md5($pwd);
echo $pwd."<br/>";
echo $pwdmd5;
?>

<html>
<body>
<h1>It works!</h1>
<form method="post" action="info.php">
<input type="text" value="" name="pwd" />
<input type="submit" value="submit" name="value" />
</body>
</html>
