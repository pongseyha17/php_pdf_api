CREATE DATABASE pdf_api_db;
USE pdf_api_db;

CREATE TABLE pdf_files (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  file_name VARCHAR(255),
  thumbnail VARCHAR(255),
  status ENUM('enabled', 'disabled') DEFAULT 'enabled',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
