<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Limitless - Responsive Web Application Kit by Eugene Kopyov</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/ui/nicescroll.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/ui/drilldown.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script type="text/javascript" src="assets/js/pages/user_pages_list.js"></script>
	<!-- /theme JS files -->

</head>

<body>

	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.html"><img src="assets/images/logo_light.png" alt=""></a>

			<ul class="nav navbar-nav pull-right visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-git-compare"></i>
						<span class="visible-xs-inline-block position-right">Git updates</span>
						<span class="badge bg-warning-400">9</span>
					</a>
					
					<div class="dropdown-menu dropdown-content">
						<div class="dropdown-content-heading">
							Git updates
							<ul class="icons-list">
								<li><a href="#"><i class="icon-sync"></i></a></li>
							</ul>
						</div>

						<ul class="media-list dropdown-content-body width-350">
							<li class="media">
								<div class="media-left">
									<a href="#" class="btn border-primary text-primary btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-pull-request"></i></a>
								</div>

								<div class="media-body">
									Drop the IE <a href="#">specific hacks</a> for temporal inputs
									<div class="media-annotation">4 minutes ago</div>
								</div>
							</li>

							<li class="media">
								<div class="media-left">
									<a href="#" class="btn border-warning text-warning btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-commit"></i></a>
								</div>
								
								<div class="media-body">
									Add full font overrides for popovers and tooltips
									<div class="media-annotation">36 minutes ago</div>
								</div>
							</li>

							<li class="media">
								<div class="media-left">
									<a href="#" class="btn border-info text-info btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-branch"></i></a>
								</div>
								
								<div class="media-body">
									<a href="#">Chris Arney</a> created a new <span class="text-semibold">Design</span> branch
									<div class="media-annotation">2 hours ago</div>
								</div>
							</li>

							<li class="media">
								<div class="media-left">
									<a href="#" class="btn border-success text-success btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-merge"></i></a>
								</div>
								
								<div class="media-body">
									<a href="#">Eugene Kopyov</a> merged <span class="text-semibold">Master</span> and <span class="text-semibold">Dev</span> branches
									<div class="media-annotation">Dec 18, 18:36</div>
								</div>
							</li>

							<li class="media">
								<div class="media-left">
									<a href="#" class="btn border-primary text-primary btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-pull-request"></i></a>
								</div>
								
								<div class="media-body">
									Have Carousel ignore keyboard events
									<div class="media-annotation">Dec 12, 05:46</div>
								</div>
							</li>
						</ul>

						<div class="dropdown-content-footer">
							<a href="#" data-popup="tooltip" title="All activity"><i class="icon-menu display-block"></i></a>
						</div>
					</div>
				</li>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-people"></i>
						<span class="visible-xs-inline-block position-right">Users</span>
					</a>
					
					<div class="dropdown-menu dropdown-content">
						<div class="dropdown-content-heading">
							Users online
							<ul class="icons-list">
								<li><a href="#"><i class="icon-gear"></i></a></li>
							</ul>
						</div>

						<ul class="media-list dropdown-content-body width-300">
							<li class="media">
								<div class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
								<div class="media-body">
									<a href="#" class="media-heading text-semibold">Jordana Ansley</a>
									<span class="display-block text-muted text-size-small">Lead web developer</span>
								</div>
								<div class="media-right media-middle"><span class="status-mark border-success"></span></div>
							</li>

							<li class="media">
								<div class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
								<div class="media-body">
									<a href="#" class="media-heading text-semibold">Will Brason</a>
									<span class="display-block text-muted text-size-small">Marketing manager</span>
								</div>
								<div class="media-right media-middle"><span class="status-mark border-danger"></span></div>
							</li>

							<li class="media">
								<div class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
								<div class="media-body">
									<a href="#" class="media-heading text-semibold">Hanna Walden</a>
									<span class="display-block text-muted text-size-small">Project manager</span>
								</div>
								<div class="media-right media-middle"><span class="status-mark border-success"></span></div>
							</li>

							<li class="media">
								<div class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
								<div class="media-body">
									<a href="#" class="media-heading text-semibold">Dori Laperriere</a>
									<span class="display-block text-muted text-size-small">Business developer</span>
								</div>
								<div class="media-right media-middle"><span class="status-mark border-warning-300"></span></div>
							</li>

							<li class="media">
								<div class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
								<div class="media-body">
									<a href="#" class="media-heading text-semibold">Vanessa Aurelius</a>
									<span class="display-block text-muted text-size-small">UX expert</span>
								</div>
								<div class="media-right media-middle"><span class="status-mark border-grey-400"></span></div>
							</li>
						</ul>

						<div class="dropdown-content-footer">
							<a href="#" data-popup="tooltip" title="All users"><i class="icon-menu display-block"></i></a>
						</div>
					</div>
				</li>
			</ul>

			<p class="navbar-text"><span class="label bg-success-400">Online</span></p>

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown language-switch">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<img src="assets/images/flags/gb.png" class="position-left" alt="">
						English
						<span class="caret"></span>
					</a>

					<ul class="dropdown-menu">
						<li><a class="deutsch"><img src="assets/images/flags/de.png" alt=""> Deutsch</a></li>
						<li><a class="ukrainian"><img src="assets/images/flags/ua.png" alt=""> Українська</a></li>
						<li><a class="english"><img src="assets/images/flags/gb.png" alt=""> English</a></li>
						<li><a class="espana"><img src="assets/images/flags/es.png" alt=""> España</a></li>
						<li><a class="russian"><img src="assets/images/flags/ru.png" alt=""> Русский</a></li>
					</ul>
				</li>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-bubbles4"></i>
						<span class="visible-xs-inline-block position-right">Messages</span>
						<span class="badge bg-warning-400">2</span>
					</a>
					
					<div class="dropdown-menu dropdown-content width-350">
						<div class="dropdown-content-heading">
							Messages
							<ul class="icons-list">
								<li><a href="#"><i class="icon-compose"></i></a></li>
							</ul>
						</div>

						<ul class="media-list dropdown-content-body">
							<li class="media">
								<div class="media-left">
									<img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt="">
									<span class="badge bg-danger-400 media-badge">5</span>
								</div>

								<div class="media-body">
									<a href="#" class="media-heading">
										<span class="text-semibold">James Alexander</span>
										<span class="media-annotation pull-right">04:58</span>
									</a>

									<span class="text-muted">who knows, maybe that would be the best thing for me...</span>
								</div>
							</li>

							<li class="media">
								<div class="media-left">
									<img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt="">
									<span class="badge bg-danger-400 media-badge">4</span>
								</div>

								<div class="media-body">
									<a href="#" class="media-heading">
										<span class="text-semibold">Margo Baker</span>
										<span class="media-annotation pull-right">12:16</span>
									</a>

									<span class="text-muted">That was something he was unable to do because...</span>
								</div>
							</li>

							<li class="media">
								<div class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
								<div class="media-body">
									<a href="#" class="media-heading">
										<span class="text-semibold">Jeremy Victorino</span>
										<span class="media-annotation pull-right">22:48</span>
									</a>

									<span class="text-muted">But that would be extremely strained and suspicious...</span>
								</div>
							</li>

							<li class="media">
								<div class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
								<div class="media-body">
									<a href="#" class="media-heading">
										<span class="text-semibold">Beatrix Diaz</span>
										<span class="media-annotation pull-right">Tue</span>
									</a>

									<span class="text-muted">What a strenuous career it is that I've chosen...</span>
								</div>
							</li>

							<li class="media">
								<div class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
								<div class="media-body">
									<a href="#" class="media-heading">
										<span class="text-semibold">Richard Vango</span>
										<span class="media-annotation pull-right">Mon</span>
									</a>
									
									<span class="text-muted">Other travelling salesmen live a life of luxury...</span>
								</div>
							</li>
						</ul>

						<div class="dropdown-content-footer">
							<a href="#" data-popup="tooltip" title="All messages"><i class="icon-menu display-block"></i></a>
						</div>
					</div>
				</li>

				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<img src="assets/images/placeholder.jpg" alt="">
						<span>Victoria</span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="#"><i class="icon-user-plus"></i> My profile</a></li>
						<li><a href="#"><i class="icon-coins"></i> My balance</a></li>
						<li><a href="#"><span class="badge badge-warning pull-right">58</span> <i class="icon-comment-discussion"></i> Messages</a></li>
						<li class="divider"></li>
						<li><a href="#"><i class="icon-cog5"></i> Account settings</a></li>
						<li><a href="#"><i class="icon-switch2"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Second navbar -->
	<div class="navbar navbar-default" id="navbar-second">
		<ul class="nav navbar-nav no-border visible-xs-block">
			<li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-second-toggle"><i class="icon-menu7"></i></a></li>
		</ul>

		<div class="navbar-collapse collapse" id="navbar-second-toggle">
			<ul class="nav navbar-nav">
				<li class="active"><a href="dashboard.php"><i class="icon-display4 position-left"></i> Dashboard</a></li>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-strategy position-left"></i> Users <span class="caret"></span>
					</a>

					<ul class="dropdown-menu width-200">
						<li class="dropdown-header">Manage Users</li>
						<li><a href="user_create.php"><i class="icon-align-center-horizontal"></i> Create User</a></li>
						<li><a href="starters/layout_sidebar_sticky.html"><i class="icon-flip-vertical3"></i> View Users</a></li>
						<li><a href="starters/layout_sidebar_sticky.html"><i class="icon-flip-vertical3"></i> Delete User</a></li>
					</ul>
				</li>

			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="changelog.html">
						<i class="icon-history position-left"></i>
						Changelog
						<span class="label label-inline position-right bg-success-400">1.2.1</span>
					</a>
				</li>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-cog3"></i>
						<span class="visible-xs-inline-block position-right">Share</span>
						<span class="caret"></span>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="#"><i class="icon-user-lock"></i> Account security</a></li>
						<li><a href="#"><i class="icon-statistics"></i> Analytics</a></li>
						<li><a href="#"><i class="icon-accessibility"></i> Accessibility</a></li>
						<li class="divider"></li>
						<li><a href="#"><i class="icon-gear"></i> All settings</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!-- /second navbar -->


	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">User Profile</span> - Create
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="index.html">Home</a></li>
					<li><a href="user_pages_profile.html">User</a></li>
					<li class="active">Create User</li>
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
								<h5 class="panel-title">Dropdown list</h5>
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

									<li class="media">
										<div class="media-left media-middle">
											<a href="#">
												<img src="assets/images/placeholder.jpg" class="img-circle" alt="">
											</a>
										</div>

										<div class="media-body">
											<div class="media-heading text-semibold">James Alexander</div>
											<span class="text-muted">Development</span>
										</div>

										<div class="media-right media-middle">
											<ul class="icons-list text-nowrap">
						                    	<li class="dropdown">
						                    		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>

						                    		<ul class="dropdown-menu dropdown-menu-right">
								                    	<li><a href="#" data-toggle="modal" data-target="#call"><i class="icon-phone2"></i> Edit</a></li>
								                    	<li><a href="#" data-toggle="modal" data-target="#chat"><i class="icon-comment"></i> Delete</a></li>
								                    	<li><a href="#" data-toggle="modal" data-target="#video"><i class="icon-video-camera"></i> Video call</a></li>
						                    		</ul>
						                    	</li>
					                    	</ul>
										</div>
									</li>

									<li class="media">
										<div class="media-left media-middle">
											<a href="#">
												<img src="assets/images/placeholder.jpg" class="img-circle" alt="">
											</a>
										</div>

										<div class="media-body">
											<div class="media-heading text-semibold">Jeremy Victorino</div>
											<span class="text-muted">Finances</span>
										</div>

										<div class="media-right media-middle">
											<ul class="icons-list text-nowrap">
						                    	<li class="dropdown">
						                    		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>

						                    		<ul class="dropdown-menu dropdown-menu-right">
								                    	<li><a href="#" data-toggle="modal" data-target="#call"><i class="icon-phone2"></i> Make a call</a></li>
								                    	<li><a href="#" data-toggle="modal" data-target="#chat"><i class="icon-comment"></i> Start chat</a></li>
								                    	<li><a href="#" data-toggle="modal" data-target="#video"><i class="icon-video-camera"></i> Video call</a></li>
						                    		</ul>
						                    	</li>
					                    	</ul>
										</div>
									</li>

									<li class="media">
										<div class="media-left media-middle">
											<a href="#">
												<img src="assets/images/placeholder.jpg" class="img-circle" alt="">
											</a>
										</div>

										<div class="media-body">
											<div class="media-heading text-semibold">Margo Baker</div>
											<span class="text-muted">Marketing</span>
										</div>

										<div class="media-right media-middle">
											<ul class="icons-list text-nowrap">
						                    	<li class="dropdown">
						                    		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>

						                    		<ul class="dropdown-menu dropdown-menu-right">
								                    	<li><a href="#" data-toggle="modal" data-target="#call"><i class="icon-phone2"></i> Make a call</a></li>
								                    	<li><a href="#" data-toggle="modal" data-target="#chat"><i class="icon-comment"></i> Start chat</a></li>
								                    	<li><a href="#" data-toggle="modal" data-target="#video"><i class="icon-video-camera"></i> Video call</a></li>
						                    		</ul>
						                    	</li>
					                    	</ul>
										</div>
									</li>

									<li class="media">
										<div class="media-left media-middle">
											<a href="#">
												<img src="assets/images/placeholder.jpg" class="img-circle" alt="">
											</a>
										</div>

										<div class="media-body">
											<div class="media-heading text-semibold">Monica Smith</div>
											<span class="text-muted">Design</span>
										</div>

										<div class="media-right media-middle">
											<ul class="icons-list text-nowrap">
						                    	<li class="dropdown">
						                    		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>

						                    		<ul class="dropdown-menu dropdown-menu-right">
								                    	<li><a href="#" data-toggle="modal" data-target="#call"><i class="icon-phone2"></i> Make a call</a></li>
								                    	<li><a href="#" data-toggle="modal" data-target="#chat"><i class="icon-comment"></i> Start chat</a></li>
								                    	<li><a href="#" data-toggle="modal" data-target="#video"><i class="icon-video-camera"></i> Video call</a></li>
						                    		</ul>
						                    	</li>
					                    	</ul>
										</div>
									</li>

									<li class="media-header">Standard Users</li>

									<li class="media">
										<div class="media-left media-middle">
											<a href="#">
												<img src="assets/images/placeholder.jpg" class="img-circle" alt="">
											</a>
										</div>

										<div class="media-body">
											<div class="media-heading text-semibold">Bastian Miller</div>
											<span class="text-muted">Web dev</span>
										</div>

										<div class="media-right media-middle">
											<ul class="icons-list text-nowrap">
						                    	<li class="dropdown">
						                    		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>

						                    		<ul class="dropdown-menu dropdown-menu-right">
								                    	<li><a href="#" data-toggle="modal" data-target="#call"><i class="icon-phone2"></i> Edit</a></li>
								                    	<li><a href="#" data-toggle="modal" data-target="#chat"><i class="icon-comment"></i> Delete</a></li>
								                    	<li><a href="#" data-toggle="modal" data-target="#video"><i class="icon-video-camera"></i> Video call</a></li>
						                    		</ul>
						                    	</li>
					                    	</ul>
										</div>
									</li>

									<li class="media">
										<div class="media-left media-middle">
											<a href="#">
												<img src="assets/images/placeholder.jpg" class="img-circle" alt="">
											</a>
										</div>

										<div class="media-body">
											<div class="media-heading text-semibold">Jordana Mills</div>
											<span class="text-muted">Sales consultant</span>
										</div>

										<div class="media-right media-middle">
											<ul class="icons-list text-nowrap">
						                    	<li class="dropdown">
						                    		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>

						                    		<ul class="dropdown-menu dropdown-menu-right">
								                    	<li><a href="#" data-toggle="modal" data-target="#call"><i class="icon-phone2"></i> Make a call</a></li>
								                    	<li><a href="#" data-toggle="modal" data-target="#chat"><i class="icon-comment"></i> Start chat</a></li>
								                    	<li><a href="#" data-toggle="modal" data-target="#video"><i class="icon-video-camera"></i> Video call</a></li>
						                    		</ul>
						                    	</li>
					                    	</ul>
										</div>
									</li>

									<li class="media">
										<div class="media-left media-middle">
											<a href="#">
												<img src="assets/images/placeholder.jpg" class="img-circle" alt="">
											</a>
										</div>

										<div class="media-body">
											<div class="media-heading text-semibold">Buzz Brenson</div>
											<span class="text-muted">UX expert</span>
										</div>

										<div class="media-right media-middle">
											<ul class="icons-list text-nowrap">
						                    	<li class="dropdown">
						                    		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>

						                    		<ul class="dropdown-menu dropdown-menu-right">
								                    	<li><a href="#" data-toggle="modal" data-target="#call"><i class="icon-phone2"></i> Make a call</a></li>
								                    	<li><a href="#" data-toggle="modal" data-target="#chat"><i class="icon-comment"></i> Start chat</a></li>
								                    	<li><a href="#" data-toggle="modal" data-target="#video"><i class="icon-video-camera"></i> Video call</a></li>
						                    		</ul>
						                    	</li>
					                    	</ul>
										</div>
									</li>

									<li class="media">
										<div class="media-left media-middle">
											<a href="#">
												<img src="assets/images/placeholder.jpg" class="img-circle" alt="">
											</a>
										</div>

										<div class="media-body">
											<div class="media-heading text-semibold">Zachary Willson</div>
											<span class="text-muted">Illustrator</span>
										</div>

										<div class="media-right media-middle">
											<ul class="icons-list text-nowrap">
						                    	<li class="dropdown">
						                    		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>

						                    		<ul class="dropdown-menu dropdown-menu-right">
								                    	<li><a href="#" data-toggle="modal" data-target="#call"><i class="icon-phone2"></i> Make a call</a></li>
								                    	<li><a href="#" data-toggle="modal" data-target="#chat"><i class="icon-comment"></i> Start chat</a></li>
								                    	<li><a href="#" data-toggle="modal" data-target="#video"><i class="icon-video-camera"></i> Video call</a></li>
						                    		</ul>
						                    	</li>
					                    	</ul>
										</div>
									</li>

									<li class="media">
										<div class="media-left media-middle">
											<a href="#">
												<img src="assets/images/placeholder.jpg" class="img-circle" alt="">
											</a>
										</div>

										<div class="media-body">
											<div class="media-heading text-semibold">William Miles</div>
											<span class="text-muted">SEO expert</span>
										</div>

										<div class="media-right media-middle">
											<ul class="icons-list text-nowrap">
						                    	<li class="dropdown">
						                    		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>

						                    		<ul class="dropdown-menu dropdown-menu-right">
								                    	<li><a href="#" data-toggle="modal" data-target="#call"><i class="icon-phone2"></i> Make a call</a></li>
								                    	<li><a href="#" data-toggle="modal" data-target="#chat"><i class="icon-comment"></i> Start chat</a></li>
								                    	<li><a href="#" data-toggle="modal" data-target="#video"><i class="icon-video-camera"></i> Video call</a></li>
						                    		</ul>
						                    	</li>
					                    	</ul>
										</div>
									</li>
									
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


		<!-- Footer -->
		<div class="footer text-muted">
			&copy; 2015. <a href="#">Limitless Web App Kit</a> by <a href="http://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a>
		</div>
		<!-- /footer -->

	</div>
	<!-- /page container -->

</body>
</html>