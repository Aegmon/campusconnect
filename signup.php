
<?php
include("connection.php");
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    // Handle form submission
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $birthdate = $_POST['birthday'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $section_id = $_POST['section_id'];
    $student_number = $_POST['student_number'];
    $password =  $_POST['password'];
    $cpassword =  $_POST['cpassword'];

    // Check for empty data fields
    if (empty($first_name) || empty($last_name) || empty($birthdate) || empty($gender) || empty($address) || empty($email) || empty($section_id) || empty($student_number) || empty($password) || empty($cpassword)) {
        $error = "Please fill in all the required fields.";
    } else {
        // Check if passwords match
        if ($password !== $cpassword) {
            $error = "Passwords do not match";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Image upload handling
            $image_upload_dir = '../img/'; // Directory where images will be stored
            $image_name = $_FILES['image']['name'];
            $image_tmp_name = $_FILES['image']['tmp_name'];

            // Check if an image was uploaded
            if (!empty($image_name)) {
                $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
                $allowed_extensions = array('jpg', 'jpeg', 'png');

                // Check if the uploaded file has a valid image extension
                if (in_array($image_extension, $allowed_extensions)) {
                    $image_destination = $image_upload_dir . $image_name;

                    // Move the uploaded image to the destination folder
                    if (move_uploaded_file($image_tmp_name, $image_destination)) {
                        // Insert data into 'userdata' table
                        $insert_userdata_query = "INSERT INTO userdata (email, password, usertype) VALUES (?, ?, ?)";
                        $usertype = 'student'; // assuming the usertype is hardcoded as 'student'
                        $stmt = $con->prepare($insert_userdata_query);
                        $stmt->bind_param("sss", $email, $hashed_password, $usertype);
                        $stmt->execute();

                        $userID = $stmt->insert_id;

                        $insert_student_query = "INSERT INTO student (student_number, fname, lname, birthdate, gender, address, image, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $con->prepare($insert_student_query);
                        $stmt->bind_param("sssssssi", $student_number, $first_name, $last_name, $birthdate, $gender, $address, $image_destination, $userID);
                        $stmt->execute();
                        $student_id = $stmt->insert_id;

                        $insert_section_student_query = "INSERT INTO section_student (stud_id, section_id) VALUES (?, ?)";
                        $stmt = $con->prepare($insert_section_student_query);
                        $stmt->bind_param("ii", $student_id, $section_id);
                        $stmt->execute();
                    } else {
                        $error = "Failed to move the uploaded image.";
                    }
                } else {
                    $error = "Invalid image file format. Allowed formats: jpg, jpeg, png.";
                }
            } else {
                $insert_userdata_query = "INSERT INTO userdata (email, password, usertype) VALUES (?, ?, ?)";
                $usertype = 'student'; // assuming the usertype is hardcoded as 'student'
                $stmt = $con->prepare($insert_userdata_query);
                $stmt->bind_param("sss", $email, $hashed_password, $usertype);
                $stmt->execute();

                // Get the userID generated for the new user
                $userID = $stmt->insert_id;

                $insert_student_query = "INSERT INTO student (student_number, fname, lname, birthdate, gender, address, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $con->prepare($insert_student_query);
                $stmt->bind_param("ssssssi", $student_number, $first_name, $last_name, $birthdate, $gender, $address, $userID);
                $stmt->execute();
                $student_id = $stmt->insert_id;

                $insert_section_student_query = "INSERT INTO section_student (stud_id, section_id) VALUES (?, ?)";
                $stmt = $con->prepare($insert_section_student_query);
                $stmt->bind_param("ii", $student_id, $section_id);
                $stmt->execute();
            }
        }
    }

    // Close the database connection

}

