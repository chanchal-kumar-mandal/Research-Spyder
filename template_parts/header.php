<?php 
require_once(realpath(dirname(__FILE__)).'/' .'../includes/query.php');
require_once(realpath(dirname(__FILE__)).'/' .'../includes/config.php');
$uid = $_SESSION['uid'];
$user_name = $_SESSION['uname'];
// Widgets Ids array making for particular user
$user_widget_type_ids_array = array();
$resultUserWidgetType = $conn->query("SELECT DISTINCT widget_id FROM user_widgets WHERE user_id = " . $uid);
if($resultUserWidgetType->num_rows > 0){
	while($rowUserWidgetType = $resultUserWidgetType->fetch_assoc()){
		$user_widget_type_ids_array[] = $rowUserWidgetType['widget_id'];
	}
}
$user_widgets_ids_array = array();
foreach ($user_widget_type_ids_array as $widget_id) {
	$resultUserWidgets = $conn->query("SELECT id FROM user_widgets WHERE user_id = $uid AND widget_id = " . $widget_id);
	while($rowUserWidgets = $resultUserWidgets->fetch_assoc()){
		$user_widgets_ids_array[$widget_id][] = $rowUserWidgets['id'];
	}
}
//print_r($user_widgets_ids_array);

// Change widgets name array making
$resultWidgets = $conn->query("SELECT * FROM widgets ORDER BY id");
$countWidgets = $resultWidgets->num_rows;
if($countWidgets > 0){
	$i=1;
	while($rowWidgets = $resultWidgets->fetch_assoc()){
	 	$widget_name = $rowWidgets['name'];
	 	$change_widget_name = str_replace(" ", "_", strtolower($widget_name));
	 	$change_widgets_names_array[$i] = $change_widget_name;
	 	$change_widgets_names_array[$i] = $change_widget_name;
	 	$widgets_display_names_array[$i] =  $rowWidgets['display_name'];
	 	$i++;
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--<title>Limitless - Responsive Web Application Kit by Eugene Kopyov</title>-->
	<title>Limitless - <?php echo PAGE_TITLE; ?></title>
	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.css" rel="stylesheet" type="text/css">
	<link href="assets/css/style.css" rel="stylesheet" type="text/css">
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
<?php if(PAGE_FILE == 'dashboard'){ ?>

	<script type="text/javascript" src="assets/js/plugins/visualization/d3/d3.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/visualization/c3/c3.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script type="text/javascript" src="assets/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/daterangepicker.js"></script>
	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<!--<script type="text/javascript" src="assets/js/pages/dashboard.js"></script>-->

	<script type="text/javascript" src="assets/js/plugins/visualization/echarts/echarts.js"></script>	
	
<?php } elseif(PAGE_FILE == 'user_create') { ?>

	<!--<script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/ui/fullcalendar/fullcalendar.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/visualization/echarts/echarts.js"></script>-->

	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/notifications/pnotify.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<!--<script type="text/javascript" src="assets/js/pages/user_pages_profile.js"></script>-->
	<script type="text/javascript" src="assets/js/pages/form_inputs.js"></script>
	<script type="text/javascript" src="assets/js/pages/form_multiselect.js"></script>

<?php } elseif(PAGE_FILE == 'view_user') { ?>	
	
	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script type="text/javascript" src="assets/js/pages/user_pages_list.js"></script>

<?php  } elseif(PAGE_FILE == ('edit_widgets' || 'assign_widgets' || 'edit_user_widgets' || 'import_widget_data')){ ?>

	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/notifications/pnotify.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>

	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script type="text/javascript" src="assets/js/pages/form_inputs.js"></script>
	<script type="text/javascript" src="assets/js/pages/form_multiselect.js"></script>

<?php } ?>
	<!-- /theme JS files -->

</head>
<body>

	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<?php
			$resultLogoExist = $conn->query("SELECT * FROM dashboard_logo");
			if($resultLogoExist->num_rows > 0){
				while($rowLogoExist = $resultLogoExist->fetch_assoc()){
					$logo = $rowLogoExist['logo'];
				}
				?>
				<a class="navbar-brand" href="<?php echo SITE_URL; ?>"><img src="<?php echo UPLOAD_DIR.$logo;?>" alt="Logo Image" style="width:104px;height:16px;"/></a>
			<?php
			}else{?>
				<a class="navbar-brand" href="<?php echo SITE_URL; ?>"><img src="assets/images/logo_light.png" alt="Logo Image"></a>
			<?php
			}
			?>

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
						<li><a class="ukrainian"><img src="assets/images/flags/ua.png" alt=""> ??????????</a></li>
						<li><a class="english"><img src="assets/images/flags/gb.png" alt=""> English</a></li>
						<li><a class="espana"><img src="assets/images/flags/es.png" alt=""> Espa�a</a></li>
						<li><a class="russian"><img src="assets/images/flags/ru.png" alt=""> ???????</a></li>
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
						<span><?php echo $_SESSION['uname']; ?></span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="#"><i class="icon-user-plus"></i> My profile</a></li>
						<li><a href="#"><i class="icon-coins"></i> My balance</a></li>
						<li><a href="#"><span class="badge badge-warning pull-right">58</span> <i class="icon-comment-discussion"></i> Messages</a></li>
						<li class="divider"></li>
						<?php if(check_menu_access('account_settings')){?>
							<li><a href="account_settings"><i class="icon-cog5"></i> Account settings</a></li>
						<?php } ?>
						<li><a href="logout"><i class="icon-switch2"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->

<?php if(isset($_SESSION['is_login'])){  ?>

	<!-- Second navbar -->
	<div class="navbar navbar-default" id="navbar-second">
		<ul class="nav navbar-nav no-border visible-xs-block">
			<li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-second-toggle"><i class="icon-menu7"></i></a></li>
		</ul>

		<div class="navbar-collapse collapse" id="navbar-second-toggle">
			<ul class="nav navbar-nav">
				<li class="active"><a href="dashboard"><i class="icon-display4 position-left"></i> Dashboard</a></li>

				<?php if(check_menu_access('user_create') || check_menu_access('view_user')) { ?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class=" icon-users2 position-left"></i> Users <span class="caret"></span>
					</a>
					<ul class="dropdown-menu width-200">
						<li class="dropdown-header">Manage Users</li>
						<?php if(check_menu_access('user_create'))
						{ ?>
							<li><a href="user_create"><i class="icon-user-plus"></i> Create User</a></li>
						<?php } 
						if(check_menu_access('view_user')){ 
						?>
							<li><a href="view_user"><i class=" icon-users4"></i> View Users</a></li>
						<?php } ?>						
					</ul>	
				</li>				
				<?php }
				if(check_menu_access('edit_widgets') || check_menu_access('assign_widgets') || check_menu_access('edit_users_widgets')) { ?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-graph position-left"></i> Widgets <span class="caret"></span>
					</a>
					<ul class="dropdown-menu width-200">
						<li class="dropdown-header">Manage Widgets</li>
						<?php if(check_menu_access('edit_widgets')){?>
							<li><a href="edit_widgets"><i class="icon-pencil7"></i> Edit Widgets</a></li>
						<?php }
						if(check_menu_access('assign_widgets')){?>
							<li><a href="assign_widgets"><i class=" icon-stats-bars"></i> Assign Widgets</a></li>
						<?php } 
						if(check_menu_access('edit_user_widgets')){?>
							<li><a href="edit_user_widgets"><i class="glyphicon glyphicon-edit"></i> Edit User Widgets</a></li>
						<?php } ?>
					</ul>
				</li>				
				<?php } 
				if(check_menu_access('import_widget_data')) { ?>
					<li class="dropdown">
						<a href="import_widget_data"><i class="icon-database-insert position-left"></i>  Import Widget Data</a>
					</li>
				<?php } ?>	
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
	
	<?php
	}
	page_redirect(); 
	check_page_access();
	?>