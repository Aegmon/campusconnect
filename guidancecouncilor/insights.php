
<?php
include("sidebar.php");

?>

		<div class="page-wrapper">
			<div class="page-content">

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
                  
	          
                 

                
					</div>
				</div>

		<div class="overlay toggle-icon"></div>

	<footer class="page-footer">
			<p class="mb-0">Campus Connect © 2023. All right reserved.</p>
		</footer>
</div>

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
// Fetch data from getdata.php
fetch('getdata.php')
  .then(response => response.json())
  .then(data => {
    // Update charts for daily, weekly, and monthly data
    updateChart(data.unapproved_daily_count, data.approved_daily_count, '#chart', 'Day');
    updateChart(data.unapproved_weekly_count, data.approved_weekly_count, '#chart1', 'Week');
    updateChart(data.unapproved_monthly_count, data.approved_monthly_count, '#chart2', 'Month');
  })
  .catch(error => console.error('Error fetching data:', error));

// Function to update chart options dynamically
function updateChart(unapprovedCount, approvedCount, chartId, timeUnit) {
  var options = {
    series: [
      {
        name: 'Unapproved Posts',
        data: [unapprovedCount],
      },
      {
        name: 'Approved Posts',
        data: [approvedCount],
      },
    ],
    chart: {
      foreColor: '#9ba7b2',
      type: 'bar',
      height: 360,
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '55%',
        endingShape: 'rounded',
      },
    },
    dataLabels: {
      enabled: false,
    },
    stroke: {
      show: true,
      width: 2,
      colors: ['transparent'],
    },
    title: {
      text: `Guidance Counselor Post Counts - ${timeUnit}`,
      align: 'left',
      style: {
        fontSize: '14px',
      },
    },
    colors: ["#29cc39", '#8833ff'],
    xaxis: {
      categories: [timeUnit],
    },
    fill: {
      opacity: 1,
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return parseInt(val); // Ensure tooltip values are whole numbers
        },
      },
    },
  };

  var chart = new ApexCharts(document.querySelector(chartId), options);
  chart.render();
}


    </script>
</body>


<!-- Mirrored from codervent.com/synadmin/demo/vertical/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Aug 2023 12:56:57 GMT -->
</html>