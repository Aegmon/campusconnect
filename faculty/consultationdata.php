<?php
// ... Other code
include('session.php');

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
$todayConsultationStatus = fetchData("SELECT
    COUNT(CASE WHEN c_status = 'Ongoing' THEN 1 END) AS today_ongoing,
    COUNT(CASE WHEN c_status = 'Cancelled' THEN 1 END) AS today_cancelled
FROM ins_consult
WHERE DATE(date) = CURDATE() AND faculty_id = '$faculty_id';", $con);

// Fetch data for this week
$weekConsultationStatus = fetchData("SELECT
    COUNT(CASE WHEN c_status = 'Ongoing' THEN 1 END) AS week_ongoing,
    COUNT(CASE WHEN c_status = 'Cancelled' THEN 1 END) AS week_cancelled
FROM ins_consult
WHERE WEEK(date) = WEEK(NOW()) AND faculty_id = '$faculty_id';", $con);

// Fetch data for this month
$monthConsultationStatus = fetchData("SELECT
    COUNT(CASE WHEN c_status = 'Ongoing' THEN 1 END) AS month_ongoing,
    COUNT(CASE WHEN c_status = 'Cancelled' THEN 1 END) AS month_cancelled
FROM ins_consult
WHERE MONTH(date) = MONTH(NOW()) AND faculty_id = '$faculty_id';", $con);

// Prepare data for JSON response
$responseData = [
    'today_consultation_status' => $todayConsultationStatus,
    'week_consultation_status' => $weekConsultationStatus,
    'month_consultation_status' => $monthConsultationStatus,
];

// Output JSON response
header('Content-Type: application/json');
echo json_encode($responseData);

// ... Other code
?>