-- Create the Pharmacy table
CREATE TABLE Pharmacy (
    pharmacy_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL
);

-- Create the Medicine table
CREATE TABLE Medicine (
    medicine_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    manufacturer VARCHAR(255),
    expiration_date DATE,
    price DECIMAL(10,2),
    stock_quantity INT
);

-- Create the Supplier table
CREATE TABLE Supplier (
    supplier_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    contact_info VARCHAR(255)
);

-- Create the Customer table
CREATE TABLE Customer (
    customer_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    contact_info VARCHAR(255)
);

-- Create the Order table
CREATE TABLE Orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    order_date DATE NOT NULL,
    total_amount DECIMAL(10,2),
    customer_id INT,
    FOREIGN KEY (customer_id) REFERENCES Customer(customer_id) ON DELETE CASCADE
);

-- Create the Prescription table
CREATE TABLE Prescription (
    prescription_id INT PRIMARY KEY AUTO_INCREMENT,
    doctor_name VARCHAR(255) NOT NULL,
    issued_date DATE NOT NULL,
    customer_id INT,
    order_id INT, 
    FOREIGN KEY (customer_id) REFERENCES Customer(customer_id) ON DELETE CASCADE,
    FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE
);

-- Create the Employee table
CREATE TABLE Employee (
    employee_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    role VARCHAR(100),
    salary DECIMAL(10,2),
    pharmacy_id INT,
    FOREIGN KEY (pharmacy_id) REFERENCES Pharmacy(pharmacy_id) ON DELETE CASCADE
);

-- Create the Transaction table (One-to-One with Orders)
CREATE TABLE TransactionTable (
    transaction_id INT PRIMARY KEY AUTO_INCREMENT,
    transaction_date DATE NOT NULL,
    payment_method VARCHAR(50),
    order_id INT UNIQUE, -- Ensuring One-to-One relation
    FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE
);

-- Create the many-to-many relationship between Pharmacy and Medicine
CREATE TABLE Pharmacy_Medicine (
    pharmacy_id INT,
    medicine_id INT,
    stock_quantity INT DEFAULT 0,
    PRIMARY KEY (pharmacy_id, medicine_id),
    FOREIGN KEY (pharmacy_id) REFERENCES Pharmacy(pharmacy_id) ON DELETE CASCADE,
    FOREIGN KEY (medicine_id) REFERENCES Medicine(medicine_id) ON DELETE CASCADE
);

-- Create the many-to-many relationship between Supplier and Medicine
CREATE TABLE Supplier_Medicine (
    supplier_id INT,
    medicine_id INT,
    PRIMARY KEY (supplier_id, medicine_id),
    FOREIGN KEY (supplier_id) REFERENCES Supplier(supplier_id) ON DELETE CASCADE,
    FOREIGN KEY (medicine_id) REFERENCES Medicine(medicine_id) ON DELETE CASCADE
);

-- Create the many-to-many relationship between Orders and Medicine
CREATE TABLE Order_Medicine (
    order_id INT,
    medicine_id INT,
    quantity INT NOT NULL,
    PRIMARY KEY (order_id, medicine_id),
    FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (medicine_id) REFERENCES Medicine(medicine_id) ON DELETE CASCADE
);
