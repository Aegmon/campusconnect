<?php
include("sidebar.php");

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
    $query = "SELECT u.userID, u.email, u.lastlogin, u.usertype, f.first_name, f.last_name, s.fname as student_fname, s.lname as student_lname, g.fname as counselor_fname, g.lname as counselor_lname,
              MAX(m.timestamp) as last_message_timestamp,m.isRead
              FROM userdata u
              LEFT JOIN faculty_info f ON u.userID = f.userID
              LEFT JOIN student s ON u.userID = s.user_id
              LEFT JOIN guidancecounselor g ON u.userID = g.userID
              LEFT JOIN messages m ON (u.userID = m.sender_id OR u.userID = m.receiver_id)
              WHERE u.userID != $currentUserId
              AND (f.first_name LIKE '%$searchTerm%' OR f.last_name LIKE '%$searchTerm%' OR s.fname LIKE '%$searchTerm%' OR s.lname LIKE '%$searchTerm%' OR g.fname LIKE '%$searchTerm%' OR g.lname LIKE '%$searchTerm%')
              GROUP BY u.userID
              ORDER BY last_message_timestamp DESC";
} else {
    // If no search term is provided, use the default query
    $query = "SELECT u.userID, u.email, u.lastlogin, u.usertype, f.first_name, f.last_name, s.fname as student_fname, s.lname as student_lname, g.fname as counselor_fname, g.lname as counselor_lname,
              MAX(m.timestamp) as last_message_timestamp,m.isRead
              FROM userdata u
              LEFT JOIN faculty_info f ON u.userID = f.userID
              LEFT JOIN student s ON u.userID = s.user_id
              LEFT JOIN guidancecounselor g ON u.userID = g.userID
              LEFT JOIN messages m ON (u.userID = m.sender_id OR u.userID = m.receiver_id)
              WHERE u.userID != $currentUserId
              GROUP BY u.userID
              ORDER BY last_message_timestamp DESC";
}

// Execute the query and store the result in $result
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

// ... (Previous code remains unchanged)

// Check if the query returns any rows
if ($result->num_rows > 0) {
    // Loop through each row
    while ($row = $result->fetch_assoc()) {
        echo '<div class="list-group list-group-flush">';
        
        // Check if the current user is the one displayed in the chat content
        $isActiveUser = ($row['userID'] == $activeUserId);

        // Your code to get the count of unread messages for the current user
$queryUnreadCount = "SELECT SUM(unreadCount) AS totalUnreadCount
                    FROM (
                        SELECT COUNT(*) AS unreadCount 
                        FROM messages 
                        WHERE (receiver_id = {$row['userID']} AND isRead = 0)
                        
                        UNION ALL
                        
                        SELECT COUNT(*) AS unreadCount 
                        FROM messages 
                        WHERE (sender_id = {$row['userID']} AND isRead = 0)
                    ) AS subquery";


   $resultUnreadCount = $con->query($queryUnreadCount);

// Check if the query execution was successful
if ($resultUnreadCount === false) {
    echo "Error in query: " . $con->error;
} else {
    // Continue fetching and processing the result
    $unreadCountData = $resultUnreadCount->fetch_assoc();

    if ($unreadCountData !== null) {
        $totalUnreadCount = $unreadCountData['totalUnreadCount'];
        $hasUnreadMessages = ($totalUnreadCount > 0);
    } else {
        // Handle the case when there are no results
        $totalUnreadCount = 0;
        $hasUnreadMessages = false;
    }
}



        // Add a CSS class based on whether there are unread messages
        $cssClass = $isActiveUser ? 'list-group-item ' : 'list-group-item';
        $cssClass .= $hasUnreadMessages ? ' ' : ' has-unread-messages';

        echo '<a href="javascript:;" class="' . $cssClass . '" onclick="setReceiverId(' . $row['userID'] . ')">'; // Pass the userID as the receiverId
        echo '<div class="d-flex">';

        echo '<img src="assets/images/avatars/admin.png" width="42" height="42" class="rounded-circle" alt="" />';
    
        echo '<div class="flex-grow-1 ms-2">';
        if ($row['usertype'] == 'faculty') {
            echo '<h6 class="mb-0 chat-title">' . $row['first_name'] . ' ' . $row['last_name'] . '</h6>';
        } elseif ($row['usertype'] == 'student') {
            echo '<h6 class="mb-0 chat-title">' . $row['student_fname'] . ' ' . $row['student_lname'] . '</h6>';
        } elseif ($row['usertype'] == 'guidance') {
            echo '<h6 class="mb-0 chat-title">' . $row['counselor_fname'] . ' ' . $row['counselor_lname'] . ' (Counselor)</h6>';
        }
    echo '<p class="mb-0 chat-msg">' . ($hasUnreadMessages ? 'No new messages' : 'Unread messages') . '</p>';
        echo '</div>';
        echo '<div class="chat-time">' . $row['lastlogin'] . '</div>';
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

    <div class="input-group">
          <div class="input-group-append">
            <label for="fileInput" class="btn btn-secondary">
                <i class="bx bx-paperclip"></i> 
            </label>
            <input type="file" name="uploadedFile" id="fileInput" style="display:none;">
        </div>
        <input type="text" class="form-control" name="message" id="message-input" placeholder="Type a message">
      
        <input type="hidden" name="receiverId" id="receiverIdField" value="">
        <button type="submit" id="send-message-btn" class="btn btn-primary">Send</button>
    </div>



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
                console.log(response);
                $(".chat-content").html(response); // Update the chat content with the fetched messages
                 scrollToLastMessage();
            }
        });
    }

