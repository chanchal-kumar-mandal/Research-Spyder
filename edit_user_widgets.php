<?php
require_once(realpath(dirname(__FILE__)).'/' .'includes/connection.php');
require_once(realpath(dirname(__FILE__)).'/' .'template_parts/header.php');

$resultUsers = $conn->query("SELECT DISTINCT tbl_user.id id, tbl_user.full_name full_name  FROM tbl_user INNER JOIN user_widgets ON tbl_user.id = user_widgets.user_id");
$resultWidgets = $conn->query("SELECT * FROM widgets");
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
					<li class="active"><a href="edit_user_widgets">Update User Widgets</a></li>
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
								<h6 class="text-semibold">Update User Widgets</h6>
								<div class="heading-elements">
									<ul class="icons-list">
				                		<li><a data-action="collapse"></a></li>
				                		<li><a data-action="reload"></a></li>
				                		<li><a data-action="close"></a></li>
				                	</ul>
			                	</div>
							</div>
							<div class="panel-body">
								<div id="message"></div>
								<form method="post" id="edit_user_widgets_form">
									<?php 
									if($resultUsers->num_rows > 0){
										?>
										<!-- Select User -->
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
										<!-- /Select User -->

										<!-- Widget  Type Selection -->
										<div id="widget_type_container">
											<div class="form-group">
												<label>Select Widget Type<span class="mand">*</span></label>
												<div class="multi-select-full">
													<select class="multiselect" name="widget_id" id="widget_type">
													</select>
												</div>
											</div>
					                    </div>	
										<!-- /Widget Type Selection -->	
										
										<!-- Widgets  Manupulation -->
										<div id="widgets_container">
											<div class="form-group"  id="widgets">
											</div>
					                        <!--<div class="text-right">
					                        	<button id="edit_user_widgets_submit_button" type="submit" class="btn btn-warning">Update <span class="glyphicon glyphicon-arrow-right"></span></button>
					                        </div>-->
					                    </div>
										<!-- /Widgets Manupulation -->
				                    <?php
				                	}else{
				                		echo '<div class="error-message">No User Available.</div>';
				                	}
				                	?>
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

	$(document).ready(function(){

		$("#widget_type_container").css("display", "none");
		$("#widgets_container").css("display", "none");

		///// Showing widget type dropdown on user selection /////
		$("select#user").change(function(){	
			$("#widget_type_container").css("display", "none");
			$("#widgets_container").css("display", "none");
			if($("#user").val() == ""){
				$("#message").html('<div class="error-message">Please select an user.</div>');
			}else{
				message_instant_remove();     
				$.ajax({
					type: "POST",
					url: "user_widget_type_informations",
					data: {user_id : $("#user").val()},
					cache: false,
					dataType : "json",
					success: function(result){
						if(result.status == 'success'){
							var resultWidgets = JSON.parse(result.data);
							var optionHTML = '<option value="">Select Widget Type</option>';
							for (i = 0; i < resultWidgets.length; i++) {
							    optionHTML += '<option value="'+resultWidgets[i].id+'">'+resultWidgets[i].display_name+'</option>';
							}
							$("#widget_type").html(optionHTML);
							$("#widget_type_container").css("display", "block");
							$('#widget_type').multiselect('rebuild');
							$(".styled, .multiselect-container input").uniform({ radioClass: 'choice'});
						}
						if(result.status == 'fail'){
							$("#message").html('<div class="error-message">'+result.message+'</div>');    
						}
					}
				});
			}
		});

		///// Showing user widgets for particular widget type /////
		$("select#widget_type").change(function(){	
			$("#widgets_container").css("display", "none");
			var widgetId = $("#widget_type").val();
			if(widgetId == ""){
				$("#message").html('<div class="error-message">Please select a widget type.</div>');
			}else{
				message_instant_remove();     
				$.ajax({
					type: "POST",
					url: "user_widget_informations",
					data: {user_id : $("#user").val(), widget_id: widgetId},
					cache: false,
					dataType : "json",
					success: function(result){
						if(result.status == 'success'){
							var resultWidgets = JSON.parse(result.data);
							var tableHTML = '<label>Widget List</label><table class="table table-bordered"><thead><tr><th width="5%" class="text-center">Id</th><th width="60%">Name</th><th width="35%" class="text-center">Actions</th></tr></thead><tbody>';
							for (i = 0; i < resultWidgets.length; i++) {
							    tableHTML += '<tr><td class="text-center">'+resultWidgets[i].id+'</td><td><input type="taxt"  style="width:100%;" name="widget_name'+resultWidgets[i].id+'" id="widget_name'+resultWidgets[i].id+'"  value="'+resultWidgets[i].widget_name+'"/></td><td style="text-align:center;">'+'<a class="btn-xs btn-warning" onclick="renameWidget('+resultWidgets[i].id+')" href="javascript:void(0)"><i class="glyphicon glyphicon-edit"></i> Rename</a> '+' <a class="btn-xs btn-danger" onclick="deleteWidget('+resultWidgets[i].id+')" href="javascript:void(0)"><i class="glyphicon glyphicon-trash"></i> Delete</a>'+'</td></tr>';
							}
							tableHTML += '</tbody></table>';
							$("#widgets").html(tableHTML);
							$("#widgets_container").css("display", "block");	
							$(".file-styled-primary").uniform({
								wrapperClass: 'bg-primary',
								fileButtonHtml: '<i class="icon-plus2"></i>'
							});
						}
						if(result.status == 'fail'){
							$("#message").html('<div class="error-message">'+result.message+'</div>');    
						}
					}
				});
			}
		});

		$("select#widgetsIds").change(function(){
	        $("#widgets_ids").val($("#widgetsIds").val());
	    });
		$("#widgets_toggle").click(function(){
	        $("#widgets_ids").val($("#widgetsIds").val());
	    });

		$("#edit_user_widgets_form").submit(function(){
			// Comare current widgets with previous widgets
			var previous_widgets_ids = $("#previous_widgets_ids").val();
			var previous_widgets_ids_array = previous_widgets_ids.split(",");

			var widgets_ids = $("#widgets_ids").val();
			var widgets_ids_array = widgets_ids.split(",");
			/*
			// Page will reload when all widgets are unassigned
			var flgPageReload = "false";
			if(widgets_ids == ""){
				flgPageReload == "true";
			}*/

			var flgWidgetDeleteConfirmMessage = "false";
			for ( var i = 0, l = previous_widgets_ids_array.length; i < l; i++ ) {
				//console.log($.inArray( previous_widgets_ids_array[i], widgets_ids_array));
			    if($.inArray( previous_widgets_ids_array[i], widgets_ids_array) == -1){
			    	flgWidgetDeleteConfirmMessage = "true";
			    	break;
			    }
			}

			// Confirmation message if previous widget was unselected
			if(flgWidgetDeleteConfirmMessage == "true"){
				if(confirm("Are you want to delete unassigned widgets data?")){
					formSubmit();
				}else{
					return false;
				}
			}else{
				formSubmit();
			}

			// Ultimate form submit
			function formSubmit(){				
				$.ajax({
					type: "POST",
					url: "form_submit.php",
					data: $('#edit_user_widgets_form').serialize(),
					cache: false,
					dataType : "json",
					success: function(result){
						if(result.status == 'success'){
							$("#message").html('<div class="success-message">'+result.message+'</div>');
							message_remove_and_page_reload();
						}
						if(result.status == 'fail'){
							$("#message").html('<div class="error-message">'+result.message+'</div>');
						}
					}
				});
			}
			return false;
		});
	});

	function renameWidget(id){
		var userWidgetId = id;
		var wName = "#widget_name" + id
		var widgetName = $(wName).val();
		if(userWidgetId == ""){
			$("#message").html('<div class="error-message">No widget id found.</div>');
		}else if(widgetName == ""){
			$("#message").html('<div class="error-message">Please enter widget name.</div>');
			$(wName).focus();
			$(wName).css("border", "1px solid #F44336");
		}else{
			var editUserWidget = "edit.user.widget";
			$.ajax({
				type: "POST",
				url: "form_submit.php",
				data: {form_name : editUserWidget, user_id : $("#user").val(), widget_id : $("#widget_type").val(), user_widget_id : userWidgetId, widget_name : widgetName},
				cache: false,
				dataType : "json",
				success: function(result){
					if(result.status == 'success'){
						$("#message").html('<div class="success-message">'+result.message+'</div>');
						message_remove_and_page_reload();
					}
					if(result.status == 'fail'){
						$("#message").html('<div class="error-message">'+result.message+'</div>');
					}
				}
			});
		}
		return false;
	}

	function deleteWidget(id){
		var userWidgetId = id;
		if(userWidgetId == ""){
			$("#message").html('<div class="error-message">No widget id found.</div>');
		}else{
			if(confirm("Are you sure to delete widget?")){
				var flgSubmission = false;
				// Checking widget data existance in database	
				$.ajax({
					type: "POST",
					url: "user_imported_widget_informations.php",
					data: {user_id : $("#user").val(), widget_id : $("#widget_type").val(), widget : userWidgetId},
					cache: false,
					dataType: "json",
					success: function(result){
						if(result.data == "exist"){	
							if(confirm("Are you want to delete existing data?")){
								flgSubmission = true;
								widgetDelete(flgSubmission, userWidgetId);
							}else{
								flgSubmission = false;
							}
						}else{
							flgSubmission = true;
							widgetDelete(flgSubmission, userWidgetId);
						}
					}
				});	
			}else{
				return false;
			}
		}
		return false;
	}

	// Ultimate widget delete and widget data delete
	function widgetDelete(flgSubmission, userWidgetId){
		if(flgSubmission){
			var deleteUserWidget = "delete.user.widget";
			$.ajax({
				type: "POST",
				url: "form_submit.php",
				data: {form_name : deleteUserWidget, user_id : $("#user").val(), widget_id : $("#widget_type").val(), user_widget_id : userWidgetId},
				cache: false,
				dataType : "json",
				success: function(result){
					if(result.status == 'success'){
						$("#message").html('<div class="success-message">'+result.message+'</div>');
						message_remove_and_page_reload();
					}
					if(result.status == 'fail'){
						$("#message").html('<div class="error-message">'+result.message+'</div>');
					}
				}
			});

		}else{
			return false;
		}
		return false;
	}
</script>

<?php
$_SESSION['msg_change_pass'] = '';
$_SESSION['msg_create_account'] = '';
require_once(realpath(dirname(__FILE__)).'/' .'template_parts/footer.php');
?>