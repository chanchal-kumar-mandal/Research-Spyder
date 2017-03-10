<?php
require_once(realpath(dirname(__FILE__)).'/template_parts/header.php');
$uid = 0;
$uname = '';
$full_name = '';
$password = '';
$repeat_password = '';
$address_line1 = '';
$address_line2 = '';
$city = '';
$state = '';
$zip = '';
$email = '';
$country = 5;
$phone = '';
$profile = '';
$logo = '';
$form_action = 'form_submit';
if(isset($_GET['uid']) && ($_GET['uid'] > 0)){
$uid = $_GET['uid'];
$form_action .= '?uid='.$uid;
$user_details = get_multiple_rows('tbl_user','*',array('id' => $uid));
$user_data = $user_details[0];
$uname = $user_data['uname'];
$full_name = $user_data['full_name'];
$password = $user_data['password'];

$address_line1 = $user_data['address_line1'];
$address_line2 = $user_data['address_line2'];
$city = $user_data['city'];
$state = $user_data['state'];
$zip = $user_data['zip'];
$email = $user_data['email'];
$country = $user_data['country'];
$phone = $user_data['phone'];
$profile = $user_data['profile'];
$logo = $user_data['logo'];
}
?>

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
					<div class="col-lg-6">
						<!-- Profile info -->
						<div class="panel panel-flat">
							<div class="panel-heading">
								<h6 class="panel-title">Profile information</h6>
								<div class="heading-elements">
									<ul class="icons-list">
				                		<li><a data-action="collapse"></a></li>
				                		<li><a data-action="reload"></a></li>
				                		<li><a data-action="close"></a></li>
				                	</ul>
			                	</div>
							</div>
							<div class="panel-body">
								<form action="<?php echo $form_action; ?>" method="post" id="user_create_form" enctype="multipart/form-data">
								<?php if($uid > 0){ ?>
									<input type="hidden" name="form_name" value="update.user">
								<?php } else { ?>
									<input type="hidden" name="form_name" value="create.user">
								<?php } ?>
								<input type="hidden" id="uid" name="uid" value="<?php echo $uid; ?>">
								<input type="hidden" id="email_err_val" value="1">
								
								<?php if(isset($_SESSION['msg_create_account']) && ($_SESSION['msg_create_account'] != '')){ ?>
								<div class="success-message"><?php echo $_SESSION['msg_create_account']; ?></div>
								<?php } ?>
									<div class="form-group">

										<div class="row">
											<div class="col-md-6">
												<label for="uname">Username<span class="mand">*</span></label>
												<input id="uname" name="uname" type="text" value="<?php echo $uname; ?>" placeholder="Enter Username" class="form-control">
												<span id="uname_err" class="error"></span>
											</div>
											<div class="col-md-6">
												<label for="full-name">Full name<span class="mand">*</span></label>
												<input id="full-name" name="full-name" value="<?php echo $full_name; ?>" type="text" placeholder="Enter Full name" class="form-control">
												<span id="name_err" class="error"></span>
											</div>
										</div>
									</div>
									<?php if($uid == 0){ ?>
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label for="pass">Password<span class="mand">*</span></label>
												<input name="password" id="pass" type="password" placeholder="Enter Password" class="form-control">
												<span id="pass_err" class="error"></span>
											</div>
											<div class="col-md-6">
												<label for="repeat-pass">Repeat Password<span class="mand">*</span></label>
												<input name="repeat-password" id="repeat-pass" type="password" placeholder="Enter Password Again" class="form-control">
												<span id="rep_pass_err" class="error"></span>
											</div>
										</div>
									</div>									
									<?php } ?>
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label for="address-line1">Address line 1</label>
												<input id="address-line1" name="address-line1" value="<?php echo $address_line1; ?>" type="text" placeholder="Enter Address line 1" class="form-control">
											</div>
											<div class="col-md-6">
												<label for="address-line2">Address line 2</label>
												<input id="address-line2" name="address-line2" value="<?php echo $address_line2; ?>" type="text" placeholder="Enter Address line 2" class="form-control">
											</div>
										</div>
									</div>

									<div class="form-group">
										<div class="row">
											<div class="col-md-4">
												<label for="city">City</label>
												<input id="city" name="city" type="text" value="<?php echo $city; ?>" placeholder="Enter City" class="form-control">
											</div>
											<div class="col-md-4">
												<label for="state">State/Province</label>
												<input id="state" name="state" type="text" value="<?php echo $state; ?>" placeholder="Enter State/Province" class="form-control">
											</div>
											<div class="col-md-4">
												<label for="zip">ZIP code</label>
												<input id="zip" name="zip" type="text" value="<?php echo $zip; ?>" placeholder="Enter ZIP code" class="form-control">
											</div>
										</div>
									</div>
