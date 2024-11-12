<?php
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $conn = getDbConnection();

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    let toast = document.createElement('div');
                    toast.style.position = 'fixed';
                    toast.style.bottom = '20px';
                    toast.style.right = '20px';
                    toast.style.padding = '10px 20px';
                    toast.style.backgroundColor = '#f44336'; /* Red background */
                    toast.style.color = '#fff';
                    toast.style.borderRadius = '5px';
                    toast.innerText = 'Error: Username or email already exists!';
    
                    document.body.appendChild(toast);
    
                    setTimeout(function() {
                        toast.remove();
                    }, 3000); // Toast disappears after 3 seconds
                });
            </script>
        ";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            $userId = $stmt->insert_id;

            $stmt2 = $conn->prepare("INSERT INTO customers (customer_id, name, email) VALUES (?, ?, ?)");
            $stmt2->bind_param("iss", $userId, $username, $email);

            if ($stmt2->execute()) {
                header("Location: login.php");
                exit();
            } else {
                echo "
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            let toast = document.createElement('div');
                            toast.style.position = 'fixed';
                            toast.style.bottom = '20px';
                            toast.style.right = '20px';
                            toast.style.padding = '10px 20px';
                            toast.style.backgroundColor = '#f44336'; /* Red background */
                            toast.style.color = '#fff';
                            toast.style.borderRadius = '5px';
                            toast.innerText = 'Error: Failed to insert data into the customer table.';
            
                            document.body.appendChild(toast);
            
                            setTimeout(function() {
                                toast.remove();
                            }, 3000); // Toast disappears after 3 seconds
                        });
                    </script>
                ";
            }

            $stmt2->close();
        } else {
            echo "
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        let toast = document.createElement('div');
                        toast.style.position = 'fixed';
                        toast.style.bottom = '20px';
                        toast.style.right = '20px';
                        toast.style.padding = '10px 20px';
                        toast.style.backgroundColor = '#f44336'; /* Red background */
                        toast.style.color = '#fff';
                        toast.style.borderRadius = '5px';
                        toast.innerText = 'Error: " . $stmt->error . "'; // Show error message for the user table
    
                        document.body.appendChild(toast);
    
                        setTimeout(function() {
                            toast.remove();
                        }, 3000); // Toast disappears after 3 seconds
                    });
                </script>
            ";
        }
    }

    $stmt->close();
    $conn->close();
}
?>
