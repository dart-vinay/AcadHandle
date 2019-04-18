<?php
// Include config file
require_once "config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Define variables and initialize with empty values
$coursecode = $facid = $modular = $semid = $slot = "";
$coursecode_err = $facid_err = $modular_err = $semid_err = $slot_err = "";

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["logged_in_as"]=="Faculty" || $_SESSION["logged_in_as"]=="Student"){
    header("location: index.php");
    exit;
}
else{
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        echo $_POST['coursecode'];
        if(empty(trim($_POST["coursecode"]))){
            $coursecode_err = "Please select the Course code.";
        } else{
            $coursecode = trim($_POST["coursecode"]);
        }
        if(empty(trim($_POST["facid"]))){
            $facid_err = "Please enter Faculty ID.";
        } else{
            $facid = trim($_POST["facid"]);
        }
        if(empty(trim($_POST["modular"]))){
            $modular_err = "Please choose wether the Course is modular or not";
        } else{
            $modular = trim($_POST["modular"]);
        }
        if(empty(trim($_POST["semid"]))){
            $semid_err = "Please enter the Semester ID.";
        } else{
            $semid = trim($_POST["semid"]);
        }
        if(empty(trim($_POST["slot"]))){
            $slot_err = "Please enter Course slot.";
        } else{
            $slot = trim($_POST["slot"]);
        }
        if(empty($coursecode_err) && empty($facid_err) && empty($modular_err) && empty($semid_err) && empty($slot_err)){
            // Prepare an insert statement
            $sql = "INSERT INTO Offering (Course_ID, Faculty_ID, Modular, Sem_ID, Slot) VALUES (?, ?, ?, ?, ?)";
            // if(mysqli_prepare($link, $sql)){
            //         header("location: index.php");
            // } else{
            //     echo "Something went wrong. Please try again later.".mysqli_error($link);
            // }
            if($stmt = mysqli_prepare($link, $sql)){
                echo "Heck";
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ssiss", $param_coursecode, $param_facid, $param_modular, $param_semid, $param_slot);
                
                // Set parameters
                $param_coursecode = $coursecode;
                $param_facid = $facid;
                $param_modular = $modular;
                $param_semid = $semid;
                $param_slot = $slot;
                if(mysqli_stmt_execute($stmt)){
                    header("location: index.php");
                } else{
                    echo "Something went wrong. Please try again later.".mysqli_error($link);
                }

            }
             
            // Close statement
            mysqli_stmt_close($stmt);
        }
        
        // Close connection
    }
}


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Offering</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
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
        <h2>Add Offering</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Course Code</label>
                
                <?php
                $row['Course_No'] = "";
                $sql = "SELECT Course_No FROM Course";
                // echo "fsggfdg";
                if($result = mysqli_query($link, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        echo "fsggfdg";
                        echo "<select name = 'coursecode' class='form-control'>";
                        while($row = mysqli_fetch_array($result)){
                            $coursecode = $row['Course_No'];
                                echo "<option value=$coursecode>$coursecode</option>";
                        }
                        echo "</select>";
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
            <div class="form-group <?php echo (!empty($modular_err)) ? 'has-error' : ''; ?>">
                <label>Faculty ID</label>
                <input type="text" name="facid" class="form-control" value="<?php echo $facid; ?>">
                <span class="help-block"><?php echo $facid_err; ?></span>
            </div>
            <div class="form-group">
                <label>Modular</label>
                <select name = "modular" class="form-control" value="<?php echo $modular; ?>">
                    <option value=1>YES</option>
                    <option value=0>NO</option>
                </select>
            </div>
            <div class="form-group <?php echo (!empty($semid_err)) ? 'has-error' : ''; ?>">
                <label>Semester ID</label>
                <input type="text" name="semid" class="form-control" value="<?php echo $semid; ?>">
                <span class="help-block"><?php echo $semid_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($slot_err)) ? 'has-error' : ''; ?>">
                <label>Slot</label>
                <input type="text" name="slot" class="form-control" value="<?php echo $slot; ?>">
                <span class="help-block"><?php echo $slot_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
        </form>
    </div>    
</body>
</html>