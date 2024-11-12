<?php include 'footer.php';
 include 'backend/dbConnect.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Order</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap CSS (can be included in common.php)
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css"> -->
</head>
<body>

    <?php include 'header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Add Order</h2>
        <form action="backend/db_addOrder.php" method="POST">
            <?php
            $conn = getDbConnection();
$query = "SELECT customer_id, name FROM customers";
$result = mysqli_query($conn, $query);
?>

<div class="mb-3">
    <label for="customer_id" class="form-label">Customer ID</label>
    <select id="customer_id" name="customer_id" class="form-control" required>
        <option value="">Select a customer</option>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <option value="<?php echo $row['customer_id']; ?>">
                <?php echo $row['customer_id'] . ' - ' . $row['name']; ?>
            </option>
        <?php endwhile; ?>
    </select>
</div>
            <div id="products-container">
                <div class="product-item mb-3">
                    <h5>Product 1</h5>
                    <label for="product_name" class="form-label">Product Name</label>
                    <input type="text" name="product_name[]" class="form-control" placeholder="Product Name" required>

                    <label for="quantity" class="form-label mt-3">Quantity</label>
                    <input type="number" name="quantity[]" class="form-control" placeholder="Quantity" required>

                    <label for="price" class="form-label mt-3">Price</label>
                    <input type="number" step="0.01" name="price[]" class="form-control" placeholder="Price" required>
                    <hr>
                </div>
            </div>

            <button type="button" class="btn btn-secondary mb-3" onclick="addProduct()">Add Another Product</button>

            <button type="submit" class="btn btn-primary w-100" onclick="submitOrder()">Add Order</button>
        </form>

        <h2>Order History</h2>
<div id="orderHistory"></div>
<div id="orderHistoryDetails"></div>
    </div>
    <script>
        let productCount = 1;

        function addProduct() {
            productCount++;
            const container = document.getElementById('products-container');
            const newProduct = document.createElement('div');
            newProduct.classList.add('product-item', 'mb-3');
            newProduct.innerHTML = `
                <h5>Product ${productCount}</h5>
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" name="product_name[]" class="form-control" placeholder="Product Name" required>

                <label for="quantity" class="form-label mt-3">Quantity</label>
                <input type="number" name="quantity[]" class="form-control" placeholder="Quantity" required>

                <label for="price" class="form-label mt-3">Price</label>
                <input type="number" step="0.01" name="price[]" class="form-control" placeholder="Price" required>
                <hr>
            `;
            container.appendChild(newProduct);
        }

        function submitOrder() {
    let customer_id = document.getElementById("customer_id").value;
    let product_name = document.getElementById("product_name").value;
    let quantity = document.getElementById("quantity").value;
    let price = document.getElementById("price").value;

    let products = [{
        name: product_name,
        quantity: quantity,
        price: price
    }];

    $.post('add_order.php', { customer_id, products: products }, function(response) {
        alert(response);
        fetchOrderHistory();
    });
}

function fetchOrderHistory() {
    $.get('backend/db_view_orders.php', function(data) {
        $('#orderHistory').html(data);
    });
}
$(document).on('click', '#orderHistoryDetails tr', function() {
    const orderId = $(this).data('order-id');
    if (orderId) {
        viewOrderDetails(orderId);
    }
});
function viewOrderDetails(orderId) {
    $.get('backend/db_view_order_details.php', { order_id: orderId }, function(data) {
        $('#orderHistoryDetails').html(data); // Replace order history with order details
    });
}
$(document).ready(function() {
    fetchOrderHistory();
});

    </script>
</body>
</html>
