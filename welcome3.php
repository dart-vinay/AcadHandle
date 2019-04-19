<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["logged_in_as"]=="Student" || $_SESSION["logged_in_as"] == "Faculty"){
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
          <a class="navbar-brand" href="#">University Management</a>
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
    <p>Want to add a new account <a href="signup.php">Click here</a>.</p>
    <p>To add a new Department <a href="add_department.php">Click here</a>. To view all Department <a href="alldep.php">Click here</a></p>
    <p>To add a new Program <a href="add_program.php">Click here</a>. To view all Program <a href="allprog.php">Click here</a></p>
    <p>Add degree requirements of a Program <a href="add_degree_requirements.php">here</a>.</p>
    <p>Add a new Course <a href="add_course.php">Click here</a>.</p>
    <p>Add a new Staff member <a href="add_staff.php">Here</a>.</p>
    <p>Add a new Offering <a href="addoffering.php">Here</a>.</p>
</body>
</html>