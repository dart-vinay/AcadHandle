<?php
// Include config file
require_once "config.php";
require_once "global_variables.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Define variables and initialize with empty values
$roll_number = $fee_status = $comments="";
$roll_err = $fee_err = "";
 

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
        if(empty($_POST['roll_number'])){
            echo "Enter roll number";
        } else{
            $roll_number = trim($_POST['roll_number']);
            $sql = "SELECT Roll_Number FROM Registration WHERE Sem_ID = $sem_id AND Roll_Number = $roll_number";
            $result = mysqli_query($link, $sql);
            if(mysqli_num_rows($result) == 1){
                if(!empty($_POST['fee_status'])){
                    $fee_status  = $_POST['fee_status'];
                    $sql = "UPDATE Registration SET Fee_Status = $fee_status WHERE Roll_Number = '$roll_number' AND Sem_ID = $sem_id";
                    if(mysqli_query($link, $sql)){
                        echo "<script> alert('Registration Details Updated.');</script>";
                        header("add_reg_info.php");
                    }else{
                        echo "hecka".mysqli_error($link);
                    }
                }

            }else {
                //rest of the stuff;
                $sql = "Select sum(Credits) from Enrollment, Offering, Course where Roll_Number = $roll_number and Offering.Offering_ID= Enrollment.Offering_ID and Offering.Course_ID=Course.Course_No and Offering.Sem_ID=$sem_id";
                if($result = mysqli_query($link, $sql)){
                    $row = mysqli_fetch_array($result);
                    $credits = (int)$row['sum(Credits)'];
                    $roll_number = trim($_POST['roll_number']);
                    $fee_status  = trim($_POST['fee_status']);
                    $SPI = 0;
                    $comments = trim($_POST['comments']);
                    $sql1 = "INSERT INTO Registration VALUES ($roll_number, $sem_id, $credits, $SPI, $fee_status, '$comments')";
                    if($result = mysqli_query($link, $sql1)){
                        echo "<script> alert('Registration Details Updated.');</script>";
                        header("location: index.php");
                    }else{
                        echo "hefdck".mysqli_error($link);
                    }

                }
            }
        }
    }
}
    //     // Validate roll number
    //     if(empty(trim($_POST["roll_number"]))){
    //         $roll_err = "Please enter the Roll no.";
    //     } else{
    //         // Prepare a select statement
    //         $sql = "SELECT Roll_Number FROM Registration WHERE Sem_ID=$sem_id Roll_No = ?";
            
    //         if($stmt = mysqli_prepare($link, $sql)){
    //             // Bind variables to the prepared statement as parameters
    //             mysqli_stmt_bind_param($stmt, "s", $param_roll);
                
    //             // Set parameters
    //             $param_roll = trim($_POST["roll_number"]);
    //             // Attempt to execute the prepared statement
    //             if(mysqli_stmt_execute($stmt)){
    //                 /* store result */
    //                 // mysqli_stmt_store_result($stmt);
    //                 mysqli_stmt_store_result($stmt);
    //                 if(mysqli_stmt_num_rows($stmt) == 1){
    //                     $roll_number = trim($_POST["roll_number"]);
    //                     $fee_status = trim($_POST["fee_status"]);
    //                     echo $fee_status;
    //                     if(!empty($fee_status)){
    //                         $sql = "UPDATE Registration SET Fee_Status = $fee_status WHERE Roll_Number = $roll_number AND Sem_ID = $sem_id";
    //                         if(mysqli_query($link, $sql)){
    //                             echo "<script> alert('Registration Details Updated.');</script>";
    //                             header("add_reg_info.php");
    //                         }
    //                         else{
    //                             echo "heck".mysqli_error($link);
    //                         }
    //                         exit;     
    //                     }else {
    //                         $fee_error = "Enter FEE Status";
    //                     }
    //                 } else{
    //                     $roll_number = trim($_POST["roll_number"]);
    //                 }
    //             } else{
    //                 echo "Oops! Something went wrong. Please try again later.";
    //             }
    //         }
    //         // Close statement
    //         mysqli_stmt_close($stmt);
    //     }
        
    //     // if(empty(trim($_POST["fee_status"]))){
    //     //     $fee_err = "Please enter the FEE status.";
    //     // } else{
    //     //     $title = trim($_POST["title"]);
    //     // }

    //     // if(empty(trim($_POST["deptid"]))){
    //     //     $deptid_err = "Please select the Department.";
    //     // } else{
    //     //     $deptid = trim($_POST["deptid"]);
    //     // }

    //     // if(empty(trim($_POST["credits"]))){
    //     //     $credits_err = "Please enter the Course Credits.";
    //     // } else{
    //     //     $credits = trim($_POST["credits"]);
    //     // }

    //     // if(empty($title_err) && empty($code_err) && empty($deptid_err) && empty($credits_err)){
            
    //     //     // Prepare an insert statement
    //     //     $sql = "INSERT INTO Course (Course_No, Title, Dept_ID, Credits) VALUES (?, ?, ?, ?)";
    //     //     // if(mysqli_prepare($link, $sql)){
    //     //     //         header("location: index.php");
    //     //     // } else{
    //     //     //     echo "Something went wrong. Please try again later.".mysqli_error($link);
    //     //     // }
    //     //     if($stmt = mysqli_prepare($link, $sql)){
    //     //         // Bind variables to the prepared statement as parameters
    //     //         mysqli_stmt_bind_param($stmt, "sssi", $param_code, $param_title, $param_deptid, $param_credits);
                
    //     //         // Set parameters
    //     //         $param_code = $code;
    //     //         $param_title = $title;
    //     //         $param_deptid = $deptid;
    //     //         $param_credits = $credits;
    //     //         if(mysqli_stmt_execute($stmt)){
    //     //             // Redirect to login page
    //     //             // echo "heckk";
    //     //             header("location: index.php");
    //     //         } else{
    //     //             echo "Something went wrong. Please try again later.".mysqli_error($link);
    //     //         }
    //     //     }
             
    //     //     // Close statement
    //     //     mysqli_stmt_close($stmt);
    //     // }
        
    //     // Close connection
    //     mysqli_close($link);
    // }

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
        <h2>Add Registration Detail</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Roll Number</label>
                <input type="text" name="roll_number" class="form-control" value="<?php echo $roll_number; ?>">
                <span class="help-block"><?php echo $roll_err; ?></span>
            </div>
            <div class="form-group">
                <label>Fee Status</label>
                <select name = "fee_status" class="form-control" value="<?php echo $fee_status
                ; ?>">
                    <option value="0">Pending</option>
                    <option value="1">Paid</option>
                </select>
            </div>
            <div class="form-group">
                <label>Comments</label>
                <input type="text" name="comments" class="form-control" value="<?php echo $comments; ?>">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
            <!-- <p>Already have an account? <a href="index.php">Login here</a>.</p> -->
        </form>
    </div>    
</body>
</html>