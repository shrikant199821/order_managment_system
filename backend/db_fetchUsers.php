<?php
include 'dbconnect.php';

$conn = getDbConnection();
$query = "SELECT username, email FROM users";
$result = $conn->query($query);

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

header('Content-Type: application/json');
echo json_encode($users);

$conn->close();
?>