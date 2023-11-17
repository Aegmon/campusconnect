
<?php
include("sidebar.php");



?>
        
        
        <!--SIDEBAR -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Consultation</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Consultation</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
						<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal">
  <i class='bx bx-plus'></i> Add Consultation
</button> -->


<!-- Modal -->
	<div class="modal fade" id="exampleVerticallycenteredModal" tabindex="-1" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">Add Consultation</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
													<div class="modal-body">
                              <form class="row g-3" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">

    <div class="col-md-12">
        <label for="inputAddress" class="form-label">Start Time</label>
        <input class="result form-control" type="text" id="date-time" name="start" placeholder="Date Picker..." value="<?php echo $start; ?>">
    </div>
    <div class="col-md-12">
        <label for="inputAddress" class="form-label">End time</label>
        <input class="result form-control" type="text" id="date-time" name="end" placeholder="Date Picker...">
    </div>
   

    <div class="col-12">
        <button type="submit" class="btn btn-primary px-5" name="register">Add</button>
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
			<div class="card-body">
						<div class="table-responsive">

<?php
$query = "SELECT * FROM ins_consult ic 
JOIN faculty_info fi ON ic.faculty_id = fi.faculty_id
JOIN consultation c ON c.ins_c_id = ic.ins_c_id WHERE c.stud_id = '$student_id' ";

$result = $con->query($query);

if ($result && $result->num_rows > 0) {
    echo '<table id="example2" class="table table-striped table-bordered">
            <thead>
                <tr>
				    <th>Faculty</th>
                    <th>Date</th>
                    <th>Start Time</th>
					<th>End Time</th>
		
					<th>Status</th>
                </tr>
            </thead>
            <tbody>';
while ($row = $result->fetch_assoc()) {
    $formattedDate = date("F j, Y", strtotime($row['date']));
    $formattedStartTime = date("h:i A", strtotime($row['starttime']));
    $formattedEndTime = date("h:i A", strtotime($row['endtime']));

    echo '<tr>
       <td>' . $row['first_name'] . ' ' . $row['last_name'] . '</td>
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