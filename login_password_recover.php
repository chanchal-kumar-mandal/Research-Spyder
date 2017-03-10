<?php 
require_once(realpath(dirname(__FILE__)).'/' .'includes/config.php'); 
require_once(realpath(dirname(__FILE__)).'/' .'includes/query.php');
require_once(realpath(dirname(__FILE__)).'/' .'template_parts/header-login.php');
check_login();
?>

	<!-- Page container -->
	<div class="page-container login-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Password recovery -->
				<form action="form_submit.php" method="post" id="login_form">
					<div class="panel panel-body login-form">
						<div class="text-center">
							<div class="icon-object border-warning text-warning"><i class="icon-spinner11"></i></div>
							<div id="msg"></div>
							
							<h5 class="content-group">Password recovery <small class="display-block">We'll send you instructions in email</small></h5>
						</div>

						<div class="form-group has-feedback">
							<input type="email" name="email" id="mails" class="form-control" placeholder="Your email">
							<span id="email_err" class="error"></span>
							<div class="form-control-feedback">
								<i class="icon-mail5 text-muted"></i>
							</div>
						</div>

						<button type="submit" id="change_pass" class="btn bg-blue btn-block">Reset password <i class="icon-arrow-right14 position-right"></i></button>
					</div>
				</form>
				<!-- /password recovery -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->


		<?php require_once(realpath(dirname(__FILE__)).'/' .'template_parts/footer.php'); ?>
		
		
<style>
	.req{border:1px solid #990000;}
	.error{color:#990000;}
	.succ{color:#006633;}
	</style>
	
	
<script>
	jQuery( document ).ready(function() {
		jQuery('#change_pass').click(function(e){
			var mails = jQuery('#mails').val();
			e.preventDefault();
			var email_filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
			if(mails == ''){
			//$('#email_err').html('This Field is Required');
			$('#msg').html('<span class="error">This Field is Required</span>');
			$('#mails').addClass('req');
			$('#mails').focus();
			//e.preventDefault();
		} else if (email_filter.test(mails)) {
		
		
			var data = {
								'action': 'login_recover',
								'email': mails
							};
				jQuery.post('includes/ajax.php', data, function(response) {
					//alert(response);
					$('#email_err').html('');
					
				
					if(response == 'err'){
						$('#msg').html('<span class="error">Sorry! The Mail Does not exist</span>');
						$('#mails').addClass('req');
						$('#mails').focus();
					} else {
						$('#msg').html('<span class="succ">Please Check Your Mail</span>');
						$('#mails').removeClass('req');
					}
				})
		
		} else {
				
			//$('#email_err').html('Please Enter a Valid Email');
			$('#msg').html('<span class="error">Please Enter a Valid Email</span>');
			$('#mails').addClass('req');
			$('#mails').focus();
				
		}
		
		
		
		});
		
	});
	</script>			