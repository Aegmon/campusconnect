<?php
// filter_data.php

// Include your database connection code here
include('../connection.php');

$timeRange = $_GET['time_range'];

$query = "SELECT * FROM ins_consult ic 
JOIN faculty_info fi ON ic.faculty_id = fi.faculty_id
JOIN consultation c ON c.ins_c_id = ic.ins_c_id 
JOIN student s ON c.stud_id = s.stud_id
WHERE DATE(ic.date) = CURDATE()";

if ($timeRange == 'week') {
    $query = "SELECT * FROM ins_consult ic 
    JOIN faculty_info fi ON ic.faculty_id = fi.faculty_id
    JOIN consultation c ON c.ins_c_id = ic.ins_c_id 
    JOIN student s ON c.stud_id = s.stud_id
    WHERE WEEK(ic.date) = WEEK(NOW())";
} elseif ($timeRange == 'month') {
    $query = "SELECT * FROM ins_consult ic 
    JOIN faculty_info fi ON ic.faculty_id = fi.faculty_id
    JOIN consultation c ON c.ins_c_id = ic.ins_c_id 
    JOIN student s ON c.stud_id = s.stud_id
    WHERE MONTH(ic.date) = MONTH(NOW())";
}

$result = $con->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
           $formattedDate = date("F j, Y", strtotime($row['date']));
    $formattedStartTime = date("h:i A", strtotime($row['starttime']));
    $formattedEndTime = date("h:i A", strtotime($row['endtime']));

    echo '<tr>
       <td>' . $row['first_name'] . ' ' . $row['last_name'] . '</td>
	        <td>' . $row['fname'] . ' ' . $row['lname'] . '</td>
       <td>' . $formattedDate . '</td>
       <td>' . $formattedStartTime . '</td>
       <td>' . $formattedEndTime . '</td>
       <td>';

    $status = $row['status'];

    if ($status == 'completed') {
        echo '<span class="badge bg-success">Completed</span>';
    } elseif ($status == 'pending') {
        echo '<span class="badge bg-warning">Pending</span>';
    } else {
   echo '<span class="badge bg-danger">Rejected</span>';
      
    }

    echo '</td>
    </tr>';
    }
} else {
    echo "No data found.";
}
?>
