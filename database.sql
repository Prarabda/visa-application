
CREATE DATABASE visa_application;

USE visa_application;

-- Table admin users
CREATE TABLE admin_users (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    country_of_work VARCHAR(50) NOT NULL,
    last_login DATETIME
);

-- Table visa applications
CREATE TABLE applications (
    application_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) DEFAULT NULL,
    email VARCHAR(100) NOT NULL,
    dob DATE NOT NULL,
    phone_number VARCHAR(15) NOT NULL,
    nationality VARCHAR(50) NOT NULL,
    country_of_application VARCHAR(50) NOT NULL,
    status VARCHAR(20) DEFAULT 'Pending',
    submission_date DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table passport details
CREATE TABLE passport_details (
    passport_id INT AUTO_INCREMENT PRIMARY KEY,
    application_id INT NOT NULL,
    passport_number VARCHAR(20) NOT NULL UNIQUE,
    country_of_issue VARCHAR(50) NOT NULL,
    passport_expiry_date DATE NOT NULL,
    passport_type VARCHAR(20) NOT NULL,
    passport_photo VARCHAR(255) NOT NULL,
    FOREIGN KEY (application_id) REFERENCES applications(application_id) ON DELETE CASCADE
);

-- Table visa details
CREATE TABLE visa_details (
    visa_id INT AUTO_INCREMENT PRIMARY KEY,
    application_id INT NOT NULL,
    visa_type_id VARCHAR(50) NOT NULL,
    visa_period VARCHAR(20) NOT NULL,
    visa_issue_date DATE NOT NULL DEFAULT CURRENT_DATE,
    visa_start_date DATE NOT NULL,
    visa_end_date DATE DEFAULT NULL,
    description TEXT DEFAULT NULL,
    FOREIGN KEY (application_id) REFERENCES applications(application_id) ON DELETE CASCADE
);
