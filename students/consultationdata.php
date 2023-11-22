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

$todayConsultationStatus = fetchData("SELECT
    COUNT(CASE WHEN status = 'completed' THEN 1 END) AS today_completed,
    COUNT(CASE WHEN status = 'pending' THEN 1 END) AS today_pending,
    COUNT(CASE WHEN status = 'rejected' THEN 1 END) AS today_rejected
FROM consultation
INNER JOIN ins_consult ON consultation.ins_c_id = ins_consult.ins_c_id
WHERE DATE(ins_consult.date) = CURDATE() AND stud_id = '$student_id';", $con);

// Fetch data for this week
$weekConsultationStatus = fetchData("SELECT
    COUNT(CASE WHEN status = 'completed' THEN 1 END) AS week_completed,
    COUNT(CASE WHEN status = 'pending' THEN 1 END) AS week_pending,
    COUNT(CASE WHEN status = 'rejected' THEN 1 END) AS week_rejected
FROM consultation
INNER JOIN ins_consult ON consultation.ins_c_id = ins_consult.ins_c_id
WHERE WEEK(ins_consult.date) = WEEK(NOW()) AND stud_id = '$student_id';", $con);

// Fetch data for this month
$monthConsultationStatus = fetchData("SELECT
    COUNT(CASE WHEN status = 'completed' THEN 1 END) AS month_completed,
    COUNT(CASE WHEN status = 'pending' THEN 1 END) AS month_pending,
    COUNT(CASE WHEN status = 'rejected' THEN 1 END) AS month_rejected
FROM consultation
INNER JOIN ins_consult ON consultation.ins_c_id = ins_consult.ins_c_id
WHERE MONTH(ins_consult.date) = MONTH(NOW()) AND stud_id = '$student_id';", $con);

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