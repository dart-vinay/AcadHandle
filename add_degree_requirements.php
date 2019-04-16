<?php
// Include config file
require_once "config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Define variables and initialize with empty values
$deptid = $progid = "";
$totalcreds = 0;
$totalcreds_err = $deptid_err = $progid_err = "";
 

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
     
        // Validate roll number
        if(empty(trim($_POST["deptid"]))){
            $deptid_err = "Please enter the Department ID.";
        } 
        else if(empty(trim($_POST["progid"]))){
            $progid_err = "Please enter the Program ID.";
        }
        else{
            // Prepare a select statement
            $sql = "SELECT Dept_ID,Prog_ID FROM Degree_Desc WHERE Dept_ID = ? AND Prog_ID = ?";
            
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ss", $param_deptid, $param_progid);
                
                // Set parameters
                $param_deptid = trim($_POST["deptid"]);
                $param_progid = trim($_POST["progid"]);
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    /* store result */
                    // mysqli_stmt_store_result($stmt);
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) == 1){
                        $progid_err = "The requirements for this degree have already been specified";
                    } else{
                        $deptid = trim($_POST["deptid"]);
                        $progid = trim($_POST["progid"]);
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
        
        if(empty(trim($_POST["totalcreds"]))){
            $totalcreds_err = "Enter total credits required to complete this Program";
        } else{
            $totalcreds = trim($_POST["totalcreds"]);
        }

        if(empty($deptid_err) && empty($progid_err)){
            
            // Prepare an insert statement
            $sql = "INSERT INTO Degree_Desc (Dept_ID, Prog_ID, Total_Credits_Req) VALUES (?, ?, ?)";
            // if(mysqli_prepare($link, $sql)){
            //         header("location: index.php");
            // } else{
            //     echo "Something went wrong. Please try again later.".mysqli_error($link);
            // }
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ssi", $param_deptid, $param_progid, $param_totalcreds);
                
                // Set parameters
                $param_deptid = $deptid;
                $param_progid = $progid;
                $param_totalcreds = $totalcreds;
                if(mysqli_stmt_execute($stmt)){
                    // Redirect to login page
                    // echo "heckk";
                    header("location: index.php");
                } else{
                    echo "Something went wrong. Please try again later.".mysqli_error($link);
                }
            }
             
            // Close statement
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
    <div class="wrapper">
        <h2>Add Degree requirements</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($deptid_err)) ? 'has-error' : ''; ?>">
                <label>Dept ID</label>
                <input type="text" name="deptid" class="form-control" value="<?php echo $deptid; ?>">
                <span class="help-block"><?php echo $deptid_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($progid_err)) ? 'has-error' : ''; ?>">
                <label>Prog ID</label>
                <input type="text" name="progid" class="form-control" value="<?php echo $progid; ?>">
                <span class="help-block"><?php echo $progid_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($totalcreds_err)) ? 'has-error' : ''; ?>">
                <label>Total Credits Required</label>
                <input type="otext" name="totalcreds" class="form-control" value="<?php echo $totalcreds; ?>">
                <span class="help-block"><?php echo $totalcreds_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <!-- <p>Already have an account? <a href="index.php">Login here</a>.</p> -->
        </form>
    </div>    
</body>
</html>