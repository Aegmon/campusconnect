
<?php
include("sidebar.php");
?>
        
        
        <!--SIDEBAR -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">

			  <h1 class="mb-0 text-uppercase text-center">GRADE-<?php echo $grade." ".$strand;?></h1>
				<hr/>
			  	<!-- <div class="row row-cols-1 row-cols-md-3 row-cols-xl-5">
					
					<div class="col-12">
						<div class="card radius-10">
							<div class="card-body">
								<div class="text-center">
									<div class="widgets-icons rounded-circle mx-auto bg-light-warning text-warning mb-3"><i class='bx bxs-group'></i>
									</div>
									<h4 class="my-1"> <?php echo $total_students; ?></h4>
									<p class="mb-0 text-secondary">GRADE-<?php echo $grade." ".$strand;?></p>
								</div>
							</div>
						</div>
					</div>
				</div> -->
			  <div class="row">
                        <div class="col-lg-4">
								<div class="card">
									<div class="card-body">
										<div class="d-flex flex-column align-items-center text-center">
											<img src="assets/images/avatars/avatar-2.png" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
											<div class="mt-3">
												<h4>John Doe</h4>
										
												<button class="btn btn-primary">Follow</button>
												<button class="btn btn-outline-primary">Message</button>
											</div>
										</div>
									
									</div>
								</div>
							</div>
              </div>
			  <div class="row">
				 <div class="col-12 col-xl-4 d-flex">
				  <div class="card radius-10 w-100">
						<div class="card-body">
							<div class="" id="chart5"></div>
						</div>
					</div>
				</div>
			    <div class="col-12 col-xl-4 d-flex">
				  <div class="card radius-10 w-100">
						<div class="card-body">
							<div class="" id="chart51"></div>
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
										<p class="mb-0">/<?php echo $total_userdata; ?></p>
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

Highcharts.chart('chart51', {
    chart: {
        type: 'pie', // Use a pie chart to represent the gender distribution
        height: 420,
        styledMode: true
    },
    credits: {
        enabled: false
    },
    title: {
        text: 'Consultation Hours'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y}</b> ({point.percentage:.1f}%)'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
            }
        }
    },
    series: [{
        name: 'Status',
        colorByPoint: true,
        data: <?php echo $consultation_json; ?>
    }]
});


    </script>
</body>



</html>