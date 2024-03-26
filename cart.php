<?php
session_start();

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$total = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    
    unset($_SESSION['cart']);
    header("Location: cart.php?thank_you=true");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $product_id => $quantity) {
        $_SESSION['cart'][$product_id]['quantity'] = $quantity;
    }
    header("Location: cart.php");
    exit;
}

if (isset($_GET['delete_product'])) {
    $product_id = $_GET['delete_product'];
    unset($_SESSION['cart'][$product_id]);
    header("Location: cart.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "ecommerce");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$username = $_SESSION['username'];
$sql = "SELECT * FROM customers WHERE username='$username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $customer = mysqli_fetch_assoc($result);
} else {
}

$name = isset($customer['name']) ? $customer['name'] : '';
$address = isset($customer['address']) ? $customer['address'] : '';
$email = isset($customer['email']) ? $customer['email'] : '';
$customerId = isset($customer['id']) ? $customer['id'] : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kosár</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="products.php">Termékek</a>
        <a href="cart.php">Kosár</a>
        <a class="logout" href="logout.php">Kijelentkezés</a>
    </div>
    <h2>Kosár</h2>
    <?php if (empty($cart)): ?>
        <p>A kosarad üres!</p>
    <?php else: ?>
        <form action="cart.php" method="post">
            <table>
                <thead>
                    <tr>
                        <th>Termék neve</th>
                        <th>Mennyiség</th>
                        <th>Egységár</th>
                        <th>Összesen</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $product_id => $product): ?>
                        <tr>
                            <td><?php echo $product['name']; ?></td>
                            <td>
                                <input type="number" name="quantity[<?php echo $product_id; ?>]" value="<?php echo $product['quantity']; ?>" min="1">
                            </td>
                            <td><?php echo $product['price']; ?> Ft</td>
                            <td><?php echo $product['price'] * $product['quantity']; ?> Ft</td>
                            <td>
                                <a href="cart.php?delete_product=<?php echo $product_id; ?>">Törlés</a>
                            </td>
                        </tr>
                        <?php $total += $product['price'] * $product['quantity']; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h3>Összesen: <?php echo $total; ?> Ft</h3>
            <input class="button" type="submit" name="update_cart" value="Kosár frissítése">

        </form>
        <button class="button" id="payButton" onclick="openPaymentForm()">Fizetés</button>
    
    
    <div id="paymentForm" style="display: none;">
            <h3>Szállítási adatok</h3>
            <form action="cart.php" method="post">
                <table>
                    <tr>
                        <td><label for="name">Név:</label></td>
                        <td><input type="text" id="name" name="name" value="<?php echo $name; ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="address">Cím:</label></td>
                        <td><input type="text" id="address" name="address" value="<?php echo $address; ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="email">Email:</label></td>
                        <td><input type="email" id="email" name="email" value="<?php echo $email; ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="delivery">Kiszállítás:</label></td>
                        <td>
                            <input type="radio" id="delivery" name="delivery" value="delivery">
                            <label for="delivery">Házhozszállítás (+1500 Ft)</label><br>
                            <input type="radio" id="pickup" name="delivery" value="pickup">
                            <label for="pickup">Személyes átvétel (ingyenes)</label>
                        </td>
                    </tr>
                    </table>
                    <h3>Fizetési adatok</h3>
                    <table>
                    <tr>
                        <td><label for="cardNumber">Kártyaszám:</label></td>
                        <td><input type="text" id="cardNumber" name="cardNumber"></td>
                    </tr>
                    <tr>
                        <td><label for="expirationDate">Lejárati dátum:</label></td>
                        <td><input type="date" id="expirationDate" name="expirationDate"></td>
                    </tr>
                    <tr>
                        <td><label for="cvv">CVV:</label></td>
                        <td><input type="text" id="cvv" name="cvv"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="checkbox" id="saveCard" name="saveCard">
                            <label for="saveCard">Kártyaadatok mentése</label></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input class="button" type="submit" value="Fizetés"></td>
                    </tr>
                </table>
            </form>
        </div>
    <?php endif; ?>

    <script>
        function openPaymentForm() {
            var paymentForm = document.getElementById("paymentForm");
            paymentForm.style.display = "block";
            var payButton = document.getElementById("payButton");
            payButton.style.display = "none";
        }
    </script>
</body>
</html>

<?php



if (isset($_GET['thank_you']) && $_GET['thank_you'] === 'true') {
    echo '<script>alert("Thank you for your order!");</script>';
}

$sql = "SELECT * FROM payments WHERE customer_id = (SELECT id FROM customers WHERE username='$username')";
$result = mysqli_query($conn, $sql);
$payment_details = mysqli_fetch_assoc($result);

$cardNumber = isset($payment_details['card_number']) ? $payment_details['card_number'] : '';
$expirationDate = isset($payment_details['expiration_date']) ? $payment_details['expiration_date'] : '';
$cvv = isset($payment_details['cvv']) ? $payment_details['cvv'] : '';
if (isset($_POST['saveCard'])) {
    $cardNumber = $_POST['cardNumber'];
    $expirationDate = $_POST['expirationDate'];
    $cvv = $_POST['cvv'];

    if ($payment_details) {
        $updateCardQuery = "UPDATE payments SET card_number = '$cardNumber', expiration_date = '$expirationDate', cvv = '$cvv' WHERE customer_id = '$customerId'";
        mysqli_query($conn, $updateCardQuery);
    } else {
        $insertCardQuery = "INSERT INTO payments (customer_id, card_number, expiration_date, cvv) VALUES ('$customerId', '$cardNumber', '$expirationDate', '$cvv')";
        mysqli_query($conn, $insertCardQuery);
    }
}

?>


