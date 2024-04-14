CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('expense', 'income') NOT NULL,
    description VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    category VARCHAR(50) NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
