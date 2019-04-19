<?php
// Include config file
require_once "config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Define variables and initialize with empty values
$year = $type = "";
$year_err = $type_err = "";
 

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["logged_in_as"]=="Student" || $_SESSION["logged_in_as"] == "Faculty"){
    header("location: index.php");
    exit;
}
else{
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(empty(trim($_POST["year"]))){
            $year_err = "Please enter the Semester year.";
        } else{
            $year = trim($_POST["year"]);
        }

        if(empty(trim($_POST["type"]))){
            $type_err = "Please select the Semester type.";
        } else{
            $type = trim($_POST["type"]);
        }

        if(empty($year_err) && empty($type_err)){
            
            // Prepare an insert statement
            $sql = "INSERT INTO Semester (Year, Type) VALUES (?, ?)";

            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ii", $param_year, $param_type);
                
                // Set parameters
                $param_year = $year;
                $param_type = $type;
                if(mysqli_stmt_execute($stmt)){
                    header("location: index.php");
                } else{
                    echo "Already a entry with this year and semester type exist".mysqli_error($link);
                }
            }
             
            // Close oci_statement_type(statement)
            mysqli_stmt_close($stmt);
        }
        
        // Close connection
        mysqli_close($link);
    }
}

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Adding</title>
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
          <a class="navbar-brand" href="index.php">University Management</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php">Sign Out</a></li>
        </ul>
      </div>
    </nav>
    <div class="wrapper">
        <h2>Add a Course</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($year_err)) ? 'has-error' : ''; ?>">
                <label>Semester Year</label>
                <input type="text" name="year" class="form-control" value="<?php echo $year; ?>">
                <span class="help-block"><?php echo $year_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($type_err)) ? 'has-error' : ''; ?>">
                <label>Semester Type (1st/2nd)</label>
                <input type="text" name="type" class="form-control" value="<?php echo $type; ?>">
                <span class="help-block"><?php echo $type_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
        </form>
    </div>    
</body>
</html>