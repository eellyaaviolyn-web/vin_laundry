-- ===================================
-- DATABASE: LAUNDRY MANAGEMENT SYSTEM
-- Database Name: if0_41185945_laundry (InfinityFree)
-- ===================================

-- Create Database (if not exists - uncomment for localhost setup)
-- CREATE DATABASE IF NOT EXISTS `laundry_db`;
-- USE `laundry_db`;

-- For InfinityFree, database already exists, just create tables:
USE `if0_41185945_laundry`;

-- ===================================
-- TABLE: outlet (Outlets/Cabang)
-- ===================================
CREATE TABLE IF NOT EXISTS `outlet` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `address` TEXT NOT NULL,
  `phone` VARCHAR(15) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================
-- TABLE: user (Users/Pengguna)
-- ===================================
CREATE TABLE IF NOT EXISTS `user` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(20) NOT NULL DEFAULT 'operator',
  `outlet_id` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`outlet_id`) REFERENCES `outlet` (`id`) ON DELETE RESTRICT,
  INDEX `idx_email` (`email`),
  INDEX `idx_role` (`role`),
  INDEX `idx_outlet_id` (`outlet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================
-- TABLE: member (Members/Pelanggan)
-- ===================================
CREATE TABLE IF NOT EXISTS `member` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(15) NOT NULL,
  `email` VARCHAR(100),
  `address` TEXT NOT NULL,
  `outlet_id` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`outlet_id`) REFERENCES `outlet` (`id`) ON DELETE CASCADE,
  INDEX `idx_name` (`name`),
  INDEX `idx_phone` (`phone`),
  INDEX `idx_outlet_id` (`outlet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================
-- TABLE: logs (Activity Logs)
-- ===================================
CREATE TABLE IF NOT EXISTS `logs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `action` VARCHAR(50) NOT NULL,
  `description` TEXT,
  `ip_address` VARCHAR(45),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_action` (`action`),
  INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================
-- SAMPLE DATA (Optional)
-- ===================================

-- Insert Sample Outlets
INSERT INTO `outlet` (`name`, `address`, `phone`) VALUES
('Outlet Jakarta Pusat', 'Jl. Menteng No. 123, Jakarta Pusat', '021-1234567'),
('Outlet Jakarta Selatan', 'Jl. Fatmawati No. 456, Jakarta Selatan', '021-9876543'),
('Outlet Jakarta Barat', 'Jl. Gajah Mada No. 789, Jakarta Barat', '021-5555555');

-- Insert Sample Users
-- Password untuk testing: 
-- admin@laundry.local : admin123
-- operator1@laundry.local : operator123
-- operator2@laundry.local : operator123
-- manager1@laundry.local : manager123
INSERT INTO `user` (`name`, `email`, `password`, `role`, `outlet_id`) VALUES
('Admin Pusat', 'admin@laundry.local', 'admin123', 'admin', 1),
('Operator Pusat', 'operator1@laundry.local', 'operator123', 'operator', 1),
('Operator Selatan', 'operator2@laundry.local', 'operator123', 'operator', 2),
('Manager Barat', 'manager1@laundry.local', 'manager123', 'manager', 3);

-- Insert Sample Members
INSERT INTO `member` (`name`, `phone`, `email`, `address`, `outlet_id`) VALUES
('Budi Santoso', '081234567890', 'budi@email.com', 'Jl. Sudirman No. 10', 1),
('Siti Nurhaliza', '082345678901', 'siti@email.com', 'Jl. Diponegoro No. 20', 1),
('Ahmad Wijaya', '083456789012', 'ahmad@email.com', 'Jl. Gatot Subroto No. 30', 2),
('Dewi Lestari', '084567890123', 'dewi@email.com', 'Jl. Imam Bonjol No. 40', 3);
