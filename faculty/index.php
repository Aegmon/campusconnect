
<?php
ob_start();
include("sidebar.php");

if (isset($_POST['Accept'])) {
    $consult_id = $_POST['consult_id'];
    $stmt = $con->prepare("UPDATE `consultation` SET status ='completed' WHERE consult_id=?");
    $stmt->bind_param("i", $consult_id);

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Redirect to the specified URL
        header("Location: https://getstream.io/video/demos/?id=comfortable-0eae9c40");
        exit(); // Ensure that no further code is executed after the redirect
    } else {
        echo "Error: " . $stmt->error;
    }
}

if (isset($_POST['Reject'])) {
  
    $consult_id = $_POST['consult_id'];
    $stmt = $con->prepare("UPDATE `consultation` SET status ='rejected' WHERE consult_id=?");
    $stmt->bind_param("i", $consult_id);

    // Execute the prepared statement
    if ($stmt->execute()) {
         
 
    } else {
        echo "Error: " . $stmt->error;
    }
}

?>

 <?php


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
    ob_end_flush(); 
?>
       
        
        <!--SIDEBAR -->
		<!--start page wrapper -->
	<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Home</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <!-- <h6 class="mb-0 text-uppercase">DataTable Import</h6> -->
        <hr/>
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
WHERE ic.faculty_id = '$faculty_id' 
ORDER BY FIELD(c.status, 'pending', 'completed', 'rejected'), ic.date DESC";

$result = $con->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {?>
 <a href="#" class="text-dark" data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo $row['consult_id']?>">
           <div class="row">
              <div class="card radius-10 bg-gradient-blues">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<img src="assets/images/avatars/admin.png" class="rounded-circle p-1 border" width="60" height="60" alt="...">
									<div class="flex-grow-1 ms-3">
                                          <div class="row">
                                        <div class="col-9">
										<h5 class="mt-0"><?php echo $row['fname'].' '.$row['lname']?></h5>
                                        
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
                                     		<?php
// Assuming $row['status'] contains the status information

$status = $row['status'];

if ($status == 'completed') {
    echo '<span class="badge bg-success">Completed</span>';
} elseif ($status == 'pending') {
    echo '<span class="badge bg-warning">Pending</span>';
} else {
 echo '<span class="badge bg-danger">Rejected</span>';
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
    <div class="modal fade" id="exampleModal-<?php echo $row['consult_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Schedule a Consultation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
              <input type="hidden" name="consult_id" value="<?php echo $row['consult_id']?>">
                  <h4 class="text-center">	<h5 class="mt-0"><?php echo $row['fname'].' '.$row['lname']?> is requesting for a consultation</h5> </h4>
             
                </div>
                <div class="modal-footer">
                     <button  type="submit" name="Reject" class="btn btn-danger px-5">Reject</button>
                      <!--<a  href="https://getstream.io/video/demos/?id=comfortable-0eae9c40" name="Accept" class="btn btn-primary px-5">Accept</a>-->
                              <button type="submit" name="Accept" class="btn btn-primary px-5">Call Now</a>
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
	<!--app JS-->
	<script src="assets/js/app.js"></script>

</body>


<!-- Mirrored from codervent.com/synadmin/demo/vertical/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Aug 2023 12:56:57 GMT -->
</html>