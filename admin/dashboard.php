
<?php
include("sidebar.php");
?>
        
        
        <!--SIDEBAR -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
			
			  <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">
			  	<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">All Users</p>
										<h4 class="my-1"><?php echo $total_userdata; ?></h4>
									
									</div>
								<div class="widgets-icons bg-light-info text-info ms-auto"><i class='bx bxs-group'></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Students</p>
										<h4 class="my-1"><?php echo $total_students; ?></h4>
									
									</div>
								<div class="widgets-icons bg-success-info text-success ms-auto"><i class='bx bxs-group'></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Faculty</p>
										<h4 class="my-1"><?php echo $faculty_count; ?></h4>
									
									</div>
								<div class="widgets-icons bg-light-warning text-warning ms-auto"><i class='bx bxs-group'></i>
									</div>
								</div>
							</div>
						</div>
					</div>
						<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Online Students</p>
										<h4 class="my-1"><?php echo $online_count; ?></h4>
									
									</div>
								  <div class="widgets-icons bg-light-danger text-danger ms-auto"><i class='bx bxs-group'></i>
									</div>
								</div>
							</div>
						</div>
					</div>
			  </div><!--end row-->
			  <h6 class="mb-0 text-uppercase">Student Per Section</h6>
				<hr/>
			  	<div class="row row-cols-1 row-cols-md-3 row-cols-xl-5">
			<?php

// Assuming you have established a database connection

$sql = "SELECT s.id, s.grade, st.strand, COUNT(ss.stud_id) AS student_count 
        FROM section s 
        INNER JOIN strand st ON s.strand = st.strand_id 
        LEFT JOIN section_student ss ON s.id = ss.section_id 
        GROUP BY s.id";

$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Generate a random background color
        $randomColor = sprintf('#%02X%02X%02X', mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));

        echo '<div class="col">';
        echo '<div class="card radius-10" style="background-color: ' . $randomColor . ';">';
        echo '<div class="card-body">';
        echo '<div class="d-flex align-items-center">';
        echo '<div>';
        echo '<p class="mb-0 text-dark">' . 'Grade-' . $row['grade'] . ' ' . $row['strand'] . '</p>';
        echo '<h4 class="my-1">' . $row['student_count'] . '</h4>';
        echo '</div>';
        echo '<div class="widgets-icons bg-dark-info text-dark ms-auto"><i class="bx bxs-group"></i></div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "0 results";
}
?>



				</div>
			  
		
			  	  <div class="row">
					    <div class="col-8">
						<div class="card">
							<div class="card-body">
								
								<div id="chart23"></div>
							</div>
						</div>
						  </div>
						<div class="col-4">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <h5 class="mb-1">Number of Likes, Posts, and Comments</h5>
                </div>
                <div class="ms-lg-auto mb-2 mb-lg-0">
                    <div class="btn-group-round">
                        <div class="btn-group">
                            <button type="button" class="btn btn-white" onclick="updateTimeRange('day')">Day</button>
                            <button type="button" class="btn btn-white" onclick="updateTimeRange('week')">Week</button>
                            <button type="button" class="btn btn-white" onclick="updateTimeRange('month')">Month</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="chart9"></div>
    </div>
</div>

<script>
function updateTimeRange(timeRange) {
    // Assuming you want to reload the same page with the selected time range as a query parameter
    window.location.href = window.location.pathname + '?time_range=' + timeRange;
}

// Use window.onload to ensure the content is fully loaded before scrolling
window.onload = function() {
    // Get the chart9 element
    var chartElement = document.getElementById('chart9');
    
    // Scroll to the chart9 element
    if (chartElement) {
        chartElement.scrollIntoView({ behavior: 'smooth' });
    }
};
</script>
	  <div class="row">
			    <div class="col-12 col-xl-8 d-flex">
				  <div class="card radius-10 w-100">
						<div class="card-body">
							<div class="" id="chart5"></div>
						</div>
					</div>
				</div>
				<div class="col-12 col-xl-4 d-flex">
				  <div class="card radius-10 w-100">
						<div class="card-body">
							<div class="d-flex align-items-center">
									<div>
										<h5 class="mb-1">Online Students</h5>
									</div>
									<div class="font-22 ms-auto"><i class="bx bx-dots-horizontal-rounded"></i>
									</div>
								</div>
							<div class="mt-4" id="onlinestudent"></div>
							<div class="d-flex align-items-center">
									<div>
												<h2 class="mb-0"><?php echo $online_count; ?></h2>
										<p class="mb-0">/<?php echo $total_students; ?> Students</p>
									</div>
									<div class="ms-auto d-flex align-items-center border radius-10 px-2">
									  <i class='bx bxs-checkbox font-22 me-1 text-primary'></i><span>Online</span>
									</div>
							  </div>
						</div>
					</div>
				</div>
				
			  </div>
						  </div>
					  </div>
					    	  <div class="row">
								    <div class="col-12">
										<div class="card">
												<div class="card-header">
													Recent Consultations</div>
											
				<div class="card-body">
					<div class="btn-group">
    <button type="button" class="btn btn-secondary" onclick="filterTable('day')">Day</button>
    <button type="button" class="btn btn-secondary" onclick="filterTable('week')">Week</button>
    <button type="button" class="btn btn-secondary" onclick="filterTable('month')">Month</button>
