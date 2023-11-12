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
$query_faculty_info = "SELECT * FROM faculty_info WHERE userID='$user_check'";
$ses_sql_faculty_info = mysqli_query($con, $query_faculty_info);
$faculty_info = mysqli_fetch_assoc($ses_sql_faculty_info);
$currentUserId = $_SESSION['userID'];
// Variables for faculty info
$faculty_id = $faculty_info['faculty_id'];
$userID = $faculty_info['userID'];
$first_name = $faculty_info['first_name'];
$last_name = $faculty_info['last_name'];
$birthday = $faculty_info['birthday'];
$gender = $faculty_info['gender'];
$address = $faculty_info['address'];
$image = $faculty_info['image'];
$email = $faculty_info['email'];
$user_id = $faculty_info ['userID'];
// Fetching section for faculty ID and section ID
$query_section = "SELECT * FROM section WHERE instructor='$faculty_id'";
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

// Further data for section_student
$query_section_student = "SELECT * FROM section_student WHERE section_id='$section_id'";
$ses_sql_section_student = mysqli_query($con, $query_section_student);
$section_student_info = mysqli_fetch_assoc($ses_sql_section_student);

// Variables for section_student

// Additional variables as per the fields in the section_student table

// Query to get the count of male and female students in the specific section
$query_male_count = "SELECT COUNT(*) as male_count FROM student WHERE gender='male' AND stud_id IN (SELECT stud_id FROM section_student WHERE section_id='$section_id')";
$query_female_count = "SELECT COUNT(*) as female_count FROM student WHERE gender='female' AND stud_id IN (SELECT stud_id FROM section_student WHERE section_id='$section_id')";

$ses_sql_male = mysqli_query($con, $query_male_count);
$ses_sql_female = mysqli_query($con, $query_female_count);

// Fetching the counts
$male_count = mysqli_fetch_assoc($ses_sql_male)['male_count'];
$female_count = mysqli_fetch_assoc($ses_sql_female)['female_count'];

// Query to get the count of users with isOnline = 1 in userdata table in the specific section
$query_online_count = "SELECT COUNT(*) as online_count FROM userdata u
JOIN faculty_info f ON u.userID = f.userID
JOIN section s ON f.faculty_id = s.instructor
WHERE s.id = '$section_id' AND isOnline= '1' and u.usertype='student'";
$ses_sql_online = mysqli_query($con, $query_online_count);

// Fetching the count
$online_count = mysqli_fetch_assoc($ses_sql_online)['online_count'];


// Query to get the total number of userdata on specific section
$query_total_userdata = "SELECT COUNT(u.userID) as total_userdata FROM userdata u
JOIN faculty_info f ON u.userID = f.userID
JOIN section s ON f.faculty_id = s.instructor
WHERE s.id = '$section_id' and  u.usertype='student'";

$ses_sql_total_userdata = mysqli_query($con, $query_total_userdata);

// Fetching the count
$total_userdata = mysqli_fetch_assoc($ses_sql_total_userdata)['total_userdata'];

// Query to get the total number of students in a specific section
$query_total_students = "SELECT COUNT(*) as total_students FROM section_student WHERE section_id='$section_id'";
$ses_sql_total_students = mysqli_query($con, $query_total_students);
$total_students = mysqli_fetch_assoc($ses_sql_total_students)['total_students'];




?>

