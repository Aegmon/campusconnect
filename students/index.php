
<?php
include("sidebar.php");
?>
        
     <?php
if (isset($_POST['consult'])) {
  
    $ins_c_id = $_POST['ins_c_id'];
    $stmt = $con->prepare("INSERT INTO consultation (stud_id, ins_c_id) VALUES (?, ?)");
   
    $stmt->bind_param("ii", $student_id, $ins_c_id);

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post'])) {
    // Retrieve form data
    $postTitle = $_POST['postTitle'];
    $postContent = $_POST['postContent'];
    $postFrom = "user";

    // Check if a file is uploaded
    $fileUploaded = !empty($_FILES["uploadedFile"]["name"]);

    // File upload handling
    if ($fileUploaded) {
        $targetDir = "../uploads/";
        $targetFile = $targetDir . basename($_FILES["uploadedFile"]["name"]);
        $uploadOk = 1;

        // ... (existing code for file checks)

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], $targetFile)) {
                // Prepare and bind the INSERT statement
                $stmt = $con->prepare("INSERT INTO posts (user_id, post_title, post_content, post_from, file_path) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("issss", $user_id, $postTitle, $postContent, $postFrom, $targetFile);

                // Execute the prepared statement
                if ($stmt->execute()) {
                    echo "New record created successfully";
                } else {
                    echo "Error inserting record: " . $stmt->error;
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // If no file is uploaded, insert only the post into the database
        $stmt = $con->prepare("INSERT INTO posts (user_id, post_title, post_content, post_from) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $postTitle, $postContent, $postFrom);

        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error inserting record: " . $stmt->error;
        }
    }

    // Close the prepared statement
    $stmt->close();
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
                 <div class="col-12 col-md-9">
<div class="card">
        <div class="card-body">
         <form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="postTitle">Post Title</label>
        <input type="text" class="form-control" id="postTitle" name="postTitle" required>
    </div>
    <div class="form-group">
        <label for="postContent">Post Content</label>
        <textarea class="form-control" id="postContent" name="postContent" rows="4" required></textarea>
    </div>
    <div class="form-group">
        <label for="uploadedFile">Attachment</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="uploadedFile" name="uploadedFile" >
    
        </div>
    </div>
    <div class="form-group mt-3">
        <button type="submit" name="post" class="btn btn-primary">Post</button>
    </div>
</form>

        </div>
    </div>
     <?php
        function time_ago($datetime, $full = false)
        {
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
LEFT JOIN student s ON p.user_id = s.user_id 
WHERE p.isapproved = '1'
ORDER BY p.post_date DESC;;");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $postTitle = $row["post_title"];
                $postContent = $row["post_content"];
                $postDate = $row["post_date"];
                $post_id = $row["post_id"];
                $postFrom = $row["post_from"];
                $likes = $row["likes"]; // new

                echo '<div class="card mb-3">';
                echo '<div class="card-body">';
                // Display the post with a header for the post source
                echo '<div class="d-flex align-items-center mb-3">
                        <img src="assets/images/avatars/admin.png" class="user-img rounded-circle" alt="user avatar" style="width: 40px; height: 40px;">
                        <div class="ml-3">
                            <h6 class="mb-0">' . $row["name"] . ':</h6>
                            <small class="text-muted">Posted ' . time_ago($postDate) . '</small>
                        </div>
                    </div>';

                echo '<h5 class="card-title">' . $postTitle . '</h5>';
                echo '<p class="card-text">' . $postContent . '</p>';
                if (!empty($row["file_path"])) {
                    $fileName = basename($row["file_path"]);
                    echo '<a href="' . $row["file_path"] . '" class="btn btn-primary btn-sm" download><i class="bx bx-download"></i>  (' . $fileName . ')</a>';
                }

                echo '<div class="d-flex justify-content-between align-items-center mt-3">
                        <button type="button" class="btn btn-primary btn-sm" onclick="toggleReply(this)">Reply</button>
                        <button type="button" class="btn btn-primary btn-sm like-button" data-post-id="' . $post_id . '" onclick="likePost(' . $post_id . ')">
                            <i class="fadeIn animated bx bx-like"></i> Like (' . $likes . ')
                        </button>
                    </div>';

                echo '<div class="mt-3 p-2" style="display: none;" id="replyField">
                        <form method="post" action="">
                            <input type="text" class="form-control form-control-sm" id="replyInput" name="replyContent" placeholder="Type your reply here">
                            <input type="hidden" id="postID" name="postID" value="' . $post_id . '">
                            <button type="submit" name="reply" class="btn btn-primary btn-sm mt-2">Reply</button>
                        </form>
                    </div>';

                $replyResult = $con->query("SELECT * FROM post_replies WHERE post_id = $post_id");

                if ($replyResult->num_rows > 0) {
                    echo '<ul class="list-group list-group-flush mt-3">';
                    while ($replyRow = $replyResult->fetch_assoc()) {
                        $replyContent = $replyRow["reply_content"];
                        $replyDate = $replyRow["reply_date"];
                        $replyFrom = $replyRow["reply_from"]; // Assuming 'admin' or 'user' is stored in the 'reply_from' field

                        echo '<li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="assets/images/avatars/admin.png" class="user-img rounded-circle" alt="user avatar" style="width: 30px; height: 30px;">
                                    <p class="mb-0">' . $replyContent . '</p>
                                </div>
                                <span class="badge bg-secondary rounded-pill">' . time_ago($replyDate) . '</span>
                            </li>';
                    }
                    echo '</ul>';
                } else {
                    echo '<div class="list-group mt-3"></div>';
                }

                echo '</div>'; // close card-body
                echo '</div>'; // close card
            }
        } else {
            echo "0 results";
        }
        ?>
		   </div>
            <div class="col-md-3 col-sm-6">
                         <div class="card ">
							<div class="card-header text-center">
                              	<h5 class="mt-2">Scheduled Consultation</h5>
                                		</div>    
                          </div>
                          
                          
                          
                          <?php

$query = "SELECT * FROM ins_consult ic 
JOIN consultation c ON c.ins_c_id = ic.ins_c_id
JOIN student s ON c.stud_id = s.stud_id 
JOIN faculty_info fi ON ic.faculty_id = fi.faculty_id WHERE s.stud_id = '$student_id' AND c.status='completed' order by ic.date  desc";

$result = $con->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {?>
 <a href="https://getstream.io/video/demos/?id=comfortable-0eae9c40" class="text-dark">
           <div class="row">
              <div class="card radius-10 bg-gradient-reds">
							<div class="card-body">
								<div class="d-flex align-items-center">
<div style="font-size: 2em;">
    <i class='bx bx-phone-call moving-icon'></i>
</div>
									<div class="flex-grow-1 ms-3">
                                          <div class="row">
                                        <div class="col-9">
										<h5 class="mt-0"><?php echo $row['first_name'].' '.$row['last_name']?></h5>
                                        
                                        </div>
                                         <div class="col-3">
                                         
                                            </div>
                                          </div>
										<p class="mb-0"><?php $originalDate = $row['date'];

// Convert the date to the desired format
$formattedDate = date("F j, Y", strtotime($originalDate));

// Output the formatted date
echo $formattedDate;?></p>
                                        <div class="row">
                                        <div class="col-9">
                                       <p class="mb-0"><?php
// Assuming $row['starttime'] and $row['endtime'] contain the times in some format
$startTime = $row['starttime'];
$endTime = $row['endtime'];

// Convert the times to the desired format
$formattedStartTime = date("h:i A", strtotime($startTime));
$formattedEndTime = date("h:i A", strtotime($endTime));

// Concatenate and output the formatted times
echo $formattedStartTime . ' - ' . $formattedEndTime;
?></p>
                                        </div>
                                              <div class="col-3">
                  

                                        </div>
                                        </div>
                                  
									</div>
                                            
							</div>
					</div>
			</div>
        </div>
        </a>
  
<?php }}else{
    Echo "";
}?>
                          
                          
                          
                          
                          
                          
                          
                          
                          
                          
                          
                          
                          
                          
                          
                          
                          
                          
                          
