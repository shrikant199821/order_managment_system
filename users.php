<?php include 'footer.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Fetch Users</title>
    <script src="assets/js/scripts.js"></script>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<?php include 'header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Users</h2>

        <div class="mb-3">
            <input type="text" id="search" class="form-control" placeholder="Search users...">
        </div>

        <table id="usersTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            // Function to fetch and display users
            function fetchUsers() {
                $.ajax({
                    url: 'backend/db_fetchUsers.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        const usersTable = $('#usersTable tbody');
                        usersTable.empty();

                        data.forEach(user => {
                            const row = $('<tr></tr>');
                            const usernameCell = $('<td></td>').text(user.username);
                            const emailCell = $('<td></td>').text(user.email);
                            row.append(usernameCell, emailCell);
                            usersTable.append(row);
                        });
                    },
                    error: function(error) {
                        console.error('Error fetching users:', error);
                    }
                });
            }

            // Function to search users
            function searchUsers() {
                const searchQuery = $('#search').val().toLowerCase();
                $('#usersTable tbody tr').each(function() {
                    const username = $(this).find('td').eq(0).text().toLowerCase();
                    const email = $(this).find('td').eq(1).text().toLowerCase();

                    if (username.includes(searchQuery) || email.includes(searchQuery)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
            fetchUsers();
            $('#search').on('keyup', searchUsers);
        });
    </script>
</body>
</html>
