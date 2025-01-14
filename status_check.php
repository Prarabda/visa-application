<?php
include 'databaseconnection.php';

$status_message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $passport_number = mysqli_real_escape_string($conn, $_POST['passport_number']);

    // display application status from passport number
    $sql = "
        SELECT 
            a.application_id, 
            vd.visa_type_id AS visa_type, 
            a.status 
        FROM 
            applications a
        INNER JOIN 
            passport_details pd ON a.application_id = pd.application_id
        INNER JOIN 
            visa_details vd ON a.application_id = vd.application_id
        WHERE 
            pd.passport_number = '$passport_number'
    ";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $application_id = $row['application_id'];
        $visa_type = $row['visa_type'];
        $status = $row['status'];
    } else {
        $status_message = "No application found for the provided passport number.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Check Visa Application Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
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
        header {
            background-color: darkblue;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        header a:hover {
            text-decoration: underline;
        }
        .banner {
            width: 105%;
            max-height:252px ;
            object-fit: cover;
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
        .result {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .result h3 {
            margin: 0 0 10px;
            color: darkblue;
        }
        .result p {
            margin: 5px 0;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<header>
        <div><a href="index.html">Visa Application System</a></div>
        <div><a href="admin.php">Admin Login</a></div>
    </header>
   <img src="banner.png"our banner" class="banner">
    <div class="container">
        <h2>Check Visa Application Status</h2>
        <form method="POST">
            <label for="passport_number">Enter Passport Number:</label>
            <input type="text" id="passport_number" name="passport_number" placeholder="Passport Number" required>
            <button type="submit">Check Status</button>
        </form>

        <?php if (isset($application_id)): ?>
            <div class="result">
                <h3>Application Details:</h3>
                <p><strong>Application Number:</strong> <?= htmlspecialchars($application_id); ?></p>
                <p><strong>Visa Type:</strong> <?= htmlspecialchars($visa_type); ?></p>
                <p><strong>Visa Status:</strong> <?= htmlspecialchars($status); ?></p>
            </div>
        <?php elseif ($status_message): ?>
            <div class="error"><?= htmlspecialchars($status_message); ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
