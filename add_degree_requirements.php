<?php
// Include config file
require_once "config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Define variables and initialize with empty values
$deptid = $progid = "";
$totalcreds = 0;
$iccreds = $hs1creds = $hs2creds = $esocreds = $oecreds = $decreds = $dccreds = $thesiscreds = $ugpcreds = 0;
$totalcreds_err = $deptid_err = $progid_err = $iccreds_err = $hs1creds_err = $hs2creds_err = $oecreds_err = "";
$decreds_err = $dccreds_err = $thesiscreds_err = $ugpcreds_err = $esocreds_err = "";
 

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
        if(empty(trim($_POST["iccreds"]))){
            $iccreds_err = "Enter IC credits required to complete this Program";
        } else{
            $iccreds = trim($_POST["iccreds"]);
        }
        if(empty(trim($_POST["hs1creds"]))){
            $hs1creds_err = "Enter HS1 credits required to complete this Program";
        } else{
            $hs1creds = trim($_POST["hs1creds"]);
        }
        if(empty(trim($_POST["hs2creds"]))){
            $hs2creds_err = "Enter HS2 credits required to complete this Program";
        } else{
            $hs2creds = trim($_POST["hs2creds"]);
        }
        if(empty(trim($_POST["oecreds"]))){
            $oecreds_err = "Enter OE credits required to complete this Program";
        } else{
            $oecreds = trim($_POST["oecreds"]);
        }
        if(empty(trim($_POST["dccreds"]))){
            $dccreds_err = "Enter DC credits required to complete this Program";
        } else{
            $dccreds = trim($_POST["dccreds"]);
        }
        if(empty(trim($_POST["decreds"]))){
            $decreds_err = "Enter DE credits required to complete this Program";
        } else{
            $decreds = trim($_POST["decreds"]);
        }
        // if(empty(trim($_POST["thesiscreds"]))){
        //     $thesiscreds_err = "Enter Thesis credits required to complete this Program";
        // } else{
        //     $thesiscreds = trim($_POST["thesiscreds"]);
        // }
        $thesiscreds = trim($_POST["thesiscreds"]);
        if(empty(trim($_POST["ugpcreds"]))){
            $ugpcreds_err = "Enter UGP credits required to complete this Program";
        } else{
            $ugpcreds = trim($_POST["ugpcreds"]);
        }
        if(empty(trim($_POST["esocreds"]))){
            $esocreds_err = "Enter ESO credits required to complete this Program";
        } else{
            $esocreds = trim($_POST["esocreds"]);
        }

        if(empty($deptid_err) && empty($progid_err) && empty($totalcreds_err) && empty($iccreds_err) && empty($decreds_err) && empty($dccreds_err) && empty($oecreds_err) && empty($hs1creds_err) && empty($hs2creds_err) 
            && empty($esocreds_err)){ 
            
            // Prepare an insert statement
            $sql = "INSERT INTO Degree_Desc (Dept_ID, Prog_ID, Total_Credits_Req, IC_Credits, HSS1_Credits, HSS2_Credits, OE_Credits, DC_Credits, DE_Credits, Thesis_Credits, UGP_Credits, ESO_Credits) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            // if(mysqli_prepare($link, $sql)){
            //         header("location: index.php");
            // } else{
            //     echo "Something went wrong. Please try again later.".mysqli_error($link);
            // }
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ssiiiiiiiiii", $param_deptid, $param_progid, $param_totalcreds, $param_iccreds, $param_hs1creds, $param_hs2creds, $param_oecreds, $param_dccreds, $param_decreds, $param_thesiscreds, $param_ugpcreds, $param_esocreds );
                
                // Set parameters
                $param_deptid = $deptid;
                $param_progid = $progid;
                $param_totalcreds = $totalcreds;
                $param_iccreds = $iccreds;
                $param_hs1creds = $hs1creds;
                $param_hs2creds = $hs2creds;
                $param_dccreds = $dccreds;
                $param_oecreds = $oecreds;
                $param_decreds = $decreds;
                $param_esocreds = $esocreds;
                $param_thesiscreds = $thesiscreds;
                $param_ugpcreds = $ugpcreds;
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
            <div class="form-group <?php echo (!empty($iccreds_err)) ? 'has-error' : ''; ?>">
                <label>IC Credits Required</label>
                <input type="otext" name="iccreds" class="form-control" value="<?php echo $iccreds; ?>">
                <span class="help-block"><?php echo $iccreds_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($hs1creds_err)) ? 'has-error' : ''; ?>">
                <label>HSS1 Credits Required</label>
                <input type="otext" name="hs1creds" class="form-control" value="<?php echo $hs1creds; ?>">
                <span class="help-block"><?php echo $hs1creds_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($hs2creds_err)) ? 'has-error' : ''; ?>">
                <label>HSS2 Credits Required</label>
                <input type="otext" name="hs2creds" class="form-control" value="<?php echo $hs2creds; ?>">
                <span class="help-block"><?php echo $hs2creds_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($oecreds_err)) ? 'has-error' : ''; ?>">
                <label>OE Credits Required</label>
                <input type="otext" name="oecreds" class="form-control" value="<?php echo $oecreds; ?>">
                <span class="help-block"><?php echo $oecreds_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($dccreds_err)) ? 'has-error' : ''; ?>">
                <label>DC Credits Required</label>
                <input type="otext" name="dccreds" class="form-control" value="<?php echo $dccreds; ?>">
                <span class="help-block"><?php echo $dccreds_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($decreds_err)) ? 'has-error' : ''; ?>">
                <label>DE Credits Required</label>
                <input type="otext" name="decreds" class="form-control" value="<?php echo $decreds; ?>">
                <span class="help-block"><?php echo $decreds_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($thesiscreds_err)) ? 'has-error' : ''; ?>">
                <label>Thesis Credits Required</label>
                <input type="otext" name="thesiscreds" class="form-control" value="<?php echo $thesiscreds; ?>">
                <span class="help-block"><?php echo $thesiscreds_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($ugpcreds_err)) ? 'has-error' : ''; ?>">
                <label>UGP Credits Required</label>
                <input type="otext" name="ugpcreds" class="form-control" value="<?php echo $ugpcreds; ?>">
                <span class="help-block"><?php echo $ugpcreds_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($esocreds_err)) ? 'has-error' : ''; ?>">
                <label>ESO Credits Required</label>
                <input type="otext" name="esocreds" class="form-control" value="<?php echo $esocreds; ?>">
                <span class="help-block"><?php echo $esocreds_err; ?></span>
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