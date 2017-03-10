<?php
require_once(realpath(dirname(__FILE__)).'/' .'includes/connection.php');
require_once(realpath(dirname(__FILE__)).'/' .'template_parts/header.php');
$resultUsers = $conn->query("SELECT * FROM tbl_user");
?>
	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Logos</span> - Upload
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="dashboard">Home</a></li>
					<li class="active"><a href="upload_logo">Upload Dashboard Logo</a></li>
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
								<h6 class="text-semibold">Upload Dashboard Logo</h6>
								<div class="heading-elements">
									<ul class="icons-list">
				                		<li><a data-action="collapse"></a></li>
				                		<li><a data-action="reload"></a></li>
				                		<li><a data-action="close"></a></li>
				                	</ul>
			                	</div>
							</div>
							<div class="panel-body">							
								<div class="row text-center" id="loading_image" style="display:none"><img src="<?php echo IMAGE_DIR.'/loading-small.gif' ; ?>" alt="Loading"/></div>
								<div id="message"></div>
								<form id="upload_logo_form" method="post" enctype="multipart/form-data">
									<input type="hidden" name="form_name" value="upload.logo">
									<?php
									$resultLogoExist = $conn->query("SELECT * FROM dashboard_logo");
									if($resultLogoExist->num_rows > 0){
										while($rowLogoExist = $resultLogoExist->fetch_assoc()){
											$logo = $rowLogoExist['logo'];
										}
										?>
										<div class="logo_container text-center" id="logo_container">	
											<span class=""> Previous Logo</span>
											<img src="<?php echo UPLOAD_DIR.$logo;?>" alt="logo" style="width:150px;height:30px;border:3px solid #dfdfdf;background-color: #37474F;"/>
										</div>
									<?php
									}
									?>
				                    <!-- Upload File -->
			                    	<div class="form-group">
			                    		<label>Upload File <span class="mand">*</span></label>
			                    		<input id="logo_file" name="logo_file" type="file" class="file-styled-primary" required/>
			                    		<span class="help-block">Accepted File Format: jpeg, jpg, png, gif. Max File Size: 2Mb. Max Dimension: 250px X 50px.</span>
			                        </div>
			                        <!-- /Upload File -->
			                        <div class="text-right">
			                        	<button id="import_widget_data_submit_button" type="submit" class="btn btn-primary">Save <i class="icon-arrow-right14 position-right"></i></button>
			                        </div>
								</form>
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

<script>
	$(document).ready(function(){

		function message_instant_remove(){
			setTimeout(function(){ 
				$("#message").html('');
			}, 0);
		}
		function message_remove(){
			setTimeout(function(){ 
				$("#message").html('');
			}, 5000);
		}

		function message_remove_and_page_reload(){
			setTimeout(function(){ 
				location.reload(true);
			}, 3000);
		}

		// Replace bg-warning class with bg-primary in upload button
		$("#upload_logo_form .bg-warning").toggleClass('bg-warning bg-primary');

				//// Import Widget Dta Form Sumission ////
		$("#upload_logo_form").on('submit',(function(e){
			e.preventDefault();
			var filename = $("#logo_file").val();
			// Use a regular expression to trim everything before final dot
        	var extension = filename.replace(/^.*\./, '');
        	var file_size = $('#logo_file')[0].files[0].size;

			// Checking file type for uploading file
			if($.inArray(extension.toLowerCase(), ['gif','png','jpg','jpeg']) == -1){
				e.preventDefault();				
				$("#message").html('<div class="error-message">Wrong file type. Please check.</div>');

			}else if(file_size>2097152){
				e.preventDefault();				
				$("#message").html('<div class="error-message">File size is greater than 2MB. Please check.</div>');
			}else{				
				e.preventDefault();
				var reader = new FileReader();
	            //Read the contents of Image File.
	            reader.readAsDataURL($('#logo_file')[0].files[0]);
	            reader.onload = function (e) {
	                //Initiate the JavaScript Image object.
	                var image = new Image();
	                //Set the Base64 string return from FileReader as source.
	                image.src = e.target.result;
	                image.onload = function () {
	                    //Determine the Height and Width.
	                    height = this.height;
	                    width = this.width;
	                    if (width > 250 || width < 100) {
	                        $("#message").html('<div class="error-message">Image width must be between 150px to 250px.</div>');
	                    }else if(height >50 || height < 15){
	                        $("#message").html('<div class="error-message">Image height must be between 15px to 50px.</div>');
	                    }else{
	                    	var form_data = new FormData(document.getElementById('upload_logo_form'));
							message_instant_remove();
							$('#loading_image').show();            
							$.ajax({
								type: "POST",
								url: "form_submit.php",
								data: form_data,
								cache: false,
								processData: false,
				        		contentType: false,
								dataType: "json",
								success: function(result){
									if(result.status == 'success'){
										$('#loading_image').hide();
										// hide file input field(s)
										// showing success message
										$("#message").html('<div class="success-message">'+result.message+'</div>');
										message_remove_and_page_reload();
									}
									if(result.status == 'fail'){
										$('#loading_image').hide();
										$("#message").html('<div class="error-message">'+result.message+'</div>');
									}
								}
							});
							return false;
	                    }
	                };
	            }
				
			}
			return false;
		}));

	});
</script>

<?php
require_once(realpath(dirname(__FILE__)).'/' .'template_parts/footer.php');
?>