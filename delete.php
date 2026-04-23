<?php
include 'DBConnector.php';
header('Content-Type: application/json');
$response = [];

// gets the keyword from the form on html
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

if (!empty($keyword)) {
    // mySQL query (finds by student id (change as needed))
    $findSql = "SELECT image_path, student_id FROM Student 
                WHERE student_id = '$keyword'"; // OR student_name = '$keyword' LIMIT 1";
    $findResult = $conn->query($findSql);

   
    if ($findResult->num_rows > 0) {
        $row = $findResult->fetch_assoc();
        $imagePath = $row['image_path'];
        $studentId = $row['student_id'];

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $conn->query("DELETE FROM Student_Course WHERE student_id = $studentId");

        $deleteSql = "DELETE FROM Student WHERE student_id = $studentId";
        
        if ($conn->query($deleteSql)) {
            $response = ["success" => true, "message" => "Student has been purged."];
        }
    } else {
        $response = ["success" => false, "message" => "Student doesn't exist."];
    }
} else {
    $response = ["success" => false, "message" => "No keyword provided."]; 
}

echo json_encode($response);
$conn->close();
?>