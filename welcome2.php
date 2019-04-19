<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["logged_in_as"]=="System_Admin" || $_SESSION["logged_in_as"] == "Student"){
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
      <div class="navbar-header">
          <a class="navbar-brand" href="index.php">University Management</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
        <li><a href="reset-password.php">Reset Password</a></li>
        <li><a href="logout.php">Sign Out</a></li>
        </ul>
      </div>
    </nav>
    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to your homepage.</h1>
    </div>

    <p><a href="faculty_mycourses.php">My Courses</a>.</p>
    <p>Want to access library <a href="library.php">Click here</a>.</p>
    <p><a href="my_complaints.php">My Complaints</a>.</p>
</body>
</html>