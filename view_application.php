<?php
session_start();
include 'databaseconnection.php';

if (!isset($_SESSION['admin_user'])) {
    header('Location: admin_login.php'); 
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid application ID.");
}

$application_id = intval($_GET['id']); 
// count work and country apply joined and display application
$sql = "
    SELECT 
        a.application_id, 
        a.first_name, 
        a.last_name, 
        a.email, 
        a.dob, 
        a.phone_number, 
        a.nationality, 
        a.country_of_application, 
        a.status, 
        a.submission_date, 
        pd.passport_number, 
        pd.country_of_issue, 
        pd.passport_expiry_date, 
        pd.passport_type, 
        vd.visa_type_id, 
        vd.visa_period, 
        vd.visa_issue_date, 
        vd.visa_start_date, 
        vd.description
    FROM 
        applications a
    INNER JOIN 
        passport_details pd ON a.application_id = pd.application_id
    INNER JOIN 
        visa_details vd ON a.application_id = vd.application_id
    WHERE 
        a.application_id = $application_id
";

$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("No application found with the provided ID.");
}

$application = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: crimson;
            margin-bottom: 20px;
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
        tr:nth-child(even) td {
            background-color: #f4f4f4;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: crimson;
            text-decoration: none;
            font-weight: bold;
        }
        .back-link a:hover {
            text-decoration: underline;
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
    </style>
</head>
<header style="background-color: darkblue ; color: white; padding: 10px 20px; display: flex; justify-content: space-between; align-items: center;">
    <div style="font-size: 24px; font-weight: bold;"><a href="index.html" >Visa Application System</a></div>
    <div>
        <a href="dashboard.php" style="color: white; text-decoration: none; margin-right: 20px;">Return </a>
        <a href="logout.php" style="color: white; text-decoration: none;">Log Out</a>
    </div>
</header>

    
    <img src="banner.png"our banner" class="banner">
<body>
    <div class="container">
        <h2>Application Details</h2>
        
        <h3>Personal Information</h3>
        <table>
            <tr><th>First Name:</th><td><?= htmlspecialchars($application['first_name']); ?></td></tr>
            <tr><th>Last Name:</th><td><?= htmlspecialchars($application['last_name']); ?></td></tr>
            <tr><th>Email:</th><td><?= htmlspecialchars($application['email']); ?></td></tr>
            <tr><th>Date of Birth:</th><td><?= htmlspecialchars($application['dob']); ?></td></tr>
            <tr><th>Phone Number:</th><td><?= htmlspecialchars($application['phone_number']); ?></td></tr>
            <tr><th>Nationality:</th><td><?= htmlspecialchars($application['nationality']); ?></td></tr>
            <tr><th>Country of Application:</th><td><?= htmlspecialchars($application['country_of_application']); ?></td></tr>
            <tr><th>Status:</th><td><?= htmlspecialchars($application['status']); ?></td></tr>
            <tr><th>Submission Date:</th><td><?= htmlspecialchars($application['submission_date']); ?></td></tr>
        </table>

        <h3>Passport Details</h3>
        <table>
            <tr><th>Passport Number:</th><td><?= htmlspecialchars($application['passport_number']); ?></td></tr>
            <tr><th>Country of Issue:</th><td><?= htmlspecialchars($application['country_of_issue']); ?></td></tr>
            <tr><th>Expiry Date:</th><td><?= htmlspecialchars($application['passport_expiry_date']); ?></td></tr>
            <tr><th>Passport Type:</th><td><?= htmlspecialchars($application['passport_type']); ?></td></tr>
        </table>

        <h3>Visa Details</h3>
        <table>
            <tr><th>Visa Type:</th><td><?= htmlspecialchars($application['visa_type_id']); ?></td></tr>
            <tr><th>Visa Period:</th><td><?= htmlspecialchars($application['visa_period']); ?></td></tr>
            <tr><th>Visa Issue Date:</th><td><?= htmlspecialchars($application['visa_issue_date']); ?></td></tr>
            <tr><th>Visa Start Date:</th><td><?= htmlspecialchars($application['visa_start_date']); ?></td></tr>
            <tr><th>Description:</th><td><?= htmlspecialchars($application['description']); ?></td></tr>
        </table>

        <div class="back-link">
            <a href="dashboard.php">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
