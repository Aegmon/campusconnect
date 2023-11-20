<?php
include('session.php');
// Check if the receiverId is set and not empty
if (isset($_POST['receiverId']) && !empty($_POST['receiverId'])) {
    $receiverId = $_POST['receiverId'];

    // Your SQL query to fetch messages based on receiverId and currentUserId
    $messagesQuery = "SELECT * FROM messages WHERE (sender_id = '$currentUserId' AND receiver_id = '$receiverId') OR (sender_id = '$receiverId' AND receiver_id = '$currentUserId') ORDER BY timestamp ASC";
    $messagesResult = $con->query($messagesQuery);
    $messagesQueryUpdate = "UPDATE messages set isRead = '1' WHERE (sender_id = '$currentUserId' AND receiver_id = '$receiverId') OR (sender_id = '$receiverId' AND receiver_id = '$currentUserId') ";
    $messagesResultupdate = $con->query($messagesQueryUpdate);
    if (!$messagesResultupdate) {
    echo "Update failed: " . $con->error;
}
    // Check if the query returns any rows
    if ($messagesResult->num_rows > 0) {
        while ($messageRow = $messagesResult->fetch_assoc()) {
            $messageText = $messageRow['message_text'];
            $senderId = $messageRow['sender_id'];
            $filePath = $messageRow['file_path'];

            // Extract filename from the file path
            $fileName = ($filePath) ? basename($filePath) : '';

            // Determine the alignment of the message
            $alignment = ($senderId == $currentUserId) ? 'rightside' : 'leftside';
            $calignment = ($senderId == $currentUserId) ? 'right' : 'left';

            // Display the user avatar based on the senderId
            $avatar = ($senderId == $currentUserId) ? 'avatar-3.png' : 'avatar-4.png';

            // Echo the message with the appropriate alignment and avatar
            echo "<div class='chat-content-$alignment'>";
            echo "<div class='d-flex'>";
     
            echo "<div class='flex-grow-1 ms-2'>";
            
            // Display the message text
            echo "<p class='chat-$calignment-msg'>";

            // Check if there is a message text
            if (!empty($messageText)) {
                echo "$messageText ";
            }

            // Display paper clip icon link if there is a file attached
            if (!empty($filePath)) {
                // Add a shaking animation to the paper clip icon
                echo "<a href='$filePath' download class='shake-animation'><i class='bx bx-paperclip'></i></a>";
            }

            echo "</p>";

            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>No messages found.</p>';
    }
} else {
    echo "Receiver ID not set.";
}

// Close the database connection
$con->close();
?>
