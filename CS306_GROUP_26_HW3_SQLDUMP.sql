 CREATE DATABASE PharmacyDB;
 USE PharmacyDB;
 -- Pharmacy Table
 CREATE TABLE Pharmacy (
 pharmacy_id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(255) NOT NULL,
 location VARCHAR(255) NOT NULL
 );
 -- Medicine Table
 CREATE TABLE Medicine (
 medicine_id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(255) NOT NULL,
 manufacturer VARCHAR(255),
 expiration_date DATE,
 price DECIMAL(10,2),
stock_quantity INT DEFAULT 0
 );
 -- Supplier Table
 CREATE TABLE Supplier (
 supplier_id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(255) NOT NULL,
 contact_info VARCHAR(255)
 );
  -- Customer Table
 CREATE TABLE Customer (
 customer_id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(255) NOT NULL,
 contact_info VARCHAR(255)
 );
 -- Orders Table
 CREATE TABLE Orders (
 order_id INT AUTO_INCREMENT PRIMARY KEY,
 order_date DATE NOT NULL,
 total_amount DECIMAL(10,2),
 customer_id INT,
 FOREIGN KEY (customer_id) REFERENCES Customer(
 customer_id) ON DELETE CASCADE
 );
 -- Prescription Table
 CREATE TABLE Prescription (
 prescription_id INT AUTO_INCREMENT PRIMARY KEY,
 doctor_name VARCHAR(255) NOT NULL,
 issued_date DATE NOT NULL,
 customer_id INT,
 order_id INT,
 FOREIGN KEY (customer_id) REFERENCES Customer(
 customer_id) ON DELETE CASCADE,
 FOREIGN KEY (order_id) REFERENCES Orders(order_id)
 ON DELETE CASCADE
 );
 -- Employee Table
 CREATE TABLE Employee (
 employee_id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(255) NOT NULL,
 role VARCHAR(100),
 salary DECIMAL(10,2),
pharmacy_id INT,
 FOREIGN KEY (pharmacy_id) REFERENCES Pharmacy(
 pharmacy_id) ON DELETE CASCADE
 );
 -- Transaction Table
 CREATE TABLE TransactionTable (
 transaction_id INT AUTO_INCREMENT PRIMARY KEY,
 transaction_date DATE NOT NULL,
 payment_method VARCHAR(50) NOT NULL,
 order_id INT,
 FOREIGN KEY (order_id) REFERENCES Orders(order_id)
 ON DELETE CASCADE
 );
 -- Pharmacy_Medicine Table (Many-to-Many)
 CREATE TABLE Pharmacy_Medicine (
 pharmacy_id INT,
 medicine_id INT,
 stock_quantity INT DEFAULT 0,
 PRIMARY KEY (pharmacy_id, medicine_id),
 FOREIGN KEY (pharmacy_id) REFERENCES Pharmacy(
 pharmacy_id) ON DELETE CASCADE,
 FOREIGN KEY (medicine_id) REFERENCES Medicine(
 medicine_id) ON DELETE CASCADE
 );
 -- Supplier_Medicine Table (Many-to-Many)
 CREATE TABLE Supplier_Medicine (
 supplier_id INT,
 medicine_id INT,
 PRIMARY KEY (supplier_id, medicine_id),
 FOREIGN KEY (supplier_id) REFERENCES Supplier(
 supplier_id) ON DELETE CASCADE,
 FOREIGN KEY (medicine_id) REFERENCES Medicine(
 medicine_id) ON DELETE CASCADE
 );
 -- Order_Medicine Table (Many-to-Many)
 CREATE TABLE Order_Medicine (
 order_id INT,
 medicine_id INT,
 quantity INT NOT NULL,
 PRIMARY KEY (order_id, medicine_id),
 FOREIGN KEY (order_id) REFERENCES Orders(order_id)
 ON DELETE CASCADE,
FOREIGN KEY (medicine_id) REFERENCES Medicine(
 medicine_id) ON DELETE CASCADE
 );
 
 
 
 -- Insert data into Pharmacy
 INSERT INTO Pharmacy (name, location) VALUES
 ('Central␣Pharmacy', 'Downtown'),
 ('Green␣Health', 'Uptown'),
 ('CarePlus␣Pharmacy', 'Suburb␣A'),
 ('MediTrust', 'Suburb␣B'),
 ('HealthFirst', 'City␣Center'),
 ('WellCare␣Pharmacy', 'North␣District'),
 ('PharmaPoint', 'Westside'),
 ('GoodMed', 'Eastside'),
 ('VitalCare', 'Southside'),
 ('SafeMeds', 'Lakeside');-- Insert data into Medicine
 INSERT INTO Medicine (name, manufacturer, expiration_date, price,
 stock_quantity) VALUES
 ('Paracetamol', 'XYZ␣Pharma', '2026-12-31', 5.00, 100),
 ('Ibuprofen', 'ABC␣Pharmaceuticals', '2025-10-20', 8.50, 200),
 ('Aspirin', 'MediCorp', '2026-08-15', 7.00, 150),
 ('Antibiotic␣A', 'MediLife', '2027-03-10', 20.00, 50),
 ('Vitamin␣C', 'Wellness␣Inc.', '2025-12-01', 10.00, 300),
 ('Cough␣Syrup', 'PharmaTrust', '2024-11-25', 15.00, 120),
 ('Allergy␣Relief', 'HealthGen', '2025-06-30', 12.00, 80),
 ('Antacid', 'Acme␣Drugs', '2026-04-05', 6.00, 250),
 ('Pain␣Reliever', 'Relief␣Pharmaceuticals', '2025-09-15',
 9.50, 180),
 ('Flu␣Medicine', 'MediCure', '2026-07-20', 14.00, 140);-- Insert data into Supplier
 INSERT INTO Supplier (name, contact_info) VALUES
 ('ABC␣Suppliers', 'abc@suppliers.com'),
 ('MediLife␣Distributors', 'medilife@supply.com'),
 ('Global␣Pharma', 'global@pharma.com'),
 ('HealthCare␣Logistics', 'health@supply.com'),
 ('FastMed␣Supply', 'fastmed@suppliers.com'),
 ('Reliable␣Drugs', 'reliable@drugs.com'),
 ('SafeMeds␣Distributors', 'safemeds@supply.com'),
 ('Prime␣Pharma', 'prime@pharma.com'),
 ('MedExpress', 'medexpress@suppliers.com'),
 ('PharmaDirect', 'direct@pharma.com');-- Insert data into Customer
 INSERT INTO Customer (name, contact_info) VALUES
 ('John␣Doe', 'john.doe@example.com'),
 ('Jane␣Smith', 'jane.smith@example.com'),
 ('Michael␣Johnson', 'michael.j@example.com'),
 ('Emily␣Brown', 'emily.b@example.com'),
 ('Chris␣Wilson', 'chris.w@example.com'),
 ('Sarah␣Lee', 'sarah.lee@example.com'),
 ('David␣Anderson', 'david.a@example.com'),
 ('Olivia␣Martinez', 'olivia.m@example.com'),
 ('Daniel␣White', 'daniel.w@example.com'),
 ('Emma␣Harris', 'emma.h@example.com');-- Insert data into Orders
 INSERT INTO Orders (order_date, total_amount, customer_id) VALUES
 ('2025-02-01', 50.00, 1),
 ('2025-02-02', 75.00, 2),
 ('2025-02-03', 40.00, 3),
 ('2025-02-04', 60.00, 4),
 ('2025-02-05', 90.00, 5),
 ('2025-02-06', 120.00, 6),
 ('2025-02-07', 35.00, 7),
 ('2025-02-08', 110.00, 8),
 ('2025-02-09', 80.00, 9),
 ('2025-02-10', 95.00, 10);-- Insert data into Prescription
 INSERT INTO Prescription (doctor_name, issued_date, customer_id,
 order_id) VALUES
 ('Dr.␣Adams', '2025-02-01', 1, 1),
 ('Dr.␣Baker', '2025-02-02', 2, 2),
 ('Dr.␣Carter', '2025-02-03', 3, 3),
 ('Dr.␣Daniels', '2025-02-04', 4, 4),
 ('Dr.␣Evans', '2025-02-05', 5, 5),
 ('Dr.␣Foster', '2025-02-06', 6, 6),
 ('Dr.␣Green', '2025-02-07', 7, 7),
 ('Dr.␣Harris', '2025-02-08', 8, 8),
 ('Dr.␣Irving', '2025-02-09', 9, 9),
 ('Dr.␣Johnson', '2025-02-10', 10, 10);-- Insert data into Employee
 INSERT INTO Employee (name, role, salary, pharmacy_id) VALUES
 ('Alice␣Johnson', 'Pharmacist', 5000, 1),
 ('Bob␣Smith', 'Technician', 3500, 2),
 ('Charlie␣Brown', 'Cashier', 2800, 3),
 ('David␣Wilson', 'Manager', 6000, 4),
 ('Emma␣Davis', 'Pharmacist', 5200, 5),
 ('Frank␣Thomas', 'Technician', 3400, 6),
 ('Grace␣Lee', 'Cashier', 2900, 7),
 ('Henry␣White', 'Manager', 5800, 8),
 ('Isabella␣Harris', 'Pharmacist', 5100, 9),
 ('Jack␣Anderson', 'Technician', 3300, 10);-- Insert data into TransactionTable
 INSERT INTO TransactionTable (transaction_date, payment_method,
 order_id) VALUES
 ('2025-02-01', 'Credit␣Card', 1),
 ('2025-02-02', 'Cash', 2),
 ('2025-02-03', 'Credit␣Card', 3),
 ('2025-02-04', 'Debit␣Card', 4),
 ('2025-02-05', 'Cash', 5),
 ('2025-02-06', 'Credit␣Card', 6),
 ('2025-02-07', 'Debit␣Card', 7),
 ('2025-02-08', 'Cash', 8),
 ('2025-02-09', 'Credit␣Card', 9),
 ('2025-02-10', 'Debit␣Card', 10);-- Insert data into Pharmacy_Medicine (Many-to-Many)
 INSERT INTO Pharmacy_Medicine (pharmacy_id, medicine_id,
 stock_quantity) VALUES
 (1, 1, 50), (2, 2, 80), (3, 3, 60), (4, 4, 40),
 (5, 5, 90), (6, 6, 100), (7, 7, 120), (8, 8, 110),
 (9, 9, 75), (10, 10, 95);-- Insert data into Supplier_Medicine (Many-to-Many)
 INSERT INTO Supplier_Medicine (supplier_id, medicine_id) VALUES
 (1, 1), (2, 2), (3, 3), (4, 4), (5, 5), (6, 6), (7, 7), (8, 8)
 , (9, 9), (10, 10);-- Insert data into Order_Medicine (Many-to-Many)
 INSERT INTO Order_Medicine (order_id, medicine_id, quantity)
 VALUES
 (1, 1, 2), (2, 2, 3), (3, 3, 1), (4, 4, 5), (5, 5, 2),
 (6, 6, 3), (7, 7, 1), (8, 8, 4), (9, 9, 2), (10, 10, 3);
 
 
 -- =============================================================================
