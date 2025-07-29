-- Create admin_users table
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert initial admin user
INSERT INTO admin_users (username, password) 
VALUES ('Admin', '$2y$08$PHlBGkSNhfZLhmNslhZvP.39HjGKXxMdFIYbpgStJKAsM7s.62tHa');
-- Note: The password is 'password123' (hashed using PHP's password_hash)
