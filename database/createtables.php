<?php
require_once "database.php";

$db = new Database();
$conn = $db->getConnection();

try {
    // 1. Drop existing tables to start fresh (Careful: This deletes old data)
    $conn->exec("SET FOREIGN_KEY_CHECKS = 0;");
    $conn->exec("DROP TABLE IF EXISTS attendance_details, course_details, student_details, teacher_details, session_details;");
    $conn->exec("SET FOREIGN_KEY_CHECKS = 1;");

    // 2. Create Teacher Table
    $conn->exec("CREATE TABLE teacher_details (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        user_name VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        department VARCHAR(10) NOT NULL
    )");

    // 3. Create Student Table
    $conn->exec("CREATE TABLE student_details (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        roll_no VARCHAR(20) UNIQUE NOT NULL,
        department VARCHAR(10) NOT NULL,
        year INT NOT NULL
    )");

    // 4. Create Course Table (Year-Only)
    $conn->exec("CREATE TABLE course_details (
        id INT AUTO_INCREMENT PRIMARY KEY,
        course_name VARCHAR(100) NOT NULL,
        department VARCHAR(10) NOT NULL,
        year INT(1) NOT NULL
    )");

    // 5. Create Attendance Table
    $conn->exec("CREATE TABLE attendance_details (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id INT NOT NULL,
        course_id INT NOT NULL,
        on_date DATE NOT NULL,
        status VARCHAR(1) NOT NULL,
        FOREIGN KEY (student_id) REFERENCES student_details(id),
        FOREIGN KEY (course_id) REFERENCES course_details(id)
    )");

    echo "Tables created successfully.<br>";

    // --- entering DATA ---
    //setting 123 as default password whose hash is $2y$10$wf2OqcnFN6MLhWvE7V44l.shFYgROjDZsUD4x0blftWcseZV1Rt6m
    $hashedPassword='$2y$10$wf2OqcnFN6MLhWvE7V44l.shFYgROjDZsUD4x0blftWcseZV1Rt6m';


    // Insert Teachers (Password is '123' for both)
    $stmt = $conn->prepare("INSERT INTO teacher_details (name, user_name,email, password, department) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute(['Ram Chandra Bhatta', 'rcb','bhattaram@ioepc.edu.np', $hashedPassword, 'BCT']);
    $stmt->execute(['Rajan Baniya', 'rbaniya','baniyarajan@ioepc.edu.np', $hashedPassword, 'BCE']);
    $stmt->execute(['Manish Khatiwada', 'mkhatiwada','khatiwadamanish@gmail.com', $hashedPassword, 'BME']);
    $stmt->execute(['Biraj Timsina', 'btimsina','timsinabiraj@ioepc.edu.np', $hashedPassword, 'BAG']);
    $stmt->execute(['Chandra Rai', 'crai','raichandra@ioepc.edu.np', $hashedPassword, 'BEL']);

    $stmt = $conn->prepare("INSERT INTO course_details (course_name, department, year) VALUES (?, ?, ?)");

$courses = [
    // --- BCT (Computer Engineering) ---
    ['C Programming', 'BCT', 1],
    ['Digital Logic', 'BCT', 1],
    ['Object Oriented Programming', 'BCT', 2],
    ['Data Structure & Algorithms', 'BCT', 2],
    ['Discrete Structure', 'BCT', 2],
    ['Microprocessors', 'BCT', 3],
    ['Computer Graphics', 'BCT', 3],
    ['Computer Network', 'BCT', 3],
    ['Instrumentation II', 'BCT', 3],
    ['Artificial Intelligence', 'BCT', 4],
    ['Project Management', 'BCT', 4],
    ['Big Data Technologies', 'BCT', 4],

    // --- BCE (Civil Engineering) ---
    ['Engineering Drawing', 'BCE', 1],
    ['Applied Mechanics', 'BCE', 1],
    ['Surveying I', 'BCE', 2],
    ['Fluid Mechanics', 'BCE', 2],
    ['Structural Analysis', 'BCE', 3],
    ['Hydrology', 'BCE', 3],
    ['Foundation Engineering', 'BCE', 4],
    ['Earthquake Engineering', 'BCE', 4],

    // --- BME (Mechanical Engineering) ---
    ['Engineering Mechanics', 'BME', 1],
    ['Thermodynamics', 'BME', 2],
    ['Fluid Mechanics', 'BME', 2],
    ['Machine Design', 'BME', 3],
    ['Manufacturing Processes', 'BME', 3],
    ['Heat Transfer', 'BME', 4],
    ['Dynamics of Machines', 'BME', 4],

    // --- BAG (Agriculture) ---
    ['Agronomy I', 'BAG', 1],
    ['Soil Science', 'BAG', 2],
    ['Plant Physiology', 'BAG', 2],
    ['Crop Production', 'BAG', 3],
    ['Horticulture', 'BAG', 3],
    ['Agricultural Economics', 'BAG', 4],
    ['Irrigation Engineering', 'BAG', 4],

    // --- BEL (Electrical Engineering) ---
    ['Basic Electrical Engineering', 'BEL', 1],
    ['Circuit Theory', 'BEL', 2],
    ['Electromagnetics', 'BEL', 2],
    ['Power Systems', 'BEL', 3],
    ['Control Systems', 'BEL', 3],
    ['Electrical Machines', 'BEL', 4],
    ['Renewable Energy Systems', 'BEL', 4]
];

foreach ($courses as $c) {
    $stmt->execute($c);
}

    $stmt = $conn->prepare("INSERT INTO student_details (name, roll_no, department, year) VALUES (?, ?, ?, ?)");

$students = [
    // 4th Year BCT (Batch 079) - 10 Students
    ['Aayush Shrestha', '079BCT001', 'BCT', 4], ['Bikram Dahal', '079BCT002', 'BCT', 4],
    ['Chitra Kumar', '079BCT003', 'BCT', 4], ['Dinesh KC', '079BCT004', 'BCT', 4],
    ['Esha Thapa', '079BCT005', 'BCT', 4], ['Firoz Khan', '079BCT006', 'BCT', 4],
    ['Gita Rai', '079BCT007', 'BCT', 4], ['Hari Om', '079BCT008', 'BCT', 4],
    ['Indra Jha', '079BCT009', 'BCT', 4], ['Jiban Rai', '079BCT010', 'BCT', 4],

    // 3rd Year BCT (Batch 080) - 10 Students
    ['Kiran Poudel', '080BCT001', 'BCT', 3], ['Laxman Shrestha', '080BCT002', 'BCT', 3],
    ['Manisha Magar', '080BCT003', 'BCT', 3], ['Niraj Gupta', '080BCT004', 'BCT', 3],
    ['Ojaswi Giri', '080BCT005', 'BCT', 3], ['Pooja Sah', '080BCT006', 'BCT', 3],
    ['Roshan BK', '080BCT007', 'BCT', 3], ['Suman Ale', '080BCT008', 'BCT', 3],
    ['Tulsi Ram', '080BCT009', 'BCT', 3], ['Umesh Yadav', '080BCT010', 'BCT', 3],

    // 2nd Year BCT (Batch 081) - 10 Students
    ['Vivek Chaudhary', '081BCT001', 'BCT', 2], ['Watan Lama', '081BCT002', 'BCT', 2],
    ['Xavier Rai', '081BCT003', 'BCT', 2], ['Yamini Pant', '081BCT004', 'BCT', 2],
    ['Zoya Ansari', '081BCT005', 'BCT', 2], ['Aaryan Neupane', '081BCT006', 'BCT', 2],
    ['Binit Tamang', '081BCT007', 'BCT', 2], ['Chetan Mani', '081BCT008', 'BCT', 2],
    ['Deepak Bohara', '081BCT009', 'BCT', 2], ['Erica Subedi', '081BCT010', 'BCT', 2],

    // 1st Year BCT (Batch 082) - 10 Students
    ['Gaurav Sharma', '082BCT001', 'BCT', 1], ['Himal Jha', '082BCT002', 'BCT', 1],
    ['Ishwor Rijal', '082BCT003', 'BCT', 1], ['Jenish Karki', '082BCT004', 'BCT', 1],
    ['Kriti Silwal', '082BCT005', 'BCT', 1], ['Lalit Bista', '082BCT006', 'BCT', 1],
    ['Madan Bhandari', '082BCT007', 'BCT', 1], ['Naveen Joshi', '082BCT008', 'BCT', 1],
    ['Om Prakash', '082BCT009', 'BCT', 1], ['Pramila KC', '082BCT010', 'BCT', 1],

    // 3rd Year BCE (Civil - Batch 080) - 10 Students
    ['Rahul Bhagat', '080BCE001', 'BCE', 3], ['Sita Ram', '080BCE002', 'BCE', 3],
    ['Tika Ram', '080BCE003', 'BCE', 3], ['Urmila Devi', '080BCE004', 'BCE', 3],
    ['Vicky Sah', '080BCE005', 'BCE', 3], ['Writik Yadav', '080BCE006', 'BCE', 3],
    ['Yuvraj Singh', '080BCE007', 'BCE', 3], ['Zeenat Aman', '080BCE008', 'BCE', 3],
    ['Ankit Kushwaha', '080BCE009', 'BCE', 3], ['Bablu Kumar', '080BCE010', 'BCE', 3],

    // Mechanical 4th Year (Batch 079)
    ['Anil Shrestha', '079BME001', 'BME', 4],
    ['Bikram Koirala', '079BME002', 'BME', 4],
    ['Chitra Lama', '079BME003', 'BME', 4],
    ['Dinesh Shahi', '079BME004', 'BME', 4],
    ['Esha Gurung', '079BME005', 'BME', 4],

    // Agriculture 3rd Year (Batch 080)
    ['Firoz Karki', '080BAG001', 'BAG', 3],
    ['Gita Thapa', '080BAG002', 'BAG', 3],
    ['Hari Rai', '080BAG003', 'BAG', 3],
    ['Indra Sah', '080BAG004', 'BAG', 3],
    ['Jiban Gurung', '080BAG005', 'BAG', 3],

    // Electrical 2nd Year (Batch 081)
    ['Kiran Shrestha', '081BEL001', 'BEL', 2],
    ['Laxman Yadav', '081BEL002', 'BEL', 2],
    ['Manisha KC', '081BEL003', 'BEL', 2],
    ['Niraj Thapa', '081BEL004', 'BEL', 2],
    ['Ojaswi Rai', '081BEL005', 'BEL', 2]
];

foreach ($students as $student) {
    $stmt->execute($student);
}

    
    // 082 --- first year
    // 081 --- second year
    // 080 --- third year
    // 079 --- forth year
    
    echo "Data entered successfully.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>