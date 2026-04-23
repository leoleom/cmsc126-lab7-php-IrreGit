<?php
include 'DBConnector.php';

// Handle the actual database UPDATE when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['student_id']; 
    $name = $_POST['name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $year = $_POST['year_level'];
    $grad = isset($_POST['graduation_status']) ? 1 : 0;
    
    // Update query for the Student table
    $updateSql = "UPDATE Student SET student_name='$name', age='$age', email='$email', year_level='$year', graduation_status='$grad' WHERE student_id='$id'"; 
    
    if ($conn->query($updateSql) === TRUE) {
        echo "Student record updated successfully!<br>";
        echo "<br><a href='index.html'>Back to Registration</a>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    
    $conn->close();
    exit; // Stop the script here so it doesn't try to load the GET request logic below
}

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
        
        // Generate the HTML form pre-filled with the database values
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Update Student</title>
            <link rel="stylesheet" href="style.css">
        </head>
        <body>
            <main class="container">
                <section class="form-card">
                    <header class="form-header">
                        <h1>Update Student Record</h1>
                        <p>Updating details for Student ID: <?php echo $row['student_id']; ?></p>
                    </header>
                    
                    <form action="update.php" method="POST">
                        <input type="hidden" name="student_id" value="<?php echo $row['student_id']; ?>">
                        
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" value="<?php echo $row['student_name']; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Age</label>
                            <input type="number" name="age" value="<?php echo $row['age']; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Course</label>
                            <input type="text" name="course" value="<?php echo $row['course_name']; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Year Level</label>
                            <input type="number" name="year_level" value="<?php echo $row['year_level']; ?>" min="1" max="4" required>
                        </div>
                        
                        <div class="form-group checkbox-group">
                            <label>Graduating this year?</label>
                            <div class="checkbox-row">
                                <input type="checkbox" name="graduation_status" value="1" <?php echo ($row['graduation_status'] == 1) ? 'checked' : ''; ?>>
                                <label>Yes</label>
                            </div>
                        </div>
                        
                        <div class="button-group">
                            <button type="submit" class="submit-btn">Save Changes</button>
                        </div>
                    </form>
                </section>
            </main>
        </body>
        </html>
        <?php
        
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