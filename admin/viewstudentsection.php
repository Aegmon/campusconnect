
<?php
include("sidebar.php");
$section_id = $_GET['id'];

$select_query = "SELECT *
                 FROM section
                 INNER JOIN strand ON section.strand = strand.strand_id WHERE section.id = '$section_id'";

// Execute the query
$result = $con->query($select_query);
$row = $result->fetch_assoc();
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
								<li class="breadcrumb-item active" aria-current="page">Grade-<?php echo $row['grade'];?> <?php echo $row['strand'];?></li>
							</ol>
						</nav>
					</div>
				
					</div>
				</div>


				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
					<?php

$query = "SELECT s.fname, s.lname, s.student_number, s.birthdate, sec.grade, st.strand
          FROM student s
          JOIN section_student ss ON s.stud_id = ss.stud_id
          JOIN section sec ON ss.section_id = sec.id
          JOIN strand st ON sec.strand = st.strand_id WHERE ss.section_id = '$section_id'";

$result = $con->query($query);

if ($result && $result->num_rows > 0) {
    echo '<table id="example2" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Student Number</th>
                  
                    <th>Birthday</th>
			
                </tr>
            </thead>
            <tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>' . $row['fname'] . ' ' . $row['lname'] . '</td>
                <td>' . $row['student_number'] . '</td>
        
                <td>' . $row['birthdate'] . '</td>
				    
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