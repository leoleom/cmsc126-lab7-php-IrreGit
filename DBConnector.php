<?php
// prelim
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lab7_db";

// establish connection
$conn = new mysqli($servername, $username, $password);

// // check connection
// if($conn->connect_error){
//     die("Connection failed: " . $conn->connect_error);
// }
// echo "Connected succesfully <br/>";

// database creation
$sql_db = "CREATE DATABASE IF NOT EXISTS $dbname";
$conn->query($sql_db);
// if ($conn->query($sql_db) === TRUE) {
//     echo "Database created successfully <br>";
// } else {
//     echo "Error creating database: " . $conn->error . "<br>";
// }
$conn->select_db($dbname);

$tables=[
    // currently uses email as unique, change if needed lang
    "student" => "CREATE TABLE IF NOT EXISTS Student(
        student_id INT(6) UNSIGNED ZEROFILL AUTO_INCREMENT PRIMARY KEY,
        student_name VARCHAR(40) NOT NULL,
        age INT(2) NOT NULL,
        email VARCHAR(40) NOT NULL UNIQUE,
        year_level INT(1) NOT NULL,
        graduation_status BOOLEAN NOT NULL,
        image_path VARCHAR(255) NOT NULL
    )",
    "course" => "CREATE TABLE IF NOT EXISTS Course(
        course_id INT(2) AUTO_INCREMENT PRIMARY KEY,
        course_name VARCHAR(40) NOT NULL UNIQUE 
    )",
    "student_course" => "CREATE TABLE IF NOT EXISTS Student_Course(
        student_id INT(6) UNSIGNED ZEROFILL,
        course_id INT(2),
        PRIMARY KEY (student_id, course_id),
        FOREIGN KEY (student_id) REFERENCES Student(student_id),
        FOREIGN KEY (course_id) REFERENCES Course(course_id)
    )",

];

foreach($tables as $tableName => $sql){
    $conn->query($sql);
    // if($conn->query($sql) === TRUE) {
    //     echo "Table '$tableName' is ready!<br>";
    // } else {
    //     echo "Error creating table '$tableName': " . $conn->error . "<br>";
    // }
}

?>