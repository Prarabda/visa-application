<?php
session_start();
include 'databaseconnection.php';


if (!isset($_SESSION['personal_details']) || !isset($_SESSION['passport_details'])) {
    die("No data available. Please complete the form steps.");
}


$personal = $_SESSION['personal_details'];
$passport = $_SESSION['passport_details'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //session stored data into varaible
    $first_name = $personal['first_name'];
    $last_name = $personal['last_name'];
    $email = $personal['email'];
    $dob = $personal['dob'];
    $phone_number = $personal['phone'];
    $nationality = $personal['nationality'];
    $country_of_application = $personal['country_of_application'];
    $status = "Pending";

    $passport_number = $passport['passport_number'];
    $country_of_issue = $passport['country_of_issue'];
    $passport_expiry_date = $passport['expiry_date'];
    $passport_type = $passport['passport_type'];

    $visa_type = $passport['visa_type'];
    $visa_period = $passport['visa_period'];
    $visa_start_date = $passport['visa_start_date'];
    $description = "Visa application submitted.";

    // Inserting page 1 data
    $sql = "
        INSERT INTO applications 
        (first_name, last_name, email, dob, phone_number, nationality, country_of_application, status, submission_date) 
        VALUES ('$first_name', '$last_name', '$email', '$dob', '$phone_number', '$nationality', '$country_of_application', '$status', NOW())
    ";
    if (mysqli_query($conn, $sql)) {
        $application_id = mysqli_insert_id($conn); 
        // Inserting page 2 passport data
        $sql = "
            INSERT INTO passport_details 
            (application_id, passport_number, country_of_issue, passport_expiry_date, passport_type) 
            VALUES ('$application_id', '$passport_number', '$country_of_issue', '$passport_expiry_date', '$passport_type')
        ";
        if (!mysqli_query($conn, $sql)) {
            die("Error inserting into passport_details table: " . mysqli_error($conn)); // Add error message
        }

        // Inserting page 2 data visa 
        $sql = "
            INSERT INTO visa_details 
            (application_id, visa_type_id, visa_period, visa_issue_date, visa_start_date, description) 
            VALUES ('$application_id', '$visa_type', '$visa_period', NOW(), '$visa_start_date', '$description')
        ";
        if (!mysqli_query($conn, $sql)) {
            die("Error inserting into visa_details table: " . mysqli_error($conn));
        }

     
        $_SESSION['success_message'] = "Your application has been submitted successfully!";
        header('Location: index.html');
        exit();
    } else {
        die("Error inserting into applications table: " . mysqli_error($conn));
    }
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Application Summary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 700px;
            margin: 30px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: crimson;
            margin-bottom: 20px;
        }
        h3 {
            color: darkblue;
            margin-top: 30px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f9f9f9;
            color: darkblue;
        }
        td {
            background-color: #fff;
        }
        tr:nth-child(even) td {
            background-color: #f4f4f4;
        }
        button {
            background-color: crimson;
            color: white;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin: 20px auto 0;
        }
        button:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
<div style="background-color: darkblue; color: white; padding: 20px; text-align: center;">
    <h1 style="margin: 0;">
        <a href="index.html" style="color: white;">Online Visa Application Form</a>
    </h1>
</div>

    
    <div class="container">
        <h2>Application Summary</h2>
        <p style="text-align: center;">Please review your application details and confirm.</p>

        <!-- showing data input by the user -->
        <h3>Personal Details</h3>
        <table>
            <tr><th>First Name:</th><td><?= htmlspecialchars($personal['first_name']); ?></td></tr>
            <tr><th>Last Name:</th><td><?= htmlspecialchars($personal['last_name']); ?></td></tr>
            <tr><th>Email:</th><td><?= htmlspecialchars($personal['email']); ?></td></tr>
            <tr><th>Date of Birth:</th><td><?= htmlspecialchars($personal['dob']); ?></td></tr>
            <tr><th>Phone Number:</th><td><?= htmlspecialchars($personal['phone']); ?></td></tr>
            <tr><th>Nationality:</th><td><?= htmlspecialchars($personal['nationality']); ?></td></tr>
            <tr><th>Country of Application:</th><td><?= htmlspecialchars($personal['country_of_application']); ?></td></tr>
        </table>

      
        <h3>Passport Details</h3>
        <table>
            <tr><th>Passport Number:</th><td><?= htmlspecialchars($passport['passport_number']); ?></td></tr>
            <tr><th>Country of Issue:</th><td><?= htmlspecialchars($passport['country_of_issue']); ?></td></tr>
            <tr><th>Expiry Date:</th><td><?= htmlspecialchars($passport['expiry_date']); ?></td></tr>
            <tr><th>Passport Type:</th><td><?= htmlspecialchars($passport['passport_type']); ?></td></tr>
        </table>

    
        <h3>Visa Details</h3>
        <table>
            <tr><th>Visa Type:</th><td><?= htmlspecialchars($passport['visa_type']); ?></td></tr>
            <tr><th>Visa Period:</th><td><?= htmlspecialchars($passport['visa_period']); ?></td></tr>
            <tr><th>Visa Start Date:</th><td><?= htmlspecialchars($passport['visa_start_date']); ?></td></tr>
        </table>

    
        <form method="POST">
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>