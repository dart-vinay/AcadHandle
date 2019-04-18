<?php
// Initialize the session
require_once "config.php";
session_start();

$oe = $de = $eso = $dc = $ic = $ugp = $thesis= $hss1 = $hss2 = 0;
$oe_req = $de_req = $eso_req = $dc_req = $ic_req = $ugp_req = $thesis_req= $hss1_req = $hss2_req = 0;
$cpi = 0;
function check($credits, $type){
    global $oe, $de, $eso, $dc ,$ic ,$ugp ,$thesis,$hss1 ,$hss2;
    if($type=='OE'){
        $oe=$credits;
    }
    elseif($type='DE'){
        $de=$credits;
    }
    elseif($type='DC'){
        $dc=$credits;
    }
    elseif($type='UGP'){
        $ugp=$credits;
    }
    elseif($type='ESO'){
        $eso=$credits;
    }
    elseif($type='IC'){
        $ic=$credits;
    }
    elseif($type='HSS1'){
        $hss1=$credits;
    }
    elseif($type='HSS2'){
        $hss2=$credits;
    }
    elseif($type='Thesis'){
        $thesis=$credits;
    }
    else{
        echo "Course Type Not matched";
    }

}
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["logged_in_as"]=="System_Admin" || $_SESSION["logged_in_as"] == "Faculty"){
    header("location: index.php");
    exit;
}
else{
    $roll_number= $_SESSION['username'];
    $sql = "Select Course_Type, sum(Credits) from Enrollment, Offering, Course where Grade is NOT NULL and Roll_Number = $roll_number and Offering.Offering_ID= Enrollment.Offering_ID and Offering.Course_ID=Course.Course_No group by Course_Type";
    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                $credits = $row['sum(Credits)'];
                $course_type = $row['Course_Type'];
                check($credits,$course_type);
                // echo $oe, "df";
            }
            // Free result set
            mysqli_free_result($result);
        } else{
            echo "No records matching your query were found.";
        }
    } else{
          echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
    $sql2 = "Select Prog_ID, Dept_ID from Student where Roll_Number = $roll_number";
    if($result = mysqli_query($link, $sql2)){
        $row = mysqli_fetch_array($result);
        $prog_id = $row['Prog_ID'];
        $dept_id = $row['Dept_ID'];
        $sql3 = "Select * from Degree_Desc where Prog_ID='$prog_id' and Dept_ID='$dept_id'";
        if($result2 = mysqli_query($link,$sql3)){
            $row2 = mysqli_fetch_array($result2);
            $oe_req=$row2['OE_Credits'];
            $ic_req=$row2['IC_Credits'];
            $dc_req=$row2['DC_Credits'];
            $de_req=$row2['DE_Credits'];
            $eso_req=$row2['ESO_Credits'];
            $hss1_req=$row2['HSS1_Credits'];
            $hss2_req=$row2['HSS2_Credits'];
            $ugp_req=$row2['UGP_Credits'];
            $thesis_req=$row2['Thesis_Credits'];
        }
        else{
            echo "There is some error".mysqli_error($link);
        }
        
    }else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }

    $sql = "Select Credits, Grade from Enrollment, Offering, Course where Grade is NOT NULL and Roll_Number = $roll_number and Offering.Offering_ID= Enrollment.Offering_ID and Offering.Course_ID=Course.Course_No";
    $total_credits = 0;
    $total_value = 0;
    if($result_cpi = mysqli_query($link,$sql)){
        while($row = mysqli_fetch_array($result_cpi)){
            $total_credits = $total_credits + $row['Credits'];
            $total_value = $total_value + (int)$row['Credits'] * ((int)$row['Grade']);
        }
        $cpi = $total_value/((float)$total_credits);
    }
    else{
        echo "There is some error".mysqli_error($link);
    }
    

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 450px; padding: 20px; }
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
    <div class="container">
        <h2>Progress Report</h2>
        <h4 class = 'text-center'><b>CPI : <?php echo $cpi?></b></h4>
        <table class ='table table-hover'>
        <tr>
            <th class = 'text-center'>Course Type</th>
            <th class = 'text-center'>Credits Required</th>
            <th class = 'text-center'>Credits Completed</th>
        </tr>
        <tr>
          <th class = 'text-center'>Open Elective</th>
            <td class = 'text-center'><?php echo $oe_req?></td>
            <td class = 'text-center'><?php echo $oe?></td>
        </tr>
        <tr>
          <th class = 'text-center'>Departmental Elective</th>
            <td class = 'text-center'><?php echo $de_req?></td>
            <td class = 'text-center'><?php echo $de?></td>
        </tr>
        <tr>
          <th class = 'text-center'>Institute Compulsory</th>
            <td class = 'text-center'><?php echo $ic_req?></td>
            <td class = 'text-center'><?php echo $ic?></td>
        </tr>
        <tr>
          <th class = 'text-center'>Departmental Compulsory</th>
            <td class = 'text-center'><?php echo $dc_req?></td>
            <td class = 'text-center'><?php echo $dc?></td>
        </tr>
        <tr>
          <th class = 'text-center'>Engineering Science Optional</th>
            <td class = 'text-center'><?php echo $eso_req?></td>
            <td class = 'text-center'><?php echo $eso?></td>
        </tr>
        <tr>
          <th class = 'text-center'>HSS Level 1</th>
            <td class = 'text-center'><?php echo $hss1_req?></td>
            <td class = 'text-center'><?php echo $hss1?></td>
        </tr>
        <tr>
          <th class = 'text-center'>HSS Level 2</th>
            <td class = 'text-center'><?php echo $hss2_req?></td>
            <td class = 'text-center'><?php echo $hss2?></td>
        </tr>
        <tr>
          <th class = 'text-center'>UGP</th>
            <td class = 'text-center'><?php echo $ugp_req?></td>
            <td class = 'text-center'><?php echo $ugp?></td>
        </tr>
        <tr>
          <th class = 'text-center'>Thesis</th>
            <td class = 'text-center'><?php echo $thesis_req?></td>
            <td class = 'text-center'><?php echo $thesis?></td>
        </tr>
        </table>
        
    </div>    
</body>
</html>