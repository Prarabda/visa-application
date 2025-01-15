<?php
session_start();
include 'databaseconnection.php';

if (!isset($_SESSION['admin_user'])) {
    header('Location: admin.php'); // Redirect to login page
    exit();
}

//country of work fetching 
$admin_country_of_work = $_SESSION['admin_user']['country_of_work'];

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $application_id = $_GET['delete'];

//deleteing  the application sql
    $sql = "DELETE FROM applications WHERE application_id = $application_id";
    if (mysqli_query($conn, $sql)) {
        header('Location: dashboard.php?message=Application+deleted+successfully');
        exit();
    } else {
        die("Error deleting application: " . mysqli_error($conn));
    }
}
//changing visa status of applicant
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $application_id = $_POST['application_id'];
    $new_status = $_POST['status'];

    $sql = "UPDATE applications SET status = '$new_status' WHERE application_id = $application_id";
    if (mysqli_query($conn, $sql)) {
        header('Location: dashboard.php?message=Status+updated+successfully');
        exit();
    } else {
        die("Error updating status: " . mysqli_error($conn));
    }
}
//application where Country of work == country of application
$sql = "
    SELECT 
        a.application_id, 
        CONCAT(a.first_name, ' ', a.last_name) AS applicant_name, 
        a.email, 
        vd.visa_type_id AS visa_type, 
        a.status, 
        a.submission_date 
    FROM 
        applications a
    INNER JOIN 
        visa_details vd ON a.application_id = vd.application_id
    WHERE 
        a.country_of_application = '$admin_country_of_work'
";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching applicants: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1000px;
            margin: 30px auto;
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
            margin-top: 20px;
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
        .action-links a {
            color: crimson;
            text-decoration: none;
            margin-right: 10px;
        }
        .action-links a:hover {
            text-decoration: underline;
        }
        .logout {
            display: block;
            margin: 20px 0;
            text-align: center;
        }
        .logout a {
            color: crimson;
            text-decoration: none;
            font-weight: bold;
        }
        .logout a:hover {
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
        <a href="add_admin.php" style="color: white; text-decoration: none; margin-right: 20px;">Add User</a>
        <a href="logout.php" style="color: white; text-decoration: none;">Log Out</a>
    </div>
</header>

    
    <img src="banner.png"our banner" class="banner">

<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <p>Namaste, <?= htmlspecialchars($_SESSION['admin_user']['username']); ?>!</p>

        <?php if (isset($_GET['message'])): ?>
            <p style="color: green;"><?= htmlspecialchars($_GET['message']); ?></p>
        <?php endif; ?>

        <h3>Applicants from <?= htmlspecialchars($admin_country_of_work); ?></h3>

        <table>
            <thead>
                <tr>
                    <th>Application ID</th>
                    <th>Applicant Name</th>
                    <th>Email</th>
                    <th>Visa Type</th>
                    <th>Status</th>
                    <th>Submission Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['application_id']); ?></td>
                            <td><?= htmlspecialchars($row['applicant_name']); ?></td>
                            <td><?= htmlspecialchars($row['email']); ?></td>
                            <td><?= htmlspecialchars($row['visa_type']); ?></td>
                            <td>
                                <form method="POST" style="margin: 0;">
                                    <input type="hidden" name="application_id" value="<?= $row['application_id']; ?>">
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="Pending" <?= $row['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="Approved" <?= $row['status'] === 'Approved' ? 'selected' : ''; ?>>Approved</option>
                                        <option value="Rejected" <?= $row['status'] === 'Rejected' ? 'selected' : ''; ?>>Rejected</option>
                                    </select>
                                    <input type="hidden" name="update_status" value="1">
                                </form>
                            </td>
                            <td><?= htmlspecialchars($row['submission_date']); ?></td>
                            <td class="action-links">
                                <a href="view_application.php?id=<?= $row['application_id']; ?>">View</a>
                                <a href="dashboard.php?delete=<?= $row['application_id']; ?>" onclick="return confirm('Are you sure you want to delete this application?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center;">No applicants found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>
</body>
</html>