-- Trigger and Stored Procedure Definitions for PharmacyDB
-- =============================================================================

-- -----------------------------------------------------------------------------
-- TRIGGER: prevent_zero_quantity_orders
-- Fires BEFORE inserting into Order_Medicine.
-- Rejects any order where quantity = 0 by raising SQLSTATE '45000'.
-- -----------------------------------------------------------------------------
DELIMITER $$
CREATE TRIGGER prevent_zero_quantity_orders
BEFORE INSERT ON Order_Medicine
FOR EACH ROW
BEGIN
    IF NEW.quantity = 0 THEN
        SIGNAL SQLSTATE '45000'
          SET MESSAGE_TEXT = 'Quantity must be greater than 0.';
    END IF;
END $$
DELIMITER ;

-- -----------------------------------------------------------------------------
-- TRIGGER: prevent_expired_medicine_order
-- Fires BEFORE inserting into Order_Medicine.
-- Checks expiration_date in Medicine; if expired (< current date),
-- raises SQLSTATE '45000' to block the insert.
-- -----------------------------------------------------------------------------
DELIMITER $$
CREATE TRIGGER prevent_expired_medicine_order
BEFORE INSERT ON Order_Medicine
FOR EACH ROW
BEGIN
    DECLARE expiry DATE;
    SELECT expiration_date INTO expiry
      FROM Medicine
     WHERE medicine_id = NEW.medicine_id;
    IF expiry < CURDATE() THEN
        SIGNAL SQLSTATE '45000'
          SET MESSAGE_TEXT = 'Cannot order expired medicine.';
    END IF;
