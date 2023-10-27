
<?php
include("sidebar.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    // Handle form submission
   $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $birthdate = $_POST['birthday'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $email = $_POST['email'];
	    $student_number = $_POST['student_number'];
    $password = 'pass123';

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

 
    // Image upload handling
    $image_upload_dir = '../img/'; // Directory where images will be stored
    $image_name = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];

    // Check if an image was uploaded
    if (!empty($image_name)) {
        $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
        $allowed_extensions = array('jpg', 'jpeg', 'png');

        // Check if the uploaded file has a valid image extension
        if (in_array($image_extension, $allowed_extensions)) {
            $image_destination = $image_upload_dir . $image_name;

            // Move the uploaded image to the destination folder
            if (move_uploaded_file($image_tmp_name, $image_destination)) {
                // Insert data into 'userdata' table
        $insert_userdata_query = "INSERT INTO userdata (email, password, usertype) VALUES (?, ?, ?)";
$usertype = 'student'; // assuming the usertype is hardcoded as 'student'
$stmt = $con->prepare($insert_userdata_query);
$stmt->bind_param("sss", $email, $hashed_password, $usertype);
$stmt->execute();
  
                $userID = $stmt->insert_id;

        
               $insert_student_query = "INSERT INTO student (student_number, fname, lname, birthdate, gender, address, image, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $con->prepare($insert_student_query);
$stmt->bind_param("sssssssi", $student_number, $first_name, $last_name, $birthday, $gender, $address, $image_destination, $userID);
$stmt->execute();
  
            } else {
                echo "Failed to move the uploaded image.";
            }
        } else {
            echo "Invalid image file format. Allowed formats: jpg, jpeg, png.";
        }
    } else {
     
     $insert_userdata_query = "INSERT INTO userdata (email, password, usertype) VALUES (?, ?, ?)";
$usertype = 'student'; // assuming the usertype is hardcoded as 'student'
$stmt = $con->prepare($insert_userdata_query);
$stmt->bind_param("sss", $email, $hashed_password, $usertype);
$stmt->execute();

        // Get the userID generated for the new user
        $userID = $stmt->insert_id;

 $insert_student_query = "INSERT INTO student (student_number, fname, lname, birthdate, gender, address, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $con->prepare($insert_student_query);
$stmt->bind_param("ssssssi", $student_number, $first_name, $last_name, $birthday, $gender, $address, $userID);
$stmt->execute();
  
    }

    // Close the database connection

}
?>

        
        
        <!--SIDEBAR -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Users</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Users</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal">
  <i class='bx bx-plus'></i> Add Students
</button>
					</div>
				</div>

<!-- Modal -->
	<div class="modal fade" id="exampleVerticallycenteredModal" tabindex="-1" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">Student</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
													<div class="modal-body">
                               
                                                 <h1>Successfully Added!</h1>
                                                    </div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
										
													</div>
												</div>
											</div>
										</div>
<!-- Modal End -->





				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
		<?php

$query = "SELECT s.fname, s.lname, s.student_number, s.birthdate, sec.grade, st.strand
          FROM student s
          JOIN section_student ss ON s.stud_id = ss.stud_id
          JOIN section sec ON ss.section_id = sec.id
          JOIN strand st ON sec.strand = st.strand_id";

$result = $con->query($query);

if ($result && $result->num_rows > 0) {
    echo '<table id="example2" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Student Number</th>
                    <th>Grade</th>
                    <th>Strand</th>
                    <th>Birthday</th>
					    <th>Action</th>
                </tr>
            </thead>
            <tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>' . $row['fname'] . ' ' . $row['lname'] . '</td>
                <td>' . $row['student_number'] . '</td>
                <td>' . $row['grade'] . '</td>
                <td>' . $row['strand'] . '</td>
                <td>' . $row['birthdate'] . '</td>
				        <td>		<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal">
  <i class="bx bx-plus"></i> Accept
</button></td>
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