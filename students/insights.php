
<?php
include("sidebar.php");
include("getdata.php");
include('consultationdata.php');
?>

        
        
        <!--SIDEBAR -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Insights</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Insights</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
		

					</div>
				</div>







				<hr/>
			
                 <div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div id="chart"></div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div id="chart1"></div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div id="chart2"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div id="chart3"></div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div id="chart4"></div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div id="chart5"></div>
            </div>
        </div>
    </div>
</div>

				</div>
		
		<!--end page wrapper -->
		<!--start overlay-->
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
	<!-- <div class="switcher-wrapper">
		<div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>
		</div>
		<div class="switcher-body">
			<div class="d-flex align-items-center">
				<h5 class="mb-0 text-uppercase">Theme Customizer</h5>
				<button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
			</div>
			<hr/>
			<h6 class="mb-0">Theme Styles</h6>
			<hr/>
			<div class="d-flex align-items-center justify-content-between">
				<div class="form-check">
					<input class="form-check-input" type="radio" name="flexRadioDefault" id="lightmode" checked>
					<label class="form-check-label" for="lightmode">Light</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="flexRadioDefault" id="darkmode">
					<label class="form-check-label" for="darkmode">Dark</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="flexRadioDefault" id="semidark">
					<label class="form-check-label" for="semidark">Semi Dark</label>
				</div>
			</div>
			<hr/>
			<div class="form-check">
				<input class="form-check-input" type="radio" id="minimaltheme" name="flexRadioDefault">
				<label class="form-check-label" for="minimaltheme">Minimal Theme</label>
			</div>
			<hr/>
			<h6 class="mb-0">Header Colors</h6>
			<hr/>
			<div class="header-colors-indigators">
				<div class="row row-cols-auto g-3">
					<div class="col">
						<div class="indigator headercolor1" id="headercolor1"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor2" id="headercolor2"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor3" id="headercolor3"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor4" id="headercolor4"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor5" id="headercolor5"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor6" id="headercolor6"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor7" id="headercolor7"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor8" id="headercolor8"></div>
					</div>
				</div>
			</div>
			<hr/>
			<h6 class="mb-0">Sidebar Backgrounds</h6>
			<hr/>
			<div class="header-colors-indigators">
				<div class="row row-cols-auto g-3">
					<div class="col">
						<div class="indigator sidebarcolor1" id="sidebarcolor1"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor2" id="sidebarcolor2"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor3" id="sidebarcolor3"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor4" id="sidebarcolor4"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor5" id="sidebarcolor5"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor6" id="sidebarcolor6"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor7" id="sidebarcolor7"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor8" id="sidebarcolor8"></div>
					</div>
				</div>
			</div>
		</div>
	</div> -->
	<!--end switcher-->
	<!-- Bootstrap JS -->
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
    	<script src="assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>


	<!--app JS-->
	<script src="assets/js/app.js"></script>

     <script>   


