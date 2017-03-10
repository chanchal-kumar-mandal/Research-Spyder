<?php
require_once(realpath(dirname(__FILE__)).'/' .'includes/connection.php');
require_once(realpath(dirname(__FILE__)).'/' .'template_parts/header.php');

$resultWidgets = $conn->query("SELECT * FROM widgets");
?>
	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Account</span> - Settings
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="dashboard">Home</a></li>
					<li class="active"><a href="account_settings">Account Settings</a></li>
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
					<div class="col-lg-6 col-lg-offset-3">
						<!-- Profile info -->
						<div class="panel panel-flat">
							<div class="panel-heading">
								<h6 class="text-semibold">Account Settings</h6>
								<div class="heading-elements">
									<ul class="icons-list">
				                		<li><a data-action="collapse"></a></li>
				                		<li><a data-action="reload"></a></li>
				                		<li><a data-action="close"></a></li>
				                	</ul>
			                	</div>
							</div>
							<div class="panel-body">
							<?php if(check_menu_access('upload_logo')){?>
								<div class="">
									<a href="upload_logo" class="btn btn-primary"><i class="glyphicon glyphicon-dashboard"></i> Upload Dashboard Logo</a>
								</div>
							<?php }?>
							</div>
						</div>
						<!-- /profile info -->
					</div>
				</div>
				<!-- /main charts -->
			</div>
			<!-- /main content -->
		</div>
		<!-- /page content -->

<?php
require_once(realpath(dirname(__FILE__)).'/' .'template_parts/footer.php');
?>