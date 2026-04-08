# SecureShare

SecureShare is a cloud-based file sharing system that provides secure and controlled access to files using passcode protection, expiry control, and request-based approval.

---

## Features

- File upload with passcode protection  
- Expiry-based file access  
- Secure file download  
- Request access after expiry  
- Admin approval system  
- Cloud deployment on AWS  

---

## Technologies Used

- AWS EC2 (Cloud Hosting)  
- Linux  
- Nginx (Web Server)  
- PHP (Backend)  
- MariaDB (Database)  
- HTML, CSS, Bootstrap (Frontend)  

---

## System Architecture

Client → Nginx → PHP → Database → File Storage  

---

## Working

1. User uploads file with passcode and expiry  
2. File is stored on server and metadata saved in database  
3. User enters passcode to download  
4. System checks passcode and expiry  
5. If expired → request access  
6. Admin approves → expiry extended  
7. File is downloaded  

---

## Project Structure
SecureShare/
│── index.php
│── download.php
│── finalUpload.php
│── requests.php
│── initialFile.php
│── navbar.php
│── assets/
│── uploads/
│── screenshots/
│── report/
│── ppt/

---
---

## How to Run

1. Install LEMP stack (Linux, Nginx, PHP, MariaDB)  
2. Place project files in `/usr/share/nginx/html`  
3. Start services:
   - sudo systemctl start nginx  
   - sudo systemctl start php-fpm  
   - sudo systemctl start mariadb  
4. Open browser and enter EC2 public IP  

---

## Future Improvements

- HTTPS (SSL/TLS encryption)  
- User authentication system  
- File preview feature  
- Improved security mechanisms  

---