<?php

$query = "SELECT * FROM ins_consult ic 
JOIN faculty_info fi ON ic.faculty_id = fi.faculty_id order by ic.date  desc";

$result = $con->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {?>
 <a href="#" class="text-dark" data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo $row['ins_c_id']?>">
           <div class="row">
              <div class="card radius-10 bg-gradient-blues">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<img src="assets/images/avatars/admin.png" class="rounded-circle p-1 border" width="60" height="60" alt="...">
									<div class="flex-grow-1 ms-3">
                                        
										<h5 class="mt-0"><?php echo $row['first_name'].' '.$row['last_name']?></h5>
										<p class="mb-0"><?php $originalDate = $row['date'];

// Convert the date to the desired format
$formattedDate = date("F j, Y", strtotime($originalDate));

// Output the formatted date
echo $formattedDate;?></p>
                                     <div class="row">
    <div class="col-8">
        <p class="mb-0">
            <?php
            // Assuming $row['starttime'] and $row['endtime'] contain the times in some format
            $startTime = $row['starttime'];
            $endTime = $row['endtime'];

            // Convert the times to the desired format
            $formattedStartTime = date("h:i A", strtotime($startTime));
            $formattedEndTime = date("h:i A", strtotime($endTime));

            // Concatenate and output the formatted times
            echo $formattedStartTime . ' - ' . $formattedEndTime;
            ?>
        </p>
    </div>
    <div class="col-4">
        <?php
        // Assuming $row['status'] contains the status information

        $status = $row['c_status'];

        if ($status == 'Ongoing') {
            echo '<span class="badge bg-success ">Ongoing</span>';
        } elseif ($status == 'Cancelled') {
            echo '<span class="badge bg-danger">Cancelled</span>';
        } else {
            // Additional conditions if needed
        }
        ?>
    </div>
</div>
                                  
									</div>
                                            
							</div>
					</div>
			</div>
        </div>
        </a>
          <form action="" method="post" class="text-center">
     <div class="modal fade" id="exampleModal-<?php echo $row['ins_c_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Schedule a Consultation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
              <input type="hidden" name="ins_c_id" value="<?php echo $row['ins_c_id']?>">
                  <h4 class="text-center">Are you sure you want to schedule a consultation?</h4>
             
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     <button  type="submit" name="consult" class="btn btn-primary px-5">Yes</button>
                </div>
            </div>
        </div>
    </div>
        </form>
<?php }}else{
    Echo "No Consultation";
}?>

    </div>
              </div>
                    
</div>

	<div class="overlay toggle-icon"></div>
	 <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
	
	<footer class="page-footer">
			<p class="mb-0">Campus Connect © 2023. All right reserved.</p>
		</footer>
</body>
<script>
function likePost(postID) {
    const likeButton = document.querySelector('.like-button[data-post-id="' + postID + '"]');

    // Check if the button is already disabled
    if (likeButton.disabled) {
        console.log('Button already disabled for post ID:', postID);
        return;
    }

    console.log('Like button clicked for post ID:', postID);

    fetch('like_post.php?post_id=' + postID, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        console.log('Response from server:', data);

        // Update the likes count in the UI
        likeButton.innerHTML = '<span class="glyphicon glyphicon-heart" aria-hidden="true"></span> Like (' + data.likes + ')';
        
        // Disable the button
        likeButton.disabled = true;
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
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
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>
</html>