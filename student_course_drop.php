<?php
// Initialize the session
session_start();
require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["logged_in_as"]=="System_Admin" || $_SESSION["logged_in_as"] == "Faculty"){
    header("location: index.php");
    exit;
}
?>
<?php
    if( isset( $_REQUEST['drop-btn'] ))
    {
        $username = $_SESSION["username"];
        $offering_id = $_REQUEST["offering_id"];

        // echo "<script>alert(".  $_SESSION["username"].  ")</script>";
        $sql = "DELETE FROM Enrollment WHERE Enrollment.Roll_Number =  $username and Enrollment.Offering_ID = $offering_id"; 
        
        if(mysqli_query($link, $sql)){
            echo "Course dropped";
        } else{
              echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
        
        // $student_id = $_REQUEST['student_id'];
        // $offering_id = $_REQUEST['offering_id'];
        // $sql1 = "Select * from Course_Bucket where Student_ID=$student_id and Offering_ID=$offering_id";
        // $sql2 = "Select * from Enrollment where Roll_Number=$student_id and Offering_ID=$offering_id";
        // $error_occured = 0;
        // if($result1 = mysqli_query($link, $sql1)){
        //     if(mysqli_num_rows($result1) > 0){
        //         echo "Course is already requested";
        //         $error_occured = 1;
        //     }
        // }
        // if($result2 = mysqli_query($link, $sql2)){
        //     if(mysqli_num_rows($result2) > 0){
        //         echo "Already enrolled in the course";
        //         $error_occured = 1;
        //     }
        // }
        // if ($error_occured==0){
        //     $sql = "Insert into Course_Bucket values($student_id, $offering_id)";
        //     if(mysqli_query($link, $sql)){
        //         echo "Course request successful";
        //     } else{
        //         echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        //     }
        // }
        
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
    <div class="wrapper">
    <h1> Courses this Semester</h1><br>
    <?php
        $sem_id = 1;
        $roll_number = $_SESSION["username"];
        $sql = "select  *  from offering, enrollment, course where offering.Offering_ID = Enrollment.Offering_ID  and Enrollment.Roll_Number = $roll_number and Offering.Sem_ID  = $sem_id and course.Course_No=offering.Course_ID ";
        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){

                echo "<table class ='table table-hover'>";
                echo "<tr>";
                    echo "<th class = 'text-center'>Course No </th>";
                    echo "<th class = 'text-center'>Course Title </th>";
                    echo "<th class = 'text-center'>Credits </th>";
                    
                    echo "<th class = 'text-center'>Request </th>";

                echo "</tr>";
                while($row = mysqli_fetch_array($result)){
                    $offering_id = $row['Offering_ID'];

                    // $student_id = $_SESSION['username'];
                    // $faculty_name = $row['Faculty_ID'];
                    // $sql2  = "Select Name from Faculty where Faculty_ID=$faculty_name";
                    // $result_faculty = mysqli_query($link, $sql2);
                    // $row_faculty = mysqli_fetch_array($result_faculty);

                    echo "<tr>";
                        echo "<td class = 'text-center'>" . $row['Course_ID'] . "</td>";
                        echo "<td class = 'text-center'>" . $row['Title'] . "</td>";
                        echo "<td class = 'text-center'>" . $row['Credits'] . "</td>";
                        echo "<td class = 'text-center'>","<form method='post'>";
                            echo "<input type='submit', class = 'btn btn-success', name='drop-btn' value='Drop' />";
                             echo "<input type='hidden' name='offering_id' value=$offering_id>";
                            // echo "<input type='hidden' name='offering_id' value=$offering_id>";
                            // echo "<input type='hidden' name='student_id' value=$student_id>";
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