END $$
DELIMITER ;

-- -----------------------------------------------------------------------------
-- TRIGGER: update_stock_after_order
-- Fires AFTER inserting into Order_Medicine.
-- Decrements the stock_quantity in Pharmacy_Medicine
-- by the NEW.quantity for the ordered medicine.
-- -----------------------------------------------------------------------------
DELIMITER $$
CREATE TRIGGER update_stock_after_order
AFTER INSERT ON Order_Medicine
FOR EACH ROW
BEGIN
    UPDATE Pharmacy_Medicine
       SET stock_quantity = stock_quantity - NEW.quantity
     WHERE medicine_id = NEW.medicine_id;
END $$
DELIMITER ;

-- =============================================================================
-- STORED PROCEDURES
-- =============================================================================

-- -----------------------------------------------------------------------------
-- PROCEDURE: GetLowStockMedicines(IN p_threshold INT)
-- Returns all medicines whose stock_quantity is less than the given threshold.
-- INPUT: p_threshold — an integer cutoff for low stock.
-- -----------------------------------------------------------------------------
DELIMITER $$
CREATE PROCEDURE GetLowStockMedicines (
    IN p_threshold INT
)
BEGIN
    SELECT
        medicine_id,
        name,
        stock_quantity
    FROM Medicine
    WHERE stock_quantity < p_threshold;
