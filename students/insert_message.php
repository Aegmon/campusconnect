<?php

include("session.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    $message = $_POST['message'];
    $receiverId = isset($_POST['receiverId']) ? $_POST['receiverId'] : 0;

    // Get the IDs of the sender and receiver (you may need to change this based on your application)
    $senderId = $currentUserId; // Assuming the sender's ID is 1, you should replace it with the actual sender's ID


    // Check if a file is uploaded
    $fileUploaded = !empty($_FILES["uploadedFile"]["name"]);
    
    // Handle file upload if a file is uploaded
    if ($fileUploaded) {
        $targetDir = "../uploads/";
        $targetFile = $targetDir . basename($_FILES["uploadedFile"]["name"]);
        $uploadOk = 1;


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
