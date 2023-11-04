<?php
include('../connection.php');

$currentUserId = 1; // Replace this with the appropriate current user ID

// Check if the receiverId is set and not empty
if (isset($_POST['receiverId']) && !empty($_POST['receiverId'])) {
    $receiverId = $_POST['receiverId'];

    // Your SQL query to fetch messages based on receiverId and currentUserId
    $messagesQuery = "SELECT * FROM messages WHERE (sender_id = '$currentUserId' AND receiver_id = '$receiverId') OR (sender_id = '$receiverId' AND receiver_id = '$currentUserId') ORDER BY timestamp ASC";
    $messagesResult = $con->query($messagesQuery);

    // Check if the query returns any rows
    if ($messagesResult->num_rows > 0) {
        while ($messageRow = $messagesResult->fetch_assoc()) {
            $messageText = $messageRow['message_text'];
            $senderId = $messageRow['sender_id'];

            // Determine the alignment of the message
            $alignment = ($senderId == $currentUserId) ? 'rightside' : 'leftside';

            // Echo the message with the appropriate alignment
            echo "<div class='chat-content-$alignment'>";
            echo "<p>$messageText</p>"; // Display the message text
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
