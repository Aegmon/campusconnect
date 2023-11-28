<?php
include('session.php');

function getCountForTodayByIntervalAndStatus($table, $dateField, $statusField, $userIdField, $currentUserId, $intervalHours)
{
    global $con;
    $today = date("Y-m-d");

    $sql = "SELECT HOUR($dateField) DIV $intervalHours AS interval_slot, 
                   COUNT(*) as count 
            FROM $table 
            INNER JOIN ins_consult ON $table.ins_c_id = ins_consult.ins_c_id
            WHERE DATE(ins_consult.date) = '$today' 
              AND $statusField = 'completed' 
              AND $userIdField = $currentUserId 
            GROUP BY interval_slot";

    $result = $con->query($sql);

    $counts = array_fill(0, 24 / $intervalHours, 0);

    while ($row = $result->fetch_assoc()) {
        $intervalSlot = $row['interval_slot'];
        $counts[$intervalSlot] = $row['count'];
    }

    return $counts;
}

function getCountPerWeekAndStatus($table, $dateField, $statusField, $userIdField, $currentUserId)
{
    global $con;
    $currentMonth = date("m");

    $sql = "SELECT DAY(ins_consult.date) as day, 
                   COUNT(*) as count 
            FROM $table 
            INNER JOIN ins_consult ON $table.ins_c_id = ins_consult.ins_c_id
            WHERE MONTH(ins_consult.date) = $currentMonth 
              AND $statusField = 'completed' 
              AND $userIdField = $currentUserId 
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

    for ($i = 1; $i <= 4; $i++) {
        if (!isset($counts[$i])) {
            $weekLabels[] = "Week " . $i;
            $counts[$i] = 0;
        }
    }

    sort($weekLabels);

    return array("labels" => $weekLabels, "counts" => $counts);
}

function getCountPerMonthAndStatus($table, $dateField, $statusField, $userIdField, $currentUserId)
{
    global $con;
    $sql = "SELECT MONTH(ins_consult.date) as month, 
                   COUNT(*) as count 
            FROM $table 
            INNER JOIN ins_consult ON $table.ins_c_id = ins_consult.ins_c_id
            WHERE $statusField = 'completed' 
              AND $userIdField = $currentUserId 
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

    $monthLabels = array_unique($monthLabels);

    return array("labels" => $monthLabels, "counts" => $counts);
}

function getCountForTodayByIntervalAndStatusPending($table, $dateField, $statusField, $userIdField, $currentUserId, $intervalHours)
{
    global $con;
    $today = date("Y-m-d");

    $sql = "SELECT HOUR($dateField) DIV $intervalHours AS interval_slot, 
                   COUNT(*) as count 
            FROM $table 
            INNER JOIN ins_consult ON $table.ins_c_id = ins_consult.ins_c_id
            WHERE DATE(ins_consult.date) = '$today' 
              AND $statusField = 'pending' 
              AND $userIdField = $currentUserId 
            GROUP BY interval_slot";

    $result = $con->query($sql);

    $counts = array_fill(0, 24 / $intervalHours, 0);

    while ($row = $result->fetch_assoc()) {
        $intervalSlot = $row['interval_slot'];
        $counts[$intervalSlot] = $row['count'];
    }

    return $counts;
}

function getCountPerWeekAndStatusPending($table, $dateField, $statusField, $userIdField, $currentUserId)
{
    global $con;
    $currentMonth = date("m");

    $sql = "SELECT DAY(ins_consult.date) as day, 
                   COUNT(*) as count 
            FROM $table 
            INNER JOIN ins_consult ON $table.ins_c_id = ins_consult.ins_c_id
            WHERE MONTH(ins_consult.date) = $currentMonth 
              AND $statusField = 'pending' 
              AND $userIdField = $currentUserId 
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

    for ($i = 1; $i <= 4; $i++) {
        if (!isset($counts[$i])) {
            $weekLabels[] = "Week " . $i;
            $counts[$i] = 0;
        }
    }

    sort($weekLabels);

    return array("labels" => $weekLabels, "counts" => $counts);
}

function getCountPerMonthAndStatusPending($table, $dateField, $statusField, $userIdField, $currentUserId)
{
    global $con;
    $sql = "SELECT MONTH(ins_consult.date) as month, 
                   COUNT(*) as count 
            FROM $table 
            INNER JOIN ins_consult ON $table.ins_c_id = ins_consult.ins_c_id
            WHERE $statusField = 'pending' 
              AND $userIdField = $currentUserId 
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

    $monthLabels = array_unique($monthLabels);

    return array("labels" => $monthLabels, "counts" => $counts);
}

