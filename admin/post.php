
<?php
include("sidebar.php");



?>
 <?php

if (isset($_POST['post'])) {
  
    $postTitle = $_POST['postTitle'];
    $postContent = $_POST['postContent'];
    $postFrom = "admin";


    // Prepare and bind the INSERT statement
    $stmt = $con->prepare("INSERT INTO posts (user_id, post_title, post_content, post_from) VALUES (?, ?, ?, ?)");
   
    $stmt->bind_param("isss", $user_id, $postTitle, $postContent, $postFrom);

    // Execute the prepared statement
 if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}


}
   if (isset($_POST['reply']) ) {
      $replyContent = $_POST['replyContent'];
        $postID = $_POST['postID']; 
   
   $stmt = $con->prepare("INSERT INTO post_replies (post_id, user_id, reply_content, reply_from) VALUES (?, ?, ?, ?)");

        // Assuming the user is an admin
        $replyFrom = 'admin'; 

        $stmt->bind_param("iiss", $postID, $user_id, $replyContent, $replyFrom);

        // Execute the prepared statement
        if ($stmt->execute()) {
            // Return success message or handle the response accordingly
            echo "Reply inserted successfully";
        } else {
            // Return error message or handle the response accordingly
            echo "Error: " . $stmt . "<br>" . $con->error;
        }
    }
?>
       
        
        <!--SIDEBAR -->
		<!--start page wrapper -->
	<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Post</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Post</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <!-- <h6 class="mb-0 text-uppercase">DataTable Import</h6> -->
        <hr/>
        <div class="card">
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="postTitle">Post Title</label>
                        <input type="text" class="form-control" id="postTitle" name="postTitle" required>
                    </div>
                    <div class="form-group">
                        <label for="postContent">Post Content</label>
                        <textarea class="form-control" id="postContent" name="postContent" rows="4" required></textarea>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" name="post" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            </div>
        <?php
        function time_ago($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );

    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

        $result = $con->query("SELECT * FROM posts");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $postTitle = $row["post_title"];
                $postContent = $row["post_content"];
                $postDate = $row["post_date"];
                $post_id = $row["post_id"];
                $postFrom = $row["post_from"]; // Assuming 'admin' or 'user' is stored in the 'post_from' field

                echo '<div class="card mb-3">';
                echo '<div class="card-body">';
                // Display the post with a header for the post source
                if ($postFrom === 'admin') {
                    echo '<div style="display: flex; align-items: center; margin-bottom: 10px;">
                            <img src="assets/images/avatars/admin.png" class="user-img" alt="user avatar" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px;">
                            <h6 class="text-dark m-0">Administrator:</h6>
                        </div>';
                }
                echo '<h5 class="card-title">' . $postTitle . '</h5>';
                echo '<p class="card-text">' . $postContent . '</p>';
                echo '<div class="card-footer text-muted" style="display: flex; justify-content: space-between; align-items: center;">
                        <small>' . time_ago($postDate) . '</small>
                        <button type="button" class="btn btn-primary btn-sm" onclick="toggleReply(this)">Reply</button>
                    </div>';
                echo '<div class="mt-3 p-2"  style="display: none;" id="replyField">
                        <form method="post" action="">
                            <input type="text" class="form-control form-control-sm" id="replyInput" name="replyContent" placeholder="Type your reply here">
                            <input type="hidden" id="postID" name="postID" value="' . $post_id . '">
                            <button type="submit" name="reply" class="btn btn-primary btn-sm mt-2">Reply</button>
                        </form>
                    </div>';

                    $replyResult = $con->query("SELECT * FROM post_replies WHERE post_id = $post_id");
        if ($replyResult->num_rows > 0) {
            echo '<ul class="list-group list-group-flush"  margin-top: 20px;">';
            while ($replyRow = $replyResult->fetch_assoc()) {
                $replyContent = $replyRow["reply_content"];
                $replyDate = $replyRow["reply_date"];
                $replyFrom = $replyRow["reply_from"]; // Assuming 'admin' or 'user' is stored in the 'reply_from' field

                echo '<li class="list-group-item d-flex justify-content-between align-items-center">
                        <div style="display: flex; align-items: center;">
                            <img src="assets/images/avatars/admin.png" class="user-img" alt="user avatar" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px;">
                            <p class="mb-0">' . $replyContent . '</p>
                        </div>
                        <span class="badge bg-secondary rounded-pill">' . time_ago($replyDate) . '</span>
                    </li>';
            }
            echo '</ul>';
        } else {
            echo '<div class="list-group mt-3" ></div>';
        }


                echo '</div>'; // close card-body
                echo '</div>'; // close card
            }
        } else {
            echo "0 results";
        }
        ?>
    </div>
</div>
		<!--end page wrapper -->
		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
	<footer class="page-footer">
			<p class="mb-0">Campus Connect © 2023. All right reserved.</p>
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
	<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
	<script>
		$(document).ready(function() {
			$('#example').DataTable();
		  } );
	</script>
	<script>
		$(document).ready(function() {
			var table = $('#example2').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
		} );
	</script>
    <script>
    function toggleReply(button) {
        var replyField = button.parentNode.nextElementSibling;
        if (replyField.style.display === "none") {
            replyField.style.display = "block";
        } else {
            replyField.style.display = "none";
        }
    }
</script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>

</body>


<!-- Mirrored from codervent.com/synadmin/demo/vertical/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Aug 2023 12:56:57 GMT -->
</html>