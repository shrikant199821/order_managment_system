<?php
include 'dbconnect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = getDbConnection();

    
    $stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $db_username, $email, $hashed_password);
    $stmt->fetch();

    if ($hashed_password && password_verify($password, $hashed_password)) {
        // Store user information in session variables
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $db_username;
        $_SESSION['email'] = $email;

        header("Location: index.php");
        exit(); 
    } else {
        echo "Invalid credentials";
    }

    $stmt->close();
    $conn->close();
}
?>
