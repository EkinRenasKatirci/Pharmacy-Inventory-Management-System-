-- Insert data into Pharmacy
INSERT INTO Pharmacy (name, location) VALUES
    ('Central Pharmacy', 'Downtown'),
    ('Green Health', 'Uptown'),
    ('CarePlus Pharmacy', 'Suburb A'),
    ('MediTrust', 'Suburb B'),
    ('HealthFirst', 'City Center'),
    ('WellCare Pharmacy', 'North District'),
    ('PharmaPoint', 'Westside'),
    ('GoodMed', 'Eastside'),
    ('VitalCare', 'Southside'),
    ('SafeMeds', 'Lakeside');

-- Insert data into Medicine
INSERT INTO Medicine (name, manufacturer, expiration_date, price, stock_quantity) VALUES
    ('Paracetamol', 'XYZ Pharma', '2026-12-31', 5.00, 100),
    ('Ibuprofen', 'ABC Pharmaceuticals', '2025-10-20', 8.50, 200),
    ('Aspirin', 'MediCorp', '2026-08-15', 7.00, 150),
    ('Antibiotic A', 'MediLife', '2027-03-10', 20.00, 50),
    ('Vitamin C', 'Wellness Inc.', '2025-12-01', 10.00, 300),
    ('Cough Syrup', 'PharmaTrust', '2024-11-25', 15.00, 120),
    ('Allergy Relief', 'HealthGen', '2025-06-30', 12.00, 80),
    ('Antacid', 'Acme Drugs', '2026-04-05', 6.00, 250),
    ('Pain Reliever', 'Relief Pharmaceuticals', '2025-09-15', 9.50, 180),
    ('Flu Medicine', 'MediCure', '2026-07-20', 14.00, 140);

-- Insert data into Supplier
INSERT INTO Supplier (name, contact_info) VALUES
    ('ABC Suppliers', 'abc@suppliers.com'),
    ('MediLife Distributors', 'medilife@supply.com'),
    ('Global Pharma', 'global@pharma.com'),
    ('HealthCare Logistics', 'health@supply.com'),
    ('FastMed Supply', 'fastmed@suppliers.com'),
    ('Reliable Drugs', 'reliable@drugs.com'),
    ('SafeMeds Distributors', 'safemeds@supply.com'),
    ('Prime Pharma', 'prime@pharma.com'),
    ('MedExpress', 'medexpress@suppliers.com'),
    ('PharmaDirect', 'direct@pharma.com');

-- Insert data into Customer
INSERT INTO Customer (name, contact_info) VALUES
    ('John Doe', 'john.doe@example.com'),
    ('Jane Smith', 'jane.smith@example.com'),
    ('Michael Johnson', 'michael.j@example.com'),
    ('Emily Brown', 'emily.b@example.com'),
    ('Chris Wilson', 'chris.w@example.com'),
    ('Sarah Lee', 'sarah.lee@example.com'),
    ('David Anderson', 'david.a@example.com'),
    ('Olivia Martinez', 'olivia.m@example.com'),
    ('Daniel White', 'daniel.w@example.com'),
    ('Emma Harris', 'emma.h@example.com');

-- Insert data into Orders
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
    ('2025-02-10', 95.00, 10);

-- Insert data into Prescription
INSERT INTO Prescription (doctor_name, issued_date, customer_id, order_id) VALUES
    ('Dr. Adams', '2025-02-01', 1, 1),
    ('Dr. Baker', '2025-02-02', 2, 2),
    ('Dr. Carter', '2025-02-03', 3, 3),
    ('Dr. Daniels', '2025-02-04', 4, 4),
    ('Dr. Evans', '2025-02-05', 5, 5),
    ('Dr. Foster', '2025-02-06', 6, 6),
    ('Dr. Green', '2025-02-07', 7, 7),
    ('Dr. Harris', '2025-02-08', 8, 8),
    ('Dr. Irving', '2025-02-09', 9, 9),
    ('Dr. Johnson', '2025-02-10', 10, 10);

-- Insert data into Employee
INSERT INTO Employee (name, role, salary, pharmacy_id) VALUES
    ('Alice Johnson', 'Pharmacist', 5000, 1),
    ('Bob Smith', 'Technician', 3500, 2),
    ('Charlie Brown', 'Cashier', 2800, 3),
    ('David Wilson', 'Manager', 6000, 4),
    ('Emma Davis', 'Pharmacist', 5200, 5),
    ('Frank Thomas', 'Technician', 3400, 6),
    ('Grace Lee', 'Cashier', 2900, 7),
    ('Henry White', 'Manager', 5800, 8),
    ('Isabella Harris', 'Pharmacist', 5100, 9),
    ('Jack Anderson', 'Technician', 3300, 10);

-- Insert data into TransactionTable
INSERT INTO TransactionTable (transaction_date, payment_method, order_id) VALUES
    ('2025-02-01', 'Credit Card', 1),
    ('2025-02-02', 'Cash', 2),
    ('2025-02-03', 'Credit Card', 3),
    ('2025-02-04', 'Debit Card', 4),
    ('2025-02-05', 'Cash', 5),
    ('2025-02-06', 'Credit Card', 6),
    ('2025-02-07', 'Debit Card', 7),
    ('2025-02-08', 'Cash', 8),
    ('2025-02-09', 'Credit Card', 9),
    ('2025-02-10', 'Debit Card', 10);

-- Insert data into Pharmacy_Medicine (Many-to-Many)
INSERT INTO Pharmacy_Medicine (pharmacy_id, medicine_id, stock_quantity) VALUES
    (1, 1, 50), (2, 2, 80), (3, 3, 60), (4, 4, 40),
    (5, 5, 90), (6, 6, 100), (7, 7, 120), (8, 8, 110),
    (9, 9, 75), (10, 10, 95);

-- Insert data into Supplier_Medicine (Many-to-Many)
INSERT INTO Supplier_Medicine (supplier_id, medicine_id) VALUES
    (1, 1), (2, 2), (3, 3), (4, 4), (5, 5), (6, 6), (7, 7), (8, 8), (9, 9), (10, 10);

-- Insert data into Order_Medicine (Many-to-Many)
INSERT INTO Order_Medicine (order_id, medicine_id, quantity) VALUES
    (1, 1, 2), (2, 2, 3), (3, 3, 1), (4, 4, 5), (5, 5, 2),
    (6, 6, 3), (7, 7, 1), (8, 8, 4), (9, 9, 2), (10, 10, 3);
