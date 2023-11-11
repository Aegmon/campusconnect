<?php
// Assuming $con is your database connection
include("../connection.php");

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
        echo "success";
    } else {
        echo "Error: " . $insertQuery . "<br>" . $con->error;
    }
}
?>
