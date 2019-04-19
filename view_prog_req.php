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
          <a class="navbar-brand" href="#">University Management</a>
        </div>
      </div>
    </nav>
    <div class = "container">
        <?php
        // $name = $id = "";
        // $row['Prog_Name'] = "";  
        // $row['Prog_ID'] = "";  
        require_once('config.php');
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        $sql = "SELECT * FROM Degree_Desc ";
        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){
                echo "<table class='table table-stripped'>";
                    echo "<tr>";
                        echo "<th class ='text-center'>Department ID</th>";
                        echo "<th class ='text-center'>Program ID</th>";
                        echo "<th class ='text-center'>IC Credits</th>";
                        echo "<th class ='text-center'>DC Credits</th>";
                        echo "<th class ='text-center'>DE Credits</th>";
                        echo "<th class ='text-center'>OE Credits</th>";
                        echo "<th class ='text-center'>ESO Credits</th>";
                        echo "<th class ='text-center'>HSS1 Credits</th>";
                        echo "<th class ='text-center'>HSS2 Credits</th>";
                        echo "<th class ='text-center'>UGP Credits</th>";
                        echo "<th class ='text-center'>Thesis Credits</th>";
                        echo "<th class ='text-center'>Total Credits Req.</th>";
                    echo "</tr>";
                while($row = mysqli_fetch_array($result)){
                    // echo gettype($row);
                    $dept_id = $row['Dept_ID'];
                    $prog_id = $row['Prog_ID'];
                    $ic = $row['IC_Credits'];
                    $dc = $row['DC_Credits'];
                    $de = $row['DE_Credits'];
                    $oe = $row['OE_Credits'];
                    $eso = $row['ESO_Credits'];
                    $hss1 = $row['HSS1_Credits'];
                    $hss2 = $row['HSS2_Credits'];
                    $ugp = $row['UGP_Credits'];
                    $thesis = $row['Thesis_Credits'];
                    $total = $row['Total_Credits_Req'];
                    echo "<tr>";
                        echo "<td>" . $dept_id . "</td>";
                        echo "<td>" . $prog_id . "</td>";
                        echo "<td>" . $ic . "</td>";
                        echo "<td>" . $dc . "</td>";
                        echo "<td>" . $de . "</td>";
                        echo "<td>" . $oe . "</td>";
                        echo "<td>" . $eso . "</td>";
                        echo "<td>" . $hss1 . "</td>";
                        echo "<td>" . $hss2 . "</td>";
                        echo "<td>" . $ugp . "</td>";
                        echo "<td>" . $thesis . "</td>";
                        echo "<td>" . $total . "</td>";

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