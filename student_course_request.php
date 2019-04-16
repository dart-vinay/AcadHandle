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
    <?php
        $roll_number = $_SESSION["username"];
        $sql = "Select * from Offering, Course where Offering.Course_ID=Course.Course_No ";
        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){
                echo "<table class ='table table-hover'>";
                echo "<tr>";
                    echo "<th align ='centre'>Department </th>";
                    echo "<th align ='centre'>Course Title </th>";
                    echo "<th align ='centre'>Credits </th>";
                    echo "<th align ='centre'>Course Slot </th>";
                    echo "<th align ='centre'>Faculty </th>";
                    echo "<th align ='centre'>Request/Cancel </th>";

                echo "</tr>";
                while($row = mysqli_fetch_array($result)){
                    $faculty_name = $row['Faculty_ID'];
                    $sql2  = "Select Name from Faculty where Faculty_ID=$faculty_name";
                    $result_faculty = mysqli_query($link, $sql2);
                    $row_faculty = mysqli_fetch_array($result_faculty);


                    echo "<tr>";
                        echo "<td>" . $row['Dept_ID'] . "</td>";
                        echo "<td>" . $row['Title'] . "</td>";
                        echo "<td>" . $row['Credits'] . "</td>";
                        echo "<td>" . $row['Slot'] . "</td>";
                        echo "<td>" . $row_faculty['Name'] ."</td>";
                        echo "<td>" , "<a href = '' class = 'btn btn-success'> Request </a>" , "    ","<a href = '' class = 'btn btn-warning'> Cancel </a>", "</td>";
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