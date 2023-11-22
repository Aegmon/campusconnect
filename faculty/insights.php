
<?php
include("sidebar.php");

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
fetch('getdata.php')
  .then(response => response.json())
  .then(data => {
    // Extract data for today
    const todayLikes = data.today_likes;
    const todayPosts = data.today_posts;
    const todayReplies = data.today_replies;

    // Extract data for this week
    const weekLikes = data.week_likes;
    const weekPosts = data.week_posts;
    const weekReplies = data.week_replies;

    // Extract data for this month
    const monthLikes = data.month_likes;
    const monthPosts = data.month_posts;
    const monthReplies = data.month_replies;

    // Update the chart options with the fetched data
    updateChartOptions(todayLikes, todayPosts, todayReplies, '#chart', 'Day');
    updateChartOptions(weekLikes, weekPosts, weekReplies, '#chart1', 'Week');
    updateChartOptions(monthLikes, monthPosts, monthReplies, '#chart2', 'Month');
  })
  .catch(error => console.error('Error fetching data:', error));




// Function to update monthly chart options dynamically
function updateChartOptions(likes, posts, replies, chartId, timeUnit) {
  var options = {
    series: [
      {
        name: 'Likes',
        data: [Math.round(likes)], // Round the value to the nearest whole number
      },
      {
        name: 'Comments',
        data: [Math.round(replies)], // Round the value to the nearest whole number
      },
      {
        name: 'Post',
        data: [Math.round(posts)], // Round the value to the nearest whole number
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
      text: `Daily Engagements - ${timeUnit}`,
      align: 'left',
      style: {
        fontSize: '14px',
      },
    },
    colors: ["#29cc39", '#8833ff', '#e62e2e'],
    xaxis: {
      categories: [timeUnit],
    },
    yaxis: {
      labels: {
        formatter: function (value) {
          return Math.round(value); // Format y-axis labels as whole numbers
        }
      }
    },
    fill: {
      opacity: 1,
    },
  };

  var chart = new ApexCharts(document.querySelector(chartId), options);
  chart.render();
}



    ////// Consultation

fetch('consultationdata.php')
  .then(response => response.json())
  .then(data => {
    // Extract data for today
    const todayOngoing = data.today_consultation_status.today_ongoing;
    const todayCancelled = data.today_consultation_status.today_cancelled;

    // Extract data for this week
    const weekOngoing = data.week_consultation_status.week_ongoing;
    const weekCancelled = data.week_consultation_status.week_cancelled;

    // Extract data for this month
    const monthOngoing = data.month_consultation_status.month_ongoing;
    const monthCancelled = data.month_consultation_status.month_cancelled;

    // Update the chart options with the fetched data
    updateConsultationStatusChart(todayOngoing, todayCancelled, '#chart3', 'Daily');
    updateConsultationStatusChart(weekOngoing, weekCancelled, '#chart4', 'Weekly');
    updateConsultationStatusChart(monthOngoing, monthCancelled, '#chart5', 'Monthly');
  })
  .catch(error => console.error('Error fetching data:', error));

// Function to update consultation status chart options dynamically
function updateConsultationStatusChart(ongoing, cancelled, chartId, timeUnit) {
  var options = {
    series: [
      {
        name: 'Ongoing',
        data: [Math.round(ongoing)],
      },
      {
        name: 'Cancelled',
        data: [Math.round(cancelled)],
      }
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
      text: `Consultation Status - ${timeUnit}`,
      align: 'left',
      style: {
        fontSize: '14px',
      },
    },
    colors: ["#29cc39", '#e62e2e'],
    xaxis: {
      categories: [timeUnit],
    },
    yaxis: {
      labels: {
        formatter: function (value) {
          return Math.round(value); // Format y-axis labels as whole numbers
        }
      }
    },
    fill: {
      opacity: 1,
    },
  };

  var chart = new ApexCharts(document.querySelector(chartId), options);
  chart.render();
}

    </script>
</body>


<!-- Mirrored from codervent.com/synadmin/demo/vertical/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Aug 2023 12:56:57 GMT -->
</html>