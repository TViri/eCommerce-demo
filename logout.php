<?php  
header("Content-type: text/html; charset=utf-8");  

?> 
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Logout</title>
</head>
<body>
<p>
<?php
session_start();
if($_SESSION['loggedin']) {
    session_destroy();
    header("Location: login.php");
    exit;
} else {
    header("Location: login.php");
    exit;
}
?>
</p>
</body>
</html>
