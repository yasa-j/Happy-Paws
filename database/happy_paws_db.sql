-- =======================================================================
-- Happy Paws - Pet Care & Veterinary Clinic Database Schema
-- Database Name: happy_paws_db
-- Version: 1.0.0
-- Description: Core relational database schema managing pet owners, clinic
--              staff, veterinarians, pet profiles, appointments, clinical
--              medical records, vaccination schedules, and store products.
-- =======================================================================

-- 1. Create and switch to the database
CREATE DATABASE IF NOT EXISTS happy_paws_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE happy_paws_db;

-- Disable foreign key checks during schema generation / table drops
SET FOREIGN_KEY_CHECKS = 0;

-- Drop existing tables to ensure clean re-initialization if needed
DROP TABLE IF EXISTS vaccinations;
DROP TABLE IF EXISTS medical_records;
DROP TABLE IF EXISTS appointments;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS pets;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS users;

-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;


-- =======================================================================
-- TABLE 1: users
-- Purpose: Central user entity storing credentials, contact info, and roles
-- Roles:
--   - pet_owner     : Registered clients bringing their pets
--   - veterinarian  : Medical doctors conducting visits & diagnoses
--   - staff         : Clinic receptionists & assistants
--   - admin         : System administrators managing clinic operations
-- =======================================================================
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Unique identifier for each user',
    first_name VARCHAR(50) NOT NULL COMMENT 'User given name',
    last_name VARCHAR(50) NOT NULL COMMENT 'User family name',
    email VARCHAR(100) NOT NULL UNIQUE COMMENT 'Unique login email address',
    password VARCHAR(255) NOT NULL COMMENT 'Bcrypt-hashed password string',
    phone_number VARCHAR(20) DEFAULT NULL COMMENT 'Primary contact phone number',
    role ENUM('admin', 'veterinarian', 'staff', 'pet_owner') NOT NULL DEFAULT 'pet_owner' COMMENT 'Access control role',
    status ENUM('Active', 'Inactive', 'Suspended') NOT NULL DEFAULT 'Active' COMMENT 'Account status',
    address TEXT DEFAULT NULL COMMENT 'Physical residential / clinic address',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp when user registered',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp of last profile update'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =======================================================================
