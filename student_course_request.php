<?php
// Initialize the session
session_start();
require_once "config.php";
require_once "global_variables.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["logged_in_as"]=="System_Admin" || $_SESSION["logged_in_as"] == "Faculty"){
    header("location: index.php");
    exit;
}
?>
<?php
    if( isset( $_REQUEST['test'] ))
    {

        $student_id = $_REQUEST['student_id'];
        $offering_id = $_REQUEST['offering_id'];
        $course_type = $_REQUEST['course_type'];
        $credits_requested = $_REQUEST['credits_requested'];
        if ($credits_requested<65){
            $sql1 = "Select * from Course_Bucket where Student_ID=$student_id and Offering_ID=$offering_id";
            $sql2 = "Select * from Enrollment where Roll_Number=$student_id and Offering_ID=$offering_id";
            $error_occured = 0;
            if($result1 = mysqli_query($link, $sql1)){
                if(mysqli_num_rows($result1) > 0){
                    echo "Course is already requested";
                    $error_occured = 1;
                }
            }
            if($result2 = mysqli_query($link, $sql2)){
                if(mysqli_num_rows($result2) > 0){
                    echo "Already enrolled in the course";
                    $error_occured = 1;
                }
            }
            if ($error_occured==0){
                $sql = "Insert into Course_Bucket values($student_id, $offering_id,'$course_type')";
                if(mysqli_query($link, $sql)){
                    echo "Course request successful";
                } else{
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                }
            }
        }
        else{
            echo "You cannot request for more courses";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request Course</title>
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
    <h1> Courses offered this Semester</h1><br>
    <h4>Courses Requested till now: <?php 
        $credits_requested = 0;
        $roll_number = $_SESSION['username'];
        $sql_c1 = "Select sum(Credits) from Enrollment, Offering, Course where Roll_Number=$roll_number and Offering.Offering_ID=Enrollment.Offering_ID and Offering.Course_ID=Course.Course_No and Sem_ID = $sem_id";
        if($result_credit = mysqli_query($link, $sql_c1)){
            $row = mysqli_fetch_array($result_credit);
            $credits_requested = $credits_requested + $row['sum(Credits)'];
        } else{
            echo "No enrolled courses this sem" . mysqli_error($link);
        }
        $sql_c2 = "Select sum(Credits) from Course_Bucket, Offering, Course where Student_ID=$roll_number and Offering.Offering_ID=Course_Bucket.Offering_ID and Offering.Course_ID=Course.Course_No and Sem_ID = $sem_id";
        if($result_req = mysqli_query($link, $sql_c2)){
            $row2 = mysqli_fetch_array($result_req);
            $credits_requested = $credits_requested + $row2['sum(Credits)'];
        } else{
            echo "No Pending requested courses this sem" . mysqli_error($link);
        }
        echo $credits_requested;
    echo "</h4><br>";
        $sql = "Select * from Offering, Course where Offering.Course_ID=Course.Course_No and Sem_ID=$sem_id";
        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){

                echo "<table class ='table table-hover'>";
                echo "<tr>";
                    echo "<th class = 'text-center'>Department </th>";
                    echo "<th class = 'text-center'>Course Title </th>";
                    echo "<th class = 'text-center'>Credits </th>";
                    echo "<th class = 'text-center'>Course Slot </th>";
                    echo "<th class = 'text-center'>Faculty </th>";
                    echo "<th class = 'text-center'>Course_type </th>";
                    echo "<th class = 'text-center'>Request </th>";

                echo "</tr>";
                while($row = mysqli_fetch_array($result)){
                    $offering_id = $row['Offering_ID'];
                    $student_id = $_SESSION['username'];
                    $faculty_name = $row['Faculty_ID'];
                    $sql2  = "Select Name from Faculty where Faculty_ID=$faculty_name";
                    $result_faculty = mysqli_query($link, $sql2);
                    $row_faculty = mysqli_fetch_array($result_faculty);
                    echo "<tr>";
                        echo "<td class = 'text-center'>" . $row['Dept_ID'] . "</td>";
                        echo "<td class = 'text-center'>" . $row['Title'] . "</td>";
                        echo "<td class = 'text-center'>" . $row['Credits'] . "</td>";
                        echo "<td class = 'text-center'>" . $row['Slot'] . "</td>";
                        echo "<td class = 'text-center'>" . $row_faculty['Name'] ."</td>";
                        echo "<form method='post'>";
                            echo "<td class = 'text-center'>", "<select name = 'course_type' class='form-control'>";
                                echo "<option value=OE>OE</option>";
                                echo "<option value=DE>DE</option>";
                                echo "<option value=DC>DC</option>";
                                echo "<option value=ESO>ESO</option>";
                                echo "<option value=UGP>UGP</option>";
                                echo "<option value=IC>IC</option>";
                            echo "</select>";
                            echo "</td>";
                            echo "<td class = 'text-center'>";
                            echo "<input type='submit', class = 'btn btn-success', name='test'/>";
                            echo "<input type='hidden' name='offering_id' value=$offering_id>";
                            echo "<input type='hidden' name='student_id' value=$student_id>";
                            echo "<input type='hidden' name='credits_requested' value=$credits_requested>";
                            echo "</td>";

                        echo "</form>";
                        echo "</td>";
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
</body>
</html>