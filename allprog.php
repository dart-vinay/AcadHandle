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
    <div class = "container">
        <?php
        $name = $id = "";
        $row['Prog_Name'] = "";  
        $row['Prog_ID'] = "";  
        require_once('config.php');
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        $sql = "SELECT * FROM Program ";
        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){
                echo "<table class='table table-stripped'>";
                    echo "<tr>";
                        echo "<th class ='text-center'>Program Code</th>";
                        echo "<th class ='text-center'>Program Name</th>";
                    echo "</tr>";
                while($row = mysqli_fetch_array($result)){
                    // echo gettype($row);
                    $id = $row['Prog_ID'];
                    $name = $row['Prog_Name'];
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