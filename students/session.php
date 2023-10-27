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
$query_student_info = "SELECT * FROM student WHERE user_id='$user_check'";
$ses_sql_student_info = mysqli_query($con, $query_student_info);
$student_info = mysqli_fetch_assoc($ses_sql_student_info);

// Variables for student info
$student_id = $student_info['stud_id'];

$first_name = $student_info['fname'];
$last_name = $student_info['lname'];
$birthday = $student_info['birthdate'];
$gender = $student_info['gender'];
$address = $student_info['address'];
$image = $student_info['image'];
$email = $student_info['email'];
$user_id = $student_info ['user_id'];
// Fetching section for student ID and section ID

$query_section_student = "SELECT * FROM section_student WHERE stud_id='$student_id'";
$ses_sql_section_student = mysqli_query($con, $query_section_student);
$section_student_info = mysqli_fetch_assoc($ses_sql_section_student);
$section_id = $section_student_info['section_id'];
$query_section = "SELECT * FROM section WHERE id='$section_id'";
$ses_sql_section = mysqli_query($con, $query_section);
$section_info = mysqli_fetch_assoc($ses_sql_section);

// Variables for section
$section_id = $section_info['id'];
$grade = $section_info['grade'];

// Fetching strand information for section
$strand_id = $section_info['strand'];
$query_strand = "SELECT * FROM strand WHERE strand_id='$strand_id'";
$ses_sql_strand = mysqli_query($con, $query_strand);
$strand_info = mysqli_fetch_assoc($ses_sql_strand);

// Variables for strand
$strand = $strand_info['strand'];



?>

