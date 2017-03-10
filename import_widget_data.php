<?php
require_once(realpath(dirname(__FILE__)).'/' .'includes/connection.php');
require_once(realpath(dirname(__FILE__)).'/' .'template_parts/header.php');
$resultUsers = $conn->query("SELECT DISTINCT tbl_user.id id, tbl_user.full_name full_name  FROM tbl_user INNER JOIN user_widgets ON tbl_user.id = user_widgets.user_id");
?>
	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Widgets</span> - Update
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="dashboard">Home</a></li>
					<li class="active"><a href="import_widget_data">Import Widget Data</a></li>
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
								<h6 class="text-semibold">Import Widget Data</h6>
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
								<form id="import_widget_data_form" method="post" enctype="multipart/form-data">
								<input type="hidden" name="form_name" value="import.widget.data">
									<!-- Select User -->
									<div id="users_container">
										<div class="form-group">
											<label>Select User <span class="mand">*</span></label>
											<div class="multi-select-full">
												<select class="multiselect" name="user_id" id="user">
													<option value="">Select User</option>
													<?php
													while($rowUser = $resultUsers->fetch_assoc()){
													?>
														<option value="<?php echo $rowUser['id'];?>"><?php echo $rowUser['full_name'];?></option>
													<?php
													}
													?>
												</select>
											</div>
										</div>
									</div>
									<div id="widget_type_container" style="display:none">
										<!-- Select Widget Type -->
										<div class="form-group">
											<label>Select Widget Type <span class="mand">*</span></label>
											<div class="multi-select-full" id="widget_type">
											</div>
										</div>
										<!-- /Select Widget Type -->
				                    </div>
									<div id="widgets_container" style="display:none">
										<!-- Select Widget -->
										<div class="form-group">
											<label>Select Widget <span class="mand">*</span></label>
											<div class="multi-select-full" id="widgets">
											</div>
										</div>
										<!-- /Select Widget -->
				                    </div>
				                    <div id="file_submit_container" style="display:none">
				                    	<!-- Upload File -->
				                    	<div class="form-group">
				                    		<div id="file_container">
			                                </div>
				                        </div>
				                        <!-- /Upload File -->
				                        <div class="text-right">
				                        	<button id="import_widget_data_submit_button" type="submit" class="btn btn-primary">Save <i class="icon-arrow-right14 position-right"></i></button>
				                        </div>
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

		///// Showing widgets dropdown on user selection /////
		$("select#user").change(function(){			
			$("#file_submit_container").css("display", "none");
			$("#widget_type_container").css("display", "none");
			$("#widgets_container").css("display", "none");
			if($("#user").val() == ""){
				$("#message").html('<div class="error-message">Please select an user.</div>');
			}else{
				message_instant_remove();
				$('#loading_image').show();        
				$.ajax({
					type: "POST",
					url: "user_widget_type_informations",
					data: {user_id : $("#user").val()},
					cache: false,
					dataType : "json",
					success: function(result){
						if(result.status == 'success'){
							var resultWidgets = JSON.parse(result.data);
							var optionHtml = '<select class="multiselect btn-primary" name="widget_id" id="widget_id"><option value="">Select Widget Type</option>';
							for (i = 0; i < resultWidgets.length; i++) {
							  widget = resultWidgets[i];
							  optionHtml += '<option value="'+widget.id+'" data-name="'+widget.name+'">'+widget.display_name+'</option>';
							}
							optionHtml +='</select>';
							$("#widget_type_container").css("display", "block");
							$("#widget_type").html(optionHtml);
							// below two lines taken from form_multiselct.js for dropdown design purpose
							$('#widget_type_container .multiselect').multiselect({
						        onChange: function() {
						            $.uniform.update();
						        }
						    });
						    $(".styled, .multiselect-container input").uniform({ radioClass: 'choice'});
						    $('#loading_image').hide();        

						}
						if(result.status == 'fail'){
							$("#message").html('<div class="error-message">'+result.message+'</div>');
							$('#loading_image').hide();        
						}
					}
				});
			}
		});

		///// Showing widgets dropdown for  particular widget type /////

		$("#widget_type").change(function(){
			$("#widgets_container").css("display", "none");
			$("#file_submit_container").css("display", "none");
			var widgetId = $("select#widget_id").val();
			if(widgetId == ""){
				$("#message").html('<div class="error-message">Please select a widget type.</div>');
			}else{
				message_instant_remove();
				$('#loading_image').show();     
				$.ajax({
					type: "POST",
					url: "user_widget_informations",
					data: {user_id : $("#user").val(), widget_id: widgetId},
					cache: false,
					dataType : "json",
					success: function(result){
						if(result.status == 'success'){
							var resultWidgets = JSON.parse(result.data);
							var optionHTML = '<select class="multiselect btn-primary" name="widget" id="widget"><option value="">Select Widget</option>';
							for (i = 0; i < resultWidgets.length; i++) {
							    optionHTML += '<option value="'+resultWidgets[i].id+'">'+resultWidgets[i].widget_name+'</option>';
							}
						    $('#loading_image').hide(); 
							$("#widgets").html(optionHTML);
							$("#widgets_container").css("display", "block");
							// below two lines taken from form_multiselct.js for dropdown design purpose
							$('#widgets .multiselect').multiselect({
						        onChange: function() {
						            $.uniform.update();
						        }
						    });
						    $(".styled, .multiselect-container input").uniform({ radioClass: 'choice'});
						}
						if(result.status == 'fail'){
							$('#loading_image').hide();   
							$("#message").html('<div class="error-message">'+result.message+'</div>');  
						}
					}
				});
			}
		});

		///// Dynamic file input making depending on widget selection /////
		$("#widgets").change(function(){
			if($("select#widget").val() == ""){
				$("#file_submit_container").css("display", "none");
				$("#message").html('<div class="error-message">Please select a widget.</div>');
			}else{
				message_instant_remove();
				//catch widget type option name
				var widgetDisplayName = $("#widget_type option:selected").text();
				var widgetName = $("#widget_type option:selected").attr('data-name');
				// convert lowercase
				widgetName = widgetName.toLowerCase();
				// replace space by underscore
				widgetName = widgetName.replace(/ /g, "_");
				if(widgetName == "marketing_performance"){
					$fileHtml = '<label>Upload File For ' + widgetDisplayName + ' <span class="mand">*</span></label>'+'<input id="csvfile" name="'+widgetName+'_file" type="file" class="file-styled-primary" required>'+'<label>Upload File For Performance Data Table <span class="mand">*</span></label>'+'<input id="csvfile_performance" name="'+widgetName+'_performance_file" type="file" class="file-styled-primary" required>'+'<label>Upload File For Combination Of Charts <span class="mand">*</span></label>'+'<input id="csvfile_combination" name="'+widgetName+'_combination_file" type="file" class="file-styled-primary" required>'+
			                                    '<span class="help-block mand">Accepted format: csv</span>';
				}else if(widgetName == "brand_sentiment"){
					$fileHtml = '<label>Upload File For ' + widgetDisplayName + ' <span class="mand">*</span></label>'+'<input id="csvfile" name="'+widgetName+'_file" type="file" class="file-styled-primary" required>'+'<label>Upload File For Basics Charts <span class="mand">*</span></label>'+'<input id="csvfile_basics" name="'+widgetName+'_basics_file" type="file" class="file-styled-primary" required>'+
			                                    '<span class="help-block mand">Accepted format: csv</span>';
				}else{
					$fileHtml = '<label>Upload File FOR ' + widgetDisplayName + ' <span class="mand">*</span></label>'+'<input id="csvfile" name="'+widgetName+'_file" type="file" class="file-styled-primary" required>'+
			                                    '<span class="help-block mand">Accepted format: csv</span>';
				}
				// Dynamic file input making
				$("#file_container").html($fileHtml);

				$(".file-styled-primary").uniform({
					wrapperClass: 'bg-primary',
					fileButtonHtml: '<i class="icon-plus2"></i>'
				});

				$("#file_submit_container").css("display", "block");
			}
		});

		//// Import Widget Dta Form Sumission ////
		$("#import_widget_data_form").on('submit',(function(e){
			e.preventDefault();

			var filename = $("#csvfile").val();
			// Use a regular expression to trim everything before final dot
        	var extension = filename.replace(/^.*\./, '');
        	var extension_basics = extension_performance = extension_combination = "";
			if($("#csvfile_basics").val()){
				var filename_basics = $("#csvfile_basics").val();
				extension_basics = filename_basics.replace(/^.*\./, '');
			}
			if($("#csvfile_performance").val()){
				var filename_performance = $("#csvfile_performance").val();
				extension_performance = filename_performance.replace(/^.*\./, '');
			}
			if($("#csvfile_combination").val()){
				var filename_combination = $("#csvfile_combination").val();
				extension_combination = filename_combination.replace(/^.*\./, '');
			}
			// Checking csv file type for uploading file
			if(extension.toLowerCase() != "csv"){
				e.preventDefault();				
				$("#message").html('<div class="error-message">Wrong file type for '+$("#widget option:selected").text()+'. Please check.</div>');

			}else if(extension_basics != "" && extension_basics.toLowerCase() != "csv"){
				e.preventDefault();				
				$("#message").html('<div class="error-message">Wrong file type for  Basics Charts. Please check.</div>');				
			}else if(extension_performance != "" && extension_performance.toLowerCase() != "csv"){
				e.preventDefault();				
				$("#message").html('<div class="error-message">Wrong file type for Performance Data Table. Please check.</div>');				
			}else if(extension_combination != "" && extension_combination.toLowerCase() != "csv"){
				e.preventDefault();				
				$("#message").html('<div class="error-message">Wrong file type for Combination Of Charts. Please check.</div>');				
			}else{
				// Checking widget data existance in database				
				e.preventDefault();	
				flgSubmission = false;
				message_instant_remove();
				$('#loading_image').show();
				$.ajax({
					type: "POST",
					url: "user_imported_widget_informations.php",
					data: $("#import_widget_data_form").serialize(),
					cache: false,
					dataType: "json",
					success: function(result){
						if(result.data == "exist"){	
							if(confirm("Are you want to overwrite existing data?")){
								flgSubmission = true;
								formSubmit(flgSubmission);
							}else{
								$('#loading_image').hide();
								flgSubmission = false;
							}
						}else{
							flgSubmission = true;
							formSubmit(flgSubmission);
						}
					}
				});	
			}

			// Ultimate data import for widget
			function formSubmit(flgSubmission){
				if(flgSubmission){
					var form_data = new FormData(document.getElementById('import_widget_data_form'));
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
								// hide widget type dropdown
								$("#widget_type_container").css("display", "none");
								// hide widget type dropdown
								$("#widgets_container").css("display", "none");
								// hide file input field(s)
								$("#file_submit_container").css("display", "none");
								// deselect selected user
								$('#users_container .dropdown-menu li.active a label div span').removeClass("checked");	
								// Remove all selected options
								$('option', $('#user')).each(function(element) {
									$(this).removeAttr('selected').prop('selected', false);
								});
								//Refresh Multiselect								
								$("#user").multiselect('refresh');	
								// add class checked to span tag in first li
								$('#users_container .dropdown-menu li:nth-child(1) a label div span').addClass("checked");
								// showing success message
								$("#message").html('<div class="success-message">'+result.message+'</div>');
								message_remove();
							}
							if(result.status == 'fail'){
								$('#loading_image').hide();
								$("#message").html('<div class="error-message">'+result.message+'</div>');
							}
						}
					});
					return false;
				}else{
					return false;
				}
			}		   
			return false;
		}));

	});
</script>

<?php
$_SESSION['widget_file_upload_success_message'] = '';
$_SESSION['widget_file_upload_error_message'] = '';
require_once(realpath(dirname(__FILE__)).'/' .'template_parts/footer.php');
?>