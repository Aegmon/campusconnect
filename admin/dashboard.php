
<?php
include("sidebar.php");
?>
        
        
        <!--SIDEBAR -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
			
			  <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">
			  	<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">All Users</p>
										<h4 class="my-1"><?php echo $total_userdata; ?></h4>
									
									</div>
								<div class="widgets-icons bg-light-info text-info ms-auto"><i class='bx bxs-group'></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Students</p>
										<h4 class="my-1"><?php echo $total_students; ?></h4>
									
									</div>
								<div class="widgets-icons bg-success-info text-success ms-auto"><i class='bx bxs-group'></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Faculty</p>
										<h4 class="my-1"><?php echo $faculty_count; ?></h4>
									
									</div>
								<div class="widgets-icons bg-light-warning text-warning ms-auto"><i class='bx bxs-group'></i>
									</div>
								</div>
							</div>
						</div>
					</div>
						<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Online Students</p>
										<h4 class="my-1"><?php echo $online_count; ?></h4>
									
									</div>
								<div class="widgets-icons bg-light-danger text-danger ms-auto"><i class='bx bxs-group'></i>
									</div>
								</div>
							</div>
						</div>
					</div>
			  </div><!--end row-->
			  <h6 class="mb-0 text-uppercase">Student Per Section</h6>
				<hr/>
			  	<div class="row row-cols-1 row-cols-md-3 row-cols-xl-5">
				<?php

// Assuming you have established a database connection

$sql = "SELECT s.id, s.grade, st.strand, COUNT(ss.stud_id) AS student_count 
        FROM section s 
        INNER JOIN strand st ON s.strand = st.strand_id 
        LEFT JOIN section_student ss ON s.id = ss.section_id 
        GROUP BY s.id";

$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col">';
        echo '<div class="card radius-10">';
        echo '<div class="card-body">';
        echo '<div class="text-center">';
        echo '<div class="widgets-icons rounded-circle mx-auto bg-light-primary text-primary mb-3"><i class="bx bxs-group"></i></div>';
        echo '<h4 class="my-1">' . $row['student_count'] . '</h4>';
        echo '<p class="mb-0 text-secondary">' . 'Grade-' . $row['grade'] . ' ' . $row['strand'] . '</p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "0 results";
}



