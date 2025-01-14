
# Visa Application Website
The Visa Application website is a comprehensive web application designed to streamline the visa application process for users and provide administrative tools for visa officers. This project is built with scalability, security, and user-friendliness in mind.
The system is designed to automate and digitize the traditional visa application workflow, ensuring accuracy, accessibility, and efficiency.

## **Features**

### **For Users:**

1. **Visa Application Form:**  
   - A **multi-page form** designed to collect comprehensive user details:
     - **Page 1(Personal_detail.php) :** Personal information, including full name, date of birth, phone number, nationality, and the country of application.
     - **Page 2(Passport_detail.php ):**  Passport details (e.g., passport number, country of issue, expiry date, passport type) and visa preferences (visa type, duration, and start date).

2. **View and Confirm:**  
   - After filling out the form, users are presented with a **summary page** where all the input data is displayed for review.
   - Users can confirm the details and submit the form, which stores the application in the database.

3. **Application Status Check:**  
   - Users can **track their application status** by entering their **passport number** on the status check page.
   - The system provides key information, including:
     - **Application Number**
     - **Visa Type**
     - **Application Status** (Pending, Approved, or Rejected).

### **For Admins:**
- **Admin Login:** Secure admin login with password hashing.
- **Dashboard Management:**
  - View all visa applications filtered by the admin's assigned country of work.
  - Update application statuses (Pending, Approved, Rejected).
  - Delete applications.
  - View detailed information for each application.
- **Admin Registration:** Ability to add new admin users via a registration form.
  

## **Technologies Used**

- **Backend:** PHP
- **Database:** MySQL
- **Frontend:** HTML, CSS (with inline styling)
- **Web Server:** XAMPP (Apache)


## **Usage**

### **User Workflow:**
2. **Fill Out the Form:** Provide personal, passport, and visa details.
3. **Check Status:** Use your passport number to track your application's status.

### **Admin Workflow:**
1. **Login:** Access the admin dashboard using valid credentials.
2. **Manage Applications:**
   - View applications.
   - Update application statuses.
   - Delete applications.
3. **Add New Admins:** Use the admin registration page to add new administrators.

### **Database**:
**Key Tables:**
applications: Stores user application data, including personal and status details.
passport_details: Contains passport-related information.
visa_details: Manages visa preferences and additional details.
email_verifications: Handles email validation tokens.
admin_users: Manages admin accounts and access control.
