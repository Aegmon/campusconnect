<?php


include('connection.php');
// Initialize variables to store error messages
$usernameError = $passwordError = '';
$errorMessage = '';
	if(isset($_POST['send'])){
		ini_set( 'display_errors', 1 );
		error_reporting( E_ALL );
		$from = "campusconnect@gmail.com";
		$to = $_POST['email'];
		$query = "SELECT * from userdata where email='$to'";
		$ses_sql = mysqli_query($con,$query);
		$row = mysqli_fetch_assoc($ses_sql);
        $user_id = $row['userID'];

		$subject = "Forgot Password";
		$message = "
	Click this link to reset your password -https://campusconnect.website/passwordreset.php?userID=$user_id
		";
	   // The content-type header must be set when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers = "From:" . $from;
		if(mail($to,$subject,$message, $headers)) {
			echo '<script>alert("Link was sent to your email")</script>';
		} else {
			echo '<script>alert("Error")</script>';
		}
 
	}
?>
<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from codervent.com/synadmin/demo/vertical/authentication-forgot-password.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Aug 2023 12:59:27 GMT -->
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
	<title>CampusConnect | Forgot Password</title>
</head>

<body>
	<!-- wrapper -->
	<div class="wrapper">
		<div class="authentication-header"></div>
		<div class="authentication-forgot d-flex align-items-center justify-content-center">
			<div class="card forgot-box">
				<div class="card-body">
					<div class="p-4 rounded">
						<div class="text-center">
							<img src="assets/images/icons/lock.png" width="120" alt="" />
						</div>
						      
                         <form method="POST" action="">
						<h4 class="mt-5 font-weight-bold">Forgot Password?</h4>
						<p class="text-muted">Enter your registered email ID to reset the password</p>
						<div class="my-4">
							<label class="form-label">Email id</label>
							<input type="text" class="form-control " name="email" placeholder="example@user.com" />
						</div>
						<div class="d-grid gap-2">
							<button type="submit" name="send" class="btn btn-primary ">Send</button> 
                            <a href="index.php" class="btn btn-white "><i class='bx bx-arrow-back me-1'></i>Back to Login</a>
						</div>
						   </form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end wrapper -->
</body>


<!-- Mirrored from codervent.com/synadmin/demo/vertical/authentication-forgot-password.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Aug 2023 12:59:27 GMT -->
</html>