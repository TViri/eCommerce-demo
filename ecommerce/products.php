
<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "ecommerce");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {
    $products = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
} else {
    $products = array(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = [
            'name' => $products[$product_id - 1]['name'],
            'price' => $products[$product_id - 1]['price'],
            'quantity' => $quantity
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termékek</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        h2 {
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
        }

        h3 {
            margin-top: 0;
        }

        p {
            margin: 5px 0;
        }

        form {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="products.php">Termékek</a>
        <a href="cart.php">Kosár</a>
        <a class="logout" href="logout.php">Kijelentkezés</a>
    </div>
    <h2>Üdv, <?php echo $_SESSION['username']; ?></h2>
    <h3>Termékek</h3>
    <ul>
    <?php foreach ($products as $product): ?>
            <li>
                <h3><?php echo $product['name']; ?></h3>
                <p>Ár: <?php echo $product['price']; ?> Ft</p>
                <form action="products.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    Mennyiség: <input type="number" name="quantity" value="1" min="1" size="3"><br>
                    <br><button class="button" type="submit" name="add_to_cart">Kosárba</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>