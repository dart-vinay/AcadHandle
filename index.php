<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if($_SESSION["logged_in_as"] == "Student"){
        header("location: welcome1.php");
    }
    elseif($_SESSION["logged_in_as"] == "Faculty"){
        header("location: welcome2.php");
    }
    elseif($_SESSION["logged_in_as"] == "System_Admin"){
        header("location: welcome3.php");
    }
    else{
        echo "There is some problem signinig in";
    }
    // header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $designation = "";
$username_err = $password_err = $designation_err = "";
// echo "heck";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
        // echo "heck";
    } else{
        $password = trim($_POST["password"]);
        // echo "heck", strlen($password);
    }
    
    if(empty(trim($_POST["designation"]))){
        $designation_err = "Please select the login type.";
    } else{
        $designation = trim($_POST["designation"]);
        // echo "heck", $designation;
    }
    // echo "heck";
    // Validate credentials
    // echo 
    if(empty($username_err) && empty($password_err) && empty($designation_err)){
        // Prepare a select statement
        if($designation == "Student"){
            $sql = "SELECT Roll_Number, password FROM Student WHERE Roll_Number = ?";
        }
        elseif($designation == "Faculty"){
            $sql = "SELECT Faculty_ID, password FROM Faculty WHERE Faculty_ID = ?";
        }
        elseif($designation == "System_Admin"){
            $sql = "SELECT username, password FROM System_Admin WHERE username = ?";
        }
        else{
            echo $designation_err;
        }
        // $sql = "SELECT id, username, password FROM Users WHERE username = ?";
        echo "entereing here";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){

                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["username"] = $username;
                            $_SESSION["logged_in_as"] = $designation;                       
                            if($designation == "Student"){
                                header("location: welcome1.php");
                            }
                            elseif($designation == "Faculty"){
                                header("location: welcome2.php");
                            }
                            elseif($designation == "System_Admin"){
                                header("location: welcome3.php");
                            }
                            else{
                                echo $designation_err;
                            }
                            // Redirect user to welcome page
                            // header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
      </div>
    </nav>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Login As</label>
                <select name = "designation" class="form-control" value="<?php echo $designation; ?>">
                    <option value="Student">Student</option>
                    <option value="Faculty">Faculty</option>
                    <option value="System_Admin">Administrator</option>
                </select>
                <span class="help-block"><?php echo $designation_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
        </form>
    </div>    
</body>
</html>