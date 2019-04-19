<?php
// Include config file
require_once "config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Define variables and initialize with empty values
$book = "";
$book_err = "";
 

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
else{
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(empty(trim($_POST["book"]))){
            $book_err = "Please enter the Book ID.";
        } else{
            $book = trim($_POST["book"]);
        }
        if(empty($book_err)){
            $issuer = $_SESSION["username"];
            $issuer_identity = $_SESSION["logged_in_as"];
            $date = date('Y/m/d H:i:s');
            $date = strtotime($date);
            $date = strtotime("+7 day", $date);
            $date = date('Y-m-d H:i:s', $date);
            // Prepare an insert statement
            // $sql = "INSERT INTO IssueBook Values (Book_ID, Issued_To, Issuer_Identity, Due_Date) VALUES ($book, $issuer, $issuer_identity, $date)";
            $sql = "INSERT INTO IssueBook (Book_ID, Issued_To, Issuer_Identity, Due_Date) VALUES (?, ?, ?, ?)";
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ssss", $book, $issuer,$issuer_identity, $date);
                if(mysqli_stmt_execute($stmt)){
                    echo "heck";
                    header("location: index.php");
                } else{
                    echo "kjdf";
                    echo "There is some error".mysqli_error($link);
                }
            }
            else{
                echo "There is some error".mysqli_error($link);
            }
        }
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Issue</title>
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
        <h2>Issue a Book</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($book_err)) ? 'has-error' : ''; ?>">
                <label>Enter Book ID</label>
                <input type="text" name="book" class="form-control" value="<?php echo $book; ?>">
                <span class="help-block"><?php echo $book_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
        </form>
    </div>    
</body>
</html>