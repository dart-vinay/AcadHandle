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
    if( isset( $_REQUEST['drop-btn'] ))
    {
        $username = $_SESSION["username"];
        $offering_id = $_REQUEST["offering_id"];

        $sql = "DELETE FROM Enrollment WHERE Enrollment.Roll_Number =  $username and Enrollment.Offering_ID = $offering_id"; 
        
        if(mysqli_query($link, $sql)){
            echo "Course dropped";
        } else{
              echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
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
          <a class="navbar-brand" href="#">University Management</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php">Sign Out</a></li>
        </ul>
      </div>
    </nav>
    <div class="wrapper">
    <h1> Courses this Semester</h1><br>
    <?php
        // $sem_id = 1;
        $roll_number = $_SESSION["username"];
        $sql = "SELECT * FROM Enrollment, Offering, Course WHERE Enrollment.Offering_ID = Offering.Offering_ID and Offering.Course_ID = Course.Course_No and Enrollment.Roll_Number = $roll_number ";
        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){

                echo "<table class ='table table-hover'>";
                echo "<tr>";
                    echo "<th class = 'text-center'>Course No </th>";
                    echo "<th class = 'text-center'>Course Title </th>";
                    echo "<th class = 'text-center'>Credits </th>";
                    echo "<th class = 'text-center'>Grade  Points </th>";
                    echo "<th class = 'text-center'>Semester </th>";
                echo "</tr>";
                while($row = mysqli_fetch_array($result)){
                    $offering_id = $row['Offering_ID'];
                    echo "<tr>";
                        echo "<td class = 'text-center'>" . $row['Course_ID'] . "</td>";
                        echo "<td class = 'text-center'>" . $row['Title'] . "</td>";
                        echo "<td class = 'text-center'>" . $row['Credits'] . "</td>";
                        echo "<td class = 'text-center'>" . $row['Grade'] . "</td>";
                        echo "<td class = 'text-center'>" . $row['Sem_ID'] . "</td>";
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