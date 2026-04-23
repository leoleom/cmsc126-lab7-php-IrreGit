<?php
include 'DBConnector.php';
header('Content-Type: application/json');

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Handle search
    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

    if (!empty($keyword)) {
        $sql = "SELECT s.*, c.course_name 
                FROM Student s 
                LEFT JOIN Student_Course sc ON s.student_id = sc.student_id 
                LEFT JOIN Course c ON sc.course_id = c.course_id 
                WHERE s.student_id = '$keyword' OR s.student_name = '$keyword'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $row['graduation_status'] = ($row['graduation_status'] == 1) ? "Yes" : "No";
            $response = ["success" => true, "student" => $row];
        } else {
            $response = ["success" => false, "message" => "Student not found"];
        }
    } else {
        $response = ["success" => false, "clear" => true];
    }
}

// Handle the actual database UPDATE when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['student_id']; 
    $name = $_POST['name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $year = $_POST['year_level'];
    $grad = isset($_POST['graduation_status']) ? 1 : 0;
    
    // Update query for the Student table
    $updateSql = "UPDATE Student 
                SET student_name='$name', age='$age', email='$email', year_level='$year', graduation_status='$grad' 
                WHERE student_id='$id'"; 
    
    if ($conn->query($updateSql)) { 
        $response = ["success" => true, "message" => "Student updated successfully"]; 
    } else {
        $response = ["success" => false, "message" => "Update failed"];
    }
}

echo json_encode($response);
$conn->close();
?>
