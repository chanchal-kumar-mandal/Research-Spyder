<?php require_once(realpath(dirname(__FILE__)).'/' .'template_parts/header.php'); 
require_once(realpath(dirname(__FILE__)).'/' .'includes/query.php'); 
$users_admin = get_multiple_rows('tbl_user', '*', array('utype' => 1, 'status' => 'A'));
$users_standard = get_multiple_rows('tbl_user', '*', array('utype' => 2, 'status' => 'A'));
if(isset($_GET['del_id']) && ($_GET['del_id'] != '')){
delete_rows('tbl_user',array('id' => $_GET['del_id']));
header("Location:view_user");
}
?>
	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">User List</span>
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="index.html">Home</a></li>
					<li><a href="user_pages_profile.html">User</a></li>
					<li class="active">User List</li>
				</ul>
			</div>

			<div class="heading-elements">
				<div class="heading-btn-group">
					<a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
					<a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
					<a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>
				</div>
			</div>
		</div>
	</div>
	<!-- /page header -->

	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Main charts -->
				<div class="row">
				<div class="col-md-offset-3 col-md-6">
					<!-- Dropdown list -->
						<div class="panel panel-flat">
							<div class="panel-heading">
								<h5 class="panel-title">User list</h5>
								<div class="heading-elements">
									<ul class="icons-list">
				                		<li><a data-action="collapse"></a></li>
				                		<li><a data-action="reload"></a></li>
				                		<li><a data-action="close"></a></li>
				                	</ul>
			                	</div>
							</div>

							<div class="panel-body">
								<ul class="media-list">
									<li class="media-header">Administrators</li>

									<?php 
									
									foreach($users_admin as $uadmin){
									if($uadmin['id'] != $_SESSION['uid']){	
									$profile = $uadmin['profile'];
									$full_name = $uadmin['full_name'];
									$uname = $uadmin['uname'];
									if(isset($profile) && ($profile != '')){
										$src = UPLOAD_DIR.'profile/'.$profile;
									} else {
										$src = IMAGE_DIR.'placeholder.jpg';
									}
									$edit_link = SITE_URL.'user_create?uid='.$uadmin['id'];
									 ?>
										<li class="media">
											<div class="media-left media-middle">
												<a href="<?php echo $edit_link; ?>">
													<img src="<?php echo $src; ?>" class="img-circle" alt="">
												</a>
											</div>
	
											<div class="media-body">
												<div class="media-heading text-semibold"><?php echo $full_name; ?></div>
												<span class="text-muted"><?php echo $uname; ?></span>
											</div>
	
											<div class="media-right media-middle">
												<ul class="icons-list text-nowrap">
													<li class="dropdown">
														<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
	
														<ul class="dropdown-menu dropdown-menu-right">
															<li><a href="javascript:void(0);" data-toggle="modal" data-target="#call" onclick="editUser(<?php echo $uadmin['id']; ?>)"><i class="glyphicon glyphicon-edit text-warning"></i> Edit</a></li>
															<li><a href="javascript:void(0);" class="del_user" data-id="<?php echo $uadmin['id']; ?>" data-toggle="modal" data-target="#chat"><i class="glyphicon glyphicon-trash text-danger"></i> Delete</a></li>
														
														</ul>
													</li>
												</ul>
											</div>
										</li>
									<?php } } ?>
									

									<li class="media-header">Standard Users</li>
									
									<?php foreach($users_standard as $uadmin){
									if($uadmin['id'] != $_SESSION['uid']){	
									$profile = $uadmin['profile'];
									$full_name = $uadmin['full_name'];
									$uname = $uadmin['uname'];
									if(isset($profile) && ($profile != '')){
										$src = UPLOAD_DIR.'profile/'.$profile;
									} else {
										$src = IMAGE_DIR.'placeholder.jpg';
									}
									$edit_link = SITE_URL.'user_create?uid='.$uadmin['id'];
									 ?>
										<li class="media">
											<div class="media-left media-middle">
												<a href="<?php echo $edit_link; ?>">
													<img src="<?php echo $src; ?>" class="img-circle" alt="">
												</a>
											</div>
	
											<div class="media-body">
												<div class="media-heading text-semibold"><?php echo $full_name; ?></div>
												<span class="text-muted"><?php echo $uname; ?></span>
											</div>
	
											<div class="media-right media-middle">
												<ul class="icons-list text-nowrap">
													<li class="dropdown">
														<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
	
														<ul class="dropdown-menu dropdown-menu-right">
															<li><a href="javascript:void(0);>" data-toggle="modal" data-target="#call" onclick="editUser(<?php echo $uadmin['id']; ?>)"><i class="glyphicon glyphicon-edit text-warning"></i> Edit</a></li>
															<li><a href="javascript:void(0);" class="del_user" data-id="<?php echo $uadmin['id']; ?>" data-toggle="modal" data-target="#chat"><i class="glyphicon glyphicon-trash text-danger"></i> Delete</a></li>
															
														</ul>
													</li>
												</ul>
											</div>
										</li>
									<?php } } ?>
									
									
								</ul>
							</div>
						</div>
						<!-- /dropdown list -->
				</div>
				</div>
				<!-- /main charts -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->


		<?php require_once(realpath(dirname(__FILE__)).'/' .'template_parts/footer.php'); ?>
		
		<script>
		function editUser(id){
			window.location.href = "user_create?uid="+id;
		}

		$('.del_user').click(function(){
			var uid = $(this).attr('data-id');
			
			if(confirm('Do You Really Want to Delete This User?')){
				$(location).attr('href', '<?php echo SITE_URL."view_user?del_id=" ?>'+uid);
			}
		});
		</script>