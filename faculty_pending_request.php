<?php
// Initialize the session

session_start();
require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["logged_in_as"]=="System_Admin" || $_SESSION["logged_in_as"] == "Student"){
    header("location: index.php");
    exit;
}
?>

<?php
    if( isset( $_REQUEST['accept'] ))
    {
        $student_id = $_REQUEST['student_id'];
        $offering_id = $_COOKIE['offering_id'];
        $course_type = $_REQUEST['course_type'];
        $sql = "Insert into Enrollment values($student_id, $offering_id, NULL, '$course_type')";
        if(mysqli_query($link, $sql)){
        	echo "Course Accepted successfully", $student_id;
        	$sql2 = "Delete from Course_Bucket where Student_ID=$student_id and Offering_ID=$offering_id";
        	if(mysqli_query($link, $sql2)){
	        	echo "Done";
	        	header("location: faculty_pending_request.php");
	        }
	        else{
	        	echo "There is some error" . mysqli_error($link);
	        }

        }
        else{
        	echo "Can't accept request" . mysqli_error($link);
        }
        
    }
    if( isset( $_REQUEST['reject'] ))
    {
        $student_id = $_REQUEST['student_id'];
        $offering_id = $_COOKIE['offering_id'];
        $sql = "Delete from Course_Bucket where Student_ID=$student_id and Offering_ID=$offering_id";
        if(mysqli_query($link, $sql)){
        	echo "Request rejected ", $student_id;
        	 header("location: faculty_pending_request.php");
        }
        else{
        	echo "No such request exist" . mysqli_error($link);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
        .wrapper{ width: 1250px; padding: 20px; }
    </style>
</head>
<body>
	<nav class="navbar navbar-inverse">
      <div class="container-fluid">
      <div class="navbar-header">
          <a class="navbar-brand" href="index.php">University Management</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php">Sign Out</a></li>
        </ul>
      </div>
    </nav>
    <div class="wrapper">
    <h1> Accept/Reject course request</h1><br>
    <?php
        $offering_id = $_COOKIE['offering_id'];
        $sql = "Select * from Course_Bucket where Offering_ID=$offering_id";
        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){
                echo "<table class ='table table-hover'>";
                echo "<tr>";
                    echo "<th class = 'text-center'>Roll Number </th>";
                    echo "<th class = 'text-center'>Name </th>";
                    echo "<th class = 'text-center'> Requested As </th>";
                    echo "<th class = 'text-center'> Accept/Reject </th>";
                    echo "<th class = 'text-center'> View Student Transcript </th>";
                echo "</tr>";
                while($row = mysqli_fetch_array($result)){
                    $roll_number = $row['Student_ID'];
                    $course_type = $row['Course_Type'];
                    $sql2 = "Select Name from Student where Roll_Number=$roll_number";
                    $result_student = mysqli_query($link, $sql2);
                    $row_student = mysqli_fetch_array($result_student);
                    $name = $row_student['Name'];
                    echo "<form method='post'";
                    echo "<tr>";
                        echo "<td class = 'text-center'>" . $roll_number. "</td>";
                        echo "<td class = 'text-center'>" . $name . "</td>";
                        echo "<td class = 'text-center'>" . $course_type . "</td>";
                        echo "<td class = 'text-center'>";
                            echo "<input type='submit', class = 'btn btn-success', name='accept' value='Accept'/>";
                            echo "  ";
                            echo "<input type='submit', class = 'btn btn-danger', name='reject' value='Reject'/>";
                            echo "<input type='hidden' name='student_id' value=$roll_number>";
                            echo "<input type='hidden' name='course_type' value=$course_type>";
                        echo "</td>";
                        echo "<td class = 'text-center'>", "<a href='progress_report2.php?roll_number=$roll_number'>View</a>", "</td>";
                    echo "</tr>";
                    echo "</form>";
                }
                // Free result set
                mysqli_free_result($result);
            } else{
                echo "No records matching your query were found.";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }   
    ?>

    </div>
    <p> Go back to <a href="faculty_mycourses.php">My Courses</a>.</p>
</body>
</html>