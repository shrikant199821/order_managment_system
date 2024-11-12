<?php

require_once 'dbConnect.php';
$conn = getDbConnection(); 

if (!$conn) {
    die("Connection failed: Unable to establish a connection.");
}

$query = "SELECT orders.order_id, customers.name AS customer_name, orders.order_date, orders.total_value
          FROM orders
          JOIN customers ON orders.customer_id = customers.customer_id
          ORDER BY orders.order_date DESC";

if ($result = $conn->query($query)) {

    echo "<table border='1' cellpadding='10' cellspacing='0' class='table table-striped table-bordered'>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Order Date</th>
                    <th>Total Value</th>
                </tr>
            </thead>
            <tbody>";

    while ($row = $result->fetch_assoc()) {
        echo '<tr onclick="viewOrderDetails(' . $row['order_id'] . ')">
        <td>' . $row['order_id'] . '</td>
        <td>' . $row['customer_name'] . '</td>
        <td>' . $row['order_date'] . '</td>
        <td>' . $row['total_value'] . '</td>
      </tr>';
    }

    echo "</tbody></table>";

} else {
    echo "Error executing query: " . $conn->error;
}

// Close the connection
$conn->close();
?>
