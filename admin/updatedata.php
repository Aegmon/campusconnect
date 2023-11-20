<?php
include('../connection.php');
// Assuming the selected time range is passed as a parameter (e.g., $_GET['time_range'])
// You may need to adjust this based on your actual implementation

$timeRange = isset($_GET['time_range']) ? $_GET['time_range'] : 'all';

// Function to get the appropriate date column for each type (post, reply, like)
function getDateColumn($type) {
    switch ($type) {
        case 'post':
            return 'post_date';
        case 'reply':
            return 'reply_date';
        case 'like':
            return 'post_date'; // Adjust this if likes have a different date column
        default:
            return '';
    }
}

// Function to get the appropriate date range condition based on the selected time range
function getDateRangeCondition($type, $timeRange) {
    $dateColumn = getDateColumn($type);
    switch ($timeRange) {
        case 'day':
            return " AND DATE($dateColumn) = CURDATE()";
        case 'week':
            return " AND YEARWEEK($dateColumn, 1) = YEARWEEK(NOW(), 1)";
        case 'month':
            return " AND MONTH($dateColumn) = MONTH(NOW()) AND YEAR($dateColumn) = YEAR(NOW())";
        default:
            return "";
    }
}

// Modify your queries to include the date range condition
$query_total_post_replies = "SELECT COUNT(*) as total_post_replies FROM post_replies WHERE 1" . getDateRangeCondition('reply', $timeRange);
$ses_sql_total_post_replies = mysqli_query($con, $query_total_post_replies);
$total_post_replies = mysqli_fetch_assoc($ses_sql_total_post_replies)['total_post_replies'];

$query_total_likes = "SELECT SUM(likes) as total_likes FROM posts WHERE 1" . getDateRangeCondition('like', $timeRange);
$ses_sql_total_likes = mysqli_query($con, $query_total_likes);
$total_likes = mysqli_fetch_assoc($ses_sql_total_likes)['total_likes'];

$query_total_posts = "SELECT COUNT(*) as total_posts FROM posts WHERE 1" . getDateRangeCondition('post', $timeRange);
$ses_sql_total_posts = mysqli_query($con, $query_total_posts);
$total_posts = mysqli_fetch_assoc($ses_sql_total_posts)['total_posts'];

?>