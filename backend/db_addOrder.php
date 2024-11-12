<?php
include 'dbConnect.php';

session_start();

$customerId = $_POST['customer_id']; 

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']; 
} else {
    die("User is not logged in.");
}

$productNames = $_POST['product_name'];
$quantities = $_POST['quantity'];
$prices = $_POST['price'];

$conn = getDbConnection();

$totalValue = 0;
foreach ($quantities as $index => $quantity) {
    $totalValue += $quantity * $prices[$index]; 
}


$orderQuery = "INSERT INTO orders (customer_id, user_id, total_value, order_date) VALUES (?, ?, ?, NOW())";
$orderStmt = $conn->prepare($orderQuery);

if ($orderStmt) {
    $orderStmt->bind_param("iii", $customerId, $userId, $totalValue);

    $orderStmt->execute();

    $order_id = $orderStmt->insert_id;

    $detailQuery = "INSERT INTO order_details (order_id, product_name, quantity, price) VALUES (?, ?, ?, ?)";
    $detailStmt = $conn->prepare($detailQuery);

    if ($detailStmt) {
        foreach ($productNames as $index => $productName) {
            $quantity = $quantities[$index];
            $price = $prices[$index];
            
            $detailStmt->bind_param("isid", $order_id, $productName, $quantity, $price);
            $detailStmt->execute();
        }
        
        // echo "Order added successfully!";
        header("Location: ../index.php?msg=Order added successfully!");
        exit();
    } else {
        header("Location: ../index.php?msg=Error inserting into order_details: " . $conn->error);
        exit();
    }
} else {
    header("Location: ../index.php?msg=Error inserting into orders: " . $conn->error);
    exit();
}
?>
