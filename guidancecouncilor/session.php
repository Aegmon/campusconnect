<?php
include('../connection.php');
session_start();
if(isset($_SESSION['userID'])) {
  // User is logged in, do nothing
} else {
  // User is not logged in, redirect to index.php
  header("Location: ../index.php");
  exit;
}

$user_check = $_SESSION['userID'];
$query_faculty_info = "SELECT * FROM guidancecounselor WHERE userID='$user_check'";
$ses_sql_faculty_info = mysqli_query($con, $query_faculty_info);
$faculty_info = mysqli_fetch_assoc($ses_sql_faculty_info);

// Variables for faculty info
$faculty_id = $faculty_info['g_id'];
$userID = $faculty_info['userID'];
$first_name = $faculty_info['fname'];
$last_name = $faculty_info['lname'];
$birthday = $faculty_info['birthdate'];





?>

