<?php
include('../connection.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postID = $_GET['post_id'];

    // Update the likes count in the database
    $updateQuery = "UPDATE posts SET likes = likes + 1 WHERE post_id = $postID";
    
    if ($con->query($updateQuery) === TRUE) {
        // Fetch the updated likes count
        $selectQuery = "SELECT likes FROM posts WHERE post_id = $postID";
        $result = $con->query($selectQuery);

        if ($result) {
            $row = $result->fetch_assoc();

            // Return the updated likes count as JSON
            echo json_encode(['likes' => $row['likes']]);
        } else {
            // Handle database query error
            echo json_encode(['error' => 'Error fetching likes count']);
        }
    } else {
        // Handle database query error
        echo json_encode(['error' => 'Error updating likes count']);
    }
}
?>
