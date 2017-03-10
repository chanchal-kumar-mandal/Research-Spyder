<?php
require_once(realpath(dirname(__FILE__)).'/' .'includes/connection.php');
require_once(realpath(dirname(__FILE__)).'/' .'template_parts/header.php');
$resultUsers = $conn->query("SELECT * FROM tbl_user");
$resultWidgets = $conn->query("SELECT * FROM widgets");
$resultWidgets1 = $conn->query("SELECT * FROM widgets");
?>
	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Widgets</span> - Assign
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="dashboard">Home</a></li>
					<li class="active"><a href="assign_widgets">Assign Widgets</a></li>
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
								<h6 class="text-semibold">Assign Widgets</h6>
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
								<form method="post" id="assign_widgets_form">
									<input type="hidden" name="form_name" value="assign.widgets">
									<?php 
									if($resultUsers->num_rows > 0){
									?>
										<!-- Select User -->
										<div class="form-group">
											<label>Select User <span class="mand">*</span></label>
											<div class="multi-select-full">
												<select class="multiselect btn-primary" name="user_id" id="user">
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

										<!-- Widgets Selection -->
										<div class="content-group-lg" id="widgets_container">
											<label>Select Widget <span class="mand">*</span></label>
											<div class="input-group">
												<div class="multi-select-full">
													<select class="multiselect-toggle-selection" multiple="multiple" id="widgetsIds" name="widgetsIds">
														<?php
														while($rowWidgets = $resultWidgets->fetch_assoc()){
														?>
															<option value="<?php echo $rowWidgets['id'];?>"><?php echo $rowWidgets['display_name'];?></option>
														<?php
														}
														?>
													</select>
												</div>

												<div class="input-group-btn">
													<button type="button" class="btn btn-primary multiselect-toggle-selection-button" id="widgets-toggle">Select All</button>
												</div>
											</div>
											<input type="hidden" id="widgets_ids" name="widgets_ids" value=""/>
										</div>
										<!-- /Widgets Selection -->
										<!-- Widget Custom Name -->	
										<div class="form-group" id="widgets_names_container">											
											<?php
											$i=1;
											while($rowWidgets1 = $resultWidgets1->fetch_assoc()){
												echo '<div class="form-group" id="widget-name-content'.$i.'">
													<label>Edit Widget Name For '.$rowWidgets1['display_name'].'<span class="mand">*</span></label>
													<input type="text" class="form-control" name="widget_name'.$i.'" placeholder="Enter Widget Name" id="" value="'.$rowWidgets1['display_name'].'"/>
												</div>';
											 	$i++;
											}
											?>
										</div>
										<!-- /Widget Custom Name -->
				                        <div class="text-right">
				                        	<button id="assign_widgets_submit_button" type="submit" class="btn btn-primary">Save <i class="icon-arrow-right14 position-right"></i></button>
				                        </div>
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

	function message_remove_and_page_reload(){
		setTimeout(function(){ 
			/*$("#message").html('');*/
			location.reload(true);
		}, 5000);
	}

	$(document).ready(function(){
		$("#widgets_container").hide();	
		$("#widgets_names_container").hide();		
		visibleWidgetName();

		$("select#user").change(function(){	
			$("#widgets_container").hide();	
			$("#widgets_names_container").hide();	
			if($("#user").val() == ""){
				$("#message").html('<div class="error-message">Please select an user.</div>');
			}else{
				message_instant_remove();
				$("#widgets_container").show();
				$("#widgets_names_container").show();
			}
		});		


		$("select#widgetsIds").change(function(){
	        $("#widgets_ids").val($("#widgetsIds").val());	        
			visibleWidgetName();
	    });
		$("#widgets-toggle").click(function(){
	        $("#widgets_ids").val($("#widgetsIds").val());
	        visibleWidgetName();
	    });

	    function visibleWidgetName(){
	    	// Comare current widgets with previous widgets
			var widgets_ids = $("#widgets_ids").val();

			var widgets_ids_array = widgets_ids.split(",");

			var intArr = [];
			for(var i=0; i < widgets_ids_array.length; i++){
			   intArr.push(parseInt(widgets_ids_array[i]));
			}
			for ( i = 1; i < 7; i++ ){
			    if( $.inArray( i, intArr) == -1){
			    	$("#widget-name-content" + i).hide();
			    }else{
			    	$("#widget-name-content" + i).show();
			    }
			}
	    }

		$("#assign_widgets_form").submit(function(){
			if($("#user").val() == ""){				
				$("#message").html('<div class="error-message">Please select an user.</div>');
			}else if($("#widgets_ids").val() == ""){
				$("#message").html('<div class="error-message">Please select a widget.</div>');
			}else{
				$.ajax({
					type: "POST",
					url: "form_submit.php",
					data: $('#assign_widgets_form').serialize(),
					cache: false,
					dataType : "json",
					success: function(result){ 
						if(result.status == 'success'){
							$("#message").html('<div class="success-message">'+result.message+'</div>');
							$("form")[0].reset();
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
</script>

<?php
$_SESSION['msg_change_pass'] = '';
$_SESSION['msg_create_account'] = '';
require_once(realpath(dirname(__FILE__)).'/' .'template_parts/footer.php');
?>