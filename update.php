<?php
include 'DBConnector.php';

// Handle the GET request from index.html to find student
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

if (!empty($keyword)) {
    $sql = "SELECT s.*, c.course_name 
            FROM Student s 
            LEFT JOIN Student_Course sc on s.student_id = sc.student_id 
            LEFT JOIN Course c on sc.course_id = c.course_id 
            WHERE s.student_id = '$keyword' OR s.student_name LIKE '$keyword' LIMIT 1";
            
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Placeholder to test if data is fetched successfully
        echo "<h3>Student Found: " . $row['student_name'] . "</h3>"; 
        
    } else {
        echo "You are delulu (Student with that ID or name does not exist).<br>";
        echo "<br><a href='index.html'>Back to Registration</a>";
    }
} else {
    echo "Please enter a search keyword.<br>";
    echo "<br><a href='index.html'>Back to Registration</a>";
}

$conn->close();
?>