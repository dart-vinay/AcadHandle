<?php
// Include config file
require_once "config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["logged_in_as"]=="System_Admin"){
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My complaints</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
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
    <div class="page-header">
        <h1>My Complaints</h1>
    </div>
    <div>
    <a href="lodge_complaint.php" class="btn btn-warning">Lodge a New Complaint</a><br><br>
    </div>
    <div class = "container">
        <?php
        $desc = $id = $status = $date = $loc = "";
        $row['Complaint_ID'] = "";  
        $row['Description'] = "";
        $row['Status'] = ""; 
        $row['Lodge_Date'] = ""; 
        $row['Location'] = "";
        $lodger = $_SESSION['username'];
        require_once('config.php');
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        $sql = "SELECT * FROM Complaint WHERE Lodged_By = $lodger";
        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){
                echo "<table class='table table-stripped'>";
                    echo "<tr>";
                        echo "<th class ='text-center'>Complaint ID</th>";
                        echo "<th class ='text-center'>Description</th>";
                        echo "<th class ='text-center'>Status</th>";
                        echo "<th class ='text-center'>Time of Lodging</th>";
                        echo "<th class ='text-center'>Location</th>";
                    echo "</tr>";
                while($row = mysqli_fetch_array($result)){
                    // echo gettype($row);
                    $id = $row['Complaint_ID'];
                    $desc = $row['Description'];
                    $status = $row['Status'];
                    $date = $row['Lodge_Date'];
                    $loc = $row['Location'];
                    echo "<tr>";
                        echo "<td>" . $id . "</td>";
                        echo "<td>" . $desc . "</td>";
                        echo "<td>" . $status . "</td>";
                        echo "<td>" . $date . "</td>";
                        echo "<td>" . $loc . "</td>";
                    echo "</tr>";
                }
                // echo "</table>";
                // Free result set
                mysqli_free_result($result);
            } 
            else{
                echo "No records matching your query were found.";
            }
        } 
        else{
            echo "ERROR: Could not execute $sql. " . mysqli_error($link);
        }

        ?>
    </div>
</body>
</html>