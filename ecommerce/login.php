<?php  
header("Content-type: text/html; charset=utf-8");  
?> 

<?php

?>
<?php
/*
// Function to validate SSL certificate details
$data = openssl_x509_parse(file_get_contents('D:\xampp\apache\conf\ssl.crt\server.crt'));
echo "Version: " . $data['version'] . "<br>";
echo "Subject: " . $data['subject']['CN'] . "<br>";
echo "Issuer: " . $data['issuer']['CN'] . "<br>";
echo "Valid From: " . date('Y-m-d H:i:s', $data['validFrom_time_t']) . "<br>";
echo "Valid To: " . date('Y-m-d H:i:s', $data['validTo_time_t']) . "<br>";
var_dump(openssl_get_cert_locations()); 
  
// openssl get cert location represent in array 
return openssl_get_cert_locations(); 


// Function to validate SSL certificate details
function validateCertificate($expectedCommonName, $expectedIssuerCommonName) {
    // Get the SSL client certificate details
    $clientCert = filter_input(INPUT_SERVER, 'SSL_CLIENT_CERT');
    if ($clientCert === null) {
        // SSL client certificate not provided, reject the request
        return false;
    }

    // Parse the client certificate
    $parsedCert = openssl_x509_parse($clientCert);
    if ($parsedCert === false) {
        // Unable to parse client certificate, reject the request
        return false;
    }

    // Compare the Common Name (CN) in the client certificate with the expected value
    if ($parsedCert['subject']['CN'] !== $expectedCommonName) {
        // Common Name (issued to) does not match, reject the request
        return false;
    }

    // Compare the Issuer Common Name (CN) in the client certificate with the expected value
    if ($parsedCert['issuer']['CN'] !== $expectedIssuerCommonName) {
        // Issuer Common Name (issued by) does not match, reject the request
        return false;
    }

    // Certificate validation successful
    return true;
}

// Set the expected values for certificate validation
$expectedCommonName = 'yourdomain.com'; // Replace with the expected Common Name (CN) of your server certificate
$expectedIssuerCommonName = 'YourIssuerCommonNameHere'; // Replace with the expected Issuer Common Name (CN) of your server certificate

// Perform certificate validation
if (!validateCertificate($expectedCommonName, $expectedIssuerCommonName)) {
    // Certificate validation failed, block access
    http_response_code(403); // Forbidden
    echo "SSL certificate validation failed. Access denied.";
    exit;
}

// Access granted, continue with your PHP logic*/

?>


<?php


/*
$url = "https://sites.local";

$orignal_parse = parse_url($url, PHP_URL_HOST);


$get = stream_context_create(array("ssl" => array("capture_peer_cert" => TRUE)));

$read = stream_socket_client("ssl://".$orignal_parse.":443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT,  $get);

print_r($read);

$cert = stream_context_get_params($read);

$certinfo = openssl_x509_parse($cert['options']['ssl']['peer_certificate']);



echo '<pre>';

print_r($certinfo);

echo '</pre>';
*/


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
