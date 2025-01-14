<?php
include 'databaseconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $_SESSION['passport_details'] = $_POST;
    header('Location: summary.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Visa Application - Passport Details</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: white; color: darkblue; }
        form { max-width: 9%0; margin: auto; padding: 20px; background: lightgray; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); }
        h2 { text-align: center; }
        label { font-weight: bold; display: block; margin-top: 15px; }
        input, select, button { width: 100%; padding: 10px; margin-top: 5px; border-radius: 5px; border: 1px solid #ccc; font-size: 16px; }
        button { background-color: crimson; color: white; font-weight: bold; cursor: pointer; }
        button:hover { background-color: darkred; }
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
    </style>
</head>

<header>
        <div><a href="index.html">Visa Application System</a></div>
        <div><a href="personal_details.php">Back</a></div>
    </header>
<body>
             <!-- applicants passport detail form -->
  
<form method="POST" enctype="multipart/form-data">
        <h2>Passport & Visa Details</h2>
        
        <label for="passport_number">Passport Number:</label>
        <input type="text" id="passport_number" name="passport_number" required>
        
        <label for="country_of_issue">Country of Issue:</label>
        <input type="text" id="country_of_issue" name="country_of_issue" required>

        <label for="expiry_date">Expiry Date:</label>
        <input type="date" id="expiry_date" name="expiry_date" required>
        
        <label for="passport_type">Passport Type:</label>
        <select id="passport_type" name="passport_type" required>
            <option value="Ordinary">Ordinary</option>
            <option value="Diplomatic">Diplomatic</option>
            <option value="Official">Official</option>
        </select>
        
       
        <!-- applicants visa detail form -->

        <label for="visa_type">Visa Type:</label>
        <select id="visa_type" name="visa_type" required>
            <option value="Tourist">Tourist</option>
            <option value="Business">Business</option>
            <option value="Student">Student</option>
            <option value="Work">Work</option>
            <option value="Other">Other</option>
        </select>
        
        <label for="visa_period">Visa Duration:</label>
        <select id="visa_period" name="visa_period" required>
            <option value="3 Months">3 Months</option>
            <option value="6 Months">6 Months</option>
            <option value="1 Year">1 Year</option>
            <option value="2 Years">2 Years</option>
        </select>
        
        <label for="visa_start_date">Visa Start Date:</label>
        <input type="date" id="visa_start_date" name="visa_start_date" required>
        
      
        <button type="submit">Next</button>
    </form>
</body>
</html>
