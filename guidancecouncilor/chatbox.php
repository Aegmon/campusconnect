<?php
include("sidebar.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    // Get the message from the form
    $message = $_POST['message'];

    // Get the IDs of the sender and receiver (you may need to change this based on your application)
    $senderId = $currentUserId; // Assuming the sender's ID is 1, you should replace it with the actual sender's ID
    $receiverId = isset($_POST['receiverId']) ? $_POST['receiverId'] : 0;

    // Check if a file is uploaded
    $fileUploaded = !empty($_FILES["uploadedFile"]["name"]);
    
    // Handle file upload if a file is uploaded
    if ($fileUploaded) {
        $targetDir = "../uploads/";
        $targetFile = $targetDir . basename($_FILES["uploadedFile"]["name"]);
        $uploadOk = 1;

        // Check if file already exists
        if (file_exists($targetFile)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size (adjust the limit as needed)
        if ($_FILES["uploadedFile"]["size"] > 5000000) { // Increased to 5 MB
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowedFormats = array("pdf", "doc", "docx", "xls", "xlsx", "ppt", "pptx");
        $fileFormat = pathinfo($targetFile, PATHINFO_EXTENSION);
        if (!in_array(strtolower($fileFormat), $allowedFormats)) {
            echo "Sorry, only PDF, DOC, DOCX, XLS, XLSX, PPT, and PPTX files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // If everything is ok, try to upload file and insert message into the database
            if (move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], $targetFile)) {
                // Create the SQL query to insert the message and file info into the database
                $insertQuery = "INSERT INTO messages (sender_id, receiver_id, message_text, file_path, timestamp) 
                                VALUES ('$senderId', '$receiverId', '$message', '$targetFile', NOW())";

                // Execute the query and check if it was successful
                if ($con->query($insertQuery) === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $insertQuery . "<br>" . $con->error;
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // If no file is uploaded, insert only the message into the database
        $insertQuery = "INSERT INTO messages (sender_id, receiver_id, message_text, timestamp) 
                        VALUES ('$senderId', '$receiverId', '$message', NOW())";

        // Execute the query and check if it was successful
        if ($con->query($insertQuery) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $insertQuery . "<br>" . $con->error;
        }
    }
}
?>



        
		<div class="page-wrapper">
			<div class="page-content">
				<div class="chat-wrapper">
					<div class="chat-sidebar">
						<div class="chat-sidebar-header">
							<div class="d-flex align-items-center">
								<div class="chat-user-online">
									<img src="assets/images/avatars/admin.png" width="45" height="45" class="rounded-circle" alt="" />
								</div>
								<div class="flex-grow-1 ms-2">
									<p class="mb-0"><?php echo $first_name ." ". $last_name;?></p>
								</div>
							
							</div>
							<div class="mb-3"></div>
				<form method="GET" action="" id="searchForm">
    <div class="input-group input-group-sm mb-3">
        <span class="input-group-text bg-transparent"><i class='bx bx-search'></i></span>
        <input type="text" class="form-control" name="search" id="searchInput" placeholder="Search names">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>
					
						</div>
						<div class="chat-sidebar-content">
							<div class="tab-content" id="pills-tabContent">
								<div class="tab-pane fade show active" id="pills-Chats">
									<div class="p-3">
								
									
										
									</div>
								<div class="chat-list">
<?php
// Your SQL query
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    // Get the search term from the form
    $searchTerm = $_GET['search'];

    // Perform the search and update the query
    $query = "SELECT u.userID, u.email, u.lastlogin, u.usertype, f.first_name, f.last_name, s.fname as student_fname, s.lname as student_lname, g.fname as counselor_fname, g.lname as counselor_lname
              FROM userdata u
              LEFT JOIN faculty_info f ON u.userID = f.userID
              LEFT JOIN student s ON u.userID = s.user_id
              LEFT JOIN guidancecounselor g ON u.userID = g.userID
              WHERE u.userID != $currentUserId
              AND (f.first_name LIKE '%$searchTerm%' OR f.last_name LIKE '%$searchTerm%' OR s.fname LIKE '%$searchTerm%' OR s.lname LIKE '%$searchTerm%' OR g.fname LIKE '%$searchTerm%' OR g.lname LIKE '%$searchTerm%')";
} else {
    // If no search term is provided, use the default query
    $query = "SELECT u.userID, u.email, u.lastlogin, u.usertype, f.first_name, f.last_name, s.fname as student_fname, s.lname as student_lname, g.fname as counselor_fname, g.lname as counselor_lname
              FROM userdata u
              LEFT JOIN faculty_info f ON u.userID = f.userID
              LEFT JOIN student s ON u.userID = s.user_id
              LEFT JOIN guidancecounselor g ON u.userID = g.userID
              WHERE u.userID != $currentUserId";
}

// Execute the query and store the result in $result
$result = $con->query($query);

// Set the initial value of $activeUserId
$activeUserId = 0;

// Your code to get the most recent chat user ID
$queryRecentChat = "SELECT * FROM messages ORDER BY timestamp DESC LIMIT 1";
$resultRecentChat = $con->query($queryRecentChat);

// Check if the query returns any rows
if ($resultRecentChat->num_rows > 0) {
    // Fetch the data from the most recent chat
    $recentChatData = $resultRecentChat->fetch_assoc();

    // Determine the active user based on the most recent chat
    $activeUserId = ($recentChatData['sender_id'] == $currentUserId) ? $recentChatData['receiver_id'] : $recentChatData['sender_id'];
}

// Check if the query returns any rows
if ($result->num_rows > 0) {
    // Loop through each row
    while ($row = $result->fetch_assoc()) {
        echo '<div class="list-group list-group-flush">';
        // Check if the current user is the one displayed in the chat content
        if ($row['userID'] == $activeUserId) {
            echo '<a href="javascript:;" class="list-group-item " onclick="setReceiverId(' . $row['userID'] . ')">'; // Pass the userID as the receiverId
        } else {
            echo '<a href="javascript:;" class="list-group-item" onclick="setReceiverId(' . $row['userID'] . ')">'; // Pass the userID as the receiverId
        }
        echo '<div class="d-flex">';
        echo '<div class="chat-user-online">';
        echo '<img src="assets/images/avatars/admin.png" width="42" height="42" class="rounded-circle" alt="" />';
        echo '</div>';
        echo '<div class="flex-grow-1 ms-2">';
        if ($row['usertype'] == 'faculty') {
            echo '<h6 class="mb-0 chat-title">' . $row['first_name'] . ' ' . $row['last_name'] . '</h6>';
        } elseif ($row['usertype'] == 'student') {
            echo '<h6 class="mb-0 chat-title">' . $row['student_fname'] . ' ' . $row['student_lname'] . '</h6>';
        } elseif ($row['usertype'] == 'guidance') {
            echo '<h6 class="mb-0 chat-title">' . $row['counselor_fname'] . ' ' . $row['counselor_lname'] . ' (Counselor)</h6>';
        }
        echo '<p class="mb-0 chat-msg">message</p>'; // Replace 'message' with the actual message
        echo '</div>';
        echo '<div class="chat-time">' . $row['lastlogin'] . '</div>'; // Assuming lastlogin is the field for the timestamp
        echo '</div>';
        echo '</a>';
        echo '</div>';
    }
} else {
    echo "No results found";
}
?>
</div>

								</div>
							</div>
						</div>
					</div>
					<div class="chat-header d-flex align-items-center">
						<div class="chat-toggle-btn"><i class='bx bx-menu-alt-left'></i>
						</div>
						<div>
							<h4 class="mb-1 font-weight-bold"></h4>
						
						</div>
					
					</div>
					<div class="chat-content">
				
			
					</div>
					<div class="chat-footer d-flex align-items-center">
    <div class="flex-grow-1 pe-2">
 <form method="post" action="" id="chatForm" enctype="multipart/form-data">
    <div class="input-group">
          <div class="input-group-append">
            <label for="fileInput" class="btn btn-secondary">
                <i class="bx bx-paperclip"></i> 
            </label>
            <input type="file" name="uploadedFile" id="fileInput" style="display:none;">
        </div>
        <input type="text" class="form-control" name="message" id="messageInput" placeholder="Type a message">
      
        <input type="hidden" name="receiverId" id="receiverIdField" value="">
        <button type="submit" class="btn btn-primary">Send</button>
    </div>
</form>


    </div>
</div>

					<!--start chat overlay-->
					<div class="overlay chat-toggle-btn-mobile"></div>
					<!--end chat overlay-->
				</div>
			</div>
		</div>
		<!--end page wrapper -->
		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
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
	<script>
		new PerfectScrollbar('.chat-list');
		new PerfectScrollbar('.chat-content');
	</script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
	    var receiverId = 0; // Initialize receiverId

    function setReceiverId(id) {
        receiverId = id; // Set the receiverId to the ID of the clicked user
        document.getElementById('receiverIdField').value = receiverId; // Set the value of the input field

        // Make an AJAX call to fetch and display messages
        $.ajax({
            type: 'POST',
            url: 'fetch_messages.php', // Replace with the actual URL for fetching messages
            data: { receiverId: receiverId },
            success: function(response) {
                $(".chat-content").html(response); // Update the chat content with the fetched messages
            }
        });
    }
  function fetchMessagesContinuously() {
        setInterval(function() {
            if (receiverId !== 0) {
                setReceiverId(receiverId);
            }
        }, 5000); // Adjust the interval as necessary (in milliseconds)
    }

    // Call the function to fetch messages continuously
    fetchMessagesContinuously();
    $(document).ready(function() {
        // Default content for chat content
        var defaultUsername = "";
        var defaultMessage = "";
        var defaultTimestamp = "";

        // Set the default chat content as empty
        $(".chat-content").html('');

        // Set the default chat header
        $(".chat-header h4").text("");

        // Handle the click event for the list items
         $(".list-group-item").click(function() {
            var username = $(this).find(".chat-title").text();
            var message = $(this).find(".chat-msg").text();
            var timestamp = $(this).find(".chat-time").text();

            // Update the chat content
            $(".chat-content").html(`
                <div class="chat-content-leftside">
                    <div class="d-flex">
                        <img src="assets/images/avatars/admin.png" width="48" height="48" class="rounded-circle" alt="" />
                        <div class="flex-grow-1 ms-2">
                            <p class="mb-0 chat-time">${username}, ${timestamp}</p>
                            <p class="chat-left-msg">${message}</p>
                        </div>
                    </div>
                </div>
            `);

            // Update the chat header
            $(".chat-header h4").text(username);
        });
    });
</script>



</body>


</html>