// Fetch and organize the data from your server (replace with your actual PHP script path)



 var options = {
    series: [{
        name: 'Likes',
        data: <?php echo json_encode($likesToday); ?>
    }, {
        name: 'Reply',
        data: <?php echo json_encode($replyToday); ?>
    }, {
        name: 'Post',
        data: <?php echo json_encode($postToday); ?>
    }],
    chart: {
        type: 'bar',
        height: 350
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    xaxis: {
        categories: <?php echo json_encode($intervalLabelsToday); ?>,
    },
    yaxis: {
        labels: {
            formatter: function(val) {
                return parseInt(val);
            }
        }
    },
    fill: {
        opacity: 1
    },
};

var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();

      
  var options = {
    series: [{
        name: 'Likes',
        data: [<?php echo implode(",", $likesWeek); ?>]
    }, {
        name: 'Reply',
        data: [<?php echo implode(",", $replyWeek); ?>]
    }, {
        name: 'Post',
        data: [<?php echo implode(",", $postWeek); ?>]
    }],
    chart: {
        type: 'bar',
        height: 350
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    xaxis: {
        categories: <?php echo json_encode($weekLabels); ?>
    },
    yaxis: {
        labels: {
            formatter: function(val) {
                return parseInt(val);
            }
        }
    },
    fill: {
        opacity: 1
    },
};

var chart = new ApexCharts(document.querySelector("#chart1"), options);
chart.render();

  

    var optionsMonth = {
    series: [
        {
            name: 'Likes',
            data: [<?php echo implode(",", $likesMonth); ?>]
        },
        {
            name: 'Reply',
            data: [<?php echo implode(",", $replyMonth); ?>]
        },
        {
            name: 'Post',
            data: [<?php echo implode(",", $postMonth); ?>]
        }
    ],
    chart: {
        type: 'bar',
        height: 350
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '40%', // Adjust this value
            endingShape: 'rounded'
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    xaxis: {
        categories: <?php echo json_encode($monthLabels); ?>
    },
    yaxis: {
        labels: {
            formatter: function(val) {
                return parseInt(val);
            }
        }
    },
    fill: {
        opacity: 1
    }
};

var chartMonth = new ApexCharts(document.querySelector("#chart2"), optionsMonth);
chartMonth.render();
















var options = {
    series: [{
        name: 'Completed',
        data: <?php echo json_encode($completedToday); ?>
    }, {
        name: 'Pending',
        data: <?php echo json_encode($pendingToday); ?>
    }, {
        name: 'Rejected',
        data: <?php echo json_encode($rejectedToday); ?>
    }],
    chart: {
        type: 'bar',
        height: 350
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    xaxis: {
        categories: <?php echo json_encode($intervalLabelsToday); ?>,
    },
    yaxis: {
        labels: {
            formatter: function(val) {
                return parseInt(val);
            }
        }
    },
    fill: {
        opacity: 1
    },
};

var chart = new ApexCharts(document.querySelector("#chart3"), options);
chart.render();
// Chart for Weekly Data
var optionsWeek = {
    series: [{
        name: 'Completed',
        data: <?php echo json_encode(array_values($completedWeek['counts'])); ?>
    }, {
        name: 'Pending',
        data: <?php echo json_encode(array_values($pendingWeek['counts'])); ?>
    }, {
        name: 'Rejected',
        data: <?php echo json_encode(array_values($rejectedWeek['counts'])); ?>
    }],
    chart: {
        type: 'bar',
        height: 350
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    xaxis: {
        categories: <?php echo json_encode($weekLabels); ?>,
    },
    yaxis: {
        labels: {
            formatter: function(val) {
                return parseInt(val);
            }
        }
    },
    fill: {
        opacity: 1
    },
};

var chartWeek = new ApexCharts(document.querySelector("#chart4"), optionsWeek);
chartWeek.render();


// Chart for Monthly Data
var optionsMonth = {
    series: [{
        name: 'Completed',
        data: <?php echo json_encode(array_values($completedMonth['counts'])); ?>
    }, {
        name: 'Pending',
        data: <?php echo json_encode(array_values($pendingMonth['counts'])); ?>
    }, {
        name: 'Rejected',
        data: <?php echo json_encode(array_values($rejectedMonth['counts'])); ?>
    }],
    chart: {
        type: 'bar',
        height: 350
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    xaxis: {
        categories: <?php echo json_encode($completedMonth['labels']); ?>,
    },
    yaxis: {
        labels: {
            formatter: function(val) {
                return parseInt(val);
            }
        }
    },
    fill: {
        opacity: 1
    },
};

var chartMonth = new ApexCharts(document.querySelector("#chart5"), optionsMonth);
chartMonth.render();


    </script>
</body>


<!-- Mirrored from codervent.com/synadmin/demo/vertical/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Aug 2023 12:56:57 GMT -->
</html>