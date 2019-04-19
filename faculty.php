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
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
      <div class="navbar-header">
          <a class="navbar-brand" href="index.php">University Management</a>
        </div>
      </div>
    </nav>
    <div class = "container">
        <?php
        $name = $id = $dept = $desig = "";
        $row['name'] = "";  
        $row['id'] = ""; 
        $row['dept'] = "";
        $row['desig'] = ""; 
        require_once('config.php');
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        $sql = "SELECT * FROM Faculty ";
        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){
                echo "<table class='table table-stripped'>";
                    echo "<tr>";
                        echo "<th class ='text-center'>Name</th>";
                        echo "<th class ='text-center'>Department</th>";
                        echo "<th class ='text-center'>Designation</th>";
                    echo "</tr>";
                while($row = mysqli_fetch_array($result)){
                    // echo gettype($row);
                    $name = $row['Name'];
                    $dept = $row['Dept_ID'];
                    $desig = $row['Designation'];
                    echo "<tr>";
                        echo "<td>" . $name . "</td>";
                        echo "<td>" . $dept . "</td>";
                        echo "<td>" . $desig . "</td>";
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