<?php
include("sidebar.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    // Get the message from the form
    $message = $_POST['message'];

    // Get the IDs of the sender and receiver (you may need to change this based on your application)
    $senderId = 1; // Assuming the sender's ID is 1, you should replace it with the actual sender's ID
   $receiverId = isset($_POST['receiverId']) ? $_POST['receiverId'] : 0;
    // Create the SQL query to insert the message into the database
    $insertQuery = "INSERT INTO messages (sender_id, receiver_id, message_text, timestamp) 
                    VALUES ('$senderId', '$receiverId', '$message', NOW())";

    // Execute the query and check if it was successful
    if ($con->query($insertQuery) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $insertQuery . "<br>" . $con->error;
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
							<div class="input-group input-group-sm"> <span class="input-group-text bg-transparent"><i class='bx bx-search'></i></span>
								<input type="text" class="form-control" placeholder="People, groups, & messages"> <span class="input-group-text bg-transparent"><i class='bx bx-dialpad'></i></span>
							</div>
					
						</div>
						<div class="chat-sidebar-content">
							<div class="tab-content" id="pills-tabContent">
								<div class="tab-pane fade show active" id="pills-Chats">
									<div class="p-3">
										<div class="meeting-button d-flex justify-content-between">
											<div class="dropdown"> <a href="#" class="btn btn-white btn-sm radius-30 dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown"><i class='bx bx-video me-2'></i>Meet Now<i class='bx bxs-chevron-down ms-2'></i></a>
												<div class="dropdown-menu"> <a class="dropdown-item" href="#">Host a meeting</a>
													<a class="dropdown-item" href="#">Join a meeting</a>
												</div>
											</div>
										
										</div>
										
									</div>
									<div class="chat-list">
								<?php

$currentUserId = 1;
// Your SQL query
$query = "SELECT u.userID, u.email, u.lastlogin, u.usertype, s.fname, s.lname
          FROM userdata u
          LEFT JOIN student s ON u.userID = s.user_id
          WHERE u.usertype = 'student'

          UNION

          SELECT u.userID, u.email, u.lastlogin, u.usertype, f.first_name, f.last_name
          FROM userdata u
          LEFT JOIN faculty_info f ON u.userID = f.userID
          WHERE u.usertype = 'faculty';";

// Execute the query and store the result in $result
// Assuming you are using mysqli
$result = $con->query($query);

// Set the initial value of $activeUserId
$activeUserId = 0;

// Your code to get the most recent chat user ID
$queryRecentChat = "SELECT sender_id, receiver_id FROM messages ORDER BY timestamp DESC LIMIT 1";
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
        echo '<h6 class="mb-0 chat-title">' . $row['fname'] . ' ' . $row['lname'] . '</h6>'; // Assuming fname and lname are the fields for first name and last name
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
						<div class="chat-content-leftside">
							<div class="d-flex">
								<img src="assets/images/avatars/admin.png" width="48" height="48" class="rounded-circle" alt="" />
								<div class="flex-grow-1 ms-2">
									<p class="mb-0 chat-time"></p>
									<p class="chat-left-msg"></p>
								</div>
							</div>
						</div>
			
					</div>
					<div class="chat-footer d-flex align-items-center">
    <div class="flex-grow-1 pe-2">
        <form method="post" action="">
            <div class="input-group">
				   <input type="text" name="receiverId" id="receiverIdField" value=""> <!-- Add this line -->
                <span class="input-group-text"><i class='bx bx-smile'></i></span>
                <input type="hidden" class="form-control" name="message" placeholder="Type a message">
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