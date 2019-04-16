<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        
        <h1>Hi, <b><?php echo htmlspecialchars($name); ?></b>. Welcome to our site.</h1>
    </div>
    <div class = "container">
<?php
    $coursename = $coursecode = $dept = $credits = "";
    $row['coursename'] = "";  
    $row['coursecode'] = ""; 
    $row['dept'] = "";
    $row['credits'] = "";
    require_once('config.php');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $sql = "SELECT * FROM Course ";
    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
            echo "<table class='table table-stripped'>";
                echo "<tr>";
                    echo "<th class ='text-center'>Course Code</th>";
                    echo "<th class ='text-center'>Dept</th>";
                    echo "<th class ='text-center'>Title</th>";
                    echo "<th class ='text-center'>Credits</th>";
                echo "</tr>";
            while($row = mysqli_fetch_array($result)){
                // echo gettype($row);
                $coursename = $row['Title'];
                $coursecode = $row['Course_No'];
                $credits = $row['Credits'];
                $dept = $row['Dept_ID'];
                echo "<tr>";
                    echo "<td>" . $coursecode . "</td>";
                    echo "<td>" . $dept . "</td>";
                    echo "<td>" . $coursename . "</td>";
                    echo "<td>" . $credits . "</td>";
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