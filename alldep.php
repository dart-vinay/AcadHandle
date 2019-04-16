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
    $name = $id = "";
    $row['Dept_Name'] = "";  
    $row['Dept_ID'] = "";  
    require_once('config.php');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $sql = "SELECT * FROM Department ";
    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
            echo "<table class='table table-stripped'>";
                echo "<tr>";
                    echo "<th class ='text-center'>Dept_ID</th>";
                    echo "<th class ='text-center'>Dept_Name</th>";
                echo "</tr>";
            while($row = mysqli_fetch_array($result)){
                // echo gettype($row);
                $id = $row['Dept_ID'];
                $name = $row['Dept_Name'];
                echo "<tr>";
                    echo "<td>" . $id . "</td>";
                    echo "<td>" . $name . "</td>";
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