<?php
include('session.php');

function getCountForToday($table, $dateField, $userIdField, $currentUserId)
{
    global $con;
    $today = date("Y-m-d");
    $sql = "SELECT COUNT(*) as count FROM $table WHERE DATE($dateField) = '$today' AND $userIdField = $currentUserId";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    return $row['count'];
}

function getCountPerWeek($table, $dateField, $userIdField, $currentUserId)
{
    global $con;
    $currentMonth = date("m");

    $sql = "SELECT DAY($dateField) as day, COUNT(*) as count FROM $table WHERE MONTH($dateField) = $currentMonth AND $userIdField = $currentUserId GROUP BY day";
    $result = $con->query($sql);

    $counts = array();
    $weekLabels = array();

    while ($row = $result->fetch_assoc()) {
        $day = $row['day'];
        $weekNumber = ceil($day / 7);
        $weekLabels[] = "Week " . $weekNumber;
        $counts[$weekNumber] = $row['count'];
    }

    // Fill in missing weeks with zero counts
    for ($i = 1; $i <= 4; $i++) {
        if (!isset($counts[$i])) {
            $weekLabels[] = "Week " . $i;
            $counts[$i] = 0;
        }
    }

    // Sort the labels to ensure correct order
    sort($weekLabels);

    return array("labels" => $weekLabels, "counts" => $counts);
}

function getCountPerMonth($table, $dateField, $userIdField, $currentUserId)
{
    global $con;
    $sql = "SELECT MONTH($dateField) as month, COUNT(*) as count FROM $table WHERE $userIdField = $currentUserId GROUP BY month";
    $result = $con->query($sql);

    $counts = array();
    $monthLabels = array();

    for ($i = 1; $i <= 12; $i++) {
        $monthName = date("M", mktime(0, 0, 0, $i, 10));
        $monthLabels[] = $monthName;
        $counts[$monthName] = 0;
    }

    while ($row = $result->fetch_assoc()) {
        $monthNumber = $row['month'];
        $monthName = date("M", mktime(0, 0, 0, $monthNumber, 10));

        $monthLabels[] = $monthName;
        $counts[$monthName] += $row['count'];
    }

    // Remove duplicate labels
    $monthLabels = array_unique($monthLabels);

    return array("labels" => $monthLabels, "counts" => $counts);
}

function getCountWithUserJoin($table, $dateField, $userIdField, $currentUserId)
{
    global $con;
    $sql = "SELECT COUNT(*) as count FROM $table 
            INNER JOIN posts ON posts.post_id = post_replies.post_id 
            WHERE $dateField = '$today' AND $userIdField = $currentUserId";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    return $row['count'];
}

$today = date("M d, Y");

// Likes data for today
// Likes data for today
$likesToday = getCountForToday('posts', 'post_date', 'user_id', $currentUserId);


// Likes data for week
$weekDataLikes = getCountPerWeek('posts', 'post_date', 'user_id', $currentUserId);
$likesWeek = $weekDataLikes['counts'];
$weekLabels = $weekDataLikes['labels'];

// Likes data for month
$monthDataLikes = getCountPerMonth('posts', 'post_date', 'user_id', $currentUserId);
$likesMonth = $monthDataLikes['counts'];
$monthLabels = $monthDataLikes['labels'];

// Replies data for today
$replyToday = getCountForToday('post_replies', 'reply_date', 'user_id', $currentUserId);


// Replies data for week
$weekDataReplies = getCountPerWeek('post_replies', 'reply_date', 'user_id', $currentUserId);
$replyWeek = $weekDataReplies['counts'];

// Replies data for month
$monthDataReplies = getCountPerMonth('post_replies', 'reply_date', 'user_id', $currentUserId);
$replyMonth = $monthDataReplies['counts'];

// Posts data for today
$postToday = getCountForToday('posts', 'post_date', 'user_id', $currentUserId);

// Posts data for week
$weekDataPosts = getCountPerWeek('posts', 'post_date', 'user_id', $currentUserId);
$postWeek = $weekDataPosts['counts'];

// Posts data for month
$monthDataPosts = getCountPerMonth('posts', 'post_date', 'user_id', $currentUserId);
$postMonth = $monthDataPosts['counts'];
// Now you have the data for likes, replies, and posts for today, week, and month, along with dynamically generated labels.
$intervalLabelsToday = [];

// Labels for every 6 hours
for ($i = 0; $i < 24; $i += 6) {
    $startHour = sprintf("%02d:00", $i);
    $endHour = sprintf("%02d:59", $i + 5);
    $intervalLabelsToday[] = "$startHour - $endHour";
}

?>

