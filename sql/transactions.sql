CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('expense', 'income') NOT NULL,
    description VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    category VARCHAR(50) NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE transactions
ADD COLUMN user_id INT;

ALTER TABLE transactions
ADD CONSTRAINT fk_user_id
FOREIGN KEY (user_id) REFERENCES users(user_id);
