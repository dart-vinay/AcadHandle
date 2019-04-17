<?php
// Include config file
require_once "config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Define variables and initialize with empty values
$title = $code = $deptid = $credits = "";
$title_err = $code_err = $deptid_err = $credits_err = "";
 

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
        if(empty(trim($_POST["code"]))){
            $code_err = "Please enter the Course Code.";
        } else{
            // Prepare a select statement
            $sql = "SELECT Course_No FROM Course WHERE Course_No = ?";
            
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_code);
                
                // Set parameters
                $param_code = trim($_POST["code"]);
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    /* store result */
                    // mysqli_stmt_store_result($stmt);
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) == 1){
                        $code_err = "This Course already exists in the database";
                    } else{
                        $code = trim($_POST["code"]);
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
        
        if(empty(trim($_POST["title"]))){
            $title_err = "Please enter the Course title.";
        } else{
            $title = trim($_POST["title"]);
        }

        if(empty(trim($_POST["deptid"]))){
            $deptid_err = "Please select the Department.";
        } else{
            $deptid = trim($_POST["deptid"]);
        }

        if(empty(trim($_POST["credits"]))){
            $credits_err = "Please enter the Course Credits.";
        } else{
            $credits = trim($_POST["credits"]);
        }

        if(empty($title_err) && empty($code_err) && empty($deptid_err) && empty($credits_err)){
            
            // Prepare an insert statement
            $sql = "INSERT INTO Course (Course_No, Title, Dept_ID, Credits) VALUES (?, ?, ?, ?)";
            // if(mysqli_prepare($link, $sql)){
            //         header("location: index.php");
            // } else{
            //     echo "Something went wrong. Please try again later.".mysqli_error($link);
            // }
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sssi", $param_code, $param_title, $param_deptid, $param_credits);
                
                // Set parameters
                $param_code = $code;
                $param_title = $title;
                $param_deptid = $deptid;
                $param_credits = $credits;
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
        <h2>Add a Course</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($code_err)) ? 'has-error' : ''; ?>">
                <label>Course Code</label>
                <input type="text" name="code" class="form-control" value="<?php echo $code; ?>">
                <span class="help-block"><?php echo $code_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($title_err)) ? 'has-error' : ''; ?>">
                <label>Course Title</label>
                <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
                <span class="help-block"><?php echo $title_err; ?></span>
            </div>
            <div class="form-group">
                <label>Department</label>
                <select name = "deptid" class="form-control" value="<?php echo $deptid; ?>">
                    <option value="AE">Aerospace Engineering</option>
                    <option value="BSBE">Biological Sciences & Bioengineering</option>
                    <option value="CHE">Chemical Engineering</option>
                    <option value="CE">Civil Engineering</option>
                    <option value="CSE">Computer Science & Engineering</option>
                    <option value="EE">Electrical Engineering</option>
                    <option value="MSE">Materials Science & Engineering</option>
                    <option value="ME">Mechanical Engineeringg</option>
                    <option value="IME">Industrial & Management Engineering</option>
                    <option value="CHM">BS Chemistry</option>
                    <option value="PHY">BS Physics</option>
                    <option value="MTH">BS Maths</option>
                    <option value="ECO">BS Economics</option>
                    <option value="ES">Earth Sciences</option>
                </select>
            </div>
            <div class="form-group <?php echo (!empty($credits_err)) ? 'has-error' : ''; ?>">
                <label>Course Credits</label>
                <input type="text" name="credits" class="form-control" value="<?php echo $credits; ?>">
                <span class="help-block"><?php echo $credits_err; ?></span>
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