END $$
DELIMITER ;

-- -----------------------------------------------------------------------------
-- PROCEDURE: GenerateCustomerOrderReport(IN p_customer_id INT)
-- Produces a summary for a single customer:
--   • total_orders — count of orders placed
--   • total_amount  — sum of total_amount across their orders
--   • last_order_date — most recent order_date
-- INPUT: p_customer_id — the ID of the customer to report on.
-- -----------------------------------------------------------------------------
DELIMITER $$
CREATE PROCEDURE GenerateCustomerOrderReport (
    IN p_customer_id INT
)
BEGIN
    SELECT
        COUNT(*)        AS total_orders,
        SUM(total_amount) AS total_amount,
        MAX(order_date) AS last_order_date
    FROM Orders
    WHERE customer_id = p_customer_id;
END $$
DELIMITER ;

-- -----------------------------------------------------------------------------
-- PROCEDURE: CreateOrderWithStockUpdate(
--     IN p_customer_id INT,
--     IN p_medicine_id INT,
--     IN p_quantity INT
-- )
-- Creates a new order and automatically inserts into Order_Medicine.
--   1) Inserts into Orders with current date and calculated total_amount
--   2) Retrieves new order_id via LAST_INSERT_ID()
--   3) Inserts into Order_Medicine to record the item and quantity.
-- Note: The update_stock_after_order trigger will then adjust stock.
-- INPUTS:
--   p_customer_id  — ID of the ordering customer
--   p_medicine_id  — ID of the medicine to order
--   p_quantity     — quantity to order (must be > 0 and not expired)
-- -----------------------------------------------------------------------------
DELIMITER $$
CREATE PROCEDURE CreateOrderWithStockUpdate (
    IN p_customer_id INT,
    IN p_medicine_id INT,
    IN p_quantity INT
)
BEGIN
    -- 1. Create the order record
    INSERT INTO Orders(order_date, total_amount, customer_id)
    VALUES (
        CURDATE(),
        p_quantity * (
            SELECT price
            FROM Medicine
            WHERE medicine_id = p_medicine_id
        ),
        p_customer_id
    );

    -- 2. Capture the new order ID
    SET @new_oid = LAST_INSERT_ID();

    -- 3. Insert the line item, firing the stock‐update trigger
    INSERT INTO Order_Medicine(order_id, medicine_id, quantity)
    VALUES (@new_oid, p_medicine_id, p_quantity);
END $$
DELIMITER ;
