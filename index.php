<?php 
//require_once('/includes/config.php'); 
//require_once('/includes/query.php');
//require_once('/template_parts/header-login.php');

require_once(realpath(dirname(__FILE__)).'/' . 'includes/config.php');
require_once(realpath(dirname(__FILE__)).'/' . 'includes/query.php');
require_once(realpath(dirname(__FILE__)).'/' . 'template_parts/header-login.php');



check_login();
?>


	<!-- Page container -->
	<div class="page-container login-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Simple login form -->
				<form action="form_submit.php" id="login_form" method="post">
					<input type="hidden" name="form_name" value="login">
					<div class="panel panel-body login-form">
						<div class="text-center">
							<div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
							<h5 class="content-group">Login to your account <small class="display-block">Enter your credentials below</small></h5>
							
							<?php if(isset($_GET['login']) && ($_GET['login'] == 'error')){ ?>
							<small class="error">Wrong Username/Password</small>
						<?php } ?>
							
						</div>

						

						<div class="form-group has-feedback has-feedback-left">
							<input type="text" name="username" id="username" class="form-control" placeholder="Username">
							<div class="form-control-feedback">
								<i class="icon-user text-muted"></i>
							</div>
						</div>

						<div class="form-group has-feedback has-feedback-left">
							<input type="password" name="password" id="password" class="form-control" placeholder="Password">
							<div class="form-control-feedback">
								<i class="icon-lock2 text-muted"></i>
							</div>
						</div>

						<div class="form-group">
							<button type="submit" id="login_now" class="btn btn-primary btn-block">Sign in <i class="icon-circle-right2 position-right"></i></button>
						</div>

						<div class="text-center">
							<a href="login_password_recover.php">Forgot password?</a>
						</div>
					</div>
				</form>
				<!-- /simple login form -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

<?php //require_once('/template_parts/footer.php'); 
require_once(realpath(dirname(__FILE__)). '/template_parts/footer.php');
?>


<style>
	.req{border:1px solid #990000;}
	.error{color:#990000;}
	</style>
	
	
<script>
	jQuery( document ).ready(function() {
		jQuery('#login_now').click(function(e){
			var username = jQuery('#username').val();
			var password = jQuery('#password').val();
			if(username != '' && password != ''){
			jQuery('form#login_form').submit();
			} else {
			if(username == ''){
				jQuery('#username').addClass('req');
				jQuery('#username').focus();
			} else if(password == ''){
				jQuery('#password').focus();
			}
			if(username != ''){
				jQuery('#username').removeClass('req');
			}
			
			if(password == ''){
				jQuery('#password').addClass('req');
			} else {
				jQuery('#password').removeClass('req');
			}
			e.preventDefault();
			}
		});
		
		jQuery('.form-control').keyup(function(){
			var val = jQuery(this).val();
			if(val == ''){
				jQuery(this).addClass('req');
			} else {
				jQuery(this).removeClass('req');
			}
		});
		
	});
	</script>	