?>


				</div>
			  
			  <div class="row">
			    <div class="col-12 col-xl-8 d-flex">
				  <div class="card radius-10 w-100">
						<div class="card-body">
							<div class="" id="chart5"></div>
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
										<p class="mb-0">/<?php echo $total_userdata; ?> Students</p>
									</div>
									<div class="ms-auto d-flex align-items-center border radius-10 px-2">
									  <i class='bx bxs-checkbox font-22 me-1 text-primary'></i><span>Online</span>
									</div>
							  </div>
						</div>
					</div>
				</div>
				
			  </div>
			  	  <div class="row">
					    <div class="col-8">
						<div class="card">
							<div class="card-body">
								<div id="chart23"></div>
							</div>
						</div>
						  </div>
						    <div class="col-4">
							<div class="card">
							<div class="card-body">
								<div id="chart9"></div>
							</div>
						</div>
						  </div>
					  </div>
					    	  <div class="row">
								    <div class="col-12">
										<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Date</th>
										<th>Name</th>
										<th>Section</th>
										<th>Instructor</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>October 12,2023</td>
										<td>Juan tamad</td>
										<td>Grade-12 Tourism</td>
										<td>Juan Delacruz</td>
										<td>	<span class="badge bg-success">Completed</span></td>
										<td>	<button type="button" class="btn btn-sml btn-primary">View
										</button></td>
									</tr>
							
								</tbody>
							
							</table>
						</div>
					</div>
				</div>
								  </div>
								  </div>
              <!--end row-->


			  <!-- <div class="row row-cols-1 row-cols-xl-2">
				<div class="col d-flex">
					<div class="card radius-10 w-100">
						<div class="card-body">
							<div class="" id="chart7"></div>
						</div>
					</div>
				</div>
				<div class="col d-flex">
					<div class="card radius-10 w-100">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<h5 class="mb-1">Sales Report</h5>
								</div>
								<div class="font-22 ms-auto"><i class="bx bx-dots-horizontal-rounded"></i>
								</div>
							</div>
							<div class="" id="chart8"></div>
						</div>
					</div>
				</div>
			  </div> -->
              <!--end row-->

			  <!-- <div class="row">
				<div class="col-12 col-xl-4 col-xxl-3 d-flex">
					<div class="card radius-10 w-100 overflow-hidden">
						<div class="card-body">
							<p class="mb-1">Overall Sales Performance</p>
							<div class="">
								<h2 class="mb-0">$84,126.5</h2>
								<p class="mb-0 text-success">+2.5% vs last month</p>
							</div>
						</div>
						<div class="" id="chart9"></div>
					</div>
				</div>
				<div class="col-12 col-xl-8 col-xxl-9 d-flex">
					<div class="card w-100 radius-10">
						<div class="row g-0">
						  <div class="col-md-4 border-end">
							<div class="card-body">
							  <h5 class="card-title">Top Sales Locations</h5>
							  <h2 class="mt-4 mb-1">25.860 <i class="flag-icon flag-icon-us rounded"></i></h2>
							  <p class="mb-0 text-secondary">Our Most Customers in US</p>
							</div>
							<ul class="list-group mt-4 list-group-flush">
								<li class="list-group-item d-flex align-items-center">
								  <i class='bx bxs-circle me-1 text-success'></i>
								  <span>Massive</span>
								  <strong class="ms-auto">18.4k</strong>
								</li>
								<li class="list-group-item d-flex align-items-center">
								  <i class='bx bxs-circle me-1 text-danger'></i>
								  <span>Large</span>
								  <strong class="ms-auto">6.9k</strong>
								</li>
								<li class="list-group-item d-flex align-items-center">
								  <i class='bx bxs-circle me-1 text-primary'></i>
								  <span>Medium</span>
								  <strong class="ms-auto">5.4k</strong>
								</li>
								<li class="list-group-item d-flex align-items-center">
								  <i class='bx bxs-circle me-1 text-warning'></i>
								  <span>Small</span>
								  <strong class="ms-auto">875</strong>
								</li>
							</ul>
						  </div>
						  <div class="col-md-8">
							  <div class="p-3">
								<div class="" id="geographic-map"></div>
							  </div>
						  </div>
						</div>
					  </div>
				</div>
			  </div> -->
              <!--end row-->

			   <!-- <div class="row">
				 <div class="col-12 col-xl-4 d-flex">
					<div class="card radius-10 w-100">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<h5 class="mb-0">New Customers</h5>
								</div>
								<div class="font-22 ms-auto"><i class='bx bx-dots-horizontal-rounded'></i>
								</div>
							</div>
						</div>
						<div class="customers-list p-3 mb-3">
							<div class="customers-list-item d-flex align-items-center border-top border-bottom p-2 cursor-pointer">
								<div class="">
									<img src="assets/images/avatars/avatar-1.png" class="rounded-circle" width="46" height="46" alt="" />
								</div>
								<div class="ms-2">
									<h6 class="mb-1 font-14">Emy Jackson</h6>
									<p class="mb-0 font-13 text-secondary">emy_jac@xyz.com</p>
								</div>
								<div class="list-inline d-flex customers-contacts ms-auto">	<a href="javascript:;" class="list-inline-item"><i class='bx bxs-envelope'></i></a>
									<a href="javascript:;" class="list-inline-item"><i class='bx bxs-phone' ></i></a>
									<a href="javascript:;" class="list-inline-item"><i class='bx bx-dots-vertical-rounded'></i></a>
								</div>
							</div>
							<div class="customers-list-item d-flex align-items-center border-bottom p-2 cursor-pointer">
								<div class="">
									<img src="assets/images/avatars/avatar-2.png" class="rounded-circle" width="46" height="46" alt="" />
								</div>
								<div class="ms-2">
									<h6 class="mb-1 font-14">Martin Hughes</h6>
									<p class="mb-0 font-13 text-secondary">martin.hug@xyz.com</p>
								</div>
								<div class="list-inline d-flex customers-contacts ms-auto">	<a href="javascript:;" class="list-inline-item"><i class='bx bxs-envelope'></i></a>
									<a href="javascript:;" class="list-inline-item"><i class='bx bxs-phone' ></i></a>
									<a href="javascript:;" class="list-inline-item"><i class='bx bx-dots-vertical-rounded'></i></a>
								</div>
							</div>
							<div class="customers-list-item d-flex align-items-center border-bottom p-2 cursor-pointer">
								<div class="">
									<img src="assets/images/avatars/avatar-3.png" class="rounded-circle" width="46" height="46" alt="" />
								</div>
								<div class="ms-2">
									<h6 class="mb-1 font-14">Laura Madison</h6>
									<p class="mb-0 font-13 text-secondary">laura_01@xyz.com</p>
								</div>
								<div class="list-inline d-flex customers-contacts ms-auto">	<a href="javascript:;" class="list-inline-item"><i class='bx bxs-envelope'></i></a>
									<a href="javascript:;" class="list-inline-item"><i class='bx bxs-phone' ></i></a>
									<a href="javascript:;" class="list-inline-item"><i class='bx bx-dots-vertical-rounded'></i></a>
								</div>
							</div>
							<div class="customers-list-item d-flex align-items-center border-bottom p-2 cursor-pointer">
								<div class="">
									<img src="assets/images/avatars/avatar-4.png" class="rounded-circle" width="46" height="46" alt="" />
								</div>
								<div class="ms-2">
									<h6 class="mb-1 font-14">Shoan Stephen</h6>
									<p class="mb-0 font-13 text-secondary">s.stephen@xyz.com</p>
								</div>
								<div class="list-inline d-flex customers-contacts ms-auto">	<a href="javascript:;" class="list-inline-item"><i class='bx bxs-envelope'></i></a>
									<a href="javascript:;" class="list-inline-item"><i class='bx bxs-phone' ></i></a>
									<a href="javascript:;" class="list-inline-item"><i class='bx bx-dots-vertical-rounded'></i></a>
								</div>
							</div>
							<div class="customers-list-item d-flex align-items-center border-bottom p-2 cursor-pointer">
								<div class="">
									<img src="assets/images/avatars/avatar-5.png" class="rounded-circle" width="46" height="46" alt="" />
								</div>
								<div class="ms-2">
									<h6 class="mb-1 font-14">Keate Medona</h6>
									<p class="mb-0 font-13 text-secondary">Keate@xyz.com</p>
								</div>
								<div class="list-inline d-flex customers-contacts ms-auto">	<a href="javascript:;" class="list-inline-item"><i class='bx bxs-envelope'></i></a>
									<a href="javascript:;" class="list-inline-item"><i class='bx bxs-phone' ></i></a>
									<a href="javascript:;" class="list-inline-item"><i class='bx bx-dots-vertical-rounded'></i></a>
								</div>
							</div>
							<div class="customers-list-item d-flex align-items-center border-bottom p-2 cursor-pointer">
								<div class="">
									<img src="assets/images/avatars/avatar-6.png" class="rounded-circle" width="46" height="46" alt="" />
								</div>
								<div class="ms-2">
									<h6 class="mb-1 font-14">Paul Benn</h6>
									<p class="mb-0 font-13 text-secondary">pauly.b@xyz.com</p>
								</div>
								<div class="list-inline d-flex customers-contacts ms-auto">	<a href="javascript:;" class="list-inline-item"><i class='bx bxs-envelope'></i></a>
									<a href="javascript:;" class="list-inline-item"><i class='bx bxs-phone' ></i></a>
									<a href="javascript:;" class="list-inline-item"><i class='bx bx-dots-vertical-rounded'></i></a>
								</div>
							</div>
							<div class="customers-list-item d-flex align-items-center border-bottom p-2 cursor-pointer">
								<div class="">
									<img src="assets/images/avatars/avatar-7.png" class="rounded-circle" width="46" height="46" alt="" />
								</div>
								<div class="ms-2">
									<h6 class="mb-1 font-14">Winslet Maya</h6>
									<p class="mb-0 font-13 text-secondary">winslet_02@xyz.com</p>
								</div>
								<div class="list-inline d-flex customers-contacts ms-auto">	<a href="javascript:;" class="list-inline-item"><i class='bx bxs-envelope'></i></a>
									<a href="javascript:;" class="list-inline-item"><i class='bx bxs-phone' ></i></a>
									<a href="javascript:;" class="list-inline-item"><i class='bx bx-dots-vertical-rounded'></i></a>
								</div>
							</div>
							<div class="customers-list-item d-flex align-items-center border-bottom p-2 cursor-pointer">
								<div class="">
									<img src="assets/images/avatars/avatar-8.png" class="rounded-circle" width="46" height="46" alt="" />
								</div>
								<div class="ms-2">
									<h6 class="mb-1 font-14">Bruno Bernard</h6>
									<p class="mb-0 font-13 text-secondary">bruno.b@xyz.com</p>
								</div>
								<div class="list-inline d-flex customers-contacts ms-auto">	<a href="javascript:;" class="list-inline-item"><i class='bx bxs-envelope'></i></a>
									<a href="javascript:;" class="list-inline-item"><i class='bx bxs-phone' ></i></a>
									<a href="javascript:;" class="list-inline-item"><i class='bx bx-dots-vertical-rounded'></i></a>
								</div>
							</div>
							<div class="customers-list-item d-flex align-items-center border-bottom p-2 cursor-pointer">
								<div class="">
									<img src="assets/images/avatars/avatar-9.png" class="rounded-circle" width="46" height="46" alt="" />
								</div>
								<div class="ms-2">
									<h6 class="mb-1 font-14">Merlyn Dona</h6>
									<p class="mb-0 font-13 text-secondary">merlyn.d@xyz.com</p>
								</div>
								<div class="list-inline d-flex customers-contacts ms-auto">	<a href="javascript:;" class="list-inline-item"><i class='bx bxs-envelope'></i></a>
									<a href="javascript:;" class="list-inline-item"><i class='bx bxs-phone' ></i></a>
									<a href="javascript:;" class="list-inline-item"><i class='bx bx-dots-vertical-rounded'></i></a>
								</div>
							</div>
							<div class="customers-list-item d-flex align-items-center border-bottom p-2 cursor-pointer">
								<div class="">
									<img src="assets/images/avatars/avatar-10.png" class="rounded-circle" width="46" height="46" alt="" />
								</div>
								<div class="ms-2">
									<h6 class="mb-1 font-14">Alister Campel</h6>
									<p class="mb-0 font-13 text-secondary">alister_42@xyz.com</p>
								</div>
								<div class="list-inline d-flex customers-contacts ms-auto">	<a href="javascript:;" class="list-inline-item"><i class='bx bxs-envelope'></i></a>
									<a href="javascript:;" class="list-inline-item"><i class='bx bxs-phone' ></i></a>
									<a href="javascript:;" class="list-inline-item"><i class='bx bx-dots-vertical-rounded'></i></a>
								</div>
							</div>
						</div>
					</div>
				 </div>
				 <div class="col-12 col-xl-4 d-flex">
					<div class="card radius-10 w-100 overflow-hidden">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<h5 class="mb-0">Store Metrics</h5>
								</div>
								<div class="font-22 ms-auto"><i class='bx bx-dots-horizontal-rounded'></i>
								</div>
							</div>
						</div>

						<div class="store-metrics p-3 mb-3">
							
                            <div class="card mt-3 radius-10 border shadow-none">
								<div class="card-body">
                                    <div class="d-flex align-items-center">
										<div>
											<p class="mb-0 text-secondary">Total Products</p>
											<h4 class="mb-0">856</h4>
										</div>
										<div class="widgets-icons bg-light-primary text-primary ms-auto"><i class='bx bxs-shopping-bag' ></i>
										</div>
									</div>
								</div>
							</div>
							<div class="card radius-10 border shadow-none">
								<div class="card-body">
                                    <div class="d-flex align-items-center">
										<div>
											<p class="mb-0 text-secondary">Total Customers</p>
											<h4 class="mb-0">45,241</h4>
										</div>
										<div class="widgets-icons bg-light-danger text-danger ms-auto"><i class='bx bxs-group' ></i>
										</div>
									</div>
								</div>
							</div>
							<div class="card radius-10 border shadow-none">
								<div class="card-body">
                                    <div class="d-flex align-items-center">
										<div>
											<p class="mb-0 text-secondary">Total Categories</p>
											<h4 class="mb-0">98</h4>
										</div>
										<div class="widgets-icons bg-light-success text-success ms-auto"><i class='bx bxs-category' ></i>
										</div>
									</div>
								</div>
							</div>
							<div class="card radius-10 border shadow-none">
								<div class="card-body">
                                    <div class="d-flex align-items-center">
										<div>
											<p class="mb-0 text-secondary">Total Orders</p>
											<h4 class="mb-0">124</h4>
										</div>
										<div class="widgets-icons bg-light-info text-info ms-auto"><i class='bx bxs-cart-add' ></i>
										</div>
									</div>
								</div>
							</div>
							<div class="card radius-10 border shadow-none mb-0">
								<div class="card-body">
                                    <div class="d-flex align-items-center">
										<div>
											<p class="mb-0 text-secondary">Total Vendors</p>
											<h4 class="mb-0">55</h4>
										</div>
										<div class="widgets-icons bg-light-warning text-warning ms-auto"><i class='bx bxs-user-account' ></i>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				 </div>

				 <div class="col-12 col-xl-4 d-flex">
					<div class="card radius-10 w-100 ">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<h5 class="mb-1">Top Products</h5>
								</div>
								<div class="font-22 ms-auto"><i class="bx bx-dots-horizontal-rounded"></i>
								</div>
							</div>
						</div>

						<div class="product-list p-3 mb-3">

							 <div class="d-flex align-items-center py-3 border-bottom cursor-pointer">
								<div class="product-img me-2">
									 <img src="assets/images/products/01.png" alt="product img">
								  </div>
								<div class="">
									<h6 class="mb-0 font-14">Black Boost Chair</h6>
									<p class="mb-0">148 Sales</p>
								</div>
								<div class="ms-auto">
									<h6 class="mb-0">$246.24</h6>
								</div>
							  </div>
							 
							  <div class="d-flex align-items-center py-3 border-bottom cursor-pointer">
								<div class="product-img me-2">
									 <img src="assets/images/products/03.png" alt="product img">
								  </div>
								<div class="">
									<h6 class="mb-0 font-14">Red Single Sofa</h6>
									<p class="mb-0">122 Sales</p>
								</div>
								<div class="ms-auto">
									<h6 class="mb-0">$328.14</h6>
								</div>
							  </div>
							
							  <div class="d-flex align-items-center py-3 border-bottom cursor-pointer">
								<div class="product-img me-2">
									 <img src="assets/images/products/04.png" alt="product img">
								  </div>
								<div class="">
									<h6 class="mb-0 font-14">Pink Rounded Sofa</h6>
									<p class="mb-0">105 Sales</p>
								</div>
								<div class="ms-auto">
									<h6 class="mb-0">$124.35</h6>
								</div>
							  </div>
							 
							  <div class="d-flex align-items-center py-3 border-bottom cursor-pointer">
								<div class="product-img me-2">
									 <img src="assets/images/products/05.png" alt="product img">
								  </div>
								<div class="">
									<h6 class="mb-0 font-14">Brown Single Table</h6>
									<p class="mb-0">201 Sales</p>
								</div>
								<div class="ms-auto">
									<h6 class="mb-0">$158.34</h6>
								</div>
							  </div>
							  
							  <div class="d-flex align-items-center py-3 border-bottom cursor-pointer">
								<div class="product-img me-2">
									 <img src="assets/images/products/06.png" alt="product img">
								  </div>
								<div class="">
									<h6 class="mb-0 font-14">Grey Long Chair</h6>
									<p class="mb-0">146 Sales</p>
								</div>
								<div class="ms-auto">
									<h6 class="mb-0">158.24</h6>
								</div>
							  </div>
							  
							  <div class="d-flex align-items-center py-3 border-bottom cursor-pointer">
								<div class="product-img me-2">
									 <img src="assets/images/products/07.png" alt="product img">
								  </div>
								<div class="">
									<h6 class="mb-0 font-14">Beautiful Sofa</h6>
									<p class="mb-0">210 Sales</p>
								</div>
								<div class="ms-auto">
									<h6 class="mb-0">$520.24</h6>
								</div>
							  </div>
							 
							  <div class="d-flex align-items-center py-3 border-bottom cursor-pointer">
								<div class="product-img me-2">
									 <img src="assets/images/products/08.png" alt="product img">
								  </div>
								<div class="">
									<h6 class="mb-0 font-14">Grey Stand Table</h6>
									<p class="mb-0">115 Sales</p>
								</div>
								<div class="ms-auto">
									<h6 class="mb-0">$345.24</h6>
								</div>
							  </div>
							 
							  <div class="d-flex align-items-center py-3 border-bottom cursor-pointer">
								<div class="product-img me-2">
									 <img src="assets/images/products/09.png" alt="product img">
								  </div>
								<div class="">
									<h6 class="mb-0 font-14">Brown Single Table</h6>
									<p class="mb-0">116 Sales</p>
								</div>
								<div class="ms-auto">
									<h6 class="mb-0">$126.24</h6>
								</div>
							  </div>
							 
							  <div class="d-flex align-items-center py-3 border-bottom cursor-pointer">
								<div class="product-img me-2">
									 <img src="assets/images/products/10.png" alt="product img">
								  </div>
								<div class="">
									<h6 class="mb-0 font-14">Four Leg Chair</h6>
									<p class="mb-0">154 Sales</p>
								</div>
								<div class="ms-auto">
									<h6 class="mb-0">$425.24</h6>
								</div>
							  </div>
							 
							  <div class="d-flex align-items-center py-3 border-bottom cursor-pointer">
								<div class="product-img me-2">
									 <img src="assets/images/products/11.png" alt="product img">
								  </div>
								<div class="">
									<h6 class="mb-0 font-14">Blue Light T-Shirt</h6>
									<p class="mb-0">186 Sales</p>
								</div>
								<div class="ms-auto">
									<h6 class="mb-0">$149.34</h6>
								</div>
							  </div>
							 
						</div>
					</div>
				 </div>
				</div> -->
               <!-- end row  -->

				<!-- <div class="row">
					<div class="col">
						<div class="card radius-10 mb-0">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<h5 class="mb-1">Recent Orders</h5>
									</div>
									<div class="ms-auto">
										<a href="javscript:;" class="btn btn-primary btn-sm radius-30">View All Products</a>
									</div>
								</div>

                               <div class="table-responsive mt-3">
								   <table class="table align-middle mb-0">
									   <thead class="table-light">
										   <tr>
											   <th>Tracking ID</th>
											   <th>Products Name</th>
											   <th>Date</th>
											   <th>Status</th>
											   <th>Price</th>
											   <th>Actions</th>
										   </tr>
									   </thead>
									   <tbody>
										   <tr>
											   <td>#55879</td>
											   <td>
												<div class="d-flex align-items-center">
													<div class="recent-product-img">
														<img src="assets/images/products/15.png" alt="">
													</div>
													<div class="ms-2">
														<h6 class="mb-1 font-14">Light Red T-Shirt</h6>
													</div>
												</div>
											   </td>
											   <td>22 Jun, 2020</td>
											   <td class=""><span class="badge bg-light-success text-success w-100">Completed</span></td>
											   <td>#149.25</td>
											   <td>
												<div class="d-flex order-actions">	<a href="javascript:;" class="text-danger bg-light-danger border-0"><i class='bx bxs-trash'></i></a>
													<a href="javascript:;" class="ms-4 text-primary bg-light-primary border-0"><i class='bx bxs-edit' ></i></a>
												</div>
											   </td>
										   </tr>
										   <tr>
											<td>#88379</td>
											<td>
											 <div class="d-flex align-items-center">
												 <div class="recent-product-img">
													 <img src="assets/images/products/16.html" alt="">
												 </div>
												 <div class="ms-2">
													 <h6 class="mb-1 font-14">Grey Headphone</h6>
												 </div>
											 </div>
											</td>
											<td>22 Jun, 2020</td>
											<td class=""><span class="badge bg-light-danger text-danger w-100">Cancelled</span></td>
											<td>#149.25</td>
											<td>
												<div class="d-flex order-actions">	<a href="javascript:;" class="text-danger bg-light-danger border-0"><i class='bx bxs-trash'></i></a>
													<a href="javascript:;" class="ms-4 text-primary bg-light-primary border-0"><i class='bx bxs-edit' ></i></a>
												</div>
											</td>
										</tr>
										<tr>
											<td>#68823</td>
											<td>
											 <div class="d-flex align-items-center">
												 <div class="recent-product-img">
													 <img src="assets/images/products/19.png" alt="">
												 </div>
												 <div class="ms-2">
													 <h6 class="mb-1 font-14">Grey Hand Watch</h6>
												 </div>
											 </div>
											</td>
											<td>22 Jun, 2020</td>
											<td class=""><span class="badge bg-light-warning text-warning w-100">Pending</span></td>
											<td>#149.25</td>
											<td>
												<div class="d-flex order-actions">	<a href="javascript:;" class="text-danger bg-light-danger border-0"><i class='bx bxs-trash'></i></a>
													<a href="javascript:;" class="ms-4 text-primary bg-light-primary border-0"><i class='bx bxs-edit' ></i></a>
												</div>
											</td>
										</tr>
										<tr>
											<td>#54869</td>
											<td>
											 <div class="d-flex align-items-center">
												 <div class="recent-product-img">
													 <img src="assets/images/products/07.png" alt="">
												 </div>
												 <div class="ms-2">
													 <h6 class="mb-1 font-14">Brown Sofa</h6>
												 </div>
											 </div>
											</td>
											<td>22 Jun, 2020</td>
											<td class=""><span class="badge bg-light-success text-success w-100">Completed</span></td>
											<td>#149.25</td>
											<td>
												<div class="d-flex order-actions">	<a href="javascript:;" class="text-danger bg-light-danger border-0"><i class='bx bxs-trash'></i></a>
													<a href="javascript:;" class="ms-4 text-primary bg-light-primary border-0"><i class='bx bxs-edit' ></i></a>
												</div>
											</td>
										</tr>
										<tr>
											<td>#22536</td>
											<td>
											 <div class="d-flex align-items-center">
												 <div class="recent-product-img">
													 <img src="assets/images/products/17.png" alt="">
												 </div>
												 <div class="ms-2">
													 <h6 class="mb-1 font-14">Black iPhone 11</h6>
												 </div>
											 </div>
											</td>
											<td>22 Jun, 2020</td>
											<td class=""><span class="badge bg-light-success text-success w-100">Completed</span></td>
											<td>#149.25</td>
											<td>
												<div class="d-flex order-actions">	<a href="javascript:;" class="text-danger bg-light-danger border-0"><i class='bx bxs-trash'></i></a>
													<a href="javascript:;" class="ms-4 text-primary bg-light-primary border-0"><i class='bx bxs-edit' ></i></a>
												</div>
											</td>
										</tr>
										<tr>
											<td>#25796</td>
											<td>
											 <div class="d-flex align-items-center">
												 <div class="recent-product-img">
													 <img src="assets/images/products/14.png" alt="">
												 </div>
												 <div class="ms-2">
													 <h6 class="mb-1 font-14">Men Yellow T-Shirt</h6>
												 </div>
											 </div>
											</td>
											<td>22 Jun, 2020</td>
											<td class=""><span class="badge bg-light-warning text-warning w-100">Pending</span></td>
											<td>#149.25</td>
											<td>
												<div class="d-flex order-actions">	<a href="javascript:;" class="text-danger bg-light-danger border-0"><i class='bx bxs-trash'></i></a>
													<a href="javascript:;" class="ms-4 text-primary bg-light-primary border-0"><i class='bx bxs-edit' ></i></a>
												</div>
											</td>
										</tr>
										<tr>
											<td>#98754</td>
											<td>
											 <div class="d-flex align-items-center">
												 <div class="recent-product-img">
													 <img src="assets/images/products/08.png" alt="">
												 </div>
												 <div class="ms-2">
													 <h6 class="mb-1 font-14">Grey Stand Table</h6>
												 </div>
											 </div>
											</td>
											<td>22 Jun, 2020</td>
											<td class=""><span class="badge bg-light-danger text-danger w-100">Cancelled</span></td>
											<td>#149.25</td>
											<td>
												<div class="d-flex order-actions">	<a href="javascript:;" class="text-danger bg-light-danger border-0"><i class='bx bxs-trash'></i></a>
													<a href="javascript:;" class="ms-4 text-primary bg-light-primary border-0"><i class='bx bxs-edit' ></i></a>
												</div>
											</td>
										</tr>
									   </tbody>
								   </table>
							   </div>
								
							</div>
						</div>
					</div>
				</div> -->
                <!--end row-->
			
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
				
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
		} );
	</script>
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

