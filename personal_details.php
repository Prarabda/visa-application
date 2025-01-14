<?php
include 'databaseconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $_SESSION['personal_details'] = $_POST;
    header('Location: passport_details.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Visa Application 1</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f2f2f2; margin: 0; padding: 0;">
    
<div style="background-color: darkblue; color: white; padding: 20px; text-align: center;">
    <h1 style="margin: 0;">
        <a href="index.html" style="color: white;">Online Visa Application Form</a>
    </h1>
</div>

   
    <div style="
        max-width: 600px; 
        margin: 30px auto; 
        padding: 20px; 
        background-color: white; 
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
        border-radius: 10px;
    ">
        <h2 style="text-align: center; color: crimson;">Personal Information</h2>
        <p style="text-align: center; color: gray;">Please provide your personal details to start your visa application.</p>

             <!-- applicant detail form -->

        <form method="POST" style="display: flex; flex-direction: column; gap: 15px;">
            <div style="display: flex; gap: 10px;">
                <div style="flex: 1;">
                    <label for="first_name" style="font-weight: bold; color: darkblue;">First Name:</label>
                    <input type="text" id="first_name" name="first_name" placeholder="Enter your first name" required style="
                        padding: 10px; 
                        border: 1px solid #ccc; 
                        border-radius: 5px; 
                        font-size: 16px; 
                        width: 100%;
                    ">
                </div>
                <div style="flex: 1;">
                    <label for="last_name" style="font-weight: bold; color: darkblue;">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" placeholder="Enter your last name" required style="
                        padding: 10px; 
                        border: 1px solid #ccc; 
                        border-radius: 5px; 
                        font-size: 16px; 
                        width: 100%;
                    ">
                </div>
            </div>

            <label for="email" style="font-weight: bold; color: darkblue;">Email Address:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required style="
                padding: 10px; 
                border: 1px solid #ccc; 
                border-radius: 5px; 
                font-size: 16px;">

            <label for="dob" style="font-weight: bold; color: darkblue;">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required style="
                padding: 10px; 
                border: 1px solid #ccc; 
                border-radius: 5px; 
                font-size: 16px;">

        
            <label for="phone" style="font-weight: bold; color: darkblue;">Phone Number:</label>
            <input type="text" id="phone" name="phone" placeholder="Enter your phone number" required style="
                padding: 10px; 
                border: 1px solid #ccc; 
                border-radius: 5px; 
                font-size: 16px;">

            
            <label for="nationality" style="font-weight: bold; color: darkblue;">Nationality:</label>
            <input type="text" id="nationality" name="nationality" placeholder="Enter your nationality" required style="
                padding: 10px; 
                border: 1px solid #ccc; 
                border-radius: 5px; 
                font-size: 16px;">

            
            <label for="country_of_application" style="font-weight: bold; color: darkblue;">Country of Application:</label>
            <input type="text" id="country_of_application" name="country_of_application" placeholder="Enter the country where you are applying" required style="
                padding: 10px; 
                border: 1px solid #ccc; 
                border-radius: 5px; 
                font-size: 16px;">

            <button type="submit" style="
                background-color: crimson; 
                color: white; 
                padding: 12px; 
                font-size: 18px; 
                font-weight: bold; 
                border: none; 
                border-radius: 5px; 
                cursor: pointer;
                margin-top: 10px;
            ">Next</button>
        </form>
    </div>
</body>
</html>