require 'google-api/vendor/autoload.php';
    // Creating new google client instance
    $client = new Google_Client();
    
    // Enter your Client ID
    $client->setClientId('47067612803-0g6nhm3ti5c8e16e4dk7bk9fl0spb45u.apps.googleusercontent.com');
    // Enter your Client Secrect
    $client->setClientSecret('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');
    // Enter the Redirect URL
    $client->setRedirectUri('http://localhost/campusconnect/signup.php');
    // Adding those scopes which we want to get (email & profile Information)
    $client->addScope("email");
    $client->addScope("profile");
   if (isset($_GET['code'])) {
    session_start();
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (!isset($token["error"])) {
        $client->setAccessToken($token['access_token']);
        // getting profile information
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        $id = mysqli_real_escape_string($con, $google_account_info->id);
        $full_name = mysqli_real_escape_string($con, trim($google_account_info->name));
        $email = mysqli_real_escape_string($con, $google_account_info->email);
        $profile_pic = mysqli_real_escape_string($con, $google_account_info->picture);

        // Check if the email already exists
        $check_email_query = "SELECT COUNT(*) as count FROM userdata WHERE email = ?";
        $check_stmt = $con->prepare($check_email_query);
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] > 0) {
            // Email already exists
            $error = "Email already exists!";
            // Handle the error according to your logic
        } else {
            // Email does not exist, proceed with the insertion
            $insert_userdata_query = "INSERT INTO userdata (email, password, usertype, google_id) VALUES (?, ?, ?, ?)";
            $usertype = 'student'; // assuming the usertype is hardcoded as 'student'
            $stmt = $con->prepare($insert_userdata_query);
            $stmt->bind_param("ssss", $email, $hashed_password, $usertype, $id);
            $stmt->execute();

            // Get the userID generated for the new user
            $userID = $stmt->insert_id;

            // Assuming $con is your database connection
            $insert_student_query = "INSERT INTO student (student_number, fname, lname, birthdate, gender, address, user_id, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $con->prepare($insert_student_query);
            $stmt->bind_param("ssssssis", $student_number, $full_name, $last_name, $birthdate, $gender, $address, $userID, $profile_pic);
            $stmt->execute();
            $student_id = $stmt->insert_id;
            $stud_id =     $student_id;
            header("location:studentregister.php?stud_id=$stud_id&user_id=$userID");
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
									<div class="d-grid">
										<a class="btn my-4 shadow-sm btn-white" href="<?php echo $client->createAuthUrl(); ?>"> <span class="d-flex justify-content-center align-items-center">
                          <img class="me-2" src="assets/images/icons/search.svg" width="16" alt="Image Description">
                          <span>Sign Up with Google</span>
											</span>
										</a> 
									</div>
									<div class="login-separater text-center mb-4"> <span>OR SIGN UP WITH EMAIL</span>
										<hr/>
									</div>
									<div class="form-body">
								   <form class="row g-3" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
											<div class="col-sm-6">
												<label for="inputFirstName" class="form-label">First Name</label>
											    <input type="text" class="form-control" id="inputFirstName" name="first_name">
											</div>
											<div class="col-sm-6">
												<label for="inputLastName" class="form-label">Last Name</label>
										  <input type="text" class="form-control" id="inputLastName" name="last_name">
											</div>
											<div class="col-12">
    <label for="inputEmailAddress" class="form-label">Date of Birth</label>
    <input type="date" class="form-control" id="inputDate" name="birthday">
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
        $sql = "SELECT * FROM section t1
        join strand t2 on t1.strand = t2.strand_id";
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
											       <label for="inputImage" class="form-label">Image (Only .jpg, .jpeg, .png)</label>
        <input type="file" class="form-control" id="inputImage" name="image" accept=".jpg, .jpeg, .png">
											</div>
												<div class="col-12">
											    <label for="inputEmail" class="form-label">Email</label>
        <input type="email" class="form-control" id="inputEmail" name="email">
		   
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
												<div class="form-check form-switch">
													<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" required>
												<a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">I read and agree to Terms & Conditions</a>

<!-- Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Terms & Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
      <div class="modal-body">
<p ><strong>General Terms and Condition</strong></p>
<p style="text-indent: 50px;">These are the Terms and Conditions governing the use of Campus Connect website and the agreement that operates between you and the website. These Terms and Conditions set out the rights and obligations of all users regarding the use of the website. Your access to and use of the website is conditioned on. Your acceptance of and compliance with these Terms and Conditions. These Terms and Conditions apply to all users’ access or use the website. By accessing or using the website you agree to be bound by these Terms and Conditions.</p>
<p style="text-indent: 50px;"> If you disagree with any part of these Terms and Conditions then you may not access the website. Your access to and use of the website is also conditioned on your acceptance of and compliance with the Privacy Policy of the website.</p>
 <p style="text-indent: 50px;"> Our Privacy Policy describes our policies and procedures on the collection, use and disclosure of your personal information when you use the website and tells you about your privacy rights and how the law protects you. Please read our Privacy Policy carefully before using our website.</p>
<p class="mt-5"><strong>User Account</strong></p>

<p style="text-indent: 50px;">When you create an account with Us, You must provide us information that is accurate, complete, and current at all times. Failure to do so constitutes a breach of the Terms, which may result in immediate termination of your account on our service. </p>

<p style="text-indent: 50px;">You are responsible for safeguarding the password that you use to access the Service and for any activities or actions under your password, whether your password is with Our Service or a Third-Party Social Media Service. </p>
<p style="text-indent: 50px;">You agree not to disclose your password to any third party. You must notify us immediately upon becoming aware of any breach of security or unauthorized use of your account. You may not use as a username the name of another person or entity or that is not lawfully available for use, a name or trademark that is subject to any rights of another person or entity other than you without appropriate authorization</p>
<p class="mt-5"><strong>Content </strong></p>
<p style="text-indent: 50px;">Our Service allows you to post content. You are responsible for the Content that you post to the Service, including its legality, reliability, and appropriateness. By posting Content to the Service, You grant us the right and license to use, modify, publicly perform, publicly display, reproduce, and distribute such Content on and through the Service.</p>

      </div>
        </div>
    </div>
</div>
												</div>
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
    <script>
    const inputDate = document.getElementById('inputDate');
    const today = new Date().toISOString().split('T')[0];
    inputDate.setAttribute('max', today);

    inputDate.addEventListener('input', function () {
        if (this.value >= today) {
            this.setCustomValidity('Please select a date before today.');
        } else {
            this.setCustomValidity('');
        }
    });
</script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>
</body>


<!-- Mirrored from codervent.com/synadmin/demo/vertical/authentication-signup-with-header-footer.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Aug 2023 12:59:27 GMT -->
</html>