<?php
include 'DBConnector.php';
$keyword = isset($_GET['keyword']) ? $_GET['keyword']: '';

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
        echo "<table border='1' cellpadding='10'>";
        echo "<tr>
                <th>Photo</th>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Email</th>
                <th>Course</th>
                <th>Year</th>
                <th>Graduating?</th>
              </tr>";

        while($row = $result->fetch_assoc()) {
            $status = ($row['graduation_status'] == 1) ? "Yes" : "No";
            
            echo "<tr>";
            echo "<td><img src='" . $row['image_path'] . "' width='50' height='50' style='object-fit: cover;'></td>";
            echo "<td>" . $row['student_id'] . "</td>";
            echo "<td>" . $row['student_name'] . "</td>";
            echo "<td>" . $row['age'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['course_name'] . "</td>";
            echo "<td>" . $row['year_level'] . "</td>";
            echo "<td>" . $status . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "You are delulu (Student with that ID or name does not exist).";
    }
} 
echo "<br><br><a href='index.html'>Back to Registration</a>";
$conn->close();
?>