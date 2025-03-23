CREATE DATABASE billing_system;
USE billing_system;
CREATE TABLE Customers(
id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(255),
    address TEXT
);
CREATE TABLE Products(
id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100),
    Selling_price DECIMAL(10,2) NOT NULL,
   Added_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Sales(
id INT AUTO_INCREMENT PRIMARY KEY,
customer_id INT,
product_id INT,
quantity INT NOT NULL,
unit_price DECIMAL(10,2) NOT NULL,
total_price DECIMAL(10,2) NOT NULL,
discount DECIMAL(10,2) DEFAULT 0,
final_amount DECIMAL(10,2) NOT NULL,
payment_method ENUM('Cash','UPI','Card','Other') NOT NULL,
purchase_date DATETIME DEFAULT CURRENT_TIMESTAMP,
status ENUM('Pending','Completed','Refund') DEFAULT 'Completed',
FOREIGN KEY(customer_id) REFERENCES Customers(id),
FOREIGN KEY(product_id) REFERENCES Products(id)
);






CREATE TABLE Expenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    expense_Type VARCHAR(255) NOT NULL,
    category ENUM('Fixed', 'Variable') NOT NULL DEFAULT 'Variable',
    amount DECIMAL(10,2) NOT NULL,
    paid_To VARCHAR(255) NULL,
    payment_Method ENUM('Cash','Card','Online','UPI','Bank Transfer') NOT NULL,
    expense_Date DATE NOT NULL,
    recurring ENUM('Yes', 'No') NOT NULL DEFAULT 'No',
    invoice_Number VARCHAR(255) UNIQUE NULL,
    notes TEXT NULL
);


CREATE TABLE Stocks(
id INT AUTO_INCREMENT PRIMARY KEY,
   product_id INT NOT NULL,
   quantity INT NOT NULL,
   purchase_price DECIMAL(10,2) NOT NULL,
   supplier_name VARCHAR(255) NOT NULL,
   purchase_date DATE NOT NULL,
   expiry_date DATE,
   Added_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   FOREIGN KEY(product_id) REFERENCES Products(id) ON DELETE CASCADE
);



SET SQL_SAFE_UPDATES = 0;


SELECT @@SQL_MODE;
SET SQL_MODE='';



ALTER TABLE Stocks
ADD COLUMN category VARCHAR(225);




DELIMITER //

CREATE PROCEDURE AddStock(
    IN p_name VARCHAR(255),
    IN p_category VARCHAR(100),
    IN p_selling_price DECIMAL(10,2),
    IN s_quantity INT,
    IN s_purchase_price DECIMAL(10,2),
    IN s_supplier_name VARCHAR(255),
    IN s_purchase_date DATE,
    IN s_expiry_date DATE
)
BEGIN
    DECLARE p_id INT;

    -- Check if the product already exists
    SELECT id INTO p_id FROM Products WHERE name = p_name LIMIT 1;

    -- If product does not exist, insert it
    IF p_id IS NULL THEN
        INSERT INTO Products (name,category,Selling_price,Added_date)
        VALUES (p_name,p_category,p_selling_price,NOW());
        
        -- Get the newly inserted product ID
        SET p_id = LAST_INSERT_ID();
    END IF;

    -- Insert into stock table
    INSERT INTO Stocks(product_id,quantity,purchase_price,supplier_name,purchase_date,expiry_date,Added_date)
    VALUES (p_id,s_quantity,s_purchase_price,s_supplier_name,s_purchase_date,s_expiry_date,NOW());
END //

DELIMITER ;


CALL AddStock(
    'Apple Juice',       
    'Beverages',         
    50.00,               
    100,                 
    30.00,               
    'Juice Supplier Co', 
    '2025-03-15',        
    '2025-09-15'         
);





SELECT p.name, p.Selling_price, s.quantity,
COALESCE(SUM(s.quantity),0) AS available_stock
FROM Products p 
JOIN Stocks s ON p.id = s.product_id 
WHERE p.id = 3;

SELECT * FROM Sales;

ALTER TABLE Sales
CHANGE discount discount DECIMAL(5,2) DEFAULT 0;

SELECT * FROM Stocks;

SELECT * FROM Customers;
## Do check by selecting all from tables to ensure that the columns written in the script are present in the actual table.If you find a column in the table but not in the code, it might have been updated,so don't get confused.