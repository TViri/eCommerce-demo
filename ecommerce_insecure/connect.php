<?php  
header("Content-type: text/html; charset=utf-8");  
?> 
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title></title>
</head>
<body>
<p>
<?php
$adatbazis = "ecommerce";

$kapcsolat = mysqli_connect( "localhost", "root", );
if ( ! $kapcsolat )
 die( "Nem lehet csatlakozni a MySQL kiszolgálóhoz! " . mysqli_error($kapcsolat) );
else {
    print "Sikerült csatlakozni!<br>";
}
mysqli_select_db($kapcsolat, $adatbazis )
or die ( "Nem lehet megnyitni a következő adatbázist:
$adatbazis".mysqli_error($kapcsolat));
print "Sikeresen kiválasztott adatbázis: ".$adatbazis; 
/*
print "<pre>";
print_r($kapcsolat);
print "</pre>";
*/
?>
</p>
</body>
</html>
