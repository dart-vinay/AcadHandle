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
    if( isset( $_REQUEST['test'] ))
    {
        $student_id = $_REQUEST['student_id'];
        $grade = $_REQUEST['grade'];
        $offering_id = $_COOKIE['offering_id'];
        $sql = "Update Enrollment set grade=$grade where Roll_Number=$student_id and Offering_ID=$offering_id";
        if(mysqli_query($link, $sql)){
        	echo "Grade Successfully submitted for ", $student_id;
        }
        else{
        	echo "Could not submit grade" . mysqli_error($link);
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
    <h1> TAs in this Course</h1><br>
    <?php
        $offering_id = $_GET['offering_id'];
        $sql = "Select * from TA_Ship where Offering_ID=$offering_id";
        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){
                echo "<table class ='table table-hover'>";
                echo "<tr>";
                    echo "<th class = 'text-center'>Roll Number </th>";
                    echo "<th class = 'text-center'>Name </th>";
                echo "</tr>";
                while($row = mysqli_fetch_array($result)){
                    $roll_number = $row['Roll_Number'];
                    $sql2 = "Select Name from Student where Roll_Number=$roll_number order by Roll_Number";
                    $result_student = mysqli_query($link, $sql2);
                    $row_student = mysqli_fetch_array($result_student);
                    $name = $row_student['Name'];
                    echo "<tr>";
                        echo "<td class = 'text-center'>" . $roll_number. "</td>";
                        echo "<td class = 'text-center'>" . $name . "</td>";
                    echo "</tr>";
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