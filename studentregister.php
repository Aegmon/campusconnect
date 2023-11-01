
<?php
include("connection.php");
$error = "";
$stud_id = $_GET['stud_id'];
$user_id = $_GET['user_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    // Handle form submission

    $birthdate = $_POST['birthday'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $section_id = $_POST['section_id'];
    $student_number = $_POST['student_number'];
    $password =  $_POST['password'];
    $cpassword =  $_POST['cpassword'];

    // Check for empty data fields
    if (empty($birthdate) || empty($gender) || empty($address)  || empty($section_id) || empty($student_number) || empty($password) || empty($cpassword)) {
        $error = "Please fill in all the required fields.";
    } else {
        // Check if passwords match
        if ($password !== $cpassword) {
            $error = "Passwords do not match";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);




            // Insert data into 'userdata' table
            $update_userdata_query = "UPDATE userdata SET password = ? WHERE userID = ?";
            $stmt = $con->prepare($update_userdata_query);
            $stmt->bind_param("si", $hashed_password, $user_id);
            $stmt->execute();


        $update_student_query = "UPDATE student SET birthdate = ?, gender = ?, address = ?, student_number = ? WHERE stud_id = ?";
$stmt = $con->prepare($update_student_query);
$stmt->bind_param("ssssi", $birthdate, $gender, $address, $student_number, $stud_id);
$stmt->execute();




            $insert_section_student_query = "INSERT INTO section_student (stud_id, section_id) VALUES (?, ?)";
            $stmt = $con->prepare($insert_section_student_query);
            $stmt->bind_param("ii", $stud_id, $section_id);
            $stmt->execute();
             header("location:index.php");
        }


    }
}

?>
<!doctype html>
<html lang="en">


<!-- Mirrored from codervent.com/synadmin/demo/vertical/authentication-signup-with-header-footer.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Aug 2023 12:59:27 GMT -->
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
	<!--plugins-->
	<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="assets/css/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	<title>Campus Connect</title>
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
			<div class="authentication-header" style="background-image: url('assets/images/building.jpg'); background-size: cover; /* Adjust this property as needed */
    background-repeat: no-repeat;height:100%;">
  <!-- Content of the div goes here -->
</div>
		<header class="login-header shadow">
			<nav class="navbar navbar-expand-lg navbar-light bg-white rounded fixed-top rounded-0 shadow-sm">
				<div class="container-fluid">
					<a class="navbar-brand" href="index.php">
						<img src="assets/images/logo-img.png" width="200" alt="" />
					</a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent1">
						<!-- <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
							<li class="nav-item"> <a class="nav-link active" aria-current="page" href="#"><i class='bx bx-home-alt me-1'></i>Home</a>
							</li>
							<li class="nav-item"> <a class="nav-link" href="#"><i class='bx bx-user me-1'></i>About</a>
							</li>
							<li class="nav-item"> <a class="nav-link" href="#"><i class='bx bx-category-alt me-1'></i>Features</a>
							</li>
							<li class="nav-item"> <a class="nav-link" href="#"><i class='bx bx-microphone me-1'></i>Contact</a>
							</li>
						</ul> -->
					</div>
				</div>
			</nav>
		</header>
		<div class="d-flex align-items-center justify-content-center my-5">
			<div class="container">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2">
					<div class="col mx-auto">
						<div class="card mt-5">
							<div class="card-body">
								<div class="border p-4 rounded">
									<div class="text-center">
										<h3 class="">Sign Up</h3>
										<p>Already have an account? <a href="index.php">Sign in here</a>
										</p>
									</div>
								
									<div class="login-separater text-center mb-4"> <span>Complete registration</span>
										<hr/>
									</div>
									<div class="form-body">
								   <form class="row g-3" method="POST" action="studentregister.php?stud_id=<?php echo $stud_id ;?>&user_id=<?php echo $user_id ;?>" enctype="multipart/form-data">
										
											<div class="col-12">
												<label for="inputEmailAddress" class="form-label">Date of Birth</label>
											        <input type="date" class="form-control" id="inputEmail" name="birthday">
											</div>
											<div class="col-12">
											    <label for="inputEmail" class="form-label">Gender</label>
        <select class="form-select" id="inputGender" name="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
											</div>
										
											<div class="col-12">
											      <label for="inputStudentNumber" class="form-label">Student Number</label>
        <input type="number" class="form-control" id="inputStudentNumber" name="student_number">
											</div>
											<div class="col-12">
    <label for="inputStudentNumber" class="form-label">Grade And Section</label>
    <select class="form-control" id="inputStudentNumber" name="section_id">
        <?php
        // Establish a database connection (replace with your credentials)
     
        // Fetch data from the section table
        $sql = "SELECT id, grade, strand FROM section";
        $result = $con->query($sql);

        // Populate the dropdown with the fetched data
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row["id"] . '">Grade ' . $row["grade"] . ' - ' . $row["strand"] . '</option>';
            }
        } else {
            echo '<option value="">No sections available</option>';
        }

        // Close the connection
        $con->close();
        ?>
    </select>
</div>

											<div class="col-12">
									        <label for="inputAddress" class="form-label">Address</label>
                                          <input type="text" class="form-control" id="inputAddress" name="address">
											</div>
										
											
											<div class="col-12">
											    <label for="inputEmail" class="form-label">Password</label>
        <input type="password" class="form-control" id="inputEmail" name="password">
		     
											</div>
												<div class="col-12">
											    <label for="inputEmail" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="inputEmail" name="cpassword">
		     
											</div>
											<div class="col-12">
												<div class="d-grid">
												
													   <button type="submit" class="btn btn-primary px-5" name="register"><i class='bx bx-user'></i>Sign up</button>
												</div>
											</div>
																		 <?php
    // Display error message if authentication failed
    if ($error) {
        echo '<p style="color: red;">' . $error . '</p>';
    }
    ?>
										</form>
							
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
		<footer class="bg-white shadow-sm border-top p-2 text-center fixed-bottom">
				<p class="mb-0">CampusConnect © 2023. All right reserved.</p>
		</footer>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<!--Password show & hide js -->
	<script>
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});
		});
	</script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>
</body>


<!-- Mirrored from codervent.com/synadmin/demo/vertical/authentication-signup-with-header-footer.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Aug 2023 12:59:27 GMT -->
</html>