<?php  
header("Content-type: text/html; charset=utf-8");  
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <style>

    </style>
</head>
<body>
    <h2>Regisztráció</h2>
    <form action="registration.php" method="post">
    <table>
        <tr>
            <td>Név:</td>
            <td><input type="text" name="name" id="name"></td>
        </tr>
        <tr>
            <td>Felhasználónév:</td>
            <td><input type="text" name="username" id="username"></td>
        </tr>
        <tr>
            <td>Cím:</td>
            <td><input type="text" name="address" id="address"></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><input type="email" name="email" id="email"></td>
        </tr>
        <tr>
            <td>Jelszó:</td>
            <td><input type="password" name="password" id="password"></td>
        </tr>
        <tr>
            <td></td>
            <td><input class="button" type="submit" name="submit" value="Regisztráció"></td>
        </tr>
    </table>
    <p>Már van fiókod? <a href="login.php">Belépés</a></p>
</form>
</body>
</html>


<?php

$conn = mysqli_connect("localhost", "root", "", "ecommerce");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];

    $password = $_POST['password'];
    
    /*
    //SHA256 hashelt algoritmus használata és kézi salt generálásával

    function generateSalt() {
        return bin2hex(random_bytes(16));
    }   
    $salt = generateSalt();
    $saltedpassword = $password . $salt;
    $hashedpassword = hash('sha256', $saltedpassword); 

    */

    $hashedpassword = password_hash($password, PASSWORD_DEFAULT);


    $check_query = "SELECT * FROM customers WHERE username='$username'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "A felhasználónév már foglalt, válassz másikat.";
    } else {
        
        $insert_query = "INSERT INTO customers (username, name, password, address, email) VALUES ('$username', '$name', '$hashedpassword', '$address', '$email')";
        $insert_result = mysqli_query($conn, $insert_query);

        if ($insert_result) {
            
            header("Location: login.php");
            exit;
        } else {
            
        }
    }
}
?>
