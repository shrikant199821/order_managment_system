<?php
include 'dbConnect.php';
$order_id = $_GET['order_id'];
$conn = getDbConnection();

// Fetch order details
$query = "SELECT orders.order_id, orders.order_date, customers.name AS customer_name
          FROM orders
          JOIN customers ON orders.customer_id = customers.customer_id
          WHERE orders.order_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

// Fetch products in the order
$query = "SELECT product_name, quantity, price FROM order_details WHERE order_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$products = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Order Details</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <p><strong>Order ID:</strong> <?= htmlspecialchars($order['order_id']); ?></p>
                </div>
                <div class="col-md-4">
                    <p><strong>Customer Name:</strong> <?= htmlspecialchars($order['customer_name']); ?></p>
                </div>
                <div class="col-md-4">
                    <p><strong>Order Date:</strong> <?= htmlspecialchars($order['order_date']); ?></p>
                </div>
            </div>

            <h4 class="mt-4">Products</h4>
            <table class="table table-bordered table-hover mt-3">
                <thead class="thead-light">
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($product = $products->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($product['product_name']); ?></td>
                            <td><?= htmlspecialchars($product['quantity']); ?></td>
                            <td>$<?= number_format($product['price'], 2); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