var optionsLine = {
		chart: {
			foreColor: '#9ba7b2',
			height: 360,
			type: 'line',
			zoom: {
				enabled: false
			},
			dropShadow: {
				enabled: true,
				top: 3,
				left: 2,
				blur: 4,
				opacity: 0.1,
			}
		},
		stroke: {
			curve: 'smooth',
			width: 5
		},
		colors: ["#8833ff", '#29cc39'],
		series: [{
			name: "Student",
			data: [1, 15, 56, 20, 33, 27]
		}, {
			name: "Faculty",
			data: [30, 33, 21, 42, 19, 32]
		}],
		title: {
			text: 'Multiline Chart',
			align: 'left',
			offsetY: 25,
			offsetX: 20
		},
		subtitle: {
			text: 'Statistics',
			offsetY: 55,
			offsetX: 20
		},
		markers: {
			size: 4,
			strokeWidth: 0,
			hover: {
				size: 7
			}
		},
		grid: {
			show: true,
			padding: {
				bottom: 0
			}
		},
		labels: ['01/15/2002', '01/16/2002', '01/17/2002', '01/18/2002', '01/19/2002', '01/20/2002'],
		xaxis: {
			tooltip: {
				enabled: false
			}
		},
		legend: {
			position: 'top',
			horizontalAlign: 'right',
			offsetY: -20
		}
	}
	var chartLine = new ApexCharts(document.querySelector('#chart23'), optionsLine);
	chartLine.render();
var options = {
    series: [1, 55, 41],
    labels: ['Comments', 'Post', 'Replies'],
    chart: {
        foreColor: '#9ba7b2',
        height: 380,
        type: 'donut',
    },
    colors: ["#B366FF", "#5C00B8", "#FF8833"],
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                height: 320
            },
            legend: {
                position: 'bottom'
            }
        }
    }]
};
var chart = new ApexCharts(document.querySelector("#chart9"), options);
chart.render();

    </script>
</body>


<!-- Mirrored from codervent.com/synadmin/demo/vertical/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Aug 2023 12:58:58 GMT -->
</html>