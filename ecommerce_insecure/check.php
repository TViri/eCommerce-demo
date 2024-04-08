<?php  
header("Content-type: text/html; charset=utf-8");  
?> 
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Check</title>
</head>
<body>
<p>
<?php
if(isset($_POST['submit'])) {
    require_once("connect.php");

    $username=$_POST['username'];
    $password=sha1($_POST['password']);
    

    $query="SELECT * FROM customers WHERE username='$username' AND password='$password' LIMIT 1";
    $result=mysqli_query($kapcsolat, $query);

    if(mysqli_num_rows($result)==1) {
        session_start();
        $_SESSION['username']=$username;
        $_SESSION['loggedin']= TRUE;
        header("Location: products.php"); 
        exit;
    } else {
        header("Location: login.php?nomatch=true");
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}


?>
</p>
</body>
</html>
