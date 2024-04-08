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
    $password=$_POST['password'];
    
    /*
    //SHA256 hashelt algoritmus használata és kézi salt generálásával

    $get_salt_query = "SELECT salt FROM customers WHERE username='$username'";
    $salt_result = mysqli_query($kapcsolat, $get_salt_query);
    $row = mysqli_fetch_assoc($salt_result);
    $salt = $row['salt'];
    
    $saltedpassword = $password . $salt;
    $hashedpassword = hash('sha256', $saltedpassword);
    

    $query=mysqli_query($kapcsolat, "SELECT * FROM customers WHERE username='$username' AND password='$hashedpassword' LIMIT 1");
    $row=mysqli_fetch_assoc($query);

    if(mysqli_num_rows($query)==1) {
        session_start();
        $_SESSION['username']=$username;
        $_SESSION['loggedin']= TRUE;
        header("Location: products.php"); 
        exit;
    } else {
        header("Location: login.php?nomatch=true");
        exit;
    }
    */

    $query = mysqli_query($kapcsolat, "SELECT * FROM customers WHERE username='$username' LIMIT 1");
    $row = mysqli_fetch_assoc($query);

    if ($row) {
        if (password_verify($password, $row['password'])) {
            session_start();
            
            $_SESSION['username'] = $username;
            $_SESSION['loggedin'] = true;
            header("Location: products.php"); 
            exit;
        } else {
            header("Location: login.php?nomatch=true");
            exit;
        }
    } 
} else {
    header("Location: login.php");
    exit;
}


?>
</p>
</body>
</html>
