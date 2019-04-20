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
    <h1> Registration History</h1><br>
    <?php
        // $sem_id = 1;
        $roll_number = $_SESSION["username"];
        $sql = "SELECT * FROM Registration WHERE Roll_Number = $roll_number";
        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){

                echo "<table class ='table table-hover'>";
                echo "<tr>";
                    echo "<th class = 'text-center'>Semester </th>";
                    echo "<th class = 'text-center'>Credits </th>";
                    echo "<th class = 'text-center'>Fee Status </th>";
                    echo "<th class = 'text-center'>Comments </th>";
                echo "</tr>";
                while($row = mysqli_fetch_array($result)){
                    echo "<tr>";
                        echo "<td class = 'text-center'>" . $row['Sem_ID'] . "</td>";
                        echo "<td class = 'text-center'>" . $row['Credits'] . "</td>";
                        echo "<td class = 'text-center'>" . $row['Fee_Status'] . "</td>";
                        echo "<td class = 'text-center'>" . $row['Comments'] . "</td>";
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