-- TABLE 2: pets
-- Purpose: Stores pet profiles linked to their owners (users table)
-- =======================================================================
CREATE TABLE pets (
    pet_id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Unique identifier for each pet',
    user_id INT NOT NULL COMMENT 'Foreign key referencing pet owner (users.user_id)',
    name VARCHAR(50) NOT NULL COMMENT 'Pet name',
    species ENUM('Dog', 'Cat', 'Bird', 'Rabbit', 'Other') NOT NULL COMMENT 'Species category',
    breed VARCHAR(50) DEFAULT NULL COMMENT 'Specific breed (e.g. Golden Retriever, Siamese)',
    gender ENUM('Male', 'Female') NOT NULL COMMENT 'Biological gender of pet',
    date_of_birth DATE DEFAULT NULL COMMENT 'Birth date or estimated birth date',
    weight_kg DECIMAL(5,2) DEFAULT NULL COMMENT 'Current weight in kilograms',
    color VARCHAR(50) DEFAULT NULL COMMENT 'Coat color or distinguishing markings',
    microchip_number VARCHAR(50) DEFAULT NULL UNIQUE COMMENT 'Unique electronic microchip ID',
    allergies TEXT DEFAULT NULL COMMENT 'Known drug or food allergies',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Record creation timestamp',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Record update timestamp',
    CONSTRAINT fk_pets_user FOREIGN KEY (user_id) 
        REFERENCES users (user_id) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =======================================================================
-- TABLE 3: services
-- Purpose: Catalog of services offered by the Happy Paws veterinary clinic
-- =======================================================================
CREATE TABLE services (
    service_id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Unique identifier for each service',
    name VARCHAR(100) NOT NULL COMMENT 'Service title (e.g., General Health Examination)',
    category ENUM('Veterinary', 'Grooming', 'Preventive', 'Surgery') NOT NULL COMMENT 'Service department/category',
    description TEXT DEFAULT NULL COMMENT 'Detailed description of what is included',
    price DECIMAL(10,2) NOT NULL COMMENT 'Standard charge for the service in USD / LKR',
    duration_minutes INT NOT NULL DEFAULT 30 COMMENT 'Estimated duration in minutes',
    status ENUM('Active', 'Inactive') NOT NULL DEFAULT 'Active' COMMENT 'Whether the service is currently bookable',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation timestamp'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =======================================================================
-- TABLE 4: appointments
-- Purpose: Manages clinic appointments between pet owners, their pets, 
--          and assigned veterinarians
-- =======================================================================
CREATE TABLE appointments (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Unique identifier for each appointment',
    user_id INT NOT NULL COMMENT 'Pet owner requesting appointment (users.user_id)',
    pet_id INT NOT NULL COMMENT 'Pet receiving the consultation (pets.pet_id)',
    vet_id INT DEFAULT NULL COMMENT 'Assigned veterinarian (users.user_id)',
    service_id INT DEFAULT NULL COMMENT 'Requested service (services.service_id)',
    appointment_date DATE NOT NULL COMMENT 'Date of the scheduled appointment',
    appointment_time TIME NOT NULL COMMENT 'Time of the scheduled appointment',
    status ENUM('Pending', 'Confirmed', 'Completed', 'Cancelled') NOT NULL DEFAULT 'Pending' COMMENT 'Appointment status',
    reason VARCHAR(255) DEFAULT NULL COMMENT 'Primary reason / chief complaint stated by owner',
    notes TEXT DEFAULT NULL COMMENT 'Staff or vet operational notes',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Booking timestamp',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Last update timestamp',
    CONSTRAINT fk_appt_user FOREIGN KEY (user_id) 
        REFERENCES users (user_id) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE,
    CONSTRAINT fk_appt_pet FOREIGN KEY (pet_id) 
        REFERENCES pets (pet_id) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE,
    CONSTRAINT fk_appt_vet FOREIGN KEY (vet_id) 
        REFERENCES users (user_id) 
        ON DELETE SET NULL 
        ON UPDATE CASCADE,
    CONSTRAINT fk_appt_service FOREIGN KEY (service_id) 
        REFERENCES services (service_id) 
        ON DELETE SET NULL 
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =======================================================================
-- TABLE 5: medical_records
-- Purpose: Clinical notes, diagnoses, treatments, and prescriptions logged
--          by veterinarians after examinations
-- =======================================================================
CREATE TABLE medical_records (
    record_id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Unique identifier for medical entry',
    pet_id INT NOT NULL COMMENT 'Pet subject of the record (pets.pet_id)',
    vet_id INT NOT NULL COMMENT 'Attending veterinarian (users.user_id)',
    appointment_id INT DEFAULT NULL COMMENT 'Associated appointment if applicable',
    visit_date DATE NOT NULL COMMENT 'Date the examination took place',
    diagnosis TEXT NOT NULL COMMENT 'Clinical diagnosis determined by veterinarian',
    treatment TEXT NOT NULL COMMENT 'Treatment, therapy, or surgical intervention given',
    prescription TEXT DEFAULT NULL COMMENT 'Medications, dosages, and administration instructions',
    follow_up_date DATE DEFAULT NULL COMMENT 'Recommended next visit date',
    notes TEXT DEFAULT NULL COMMENT 'Additional medical observations or test results',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp when record was logged',
    CONSTRAINT fk_med_pet FOREIGN KEY (pet_id) 
        REFERENCES pets (pet_id) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE,
    CONSTRAINT fk_med_vet FOREIGN KEY (vet_id) 
        REFERENCES users (user_id) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE,
    CONSTRAINT fk_med_appt FOREIGN KEY (appointment_id) 
        REFERENCES appointments (appointment_id) 
        ON DELETE SET NULL 
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =======================================================================
-- TABLE 6: vaccinations
-- Purpose: Vaccine immunization records, administered dates, and due dates
-- =======================================================================
CREATE TABLE vaccinations (
    vaccination_id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Unique identifier for vaccination record',
    pet_id INT NOT NULL COMMENT 'Pet vaccinated (pets.pet_id)',
    vet_id INT DEFAULT NULL COMMENT 'Veterinarian who administered vaccine (users.user_id)',
    vaccine_name VARCHAR(100) NOT NULL COMMENT 'Name of vaccine (e.g. Rabies, DHPP, FVRCP)',
    administered_date DATE NOT NULL COMMENT 'Date the vaccine was given',
    next_due_date DATE NOT NULL COMMENT 'Date the booster or renewal is due',
    batch_number VARCHAR(50) DEFAULT NULL COMMENT 'Manufacturer batch/lot number',
    status ENUM('Upcoming', 'Completed', 'Overdue') NOT NULL DEFAULT 'Completed' COMMENT 'Vaccine validity status',
    notes TEXT DEFAULT NULL COMMENT 'Veterinarian observations or side-effect notes',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Entry timestamp',
    CONSTRAINT fk_vax_pet FOREIGN KEY (pet_id) 
        REFERENCES pets (pet_id) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE,
    CONSTRAINT fk_vax_vet FOREIGN KEY (vet_id) 
        REFERENCES users (user_id) 
        ON DELETE SET NULL 
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =======================================================================
-- TABLE 7: products
-- Purpose: Pet care products available in the clinic store / pharmacy
-- =======================================================================
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Unique identifier for retail product',
    name VARCHAR(100) NOT NULL COMMENT 'Product title',
    category ENUM('Food', 'Medicine', 'Grooming', 'Accessories', 'Toys') NOT NULL COMMENT 'Product category',
    description TEXT DEFAULT NULL COMMENT 'Product details and benefits',
    price DECIMAL(10,2) NOT NULL COMMENT 'Retail unit price',
    stock_quantity INT NOT NULL DEFAULT 0 COMMENT 'Number of units remaining in stock',
    image_url VARCHAR(255) DEFAULT NULL COMMENT 'Image asset path or URL',
    status ENUM('In Stock', 'Out of Stock', 'Discontinued') NOT NULL DEFAULT 'In Stock' COMMENT 'Availability status',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Entry timestamp'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- =======================================================================
-- SEED DATA INSERTION
-- Realistic sample records to enable immediate testing of login, 
-- dashboards, appointments, pet profiles, and clinic workflows.
--
-- Password for all seed users is: password123
-- Hash: $2y$12$cuuUa02.DXUGWQhfp6tp6uyxQDVf1PtzNn/4EYWzCBTzs50QHPe.2
-- =======================================================================

-- 1. Insert Sample Users
INSERT INTO users (user_id, first_name, last_name, email, password, phone_number, role, status, address) VALUES
(1, 'Sarah', 'Miller', 'owner@example.com', '$2y$12$cuuUa02.DXUGWQhfp6tp6uyxQDVf1PtzNn/4EYWzCBTzs50QHPe.2', '+94 77 123 4567', 'pet_owner', 'Active', '45 Park Avenue, Colombo 03'),
(2, 'Michael', 'Vance', 'vet@happypaws.lk', '$2y$12$cuuUa02.DXUGWQhfp6tp6uyxQDVf1PtzNn/4EYWzCBTzs50QHPe.2', '+94 71 987 6543', 'veterinarian', 'Active', '12 Medical Row, Colombo 07'),
(3, 'Sarah', 'Jenkins', 'admin@happypaws.lk', '$2y$12$cuuUa02.DXUGWQhfp6tp6uyxQDVf1PtzNn/4EYWzCBTzs50QHPe.2', '+94 70 555 1234', 'admin', 'Active', '123 Pet Lane, Colombo 07'),
(4, 'Emily', 'Clark', 'staff@happypaws.lk', '$2y$12$cuuUa02.DXUGWQhfp6tp6uyxQDVf1PtzNn/4EYWzCBTzs50QHPe.2', '+94 76 333 4444', 'staff', 'Active', '78 Lake Road, Rajagiriya');


-- 2. Insert Sample Pets (belonging to Sarah Miller, user_id = 1)
INSERT INTO pets (pet_id, user_id, name, species, breed, gender, date_of_birth, weight_kg, color, microchip_number, allergies) VALUES
(1, 1, 'Milo', 'Dog', 'Golden Retriever', 'Male', '2021-06-15', 28.50, 'Golden / Honey', '985141002341901', 'None known'),
(2, 1, 'Luna', 'Cat', 'Siamese', 'Female', '2022-03-20', 4.20, 'Cream & Seal Point', '985141002341902', 'Penicillin sensitivity'),
(3, 1, 'Bella', 'Dog', 'French Bulldog', 'Female', '2023-01-10', 11.00, 'Fawn with Black Mask', '985141002341903', 'Pollen & Grain allergies');


-- 3. Insert Clinic Services
INSERT INTO services (service_id, name, category, description, price, duration_minutes, status) VALUES
(1, 'Comprehensive Health Checkup', 'Veterinary', 'Full physical examination including vital checks, eye, ear, coat, and dental inspection.', 45.00, 30, 'Active'),
(2, 'Core Vaccination Package', 'Preventive', 'Essential annual immunizations protecting against rabies, distemper, and parvovirus.', 35.00, 20, 'Active'),
(3, 'Full Bath & Grooming Spa', 'Grooming', 'Deep cleansing bath, conditioning, ear cleaning, coat styling, and nail clipping.', 50.00, 60, 'Active'),
(4, 'Dental Cleaning & Polishing', 'Veterinary', 'Ultrasonic tartar removal, plaque cleaning, and tooth polishing under gentle sedation.', 80.00, 45, 'Active'),
(5, 'Minor Soft-Tissue Surgery', 'Surgery', 'Neutering, spaying, and minor wound repair with full anesthetic monitoring.', 150.00, 90, 'Active');


-- 4. Insert Sample Appointments
INSERT INTO appointments (appointment_id, user_id, pet_id, vet_id, service_id, appointment_date, appointment_time, status, reason, notes) VALUES
(1, 1, 1, 2, 1, '2026-10-05', '10:00:00', 'Confirmed', 'Annual routine wellness checkup', 'Owner requests weight check and nutritional guidance'),
(2, 1, 2, 2, 2, '2026-10-12', '14:30:00', 'Pending', 'Annual rabies booster', 'Reminded owner to bring vaccination card'),
(3, 1, 3, 2, 1, '2026-08-15', '09:00:00', 'Completed', 'Skin allergy checkup and ear cleaning', 'Prescribed antihistamines and hypoallergenic shampoo');


-- 5. Insert Sample Medical Records
INSERT INTO medical_records (record_id, pet_id, vet_id, appointment_id, visit_date, diagnosis, treatment, prescription, follow_up_date, notes) VALUES
(1, 3, 2, 3, '2026-08-15', 'Mild allergic dermatitis with secondary ear irritation', 'Thorough ear flush and topical soothing antiseptic application', 'Apoquel 5.4mg once daily for 14 days; Otodex ear drops 3 drops bid for 7 days', '2026-09-01', 'Patient was calm during inspection. Condition improved within 3 days.');


-- 6. Insert Sample Vaccinations
INSERT INTO vaccinations (vaccination_id, pet_id, vet_id, vaccine_name, administered_date, next_due_date, batch_number, status, notes) VALUES
(1, 1, 2, 'Rabies (Defensor 3)', '2025-10-01', '2026-10-01', 'LOT-RB-2025-09A', 'Upcoming', 'Annual booster due next month'),
(2, 1, 2, 'DHPP Core Dog Vaccine', '2025-10-01', '2026-10-01', 'LOT-DH-2025-12B', 'Upcoming', 'Protection against Distemper, Hepatitis, Parvo, Parainfluenza'),
(3, 2, 2, 'FVRCP Feline Core Vaccine', '2025-11-15', '2026-11-15', 'LOT-FV-2025-04K', 'Completed', 'Feline viral rhinotracheitis, calicivirus, panleukopenia booster');


-- 7. Insert Sample Retail Products
INSERT INTO products (product_id, name, category, description, price, stock_quantity, image_url, status) VALUES
(1, 'Royal Canin Golden Retriever Adult (12kg)', 'Food', 'Tailor-made nutrition for adult Golden Retrievers with cardiac & skin support nutrients.', 78.50, 24, 'images/products/royal_canin_retriever.jpg', 'In Stock'),
(2, 'Bravecto Flea & Tick Chew for Dogs', 'Medicine', '3-month persistent flea and tick protection chewable tablet.', 42.00, 50, 'images/products/bravecto.jpg', 'In Stock'),
(3, 'Oatmeal & Aloe Soothing Pet Shampoo (500ml)', 'Grooming', 'Hypoallergenic calming shampoo specially formulated for dry and sensitive skin.', 18.00, 35, 'images/products/shampoo.jpg', 'In Stock'),
(4, 'Multi-Level Plush Cat Scratching Tree', 'Toys', 'Sturdy sisal rope scratching posts with resting hammock and toy pom-poms.', 65.00, 12, 'images/products/cat_tree.jpg', 'In Stock');