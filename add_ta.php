<?php
// Initialize the session

session_start();
require_once "config.php";
$ta_id = $ta_id_err = "";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["logged_in_as"]=="System_Admin" || $_SESSION["logged_in_as"] == "Student"){
    header("location: index.php");
    exit;
}
else{
	// Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
     
        // Validate TA ID
        $offering_id = $_POST['offering_id'];
        if(empty(trim($_POST['ta_id']))){
            $ta_id_err = "Please enter the TA ID.";
        } else{
            // Prepare a select statement
            $sql = "SELECT * FROM TA_Ship WHERE Offering_ID = ?";
            
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_ta_id);
                
                // Set parameters
                $param_ta_id = trim($_POST["ta_id"]);
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    /* store result */
                    // mysqli_stmt_store_result($stmt);
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) == 1){
                        $ta_id_err = "The TA already exists for this course";
                    } else{
                        $ta_id = trim($_POST["ta_id"]);
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }

        if(empty($ta_id_err)){
            
            // Prepare an insert statement
            $sql = "INSERT INTO TA_Ship values($offering_id, $ta_id)";
            if(mysqli_query($link, $sql)){
        		echo "TA successfully added.";
        		header("location: faculty_mycourses.php");
	        }
	        else{
	        	echo "Could not add a TA" . mysqli_error($link);
	        }
        }
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
        <h2>Add TA for this course</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($ta_id_err)) ? 'has-error' : ''; ?>">
                <label>TA ID</label>
                <input type="text" name="ta_id" class="form-control" value="<?php echo $ta_id; ?>">
                <span class="help-block"><?php echo $ta_id_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <?php
                $offering_id = $_GET['offering_id'];
                echo "<input type='hidden' name='offering_id' value=$offering_id>";
                ?>
            </div>
            <!-- <p>Already have an account? <a href="index.php">Login here</a>.</p> -->
        </form>
    </div>    
</body>
</html>