</div>
						<div class="table-responsive">

<?php
$query = "SELECT * FROM ins_consult ic 
JOIN faculty_info fi ON ic.faculty_id = fi.faculty_id
JOIN consultation c ON c.ins_c_id = ic.ins_c_id 
JOIN student s ON c.stud_id = s.stud_id ORDER BY ic.date desc";

$result = $con->query($query);

if ($result && $result->num_rows > 0) {
    echo '<table id="example2" class="table table-striped table-bordered">
            <thead>
                <tr>
				    <th>Faculty</th>
					  <th>Student</th>
                    <th>Date</th>
                    <th>Start Time</th>
					<th>End Time</th>
		
					<th>Status</th>
                </tr>
            </thead>
            <tbody id="table-body">';
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


    echo '</tbody>
          </table>';
} else {
    echo "No data found.";
}
?>




						</div>
					</div>
				</div>
								  </div>
								  </div>
          
			
			</div>
		</div>
		<!--end page wrapper -->
		<!--start overlay-->
		<div class="search-overlay"></div>
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<footer class="page-footer">
			<p class="mb-0">Campus Connect © 2023. All right reserved.</p>
		</footer>
	</div>
	<!--end wrapper-->
	<!--start switcher-->
	
	<!--end switcher-->
	<!-- Bootstrap JS -->
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script src="assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
	<script src="assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="assets/plugins/highcharts/js/highcharts.js"></script>
	<script src="assets/plugins/highcharts/js/exporting.js"></script>
	<script src="assets/plugins/highcharts/js/variable-pie.js"></script>
	<script src="assets/plugins/highcharts/js/export-data.js"></script>
	<script src="assets/plugins/highcharts/js/accessibility.js"></script>
	<script src="assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
	<script src="assets/js/index2.js"></script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>
		<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
	<script>
function filterTable(timeRange) {
    // Use AJAX to fetch filtered data from the server based on the selected time range
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Replace the table content with the filtered data
            document.getElementById("table-body").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "filter_data.php?time_range=" + timeRange, true);
    xhttp.send();
}
</script>
	<script>



		$(document).ready(function() {
			$('#example').DataTable();
		  } );
	</script>
	<script>
		$(document).ready(function() {
			var table = $('#example2').DataTable( {
				lengthChange: false,
				
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
		} );
	</script>
	<script>
		new PerfectScrollbar('.customers-list');
		new PerfectScrollbar('.store-metrics');
		new PerfectScrollbar('.product-list');
	</script>

    <script>
$(document).ready(function () {
Highcharts.chart('chart5', {
    chart: {
        type: 'pie', // Use a pie chart to represent the gender distribution
        height: 420,
        styledMode: true
    },
    credits: {
        enabled: false
    },
    title: {
        text: 'Gender Distribution of Students'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y}</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y}'
            }
        }
    },
    series: [{
        name: 'Gender',
        colorByPoint: true,
        data: [
            {
                name: 'Male',
                y: <?php echo $male_count; ?> // Replace with the actual count of male students
            },
            {
                name: 'Female',
                y: <?php echo $female_count; ?> // Replace with the actual count of female students
            }
        ]
    }]
});
// chart 6

var options = {
    chart: {
        height: 300,
        type: 'radialBar',
        toolbar: {
            show: false
        }
    },
    plotOptions: {
        radialBar: {
            hollow: {
                margin: 0,
                size: '78%',
                image: undefined,
                imageOffsetX: 0,
                imageOffsetY: 0,
                position: 'front',
                dropShadow: {
                    enabled: false,
                    top: 3,
                    left: 0,
                    blur: 4,
                    color: 'rgba(0, 169, 255, 0.25)',
                    opacity: 0.65
                }
            },
            track: {
                background: '#f0e6ff',
                margin: 0,
                dropShadow: {
                    enabled: false,
                    top: -3,
                    left: 0,
                    blur: 4,
                    color: 'rgba(0, 169, 255, 0.85)',
                    opacity: 0.65
                }
            },
            dataLabels: {
                showOn: 'always',
                name: {
                    offsetY: -25,
                    show: true,
                    color: '#6c757d',
                    fontSize: '16px'
                },
                value: {
                    formatter: function (val) {
                        return val;
                    },
                    color: '#000',
                    fontSize: '45px',
                    show: true,
                    offsetY: 10,
                }
            }
        }
    },
    fill: {
        type: 'gradient',
        gradient: {
            shade: 'light',
            type: 'horizontal',
            shadeIntensity: 0.5,
            gradientToColors: ['#8833ff'],
            inverseColors: false,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100]
        }
    },
    colors: ["#8833ff"],
    series: [ <?php echo $online_count; ?>], // Replace with the number of online students
    stroke: {
        lineCap: 'round',
    },
    labels: ['Online Students'], // Label for the chart
};

var chart = new ApexCharts(document.querySelector("#onlinestudent"), options);
chart.render();

});


