<?php
include 'DBConnector.php';
header('Content-Type: application/json');

$keyword = isset($_GET['keyword']) ? $_GET['keyword']: '';
$response = [];

// gets the keyword from the form on html
if (!empty($keyword)){
    
    // mySQL query
    $sql = "SELECT s.*, c.course_name
        FROM Student s
        LEFT JOIN Student_Course sc on s.student_id = sc.student_id
        LEFT JOIN Course c on sc.course_id = c.course_id
        WHERE s.student_id = '$keyword' OR s.student_name LIKE '%$keyword%'";
    
    $result = $conn->query($sql);

    // creates a table with the data for each match from search query
    if ($result->num_rows > 0) {
        $students = [];
        while($row = $result->fetch_assoc()) {
            $row['graduation_status'] = ($row['graduation_status'] == 1) ? "Yes" : "No";
            $students[] = $row;
        }
        $response = ["success" => true, "students" => $students]; 
    } else {
        $response = ["success" => false, "message" => "No student found"]; 
    }
    
} else {
    $response = ["success" => false, "message" => "No keyword provided"]; 
}


echo json_encode($response);
$conn->close();
?>