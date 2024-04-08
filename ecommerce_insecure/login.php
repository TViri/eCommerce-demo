<?php  
header("Content-type: text/html; charset=utf-8");  
?> 
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Bejelentkezés</title>
    <style>
		#errors {
			color: red;
			}
        
	</style>
</head>
<body>
<h2>Bejelentkezés</h2>
<div id="errors">

<?php
if(isset($_GET['nomatch'])) {
    if($_GET['nomatch'] == true) {
        echo "<h3>Hibás felhasználónév/jelszó páros adtál meg!</h3>";
    }
}
?>

</div>
<form action="check.php" method="post" onSubmit="return blankCheck()">
    <table>
        <tr>
            <td>Felhasználónév:</td>
            <td><input type="text" name="username" id="username"></td>
        </tr>
        <tr>
            <td>Jelszó:</td>
            <td><input type="password" name="password" id="password"></td>
        </tr>
        <tr>
            <td></td>
            <td><input class="button" type="submit" name="submit" value="Belépés"></td>
        </tr>
    </table>
    <p>Még nincs fiókod? <a href="registration.php">Regisztráció</a></p>
</form>
<script>
    function blankCheck() {
        var errormsg="<h3>Töltsd ki mindkét mezőt a belépéshez!</h3>";
        if(document.getElementById('username').value=="" || document.getElementById('password').value=="") {
            document.getElementById('errors').innerHTML = errormsg;
            return false;
        } else {
            return true;
        }
    }
</script>
<p>
<?php

?>
</p>
</body>
</html>
