<?php
include("../connection.php");

	$error = ""; 

    
if (isset($_POST['login'])) {
    session_start();
    
    // Get user input
    $username = $con->real_escape_string($_POST['username']);
    $password = $con->real_escape_string($_POST['password']);
    
    if (empty($username) || empty($password)) {
        $error = "Enter Username and Password.";
    } else {
        $query = "SELECT * FROM admin WHERE username=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            if (password_verify($password, $row['password'])) {
                $_SESSION['login_user'] = $username;
                header("location:dashboard.php");
                exit;
            } else {
                $error = "Invalid Username or Password.";
            }
        } else {
            $error = "Invalid Username or Password.";
        }
        
        $stmt->close();
    }
}

    ?>
<!doctype html>
<html lang="en">
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
		<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-4">
			<div class="container-fluid">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">
						<div class="card mt-5 mt-lg-0">
							<div class="card-body">
								<div class="p-4 rounded">
									<div class="text-center">
										<h3 class="">Welcome Administrator</h3>
										
									</div>
								
								
									</div>
									<div class="form-body">
									    <form class="row g-3" method="POST" action="">
        <div class="col-12">
            <label for="inputEmailAddress" class="form-label">Username</label>
            <input type="text" class="form-control" id="inputEmailAddress" name="username" placeholder="Username" ">
        </div>
        <div class="col-12">
            <label for="inputChoosePassword" class="form-label">Enter Password</label>
            <div class="input-group" id="show_hide_password">
                <input type="password" class="form-control border-end-0" id="inputChoosePassword" name="password" placeholder="Enter Password">
                <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
            </div>
        </div>
        <div class="col-12">
            <div class="d-grid">
                <button type="submit" class="btn btn-primary" name="login"><i class="bx bxs-lock-open"></i>Sign in</button>
            </div>
        </div>
    </form>

    <?php
    // Display error message if authentication failed
    if ($error) {
        echo '<p style="color: red;">' . $error . '</p>';
    }
    ?>
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


<!-- Mirrored from codervent.com/synadmin/demo/vertical/authentication-signin-with-header-footer.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Aug 2023 12:59:27 GMT -->
</html>