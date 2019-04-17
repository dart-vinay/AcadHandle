<?php
// Initialize the session
session_start();
require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["logged_in_as"]=="System_Admin" || $_SESSION["logged_in_as"] == "Student"){
    header("location: index.php");
    exit;
}
?><?php
    if( isset( $_REQUEST['test'] ))
    {
        setcookie('offering_id', $_REQUEST['offering_id']);
        echo $_COOKIE['offering_id'];
        header("location: assign_grade.php");
        
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
    <h1> My courses this Semester</h1><br>
    <?php
        $faculty_id = $_SESSION["username"];
        $sql = "Select * from Offering, Course where Offering.Course_ID=Course.Course_No and Faculty_ID= $faculty_id";
        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){
                echo "<table class ='table table-hover'>";
                echo "<tr>";
                    echo "<th class = 'text-center'>Course Number </th>";
                    echo "<th class = 'text-center'>Course Title </th>";
                    echo "<th class = 'text-center'>Student List</th>";
                    echo "<th class = 'text-center'>TA List </th>";
                    echo "<th class = 'text-center'> Assign Grades </th>";
                    echo "<th class = 'text-center'> Add TAs </th>";
                echo "</tr>";
                while($row = mysqli_fetch_array($result)){
                    $course_code = $row['Course_No'];
                    $course_title = $row['Title'];
                    $offering_id = $row['Offering_ID'];
                    echo "<tr>";
                        echo "<td class = 'text-center'>" . $course_code. "</td>";
                        echo "<td class = 'text-center'>" . $course_title . "</td>";
                        echo "<td class = 'text-center'>" , "<a href='students_enrolled.php?offering_id=$offering_id'>Click Here</a>", "</td>";
                        echo "<td class = 'text-center'>" , "<a href='ta_list.php?offering_id=$offering_id'>Click Here</a>", "</td>";
                        
                        echo "<td class = 'text-center'>","<form method='post'>";
                            echo "<input type='submit', class = 'btn btn-success', name='test' value = 'Assign'/>";
                            echo "<input type='hidden' name='offering_id' value=$offering_id>";
                        echo "</form>";
                        echo "<td class = 'text-center'>" , "<a href='add_ta.php?offering_id=$offering_id'>Click Here</a>", "</td>";
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