
<?php
include("sidebar.php");

if (isset($_POST['register'])) {
    // Retrieve form data
    $grade = $_POST['grade'];
    $strand = $_POST['strand'];
    $instructor = $_POST['faculty'];

 

    // Insert the data into the registration_data table
    $query = "INSERT INTO section (grade, strand, instructor) VALUES ('$grade', '$strand', '$instructor')";
    
    if (mysqli_query($con, $query)) {

        exit;
    } else {
        // There was an error inserting the data
        echo "Error: " . mysqli_error($con);
    }
}

?>
        
        
        <!--SIDEBAR -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Section</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Grade-12 TOURISM</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<!-- <div class="btn-group">
									<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal">
  <i class='bx bx-plus'></i> Add Section
</button> -->


<!-- Modal -->
	<div class="modal fade" id="exampleVerticallycenteredModal" tabindex="-1" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">Add Section</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
													<div class="modal-body">
  <form class="row g-3" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">


  
    <div class="col-md-12">
        <label for="inputEmail" class="form-label">Grade</label>
        <select class="form-select" id="inputGender" name="grade">
           <option value="11">Grade 11</option>
            <option value="12">Grade 12</option>
        </select>
    </div>
     <div class="col-md-12">
        <label for="inputEmail" class="form-label">Strand</label>
        <select class="form-select" id="inputGender" name="strand">
            <option value="">Select a Strand</option>
                 <?php
            
                    $query = "SELECT strand_id, strand FROM strand";
                    $result = mysqli_query($con, $query);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $strand_id = $row["strand_id"];
                            $strand = $row["strand"];
                            echo "<option value='$strand_id'>$strand</option>";
                        }
                    }

      
                    ?> 
        </select>
    </div>
     <div class="col-md-12">
        <label for="inputEmail" class="form-label">Instructor</label>
       
             <select class="form-select" id="inputGender" name="faculty">
               <option value="">Select Instructor</option>
                 <?php
            
                    $query = "SELECT * FROM faculty_info";
                    $result = mysqli_query($con, $query);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $fuculty_id = $row["faculty_id"];
                            $fname = $row["first_name"];
                               $lname = $row["last_name"];
                            echo "<option value='$fuculty_id'>$fname $lname</option>";
                        }
                    }

      
                    ?> 
        </select>
       
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
				<div class="col" id="success-notification" style="display: none;">
    <div class="alert alert-success" role="alert">
        <i class="bx bx-check-circle"></i> Registration Successful!
    </div>
</div>

				<!-- <h6 class="mb-0 text-uppercase">DataTable Import</h6> -->
				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
						<?php
// Assuming you have a database connection ($con) already established

// Create a SELECT query to fetch data from the "faculty_info," "section," and "strand" tables using INNER JOINs
$select_query = "SELECT faculty_info.first_name, faculty_info.last_name, section.strand, section.grade, strand.strand AS strand_name
                 FROM faculty_info
                 INNER JOIN section ON faculty_info.faculty_id = section.instructor
                 INNER JOIN strand ON section.strand = strand.strand_id";

// Execute the query
$result = $con->query($select_query);

// Check if the query was successful
if ($result) {
    // Display the table headers
    echo '<table id="example2" class="table table-striped table-bordered">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Student Name</th>';
    echo '<th>Student Number</th>';


    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // Fetch and display each row of data
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td> Juan Dela Cruz </td>';
        echo '<td> 2023123456 </td>';
 
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
} else {
    // Handle the case where the query was not successful
    echo 'Error executing the query: ' . $con->error;
}

// Close the database connection
$con->close();
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