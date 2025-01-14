<?php
session_start();
include 'databaseconnection.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $country_of_work = mysqli_real_escape_string($conn, $_POST['country_of_work']);

    // passwords matching 
    if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        $sql = "SELECT * FROM admin_users WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $message = "Username already exists. Please choose another.";
        } else {
            // Hashing  password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            //insertung in database sql
            $sql = "
                INSERT INTO admin_users (username, password, country_of_work)
                VALUES ('$username', '$hashed_password', '$country_of_work')
            ";
            if (mysqli_query($conn, $sql)) {
                $message = "Admin registered successfully!";
            } else {
                $message = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: crimson;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-weight: bold;
            color: darkblue;
        }
        input {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        button {
            background-color: crimson;
            color: white;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: darkred;
        }
        .message {
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
        }
        .message.success {
            color: green;
        }
        .message.error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Registration</h2>
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm password" required>

            <label for="country_of_work">Country of Work:</label>
            <input type="text" id="country_of_work" name="country_of_work" placeholder="Enter country of work" required>

            <button type="submit">Register Admin</button>
        </form>

        <?php if ($message): ?>
            <div class="message <?= strpos($message, 'successfully') !== false ? 'success' : 'error'; ?>">
                <?= htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
