<?php


function getCountForTodayByIntervalAndStatusForSection($table, $dateField, $statusField, $userIdField, $sectionId, $intervalHours)
{
    global $con;
    $today = date("Y-m-d");

    $sql = "SELECT HOUR($dateField) DIV $intervalHours AS interval_slot, 
                   COUNT(*) as count 
            FROM $table 
            INNER JOIN ins_consult ON $table.ins_c_id = ins_consult.ins_c_id
            INNER JOIN section_student ON $table.stud_id = section_student.stud_id
            INNER JOIN section ON section_student.section_id = section.id
            WHERE DATE(ins_consult.date) = '$today' 
              AND $statusField = 'completed' 
              AND section.instructor = $sectionId
            GROUP BY interval_slot";

    $result = $con->query($sql);

    $counts = array_fill(0, 24 / $intervalHours, 0);

    while ($row = $result->fetch_assoc()) {
        $intervalSlot = $row['interval_slot'];
        $counts[$intervalSlot] = $row['count'];
    }

    return $counts;
}

function getCountPerWeekAndStatusForSection($table, $dateField, $statusField, $userIdField, $currentUserId, $sectionId)
{
    global $con;
    $currentMonth = date("m");

    $sql = "SELECT DAY(ins_consult.date) as day, 
                   COUNT(*) as count 
            FROM $table 
            INNER JOIN ins_consult ON $table.ins_c_id = ins_consult.ins_c_id
            INNER JOIN section_student ON $table.stud_id = section_student.stud_id
            INNER JOIN section ON section_student.section_id = section.id
            WHERE MONTH(ins_consult.date) = $currentMonth 
              AND $statusField = 'completed' 
              AND section.instructor = $sectionId
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

function getCountPerMonthAndStatusForSection($table, $dateField, $statusField, $userIdField, $currentUserId, $sectionId)
{
    global $con;
    $sql = "SELECT MONTH(ins_consult.date) as month, 
                   COUNT(*) as count 
            FROM $table 
            INNER JOIN ins_consult ON $table.ins_c_id = ins_consult.ins_c_id
            INNER JOIN section_student ON $table.stud_id = section_student.stud_id
            INNER JOIN section ON section_student.section_id = section.id
            WHERE $statusField = 'completed' 
              AND section.instructor = $sectionId
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

function getCountForTodayByIntervalAndStatusPendingForSection($table, $dateField, $statusField, $userIdField, $sectionId, $intervalHours)
{
    global $con;
    $today = date("Y-m-d");

    $sql = "SELECT HOUR($dateField) DIV $intervalHours AS interval_slot, 
                   COUNT(*) as count 
            FROM $table 
            INNER JOIN ins_consult ON $table.ins_c_id = ins_consult.ins_c_id
            INNER JOIN section_student ON $table.stud_id = section_student.stud_id
            INNER JOIN section ON section_student.section_id = section.id
            WHERE DATE(ins_consult.date) = '$today' 
              AND $statusField = 'pending' 
              AND section.instructor = $sectionId
            GROUP BY interval_slot";

    $result = $con->query($sql);

    $counts = array_fill(0, 24 / $intervalHours, 0);

    while ($row = $result->fetch_assoc()) {
        $intervalSlot = $row['interval_slot'];
        $counts[$intervalSlot] = $row['count'];
    }

    return $counts;
}

function getCountPerWeekAndStatusPendingForSection($table, $dateField, $statusField, $userIdField, $currentUserId, $sectionId)
{
    global $con;
    $currentMonth = date("m");

    $sql = "SELECT DAY(ins_consult.date) as day, 
                   COUNT(*) as count 
            FROM $table 
            INNER JOIN ins_consult ON $table.ins_c_id = ins_consult.ins_c_id
            INNER JOIN section_student ON $table.stud_id = section_student.stud_id
            INNER JOIN section ON section_student.section_id = section.id
            WHERE MONTH(ins_consult.date) = $currentMonth 
              AND $statusField = 'pending' 
              AND section.instructor = $sectionId
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

function getCountPerMonthAndStatusPendingForSection($table, $dateField, $statusField, $userIdField, $currentUserId, $sectionId)
{
    global $con;
    $sql = "SELECT MONTH(ins_consult.date) as month, 
                   COUNT(*) as count 
            FROM $table 
            INNER JOIN ins_consult ON $table.ins_c_id = ins_consult.ins_c_id
            INNER JOIN section_student ON $table.stud_id = section_student.stud_id
            INNER JOIN section ON section_student.section_id = section.id
            WHERE $statusField = 'pending' 
              AND section.instructor = $sectionId
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

function getCountForTodayByIntervalAndStatusRejectedForSection($table, $dateField, $statusField, $userIdField, $sectionId, $intervalHours)
{
    global $con;
    $today = date("Y-m-d");

    $sql = "SELECT HOUR($dateField) DIV $intervalHours AS interval_slot, 
                   COUNT(*) as count 
            FROM $table 
            INNER JOIN ins_consult ON $table.ins_c_id = ins_consult.ins_c_id
            INNER JOIN section_student ON $table.stud_id = section_student.stud_id
            INNER JOIN section ON section_student.section_id = section.id
            WHERE DATE(ins_consult.date) = '$today' 
              AND $statusField = 'rejected' 
              AND section.instructor = $sectionId
            GROUP BY interval_slot";

    $result = $con->query($sql);

    $counts = array_fill(0, 24 / $intervalHours, 0);

    while ($row = $result->fetch_assoc()) {
        $intervalSlot = $row['interval_slot'];
        $counts[$intervalSlot] = $row['count'];
    }

    return $counts;
}

function getCountPerWeekAndStatusRejectedForSection($table, $dateField, $statusField, $userIdField, $currentUserId, $sectionId)
{
    global $con;
    $currentMonth = date("m");

    $sql = "SELECT DAY(ins_consult.date) as day, 
                   COUNT(*) as count 
            FROM $table 
            INNER JOIN ins_consult ON $table.ins_c_id = ins_consult.ins_c_id
            INNER JOIN section_student ON $table.stud_id = section_student.stud_id
            INNER JOIN section ON section_student.section_id = section.id
            WHERE MONTH(ins_consult.date) = $currentMonth 
              AND $statusField = 'rejected' 
              AND section.instructor = $sectionId
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

function getCountPerMonthAndStatusRejectedForSection($table, $dateField, $statusField, $userIdField, $currentUserId, $sectionId)
{
    global $con;
    $sql = "SELECT MONTH(ins_consult.date) as month, 
                   COUNT(*) as count 
            FROM $table 
            INNER JOIN ins_consult ON $table.ins_c_id = ins_consult.ins_c_id
            INNER JOIN section_student ON $table.stud_id = section_student.stud_id
            INNER JOIN section ON section_student.section_id = section.id
            WHERE $statusField = 'rejected' 
              AND section.instructor = $sectionId
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

function getCountWithUserJoinConsultationForSection($table, $dateField, $userIdField, $currentUserId, $sectionId)
{
    global $con;
    $today = date("Y-m-d");
    $sql = "SELECT COUNT(*) as count FROM $table 
            INNER JOIN ins_consult ON $table.ins_c_id = ins_consult.ins_c_id
            INNER JOIN section_student ON $table.stud_id = section_student.stud_id
            INNER JOIN section ON section_student.section_id = section.id
            WHERE $dateField = '$today' AND $userIdField = $currentUserId 
              AND section.id = $sectionId";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    return $row['count'];
}

 $currentUserId =$currentUserId ;
$sectionId = $faculty_id;

echo $section_id;// Replace with the actual section ID
$completedToday = getCountForTodayByIntervalAndStatusForSection('consultation', 'ins_consult.date', 'status', 'stud_id', $sectionId, 6);
$completedWeek = getCountPerWeekAndStatusForSection('consultation', 'ins_consult.date', 'status', 'stud_id', $currentUserId, $sectionId);
$completedMonth = getCountPerMonthAndStatusForSection('consultation', 'ins_consult.date', 'status', 'stud_id', $currentUserId, $sectionId);



$pendingToday = getCountForTodayByIntervalAndStatusPendingForSection('consultation', 'ins_consult.date', 'status', 'stud_id', $currentUserId, 6);
$pendingWeek = getCountPerWeekAndStatusPendingForSection('consultation', 'ins_consult.date', 'status', 'stud_id', $currentUserId, $sectionId);
$pendingMonth = getCountPerMonthAndStatusPendingForSection('consultation', 'ins_consult.date', 'status', 'stud_id', $currentUserId, $sectionId);

$rejectedToday = getCountForTodayByIntervalAndStatusRejectedForSection('consultation', 'ins_consult.date', 'status', 'stud_id', $currentUserId, 6);

$rejectedWeek = getCountPerWeekAndStatusRejectedForSection('consultation', 'ins_consult.date', 'status', 'stud_id', $currentUserId, $sectionId);
$rejectedMonth = getCountPerMonthAndStatusRejectedForSection('consultation', 'ins_consult.date', 'status', 'stud_id', $currentUserId, $sectionId);

?>
