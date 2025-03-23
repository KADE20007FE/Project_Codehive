# Project_Codehive

## WebApp -> Billing Application

Welcome to the Billing Application! This web-based application allows you to manage sales, inventory, and generate bills efficiently.

---

## Features
- 🛒 **Easy Checkout**: Streamline your checkout process with our user-friendly interface.
- 📦 **Inventory Management**: Keep track of your stock levels and manage your inventory efficiently.

---

## How to Download
1. 📥 **Click the `Code` button** on the GitHub repository page.
2. 📦 **Select `Download ZIP`**.
3. 💻 **Extract the downloaded ZIP file** to your device (suggested: laptop).

---

## Installation
1. 🛠️ **Ensure you have [XAMPP](https://www.apachefriends.org/index.html) installed** on your device.
2. 📂 **Move the extracted folder** to the `htdocs` directory inside your XAMPP installation directory (e.g., `C:\xampp\htdocs\Billing_app`).

---

## Database Setup
1. 🟢 **Start Apache and MySQL** from the XAMPP Control Panel.
2. 🌐 **Open your web browser** and go to `http://localhost/phpmyadmin`.
3. 🗄️ **Create a new database** named `billing_system`.
   - **Note**: I have given a code you have to paste that in MySQL after installing XAMPP (don't make in web browser).
4. 📄 **Import the provided SQL file** (`billing_app.sql`) into the `billing_system database.

---

## Configuration (skip this step if everything matches)
1. 📝 **Open the `db_connect.php` file** and update the database connection details if necessary:
    ```php
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "billing_system";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    ?>
    ```
## Note this file already exists in this folder.
---

## Usage
1. 🌐 **Open your web browser** and go to `http://localhost/Billing_app/Project_Codehive/index.html`.
2. 🧭 **Use the navigation links** to access different parts of the application:
    - 🛒 **Checkout**: Manage sales and generate bills.

---

## Troubleshooting
- 🟢 **Ensure that Apache and MySQL are running** in the XAMPP Control Panel.
- 📝 **Check the database connection details** in `db_connect.php`.
- 🗄️ **Verify that the database and tables are correctly set up** in phpMyAdmin.

---

