<?php
include('session.php');

// Function to execute a SQL query and fetch the result
function fetchData($query, $con) {
    $result = $con->query($query);

    if ($result) {
        $data = $result->fetch_assoc();
        $result->free_result();
        return $data;
    } else {
        return false;
    }
}

// Fetch data for today
// Fetch data for today for a specific user
$todayLikes = fetchData("SELECT COUNT(*) AS today_likes FROM posts WHERE DATE(post_date) = CURDATE() AND likes = 1 AND user_id = '$currentUserId';", $con);
$todayPosts = fetchData("SELECT COUNT(*) AS today_posts FROM posts WHERE DATE(post_date) = CURDATE() AND user_id = '$currentUserId';", $con);
$todayReplies = fetchData("SELECT COUNT(*) AS today_replies FROM post_replies WHERE DATE(reply_date) = CURDATE() AND user_id = '$currentUserId';", $con);

// Fetch data for this week for a specific user
$weekLikes = fetchData("SELECT COUNT(*) AS week_likes FROM posts WHERE WEEK(post_date) = WEEK(NOW()) AND likes = 1 AND user_id = '$currentUserId';", $con);
$weekPosts = fetchData("SELECT COUNT(*) AS week_posts FROM posts WHERE WEEK(post_date) = WEEK(NOW()) AND user_id = '$user_id';", $con);
$weekReplies = fetchData("SELECT COUNT(*) AS week_replies FROM post_replies WHERE WEEK(reply_date) = WEEK(NOW()) AND user_id = '$currentUserId';", $con);

// Fetch data for this month for a specific user
$monthLikes = fetchData("SELECT COUNT(*) AS month_likes FROM posts WHERE MONTH(post_date) = MONTH(NOW()) AND likes = 1 AND user_id = '$currentUserId';", $con);
$monthPosts = fetchData("SELECT COUNT(*) AS month_posts FROM posts WHERE MONTH(post_date) = MONTH(NOW()) AND user_id = '$currentUserId';", $con);
$monthReplies = fetchData("SELECT COUNT(*) AS month_replies FROM post_replies WHERE MONTH(reply_date) = MONTH(NOW()) AND user_id = '$currentUserId';", $con);


// Prepare data for JSON response
$responseData = [
    'today_likes' => $todayLikes['today_likes'],
    'today_posts' => $todayPosts['today_posts'],
    'today_replies' => $todayReplies['today_replies'],
    'week_likes' => $weekLikes['week_likes'],
    'week_posts' => $weekPosts['week_posts'],
    'week_replies' => $weekReplies['week_replies'],
    'month_likes' => $monthLikes['month_likes'],
    'month_posts' => $monthPosts['month_posts'],
    'month_replies' => $monthReplies['month_replies'],
];

// Output JSON response
header('Content-Type: application/json');
echo json_encode($responseData);

// Close the database conection
$con->close();
?>
