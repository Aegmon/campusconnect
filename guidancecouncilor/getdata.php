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

// Count the number of posts where isapproved = 0 for all guidance counselors (daily)
$unapprovedDailyCount = fetchData("SELECT COUNT(*) AS unapproved_daily_count FROM posts WHERE isapproved = 0 AND DATE(post_date) = CURDATE();", $con);

// Count the number of posts where isapproved = 1 for all guidance counselors (daily)
$approvedDailyCount = fetchData("SELECT COUNT(*) AS approved_daily_count FROM posts WHERE isapproved = 1 AND DATE(post_date) = CURDATE();", $con);

// Count the number of posts where isapproved = 0 for all guidance counselors (weekly)
$unapprovedWeeklyCount = fetchData("SELECT COUNT(*) AS unapproved_weekly_count FROM posts WHERE isapproved = 0 AND WEEK(post_date) = WEEK(NOW());", $con);

// Count the number of posts where isapproved = 1 for all guidance counselors (weekly)
$approvedWeeklyCount = fetchData("SELECT COUNT(*) AS approved_weekly_count FROM posts WHERE isapproved = 1 AND WEEK(post_date) = WEEK(NOW());", $con);

// Count the number of posts where isapproved = 0 for all guidance counselors (monthly)
$unapprovedMonthlyCount = fetchData("SELECT COUNT(*) AS unapproved_monthly_count FROM posts WHERE isapproved = 0 AND MONTH(post_date) = MONTH(NOW());", $con);

// Count the number of posts where isapproved = 1 for all guidance counselors (monthly)
$approvedMonthlyCount = fetchData("SELECT COUNT(*) AS approved_monthly_count FROM posts WHERE isapproved = 1 AND MONTH(post_date) = MONTH(NOW());", $con);

// Prepare data for JSON response
$responseData = [
    'unapproved_daily_count' => $unapprovedDailyCount['unapproved_daily_count'],
    'approved_daily_count' => $approvedDailyCount['approved_daily_count'],
    'unapproved_weekly_count' => $unapprovedWeeklyCount['unapproved_weekly_count'],
    'approved_weekly_count' => $approvedWeeklyCount['approved_weekly_count'],
    'unapproved_monthly_count' => $unapprovedMonthlyCount['unapproved_monthly_count'],
    'approved_monthly_count' => $approvedMonthlyCount['approved_monthly_count'],
];

// Output JSON response
header('Content-Type: application/json');
echo json_encode($responseData);

// Close the database connection
$con->close();
?>