function getCountForTodayByIntervalAndStatusRejected($table, $dateField, $statusField, $userIdField, $currentUserId, $intervalHours)
{
    global $con;
    $today = date("Y-m-d");

    $sql = "SELECT HOUR($dateField) DIV $intervalHours AS interval_slot, 
                   COUNT(*) as count 
            FROM $table 
            INNER JOIN ins_consult ON $table.ins_c_id = ins_consult.ins_c_id
            WHERE DATE(ins_consult.date) = '$today' 
              AND $statusField = 'rejected' 
              AND $userIdField = $currentUserId 
            GROUP BY interval_slot";

    $result = $con->query($sql);

    $counts = array_fill(0, 24 / $intervalHours, 0);

    while ($row = $result->fetch_assoc()) {
        $intervalSlot = $row['interval_slot'];
        $counts[$intervalSlot] = $row['count'];
    }

    return $counts;
}

function getCountPerWeekAndStatusRejected($table, $dateField, $statusField, $userIdField, $currentUserId)
{
    global $con;
    $currentMonth = date("m");

    $sql = "SELECT DAY(ins_consult.date) as day, 
                   COUNT(*) as count 
            FROM $table 
            INNER JOIN ins_consult ON $table.ins_c_id = ins_consult.ins_c_id
            WHERE MONTH(ins_consult.date) = $currentMonth 
              AND $statusField = 'rejected' 
              AND $userIdField = $currentUserId 
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

    for ($i = 1; $i <= 4; $i++) {
        if (!isset($counts[$i])) {
            $weekLabels[] = "Week " . $i;
            $counts[$i] = 0;
        }
    }

    sort($weekLabels);

    return array("labels" => $weekLabels, "counts" => $counts);
}

function getCountPerMonthAndStatusRejected($table, $dateField, $statusField, $userIdField, $currentUserId)
{
    global $con;
    $sql = "SELECT MONTH(ins_consult.date) as month, 
                   COUNT(*) as count 
            FROM $table 
            INNER JOIN ins_consult ON $table.ins_c_id = ins_consult.ins_c_id
            WHERE $statusField = 'rejected' 
              AND $userIdField = $currentUserId 
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

    $monthLabels = array_unique($monthLabels);

    return array("labels" => $monthLabels, "counts" => $counts);
}

function getCountWithUserJoinConsultation($table, $dateField, $userIdField, $currentUserId)
{
    global $con;
    $today = date("Y-m-d");
    $sql = "SELECT COUNT(*) as count FROM $table 
            INNER JOIN ins_consult ON $table.ins_c_id = ins_consult.ins_c_id
            WHERE $dateField = '$today' AND $userIdField = $currentUserId";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    return $row['count'];
}

$currentUserId = $student_id; // Replace with the actual user ID



// Consultation data with user join
$consultationWithUserJoin = getCountWithUserJoinConsultation('consultation', 'ins_consult.date', 'stud_id', $currentUserId);

$completedToday = getCountForTodayByIntervalAndStatus('consultation', 'ins_consult.date', 'status', 'stud_id', $currentUserId, 6);
$completedWeek = getCountPerWeekAndStatus('consultation', 'ins_consult.date', 'status', 'stud_id', $currentUserId);
$completedMonth = getCountPerMonthAndStatus('consultation', 'ins_consult.date', 'status', 'stud_id', $currentUserId);

$pendingToday = getCountForTodayByIntervalAndStatusPending('consultation', 'ins_consult.date', 'status', 'stud_id', $currentUserId, 6);
$pendingWeek = getCountPerWeekAndStatusPending('consultation', 'ins_consult.date', 'status', 'stud_id', $currentUserId);
$pendingMonth = getCountPerMonthAndStatusPending('consultation', 'ins_consult.date', 'status', 'stud_id', $currentUserId);

$rejectedToday = getCountForTodayByIntervalAndStatusRejected('consultation', 'ins_consult.date', 'status', 'stud_id', $currentUserId, 6);

$rejectedWeek = getCountPerWeekAndStatusRejected('consultation', 'ins_consult.date', 'status', 'stud_id', $currentUserId);
$rejectedMonth = getCountPerMonthAndStatusRejected('consultation', 'ins_consult.date', 'status', 'stud_id', $currentUserId);

?>
<?php echo json_encode($completedWeek['labels']); ?>