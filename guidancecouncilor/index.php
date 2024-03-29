
<?php
include("sidebar.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify'])) {
    // Handle form submission
    $post_id = $_POST['post_id'];

    // Insert data into 'userdata' table
    $insert_userdata_query = "UPDATE `posts` SET isapproved = '1' WHERE post_id = ?";
    $stmt = $con->prepare($insert_userdata_query);
    if ($stmt) {
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $stmt->close();
    } else {
        // Error handling
        echo "Error in the database operation.";
    }


}




?>
        
        
        <!--SIDEBAR -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Dashboard</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
						<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal">
  <i class='bx bx-plus'></i> Add
</button> -->


<!-- Modal -->
	<div class="modal fade" id="exampleVerticallycenteredModal" tabindex="-1" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">Add Student Concern</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
													<div class="modal-body">
                              <form class="row g-3" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">

    <div class="col-md-12">
        <label for="inputAddress" class="form-label">Concern</label>
        <input class="result form-control" type="text"name="concern" placeholder="Enter Your Concern..." >
    </div>

   

    <div class="col-12">
        <button type="submit" class="btn btn-primary px-5" name="add">Add</button>
    </div>
</form>

                                                 
                                                    </div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
										
													</div>
												</div>
											</div>
										</div>
<!-- Modal End -->



						</div>
					</div>
				</div>
				<!--end breadcrumb-->
	

				<!-- <h6 class="mb-0 text-uppercase">DataTable Import</h6> -->
				<hr/>
				<div class="card">
                      <div class="col-md-12">
   


    </div>
					<div class="card-body">
						<div class="table-responsive">

<?php
$query = "SELECT p.*, 
    CASE 
        WHEN p.post_from = 'admin' THEN 'Administrator'
        ELSE COALESCE(
            NULLIF(CONCAT(s.fname, ' ', NULLIF(s.lname, '')), ' '), 
            NULLIF(CONCAT(f.first_name, ' ', NULLIF(f.last_name, '')), ' '),
            s.fname,
            f.first_name
        )
    END AS name 
FROM posts p 
LEFT JOIN faculty_info f ON p.user_id = f.userID 
LEFT JOIN student s ON p.user_id = s.user_id 
ORDER BY p.post_date DESC";

$result = $con->query($query);

if ($result && $result->num_rows > 0) {
    echo '<table id="example2" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Post From</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Tools</th>
                </tr>
            </thead>
            <tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>' . $row['name'] . '</td>
                <td>' . $row['post_title'] . '</td>
                <td>' . $row['post_content'] . '</td>
                <td>' . $row['post_date'] . '</td>';

        if ($row['isapproved'] == 0) {
            echo '<td>Unverified</td>';
        } else if ($row['isapproved'] == 1) {
            echo '<td>Verified</td>';
        } else {
            echo '<td>Unknown</td>';
        }

        echo '<td>';

        if ($row['isapproved'] != 1) {
            // Button is enabled if the status is not verified
            echo '<form action="" method="post">
                    <input type="hidden" name="post_id" value="' . $row['post_id'] . '">
                    <button type="submit" name="verify" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal">
                        <i class="bx bx-plus"></i> Accept
                    </button>
                </form>';
        } else {
            // Button is disabled if the status is already verified
            echo '<button class="btn btn-primary" disabled>
                        <i class="bx bx-plus"></i> Accept
                    </button>';
        }

        echo '</td></tr>';
    }
    echo '</tbody></table>';
} else {
    echo "No data found.";
}
?>





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
	
	<!-- Bootstrap JS -->
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
  
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script src="assets/plugins/datetimepicker/js/legacy.js"></script>
	<script src="assets/plugins/datetimepicker/js/picker.js"></script>
	<script src="assets/plugins/datetimepicker/js/picker.time.js"></script>
	<script src="assets/plugins/datetimepicker/js/picker.date.js"></script>
	<script src="assets/plugins/bootstrap-material-datetimepicker/js/moment.min.js"></script>
	<script src="assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js"></script>
    	<script>
		$('.datepicker').pickadate({
			selectMonths: true,
	        selectYears: true
		}),
		$('.timepicker').pickatime()
	</script>
	<script>
		$(function () {
			$('#date-time').bootstrapMaterialDatePicker({
				format: 'YYYY-MM-DD HH:mm'
			});
			$('#date').bootstrapMaterialDatePicker({
				time: false
			});
			$('#time').bootstrapMaterialDatePicker({
				date: false,
				format: 'HH:mm'
			});
		});
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
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
		} );
	</script>
    
	<!--app JS-->
	<script src="assets/js/app.js"></script>

</body>


<!-- Mirrored from codervent.com/synadmin/demo/vertical/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Aug 2023 12:56:57 GMT -->
</html>