<!--eugene@kopyov.com-->
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label for="email">Email<span class="mand">*</span></label>
												<input name="email" id="email" type="text" value="<?php echo $email; ?>" placeholder="Enter Email" class="form-control">
												<span id="email_err" class="error"></span>
											</div>
											<div class="col-md-6">
					                            <label for="country">Your country</label>
					                            <div class="multi-select-full">
													<?php
													$resultCountries = $conn->query("SELECT * FROM tbl_countries ORDER BY title");
													if(count($rowCountry = $resultCountries->fetch_assoc()) > 0){
														echo '<select class="multiselect btn-primary" name="country" id="country">
																<option value="">Select Country</option>';
														while($rowCountry = $resultCountries->fetch_assoc()){
														?>
															<option value="<?php echo $rowCountry['id'];?>" <?php echo ((isset($country) && $country == $rowCountry['id']) ? 'selected="selected"' : '');?>><?php echo $rowCountry['title'];?></option>
														<?php
														}
														echo '</select>';
													}else{
														echo '<div class="error-message">No Country Found.</div>';
													}
													?>
												</div>
												<?php/*
												echo all_country_list('country','country','select',$country,1);
												*/?>
											</div>
										</div>
									</div>
			                        <div class="form-group">
			                        	<div class="row">
			                        		<div class="col-md-6">
												<label for="phone">Phone #</label>
												<input id="phone" name="phone" value="<?php echo $phone; ?>" placeholder="Enter Phone" type="text" class="form-control">
												<span class="help-block">+99-99-9999-9999</span>
			                        		</div>
											<div class="col-md-6">
												<label for="profile">Upload profile image</label>
												<?php
												if($profile != ""){?>
													<div class="text-center">
														<span class=""> Previous Image</span>
														<img src="<?php echo UPLOAD_DIR."profile/".$profile;?>" alt="profile" style="width:120px;height:30px;border:3px solid #dfdfdf;margin-bottom:5px;"/>
													</div>
												<?php 
												}
												?>
			                                    <input id="profile" name="profile" type="file" class="file-styled-primary">
			                                    <span class="help-block">Accepted formats: gif, png, jpg, jpeg. Max file size 2Mb.</span>
			                                    <span id="profile_err" class="error"></span>
											</div>
											<div class="col-md-12">
												<label for="user_logo_file">Upload User Dashboard Logo</label>
												<?php
												if($logo != ""){?>
													<div class="text-center">
														<span class=""> Previous Image</span>
														<img src="<?php echo UPLOAD_DIR."user_logo/".$logo;?>" alt="logo" style="width:120px;height:30px;border:3px solid #dfdfdf;margin-bottom:5px;"/>
													</div>
												<?php 
												}
												?>
			                                    <input id="user_logo_file" name="user_logo_file" type="file" class="file-styled-primary">
			                                    <span class="help-block">Accepted formats: gif, png, jpg, jpeg. Max file size 2Mb.</span>
			                                    <span id="logo_err" class="error"></span>
											</div>
			                        	</div>
			                        </div>
			                        <div class="text-right">
			                        	<button id="user_create_button" type="submit" class="btn <?php echo (isset($_GET['uid']) ? 'btn-warning' : 'btn-primary');?>">Save <i class="icon-arrow-right14 position-right"></i></button>
			                        </div>
								</form>
							</div>
						</div>
						<!-- /profile info -->
					</div>
					<div class="col-lg-6">
						<!-- Account settings -->
						<div class="panel panel-flat">
							<div class="panel-heading">
								<h6 class="panel-title">Account settings</h6>
								<div class="heading-elements">
									<ul class="icons-list">
				                		<li><a data-action="collapse"></a></li>
				                		<li><a data-action="reload"></a></li>
				                		<li><a data-action="close"></a></li>
				                	</ul>
			                	</div>
							</div>
							<div class="panel-body">
								<form action="form_submit" id="change_pass_form" method="post">
									<input type="hidden" id="uid" name="uid" value="<?php echo $uid; ?>">
									<input type="hidden" id="form_name" name="form_name" value="change_pass">
									<?php if(isset($_SESSION['msg_change_pass']) && ($_SESSION['msg_change_pass'] != '')){ ?>
									<div class="success-message"><?php echo $_SESSION['msg_change_pass']; ?></div>
									<?php } ?>
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label>Username</label>
												<input type="text" value="<?php echo $email; ?>" readonly="readonly" class="form-control">
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label>New password</label>
												<input type="password" id="new_password" name="new_password" placeholder="Enter new password" class="form-control">
												<span id="new_password_err" class="error"></span>
											</div>
											<div class="col-md-6">
												<label>Repeat password</label>
												<input type="password" id="new_password_repeat" name="new_password_repeat" placeholder="Repeat new password" class="form-control">
												<span id="new_password_repeat_err" class="error"></span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label>Profile Type</label>
												<div class="radio">
													<label>
														<input type="radio" name="utype" value="1" class="styled" checked="checked">
														Administrator
													</label>
												</div>
												<div class="radio">
													<label>
														<input type="radio" name="utype" value="2" class="styled">
														Standard
													</label>
												</div>
											</div>
											<div class="col-md-6">

												<!--<label>Notifications</label>
												<div class="checkbox">
													<label>
														<input type="checkbox" class="styled" checked="checked">
														Password expiration notification
													</label>
												</div>
												<div class="checkbox">
													<label>
														<input type="checkbox" class="styled" checked="checked">
														New message notification
													</label>
												</div>
												<div class="checkbox">
													<label>
														<input type="checkbox" class="styled" checked="checked">
														New task notification
													</label>
												</div>
												<div class="checkbox">
													<label>
														<input type="checkbox" class="styled">
														New contact request notification
													</label>
												</div>-->
											</div>
										</div>
									</div>
			                        <div class="text-right">
			                        	<button<?php if(!$uid || $uid == 0 || $uid == ''){ ?> disabled="disabled"<?php } ?> id="change_pass" type="submit" class="btn <?php echo (isset($_GET['uid']) ? 'btn-warning' : 'btn-primary');?>">Save <i class="icon-arrow-right14 position-right"></i></button>
			                        </div>
		                        </form>
							</div>
						</div>
						<!-- /account settings -->
					</div>
				</div>
				<!-- /main charts -->
			</div>
			<!-- /main content -->
		</div>
		<!-- /page content -->


		<?php
