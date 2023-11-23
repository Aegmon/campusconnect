<?php
include('session.php');

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
	<link href="assets/plugins/highcharts/css/highcharts.css" rel="stylesheet" />
	<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<link href="assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="assets/css/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	   <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="assets/css/dark-theme.css" />
	<link rel="stylesheet" href="assets/css/semi-dark.css" />
	<link rel="stylesheet" href="assets/css/header-colors.css" />
	<title>Campus Connect | Guidance</title>
	<style>
    @keyframes moveIcon {
          0%, 100% {
            transform: translateX(0);
            color: white;
        }
        25%, 75% {
            transform: translateX(-5px);
            color: #00ff00; /* Green color */
        }
        50% {
            transform: translateX(5px);
            color: white;
        }
    }

    .moving-icon {
        animation: moveIcon 0.5s infinite;  /* You can adjust the duration and other properties */
         color: green;
    }

.list-group-item.has-unread-messages {
    font-weight: bold; /* Add your preferred styling for unread messages */
    color: #ff0000; /* Add your preferred color for unread messages */
}
</style>
   <script>
        $(document).ready(function () {
    $(".toggle-icon").click(function () {
        if ($(".wrapper").hasClass("toggled")) {
            // unpin sidebar when hovered
            $(".wrapper").removeClass("toggled");
            $(".sidebar-wrapper").unbind("mouseenter mouseleave");
        } else {
            $(".wrapper").addClass("toggled");
            $(".sidebar-wrapper").on({
                mouseenter: function () {
                    $(".wrapper").addClass("sidebar-hovered");
                },
                mouseleave: function () {
                    $(".wrapper").removeClass("sidebar-hovered");
                }
            });
        }
    });
    	$(".mobile-toggle-menu").on("click", function () {
		$(".wrapper").addClass("toggled");
	});
	$(".chat-toggle-btn").on("click", function () {
		$(".chat-wrapper").toggleClass("chat-toggled");
	});
	$(".chat-toggle-btn-mobile").on("click", function () {
		$(".chat-wrapper").removeClass("chat-toggled");
	});
});

    </script>
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
				</div>
				<div>
					<h4 class="logo-text">Campus Connect</h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-first-page'></i>
				</div>
			</div>
	
			<ul class="metismenu" id="menu">
                 <li class="menu-label">Dashboard</li>
				<li>
					<a href="index.php" >
						<div class="parent-icon"><i class='bx bx-home'></i>
						</div>
						<div class="menu-title">Home</div>
					</a>
				</li>
             <hr>
                	<li>
					<a href="users.php">
						<div class="parent-icon"><i class='bx bx-user' ></i>
						</div>
						<div class="menu-title">Students</div>
					</a>
				</li>
           	<li>
					<a href="insights.php">
						<div class="parent-icon"><i class='bx bx-bar-chart-alt-2' ></i>
						</div>
						<div class="menu-title">Insights</div>
					</a>
				</li>
		
				 
			 <li>
    <a href="chatbox.php">
        <div class="parent-icon"><i class='bx bx-chat'></i></div>
        <div class="menu-title">Chat Box</div>
        <?php
        // Your code to count unread messages for the current user
        $queryUnreadCount = "SELECT COUNT(*) AS unreadCount 
                            FROM messages 
                            WHERE receiver_id = $currentUserId AND isRead = 0";

        $resultUnreadCount = $con->query($queryUnreadCount);

        // Check if the query execution was successful
        if ($resultUnreadCount !== false) {
            $unreadCountData = $resultUnreadCount->fetch_assoc();

            if ($unreadCountData !== null) {
                $unreadCount = $unreadCountData['unreadCount'];

                // Display the count only if there are unread messages
                if ($unreadCount > 0) {
                    echo '<span class="alert-count">' . $unreadCount . '</span>';
                }
            } else {
                // Handle the case when there are no results
                echo '<span class="alert-count">0</span>';
            }
        } else {
            echo "Error in query: " . $con->error;
        }
        ?>
    </a>
</li>

			
			</ul>
	
		</div>
	
			<header>
			<div class="topbar d-flex align-items-center">
				<nav class="navbar navbar-expand">
					<div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
					</div>
			
					<div class="top-menu ms-auto">
						
					</div>
				<div class="user-box dropdown">
						<a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<img src="assets/images/avatars/admin.png" class="user-img" alt="user avatar">
							<div class="user-info ps-3">
								<p class="user-name mb-0 "><?php echo $first_name ." ". $last_name;?></p>
								<p class="designattion mb-0">Guidance Counselor</p>
							</div>
						</a>
						<ul class="dropdown-menu dropdown-menu-end">
						
							<li><a class="dropdown-item" href="#"><i class="bx bx-cog"></i><span>Settings</span></a>
							</li>
							<li><a class="dropdown-item" href="dashboard.php"><i class='bx bx-home-circle'></i><span>Dashboard</span></a>
							</li>
						
							<li>
								<div class="dropdown-divider mb-0"></div>
							</li>
							<li><a class="dropdown-item" href="logout.php"><i class='bx bx-log-out-circle'></i><span>Logout</span></a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</header>