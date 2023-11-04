
<?php
include("sidebar.php");
?>
        
     <?php

if (isset($_POST['post'])) {
  
    $postTitle = $_POST['postTitle'];
    $postContent = $_POST['postContent'];
    $postFrom = "user";


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
			<div class="row">	
                	<div class="col-9">	
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
                        <button type="submit" name="post" class="btn btn-primary">Post</button>
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

        $result = $con->query("SELECT p.*, 
    CASE 
        WHEN p.post_from = 'admin' THEN 'Administrator'
        ELSE COALESCE(
            NULLIF(CONCAT(s.fname, ' ', NULLIF(s.lname, '')), ' '), 
            NULLIF(CONCAT(f.first_name, ' ', NULLIF(f.last_name, '')), ' '),
            s.fname,
            f.first_name
        )
    END AS name 
FROM posts p 
LEFT JOIN faculty_info f ON p.user_id = f.userID 
LEFT JOIN student s ON p.user_id = s.user_id where p.isapproved = '1'
ORDER BY p.post_date DESC;
");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $postTitle = $row["post_title"];
                $postContent = $row["post_content"];
                $postDate = $row["post_date"];
                $post_id = $row["post_id"];
                $postFrom = $row["post_from"]; 

                echo '<div class="card mb-3">';
                echo '<div class="card-body">';
                // Display the post with a header for the post source
                if ($postFrom === 'user') {
                    echo '<div style="display: flex; align-items: center; margin-bottom: 10px;">
                            <img src="assets/images/avatars/admin.png" class="user-img" alt="user avatar" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px;">
                            <h6 class="text-dark m-0">'.  $row["name"] .':</h6>
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
           	<div class="col-3">	
 <div class="card">
       <div class="card-header"> Available for consultation</div>
            <div class="card-body">
              
<?php
$sql = "SELECT s.fname AS student_first_name, s.lname AS student_last_name, s.image AS student_image
        FROM student s
        JOIN consultation c ON s.user_id = c.user_id_host";

$result = $con->query($sql);

if ($result->num_rows > 0) {
  // Output data of each row
  while ($row = $result->fetch_assoc()) {
    echo '
    <div class="card radius-10">
      <div class="card-body">
        <div class="d-flex align-items-center">
        <a type="button" class="position-relative">   
									
         <img src="' . $row["student_image"] . '" class="rounded-circle p-1 border" width="90" height="90" alt="Student Image"><span class="position-absolute top-0 start-100 translate-middle badge border border-light rounded-circle bg-success p-2"><span class="visually-hidden">unread messages</span></span>
        	</a>
         <div class="flex-grow-1 ms-3">
            <h5 class="mt-0">' . $row["student_first_name"] . ' ' . $row["student_last_name"] . '</h5>
          </div>
        </div>
      </div>
    </div>';
  }
} else {
  echo "0 results";
}

?>


                  </div>
                    </div>
                 </div>
              </div>
                    
</div>

	<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
	<footer class="page-footer">
			<p class="mb-0">Campus Connect © 2023. All right reserved.</p>
		</footer>
</body>



</html>