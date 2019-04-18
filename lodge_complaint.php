<?php
// Include config file
require_once "config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Define variables and initialize with empty values
$name = $desig = $desc = $loc = $contact = "";
$handler = "123";
$name_err = $desig_err = $desc_err = $loc_err = $contact_err = $status_err = $handler_err = "";

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["logged_in_as"]=="System_Admin"){
    header("location: index.php");
    exit;
}
else{
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty(trim($_POST["name"]))){
            $name_err = "Please enter your name.";
        } else{
            $name = trim($_POST["name"]);
        }
        if(empty(trim($_POST["desc"]))){
            $desc_err = "Please enter Complaint Description.";
        } else{
            $desc = trim($_POST["desc"]);
        }
        if(empty(trim($_POST["loc"]))){
            $loc_err = "Please enter your location.";
        } else{
            $loc = trim($_POST["loc"]);
        }
        if(empty(trim($_POST["contact"]))){
            $contact_err = "Please enter your Mobile No.";
        } else{
            $contact = trim($_POST["contact"]);
        }
        if(empty($name_err) && empty($desig_err) && empty($desc_err) && empty($loc_err) && empty($contact_err)){
            
            // Prepare an insert statement
            $sql = "INSERT INTO Complaint (Lodged_By, Lodger_Designation, Description, Status, Handler, Location, Lodger_Contact) VALUES (?, ?, ?, ?, ?, ?, ?)";
            // if(mysqli_prepare($link, $sql)){
            //         header("location: index.php");
            // } else{
            //     echo "Something went wrong. Please try again later.".mysqli_error($link);
            // }
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sssssss", $param_name, $param_desig, $param_desc, $param_status, $param_handler, $param_loc, $param_contact);
                
                // Set parameters
                $param_name = $_SESSION['username'];
                $param_desig = $_SESSION['logged_in_as'];
                $param_desc = $desc;
                $param_status = "Pending";
                $param_handler = $handler;
                $param_loc = $loc;
                $param_contact = $contact;
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
    <title>Lodge Complaint</title>
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
        <h2>Lodge a Complaint</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                <span class="help-block"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($desc_err)) ? 'has-error' : ''; ?>">
                <label>Description</label>
                <input type="text" name="desc" class="form-control" value="<?php echo $desc; ?>">
                <span class="help-block"><?php echo $desc_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($handler_err)) ? 'has-error' : ''; ?>">
                <label>Handler</label>
                <input type="text" name="handler" class="form-control" value="<?php echo $handler; ?>">
                <span class="help-block"><?php echo $handler_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($loc_err)) ? 'has-error' : ''; ?>">
                <label>Your Location</label>
                <input type="text" name="loc" class="form-control" value="<?php echo $loc; ?>">
                <span class="help-block"><?php echo $loc_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($contact_err)) ? 'has-error' : ''; ?>">
                <label>Mobile Number</label>
                <input type="text" name="contact" class="form-control" value="<?php echo $contact; ?>">
                <span class="help-block"><?php echo $contact_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
        </form>
    </div>    
</body>
</html>