$('#send-message-btn').on('click', function() {
    document.getElementById('receiverIdField').value = receiverId; // Set the value of the input field
    const message = $('#message-input').val(); // Get the message from the input field
    const fileInput = $('#fileInput')[0].files[0]; // Get the selected file

    // Check if the message is not empty
    if (message.trim() !== '') {
        // Check if a file is selected
        if (fileInput) {
          const allowedFileTypes = [
                'application/pdf',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'application/msword', // MIME type for DOC files
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' // MIME type for DOCX files
            ];

            if (allowedFileTypes.indexOf(fileInput.type) === -1) {
                alert('Invalid file type. Please select a PDF, Excel, or PowerPoint file.');
                return;
            }

            // Create a FormData object to send both text and file data
            var formData = new FormData();
            formData.append('receiverId', receiverId);
            formData.append('message', message);
            formData.append('uploadedFile', fileInput);

            // AJAX request to send the message and file
            $.ajax({
                type: 'POST',
                url: 'insert_message.php', // Create a new PHP script for handling the message insertion
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                          console.log(response);
                    $('#message-input').val('');

                    // Fetch and display updated messages
                    fetchAndUpdateMessages(receiverId);
                },
                error: function(error) {
                    console.error('Error sending message:', error);
                }
            });
        } else {
       
            $.ajax({
                type: 'POST',
                url: 'insert_message.php', // Create a new PHP script for handling the message insertion
                data: { receiverId: receiverId, message: message },
                success: function(response) {
                      console.log(response);
                    $('#message-input').val('');

                    // Fetch and display updated messages
                    fetchAndUpdateMessages(receiverId);
                },
                error: function(error) {
                    console.error('Error sending message:', error);
                }
            });
        }
    } else {
        // Handle the case when the message is empty
        alert('Please enter a message.');
    }
});

   // Function to fetch and update messages (reuse this function)
function fetchAndUpdateMessages(receiverId) {
    // AJAX request to fetch and display user messages
    $.ajax({
        type: 'POST',
        url: 'fetch_messages.php', // Replace with the actual URL for fetching messages
        data: { receiverId: receiverId },
        success: function(response) {
            console.log(response);
            $(".chat-content").html(response); // Update the chat content with the fetched messages

            // Scroll to the last message
            scrollToLastMessage();
        }
    });
}
function scrollToLastMessage() {
    var chatContent = $(".chat-content");
    var lastMessage = chatContent.children().last();

    if (lastMessage.length > 0) {
        chatContent.scrollTop(lastMessage.offset().top);
    }
}



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
       

            // Update the chat header
            $(".chat-header h4").text(username);
        });
    });
</script>



</body>


</html>