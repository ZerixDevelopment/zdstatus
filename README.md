# 📊 Status Monitor System (Light Mode)

A professional, lightweight status page system built with **PHP**, **MySQL**, and **Bootstrap 5**. Monitor your websites and IP addresses, report incidents, and schedule maintenance through a clean administrative dashboard.

## 🚀 Quick Start (XAMPP)

1. **Database Setup**:
   - Open **phpMyAdmin**.
   - Create a new database named `calender`.
   - Run the following SQL to create the necessary tables:
     ```sql
     CREATE TABLE users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(50) UNIQUE, password VARCHAR(255));
     CREATE TABLE services (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100), type ENUM('website', 'ip'), target VARCHAR(255), status ENUM('online', 'offline') DEFAULT 'online');
     CREATE TABLE incidents (id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(255), description TEXT, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
     CREATE TABLE maintenance (id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(255), description TEXT, scheduled_date DATETIME);
     ```

2. **Default Credentials**:
   - Navigation: `http://localhost/admin/login.php`
   - **Username**: `admin`
   - **Password**: `admin123`
   *Note: Accessing `admin/users.php` will automatically create this user if it doesn't exist.*

3. **Monitoring**:
   - To update service statuses, run `check_status.php` manually or set up a Cron job/Task Scheduler.

## 📂 Folder Structure

```text
C:\xampp\htdocs\
├── index.php             # Public status page
├── db.php                # Database connection settings
├── style.css             # Light-mode UI styling
├── check_status.php      # Automation script (Pings URLs/IPs)
└── admin\                # Protected directory
    ├── index.php         # Admin Dashboard
    ├── services.php      # Manage Websites & IPs
    ├── incidents.php     # Report system outages
    ├── maintenance.php   # Plan server work
    ├──