$_SESSION['msg_change_pass'] = '';
$_SESSION['msg_create_account'] = '';
require_once(realpath(dirname(__FILE__)).'/' .'template_parts/footer.php');

/* Particular CSS for selected dropdown background in update user form */
if(isset($_GET['uid'])){?>
<style>
#user_create_form .dropdown-menu > .active > a, #user_create_form .dropdown-menu > .active > a:hover, #user_create_form .dropdown-menu > .active > a:focus {
    background-color: #FF5722;
}
#user_create_form .btn-primary{
	 background-color: #FF5722;
	 border-color: #FF5722;
}
</style>
<?php
}else{?>
<style>
	#user_create_form .bg-warning{
		 background-color: #2196F3;
		 border-color: #2196F3;
	}
</style>
<?php
}
?>

<script>
	$('#repeat-pass').keyup(function(){
		var rep = $(this).val();
		var val = $('#pass').val();
		if(rep == val){
			$(this).removeClass('err');
			$('#rep_pass_err').html('');
		} else {
			$('#rep_pass_err').html('The Password is not Matching');
			$(this).addClass('err');
			$(this).focus();
		}
		
	});
	
	
	$('.form-control').keyup(function(){
		if($(this).val() != ''){
			$(this).removeClass('err');
		} else {
			$(this).addClass('err');
		}
	});
	


	$('#change_pass').click(function(e){
		var new_password = $('#new_password').val();
		var new_password_repeat = $('#new_password_repeat').val();
		var np = 0;
		var npr = 0;
		e.preventDefault();
		if(new_password_repeat == ''){
			e.preventDefault();
			$('#new_password_repeat_err').html('This Field is Required');
			$('#new_password_repeat').addClass('err');
			$('#new_password_repeat').focus();
		} else {
			np = 1;
			$('#new_password_repeat_err').html('');
			$('#new_password_repeat').removeClass('err');
		}
		
		
		if(new_password == ''){
			e.preventDefault();
			$('#new_password_err').html('This Field is Required');
			$('#new_password').addClass('err');
			$('#new_password').focus();
		} else {
			npr = 1;
			$('#new_password_err').html('');
			$('#new_password').removeClass('err');
		}
		
		if(np == 1 && npr == 1){
			if(new_password == new_password_repeat){
				$('#change_pass_form').submit();
			} else {
				$('#new_password_repeat_err').html('The Password Does not Match');
				$('#new_password_repeat').addClass('err');
				$('#new_password_repeat').focus();
			}
		}
		
		
		
	});
	
	
	$('#user_create_button').click(function(e){
		var uname = $('#uname').val();
		var full_name = $('#full-name').val();
		var pass = $('#pass').val();
		var repeat_pass = $('#repeat-pass').val();
		var email = $('#email').val();
		
		var uname_err = 0;
		var full_name_err = 0;
		var pass_err1 = 0;
		var pass_err2 = 0;
		var pass_err = 0;
		var email_err = 0;
		var profile_err = 1;
		var logo_err = 1;
		
		var uid = $('#uid').val();
		
		
		e.preventDefault();
		
		var email_filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
		
		if(email == ''){
			$('#email_err').html('This Field is Required');
			$('#email').addClass('err');
			$('#email').focus();
			//e.preventDefault();
		} else if (email_filter.test(email)) {
				//e.preventDefault();
				//email_err = 1;
				var data = {
								'action': 'check_email',
								'email': email,
								'uid': uid
							};
				/*var test = jQuery.post('ajax.php', data, function(response) {
					return response;
				}).responseText;	*/
				
				
				
				var jqxhr = $.ajax({
									type: 'POST',       
									url: "includes/ajax.php",
									data: data,
									dataType: 'html',
									context: document.body,
									global: false,
									async:false,
									success: function(data) {
										return data;
									}
								}).responseText;
				

				if(jqxhr == 1){
					email_err = 1;
					$('#email_err').html('');
					$('#email').removeClass('err');
				} else {
					$('#email_err').html('This Email is Already in Used');
					$('#email').addClass('err');
					$('#email').focus();
					e.preventDefault();	
				}
						
			
			} else {
				$('#email_err').html('Please Enter a Valid Email');
				$('#email').addClass('err');
				$('#email').focus();
			}
			
		
		
		
		if(repeat_pass == ''){
			$('#rep_pass_err').html('This Field is Required');
			$('#repeat-pass').addClass('err');
			$('#repeat-pass').focus();
			e.preventDefault();
		} else {
			$('#rep_pass_err').html('');
			$('#repeat-pass').removeClass('err');
			pass_err1 = 1;
		}
		
		if(pass == ''){
			$('#pass_err').html('This Field is Required');
			$('#pass').addClass('err');
			$('#pass').focus();
			e.preventDefault();
		} else {
			$('#pass_err').html('');
			$('#pass').removeClass('err');
			pass_err2 = 1;
		}
		
		if(pass_err1 == 1 && pass_err2 == 1){
			if(pass == repeat_pass){
				pass_err = 1;
			} else {
				$('#rep_pass_err').html('The Password is not Matching');
				$('#repeat-pass').addClass('err');
				$('#repeat-pass').focus();
				e.preventDefault();
			}
		}
		
		if(full_name == ''){
			$('#name_err').html('This Field is Required');
			$('#full-name').addClass('err');
			$('#full-name').focus();
			e.preventDefault();
		} else {
			$('#name_err').html('');
			$('#full-name').removeClass('err');
			full_name_err = 1;
		}
		
		if(uname == ''){
			$('#uname_err').html('This Field is Required');
			$('#uname').addClass('err');
			$('#uname').focus();
			e.preventDefault();
		} else {
			


        var data = {
								'action': 'check_uname',
								'uname': uname,
								'uid': uid
							};
				/*var test = jQuery.post('ajax.php', data, function(response) {
					return response;
				}).responseText;	*/
				
				
				
				var jqxhr = $.ajax({
									type: 'POST',       
									url: "includes/ajax.php",
									data: data,
									dataType: 'html',
									context: document.body,
									global: false,
									async:false,
									success: function(data) {
										return data;
									}
								}).responseText;
				

				if(jqxhr == 1){
					$('#uname_err').html('');
					$('#uname').removeClass('err');
					uname_err = 1;
				} else {
					$('#uname_err').html('This Username is Already in Used');
					$('#uname').addClass('err');
					$('#uname').focus();
					e.preventDefault();	
				}

		}

		// Profile Image Validation
		var profileName = $("#profile").val();
		// Use a regular expression to trim everything before final dot
    	var profileExt = profileName.replace(/^.*\./, '');
    	if($('#profile').val() != ""){
    		var profileSize = $('#profile')[0].files[0].size;
    		if($.inArray(profileExt.toLowerCase(), ['gif','png','jpg','jpeg']) == -1){
				e.preventDefault();	
				$("#profile_err").html("Wrong file type");
				$('#uniform-profile > span.filename').css('border', '1px solid #990000');
				profile_err = 0;

			}else if(profileSize>2097152) {
				e.preventDefault();	
				$("#profile_err").html("File size is greater than 2MB");
				$('#uniform-profile > span.filename').css('border', '1px solid #990000');
				profile_err = 0;
			}else{
				$('#profile_err').html('');
				$('#uniform-profile > span.filename').css('border', '1px solid #ddd');
				profile_err = 1;
			} 
    	}
		

		// User Dashboard Logo Image Validation
		var userLogoName = $("#user_logo_file").val();
		// Use a regular expression to trim everything before final dot
    	var userLogoExt = userLogoName.replace(/^.*\./, '');
    	if($('#user_logo_file').val() != ""){
    		var userLogoSize = $('#user_logo_file')[0].files[0].size;
			if($.inArray(userLogoExt.toLowerCase(), ['gif','png','jpg','jpeg']) == -1){
				e.preventDefault();	
				$("#logo_err").html("Wrong file type");
				$('#uniform-user_logo_file > span.filename').css('border', '1px solid #990000');
				logo_err = 0;

			}else if(userLogoSize>2097152) {
				e.preventDefault();	
				$("#logo_err").html("File size is greater than 2MB");
				$('#uniform-user_logo_file > span.filename').css('border', '1px solid #990000');
				logo_err = 0;
			}else{
				$('#logo_err').html('');
				$('#uniform-user_logo_file > span.filename').css('border', '1px solid #ddd');
				logo_err = 1;
			} 		
    	}

		if(uname_err == 1 && full_name_err == 1 && pass_err == 1 && email_err == 1 && profile_err == 1 && logo_err == 1){
			$('#user_create_form').submit();
		} else {
			e.preventDefault();
		}
		
	});
	//$('.error').html('This Field is Mandatory');

//});
</script>
<style>
.err{border:1px solid #990000;}
.mand{color:#990000; font-size:15px; padding-left:5px;}
.error{color:#990000;}
.msg{color:#006633;}
</style>