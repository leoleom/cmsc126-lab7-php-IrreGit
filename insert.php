<?php
include 'DBConnector.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // verif (no duplicate email)
    $email = $_POST['email'];
    $checkEmail = "SELECT * FROM Student where email = '$email'";
    $result = $conn->query($checkEmail);
    if($result->num_rows > 0){
        echo "This email has already been registered to another student";
        echo "<br><br><a href='index.html'>Back to Registration</a>";
        exit;
    }

    else{
        // image upload
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
        $extension = pathinfo($_FILES["profile_image"]["name"], PATHINFO_EXTENSION);


        // insert form data
        $name = $_POST['name'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $course = $_POST['course'];
        $year = $_POST['year_level'];
        $grad = isset($_POST['graduation_status']) ? 1 : 0;
        
        // checks if a course already exists    
        $checkCourse = $conn->query("SELECT course_id FROM Course WHERE course_name = '$course'");
        if ($checkCourse->num_rows > 0) {
            $row = $checkCourse->fetch_assoc();
            $last_course_id = $row['course_id'];
        } else {
            $conn->query("INSERT INTO Course (course_name) VALUES ('$course')");
            $last_course_id = $conn->insert_id;
        }

        $sql_stud = "INSERT INTO Student(
        student_name, age, email, year_level, graduation_status, image_path)
        VALUES('$name', '$age', '$email', '$year', '$grad', '')
        ";

        if ($conn->query($sql_stud)) {
            $last_stud_id = $conn->insert_id;
            $file_name = $last_stud_id . "." . $extension;
            $target_file = $target_dir . $file_name;
            
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                $conn->query("UPDATE Student SET image_path = '$target_file' WHERE student_id = $last_stud_id");
            }
            
            $sql_link = "INSERT INTO Student_Course(student_id, course_id) VALUES ($last_stud_id, $last_course_id)";
            $conn -> query($sql_link);
        }

        echo "Student registered successfully!";
    }
}
header("Location: index.html?status=success");
$conn->close();
?>