<?php
function getChartData($con, $table, $type)
{
    $countField = ($type === 'post') ? 'likes' : 'COUNT(*)';
    $dateField = ($type === 'post') ? 'post_date' : 'reply_date';

    $query = "SELECT $countField as count, $dateField as datecreated FROM $table GROUP BY $dateField";
    $result = $con->query($query);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'count' => $row['count'],
            'datecreated' => $row['datecreated']
        ];
    }

    return $data;
}

// Get data for posts and likes
$postData = getChartData($con, 'posts', 'post');
$replyData = getChartData($con, 'post_replies', 'reply');

$postCounts = [];
$replyCounts = [];
$labels = [];

foreach ($postData as $data) {
    $labels[] = $data['datecreated'];
    $postCounts[] = $data['count'];
}

foreach ($replyData as $data) {
    $replyCounts[] = $data['count'];
}

// Create options for the chart
$optionsLine = [
    'chart' => [
        'foreColor' => '#9ba7b2',
        'height' => 360,
        'type' => 'line',
        'zoom' => [
            'enabled' => false
        ],
        'dropShadow' => [
            'enabled' => true,
            'top' => 3,
            'left' => 2,
            'blur' => 4,
            'opacity' => 0.1,
        ]
    ],
    'stroke' => [
        'curve' => 'smooth',
        'width' => 5
    ],
    'colors' => ["#8833ff", '#29cc39', '#ff9933'], // Add color for replyCounts
    'series' => [
        [
            'name' => "Post Likes",
            'data' => $postCounts
        ],
        [
            'name' => "Reply Likes",
            'data' => $replyCounts
        ],
    ],
    'title' => [
        'text' => 'Likes Chart',
        'align' => 'left',
        'offsetY' => 25,
        'offsetX' => 20
    ],
    'subtitle' => [
        'text' => 'Statistics',
        'offsetY' => 55,
        'offsetX' => 20
    ],
    'markers' => [
        'size' => 4,
        'strokeWidth' => 0,
        'hover' => [
            'size' => 7
        ]
    ],
    'grid' => [
        'show' => true,
        'padding' => [
            'bottom' => 0
        ]
    ],
    'labels' => $labels,
    'xaxis' => [
        'tooltip' => [
            'enabled' => false
        ]
    ],
    'legend' => [
        'position' => 'top',
        'horizontalAlign' => 'right',
        'offsetY' => -20
    ]
];

// Convert options to JSON
$optionsLineJSON = json_encode($optionsLine, JSON_NUMERIC_CHECK);

?>
<?php

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

var options = {
    series: [<?php echo $total_post_replies?>, <?php echo $total_posts?>,  <?php echo $total_likes?>],
    labels: ['Comments', 'Post', 'Likes'],
    chart: {
        foreColor: '#9ba7b2',
        height: 380,
        type: 'donut',
    },
    colors: ["#B366FF", "#5C00B8", "#FF8833"],
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                height: 320
            },
            legend: {
                position: 'bottom'
            }
        }
    }]
};
var chart = new ApexCharts(document.querySelector("#chart9"), options);
chart.render();
	var options = {
		series: [44, 55, 41, 17],
		chart: {
			foreColor: '#9a9797',
			height: 320,
			type: 'donut',
		},
		legend: {
			position: 'bottom',
			show: true,
		},
		plotOptions: {
			pie: {
				customScale: 0.8,
				donut: {
					size: '80%'
				}
			}
		},
		colors: ["#504da6", "#ffc200", "#6fd1f6", "#e0e6f0"],
		dataLabels: {
			enabled: false
		},
		labels: ['Flue', 'Covid-19', 'Diabetis', 'Colds'],
		responsive: [{
			breakpoint: 480,
			options: {
				chart: {
					height: 300
				},
				legend: {
					position: 'bottom'
				},
				plotOptions: {
					pie: {
						customScale: 1,
					}
				},
			}
		}]
	};
	var chart = new ApexCharts(document.querySelector("#chart4"), options);
	chart.render();

	var options = {
		series: [<?php echo $male_count; ?>, <?php echo $female_count; ?>],
		chart: {
			foreColor: '#9a9797',
			height: 320,
			type: 'donut',
		},
		legend: {
			position: 'bottom',
			show: true,
		},
		plotOptions: {
			pie: {
				customScale: 0.8,
				donut: {
					size: '80%'
				}
			}
		},
		colors: ["#504da6", "#ffc200"],
		dataLabels: {
			enabled: false
		},
		labels: ['Male', 'Female'],
		responsive: [{
			breakpoint: 480,
			options: {
				chart: {
					height: 300
				},
				legend: {
					position: 'bottom'
				},
				plotOptions: {
					pie: {
						customScale: 1,
					}
				},
			}
		}]
	};
	var chart = new ApexCharts(document.querySelector("#chart41"), options);
	chart.render();
    </script>
	    <script>
        var optionsLine = <?php echo $optionsLineJSON; ?>;
        var chartLine = new ApexCharts(document.querySelector('#chart23'), optionsLine);
        chartLine.render();
    </script>
</body>


<!-- Mirrored from codervent.com/synadmin/demo/vertical/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Aug 2023 12:58:58 GMT -->
</html>