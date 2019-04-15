<?php
// Include config file
require_once "config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Define variables and initialize with empty values
$name = $roll_number = $password = $confirm_password= "";
$dept_id = $prog_id="";
$name_err = $roll_number_err = $password_err = $confirm_password_err = "";
 

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
        if(empty(trim($_POST["roll_number"]))){
            $roll_number_err = "Please enter the Roll Number.";
        } else{
            // Prepare a select statement
            $sql = "SELECT Roll_Number FROM Student WHERE Roll_Number = ?";
            
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_roll_number);
                
                // Set parameters
                $param_roll_number = trim($_POST["roll_number"]);
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    /* store result */
                    // mysqli_stmt_store_result($stmt);
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) == 1){
                        $roll_number_err = "This Student already exists in the database";
                    } else{
                        $roll_number = trim($_POST["roll_number"]);
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
        
        // Validate password
        if(empty(trim($_POST["password"]))){
            $password_err = "Please enter a password.";     
        } elseif(strlen(trim($_POST["password"])) < 6){
            $password_err = "Password must have atleast 6 characters.";
        } else{
            $password = trim($_POST["password"]);
        }

        // Validate Identification Number
        if(empty(trim($_POST["name"]))){
            $name_err = "Please enter the name of the student.";
        } else{
            $name = trim($_POST["name"]);
        }

        if(empty(trim($_POST["dept_id"]))){
            // $designation_err = "Please enter the designation.";
        } else{
            $dept_id = trim($_POST["dept_id"]);
        }

        if(empty(trim($_POST["prog_id"]))){
            // $designation_err = "Please enter the designation.";
        } else{
            $prog_id = trim($_POST["prog_id"]);
        }

        // Validate confirm password
        if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err = "Please confirm password.";     
        } else{
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($password_err) && ($password != $confirm_password)){
                $confirm_password_err = "Password did not match.";
            }
        }
        
        // Check input errors before inserting in database
        if(empty($name_err) && empty($password_err) && empty($confirm_password_err) && empty(
            $roll_number_err)){
            
            // Prepare an insert statement
            $sql = "INSERT INTO Student (Roll_Number, password, Name, Dept_ID, Prog_ID ) VALUES (?, ?, ?, ?, ?)";
            // if(mysqli_prepare($link, $sql)){
            //         header("location: index.php");
            // } else{
            //     echo "Something went wrong. Please try again later.".mysqli_error($link);
            // }
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sssss", $param_roll_number, $param_password, $param_name, $param_dept_id, $param_prog_id);
                
                // Set parameters
                $param_roll_number = $roll_number;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                $param_name = $name;
                $param_dept_id = $dept_id;
                $param_prog_id = $prog_id;
                // mysqli_stmt_execute($stmt);
                // Attempt to execute the prepared statement
                // echo mysqli_stmt_execute($stmt), "fgh";
                // echo "safe";
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
        <h2>Sign Up for Student</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($roll_number_err)) ? 'has-error' : ''; ?>">
                <label>Roll Number</label>
                <input type="text" name="roll_number" class="form-control" value="<?php echo $roll_number; ?>">
                <span class="help-block"><?php echo $roll_number_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                <span class="help-block"><?php echo $name_err; ?></span>
            </div>

            <div class="form-group">
                <label>Department</label>
                <select name = "dept_id" class="form-control" value="<?php echo $dept_id; ?>">
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
            <div class="form-group">
                <label>Program</label>
                <select name = "prog_id" class="form-control" value="<?php echo $prog_id; ?>">
                    <option value="B.Tech">Bachelor of Technology</option>
                    <option value="M.Tech">M.Tech</option>
                    <option value="Dual">Dual Degree</option>
                    <option value="Double Major">Double Major</option>
                    <option value="BS">Bachelor in Science</option>
                    <option value="MS">Masters in Science</option>
                    <option value="PhD">"Doctor of Philosophy"</option>
                </select>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="index.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>