
<?php
include("sidebar.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    // Handle form submission
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $password = $_POST['password'];

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
                $insert_userdata_query = "INSERT INTO userdata (email, password) VALUES (?, ?)";
                $stmt = $con->prepare($insert_userdata_query);
                $stmt->bind_param("ss", $email, $hashed_password);
                $stmt->execute();

                // Get the userID generated for the new user
                $userID = $stmt->insert_id;

                // Insert data into 'faculty_info' table, including the image path
                $insert_faculty_info_query = "INSERT INTO faculty_info (userID, first_name, last_name, birthday, gender, address, image) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $con->prepare($insert_faculty_info_query);
                $stmt->bind_param("issssss", $userID, $first_name, $last_name, $birthday, $gender, $address, $image_destination);
                $stmt->execute();
  
            } else {
                echo "Failed to move the uploaded image.";
            }
        } else {
            echo "Invalid image file format. Allowed formats: jpg, jpeg, png.";
        }
    } else {
        // If no image was uploaded, insert data into 'userdata' and 'faculty_info' without the image path
        $insert_userdata_query = "INSERT INTO userdata (email, password) VALUES (?, ?)";
        $stmt = $con->prepare($insert_userdata_query);
        $stmt->bind_param("ss", $email, $hashed_password);
        $stmt->execute();

        // Get the userID generated for the new user
        $userID = $stmt->insert_id;

        // Insert data into 'faculty_info' table without the image path
        $insert_faculty_info_query = "INSERT INTO faculty_info (userID, first_name, last_name, birthday, gender, address) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($insert_faculty_info_query);
        $stmt->bind_param("isssss", $userID, $first_name, $last_name, $birthday, $gender, $address);
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
					<div class="breadcrumb-title pe-3">Faculty</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Faculty</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
						<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal">
  <i class='bx bx-plus'></i> Add Faculty
</button>


<!-- Modal -->
	<div class="modal fade" id="exampleVerticallycenteredModal" tabindex="-1" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">Add Faculty</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
													<div class="modal-body">
                                <form class="row g-3" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
    <div class="col-md-6">
        <label for="inputFirstName" class="form-label">First Name</label>
        <input type="text" class="form-control" id="inputFirstName" name="first_name">
    </div>
    <div class="col-md-6">
        <label for="inputLastName" class="form-label">Last Name</label>
        <input type="text" class="form-control" id="inputLastName" name="last_name">
    </div>
    <div class="col-md-6">
        <label for="inputEmail" class="form-label">Birthday</label>
        <input type="date" class="form-control" id="inputEmail" name="birthday">
    </div>
    <div class="col-md-6">
        <label for="inputEmail" class="form-label">Gender</label>
        <select class="form-select" id="inputGender" name="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
    </div>
    <div class="col-md-12">
        <label for="inputAddress" class="form-label">Address</label>
        <input type="text" class="form-control" id="inputAddress" name="address">
    </div>
   <div class="col-md-12">
        <label for="inputImage" class="form-label">Image (Only .jpg, .jpeg, .png)</label>
        <input type="file" class="form-control" id="inputImage" name="image" accept=".jpg, .jpeg, .png">
          </div>
 <div class="col-md-12">
        <label for="inputEmail" class="form-label">Email</label>
        <input type="email" class="form-control" id="inputEmail" name="email">
    </div>
    <div class="col-md-6">
        <input type="hidden" class="form-control" id="inputPassword" name="password" value="Pass@123">
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary px-5" name="register">Register</button>
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
// Assuming you have a database connection ($con) already established

// Create a SELECT query to fetch data from the "faculty_info" table
$select_query = "SELECT first_name, last_name, birthday, address FROM faculty_info";

// Execute the query
$result = $con->query($select_query);

// Check if the query was successful
if ($result) {
    // Display the table headers
    echo '<table id="example2" class="table table-striped table-bordered">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Name</th>';
    echo '<th>Birthday</th>';
    echo '<th>Age</th>';
    echo '<th>Address</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // Fetch and display each row of data
    while ($row = $result->fetch_assoc()) {
        // Calculate age based on the birthday
        $birthday = new DateTime($row['birthday']);
        $currentDate = new DateTime();
        $age = $currentDate->diff($birthday)->y;

        echo '<tr>';
        echo '<td>' . $row['first_name'] . ' ' . $row['last_name'] . '</td>';
        echo '<td>' . $row['birthday'] . '</td>';
        echo '<td>' . $age . '</td>';
        echo '<td>' . $row['address'] . '</td>';
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