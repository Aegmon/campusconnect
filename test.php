<?php

include('session.php');
function getCountForTodayByIntervalConsultation($table, $dateField, $userIdField, $currentUserId, $intervalHours,$status)
{
    global $con;
    $today = date("Y-m-d");

    $sql = "SELECT HOUR($dateField) DIV $intervalHours AS interval_slot, COUNT(*) as count 
            FROM $table 
            WHERE DATE($dateField) = '$today' AND $userIdField = $currentUserId AND c_status = '$status'
            GROUP BY interval_slot";

    $result = $con->query($sql);

    $counts = array_fill(0, 24 / $intervalHours, 0); // Initialize counts for each interval

    while ($row = $result->fetch_assoc()) {
        $intervalSlot = $row['interval_slot'];
        $counts[$intervalSlot] = $row['count'];
    }

    return $counts;
}

function getCountPerWeekConsultation($table, $dateField, $userIdField, $currentUserId,$status)
{
    global $con;
    $currentMonth = date("m");

    $sql = "SELECT DAY($dateField) as day, COUNT(*) as count 
            FROM $table 
            WHERE MONTH($dateField) = $currentMonth AND $userIdField = $currentUserId AND c_status = '$status'
            GROUP BY day";

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

function getCountPerMonthConsultation($table, $dateField, $userIdField, $currentUserId,$status)
{
    global $con;
    $sql = "SELECT MONTH($dateField) as month, COUNT(*) as count 
            FROM $table 
            WHERE $userIdField = $currentUserId AND c_status = '$status'
            GROUP BY month";

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

$today = date("Y-m-d");

// Consultations data for today with 6-hour intervals
$consultationsTodayOngoing = getCountForTodayByIntervalConsultation('ins_consult', 'date', 'faculty_id', $faculty_id, 6,'Ongoing');
$consultationsTodayCancelled = getCountForTodayByIntervalConsultation('ins_consult', 'date', 'faculty_id', $faculty_id, 6,'Cancelled');

// Consultations data for week
$weekDataConsultationsOngoing = getCountPerWeekConsultation('ins_consult', 'date', 'faculty_id', $faculty_id ,'Ongoing');
$consultationsWeekOngoing = $weekDataConsultationsOngoing['counts'];
$weekDataConsultationsCancelled = getCountPerWeekConsultation('ins_consult', 'date', 'faculty_id', $faculty_id ,'Cancelled');
$consultationsWeekCancelled = $weekDataConsultationsCancelled['counts'];

$monthDataConsultationsOngoing = getCountPerMonthConsultation('ins_consult', 'date', 'faculty_id', $faculty_id,'Ongoing');
$consultationsMonthOngoing = $monthDataConsultationsOngoing['counts'];
$monthDataConsultationsCancelled = getCountPerMonthConsultation('ins_consult', 'date', 'faculty_id', $faculty_id,'Cancelled');
$consultationsMonthCancelled = $monthDataConsultationsCancelled['counts'];
// Consultations data for month
$consultationsWeekOngoing = array_values($consultationsWeekOngoing);
$consultationsWeekCancelled = array_values($consultationsWeekCancelled);
$consultationsMonthOngoing = array_values($consultationsMonthOngoing);
$consultationsMonthCancelled = array_values($consultationsMonthCancelled);
$weekLabels = $weekDataConsultationsCancelled['labels'];
$monthLabels = $monthDataConsultationsCancelled['labels'];

?>

 <?php echo json_encode($consultationsTodayOngoing); ?>
<?php echo json_encode($monthLabels); ?>,