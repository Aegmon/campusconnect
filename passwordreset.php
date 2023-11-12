<?php
include('connection.php');

$user_id = $_GET['userID'];
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user input
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Perform validation (you can add more validation as needed)
    if (empty($password)) {
        $error = 'Password is required';
    } elseif ($password !== $cpassword) {
        $error = 'Passwords do not match';
    }

    // If there are no validation errors, update the password
    if (empty($error)) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Update the password using prepared statement to prevent SQL injection
        $updateQuery = "UPDATE userdata SET password = ? WHERE userID = ?";
        $updateStatement = mysqli_prepare($con, $updateQuery);
        
        // Bind parameters
        mysqli_stmt_bind_param($updateStatement, "si", $hashedPassword, $user_id);

        // Execute the statement
        $updateResult = mysqli_stmt_execute($updateStatement);

        // Check if the update was successful
        if ($updateResult) {
            $successMessage = 'Password updated successfully';
            header('location: index.php');
        } else {
            $error = 'Error updating password. Please try again later.';
        }

        // Close the statement
        mysqli_stmt_close($updateStatement);
    }
}

// Close the database connection
mysqli_close($con);
?>




<!DOCTYPE html>
<html lang="en">



<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="assets/css/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	<title>Password Reset</title>
</head>

<body>
	<!-- wrapper -->
	<div class="wrapper">
		<div class="authentication-header"></div>
		 <div class="authentication-reset-password d-flex align-items-center justify-content-center">
			<div class="row">
				<div class="col-12 col-lg-10 mx-auto">
					<div class="card">
						<div class="row g-0">
							<div class="col-lg-5 border-end">
								<div class="card-body">
									<div class="p-5">
										<div class="text-start">
											<img src="assets/images/logo-img.png" width="180" alt="">
										</div>
										<h4 class="mt-5 font-weight-bold">Genrate New Password</h4>
										<p class="text-muted">We received your reset password request. Please enter your new password!</p>
										                <form method="POST" action="">
										<div class="mb-3 mt-5">
											<label class="form-label">New Password</label>
											<input type="text" class="form-control" placeholder="Enter new password" name="password" />
										</div>
										<div class="mb-3">
											<label class="form-label">Confirm Password</label>
											<input type="text" class="form-control" placeholder="Confirm password"  name="cpassword"/>
										</div>
										<div class="d-grid gap-2">
											<button type="button" name="reset"class="btn btn-primary">Change Password</button> 
											<a href="index.php" class="btn btn-light"><i class='bx bx-arrow-back mr-1'></i>Back to Login</a>
										</div>
										   </form>
			 		 <?php

                 if ($error) {
                       echo '<p style="color: red;">' . $error . '</p>';
                         }
                                ?>
									</div>
								</div>
							</div>
							<div class="col-lg-7">
								<img src="assets/images/login-images/forgot-password-frent-img.jpg" class="card-img login-img h-100" alt="...">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end wrapper -->
</body>


<!-- Mirrored from codervent.com/synadmin/demo/vertical/authentication-reset-password.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Aug 2023 12:59:27 GMT -->
</html>