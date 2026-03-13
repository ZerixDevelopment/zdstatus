# 🚀 Custom Status Panel

A lightweight, self-hosted Status Page and Monitoring System built with PHP, MySQL, and Bootstrap 5. It automatically monitors websites and servers, reports incidents, and provides an easy-to-use admin interface.

## ✨ Features

* **Real-time Monitoring:** Automatically checks if your websites (HTTP/HTTPS) or servers (IP) are online.
* **Auto-Incident Management:** * Creates an incident automatically when a service goes **offline**.
    * Automatically resolves (deletes) the incident when the service comes back **online**.
* **Modern Admin Dashboard:** English-language interface with quick stats for Services, Incidents, and Admins.
* **Secure Authentication:** Admin accounts are protected with `password_hash` (Bcrypt) encryption.
* **Responsive Design:** Fully mobile-friendly UI using Bootstrap 5 and Lucide Icons.

## 🛠️ Installation

1.  **Database Setup:**
    * Create a database named `status` in phpMyAdmin.
    * Import your tables (`services`, `incidents`, `users`, `maintenance`).

2.  **Configuration:**
    * Edit `db.php` in the root folder with your database credentials:
    ```php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "status";
    ```

3.  **Create Admin:**
    * Use the `users` section in the admin panel to create your first administrator account.

## 📈 Monitoring Setup

To keep the status updated automatically, the file `admin/check_status.php` needs to be triggered regularly.

### Windows (XAMPP)
You can use a "Browser Auto Refresh" extension or a Cron-job tool to hit:
`http://localhost/admin/check_status.php` every 1 or 5 minutes.

### Linux (Server)
Add a crontab entry:
```bash
*/5 * * * * php /var/www/html/admin/check_status.php