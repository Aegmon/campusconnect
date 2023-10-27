<?php
include('../connection.php');
session_start();
if(isset($_SESSION['login_user'])) {
  // User is logged in, do nothing
} else {
  // User is not logged in, redirect to index.php
  header("Location: ../index.php");
  exit;
}

$user_check = $_SESSION['login_user'];
$query = "SELECT * FROM admin WHERE username='$user_check'";
$ses_sql = mysqli_query($con,$query);
$row = mysqli_fetch_assoc($ses_sql);

$user_id = $row ['admin_id'];

// Query to get the count of male and female students
$query_male_count = "SELECT COUNT(*) as male_count FROM student WHERE gender='male'";
$query_female_count = "SELECT COUNT(*) as female_count FROM student WHERE gender='female'";

$ses_sql_male = mysqli_query($con, $query_male_count);
$ses_sql_female = mysqli_query($con, $query_female_count);

// Fetching the counts
$male_count = mysqli_fetch_assoc($ses_sql_male)['male_count'];
$female_count = mysqli_fetch_assoc($ses_sql_female)['female_count'];

// Query to get the count of users with isOnline = 1 in userdata table
$query_online_count = "SELECT COUNT(*) as online_count FROM userdata WHERE isOnline=1 and usertype = 'student'";
$ses_sql_online = mysqli_query($con, $query_online_count);

// Fetching the count
$online_count = mysqli_fetch_assoc($ses_sql_online)['online_count'];
$query_faculty_count = "SELECT COUNT(*) as online_count FROM userdata WHERE usertype = 'faculty'";
$ses_sql_faculty = mysqli_query($con, $query_faculty_count);

// Fetching the count
$faculty_count = mysqli_fetch_assoc($ses_sql_faculty)['online_count'];

// Query to get the total number of userdata on specific section
$query_total_userdata = "SELECT COUNT(u.userID) as total_userdata FROM userdata u
    JOIN faculty_info f ON u.userID = f.userID
    JOIN section s ON f.faculty_id = s.instructor";

$ses_sql_total_userdata = mysqli_query($con, $query_total_userdata);

// Fetching the count
$total_userdata = mysqli_fetch_assoc($ses_sql_total_userdata)['total_userdata'];
// Query to get the total number of students in a specific section
$query_total_students = "SELECT COUNT(*) as total_students FROM section_student";
$ses_sql_total_students = mysqli_query($con, $query_total_students);
$total_students = mysqli_fetch_assoc($ses_sql_total_students)['total_students'];



?>