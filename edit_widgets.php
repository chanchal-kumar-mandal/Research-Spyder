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
					<span class="text-semibold">Widgets</span> - Update
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="dashboard">Home</a></li>
					<li class="active"><a href="edit_widgets">Update Widgets</a></li>
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
								<h6 class="text-semibold">Update Widgets</h6>
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
								<div id="edit_widgets_container">
									<?php 
									if($resultWidgets->num_rows > 0){
										while($rowWidgets = $resultWidgets->fetch_assoc()){
										?>
										<div class="input-group">
											<input type="hidden" name="form_name" id="edit_widgets" value="edit.widgets">
										  	<input type="text" class="form-control" placeholder="Enter Widget Name" aria-describedby="basic-addon2" id="widget<?php echo $rowWidgets['id'];?>" value="<?php echo $rowWidgets['display_name'];?>"/>
										 	<span class="input-group-addon btn btn-warning widget-update-button" data-id="<?php echo $rowWidgets['id'];?>">Update <span class="glyphicon glyphicon-arrow-right"></span></span>
										</div>
										<br/>
										<?php
										}
									}else{
				                		echo '<div class="error-message">No Widget Available.</div>';
				                	}
									?>
			                        <!--<div class="text-right">
			                        	<button id="edit_widgets_submit_button" type="submit" class="btn btn-warning">Update <i class="icon-arrow-right14 position-right"></i></button>
			                        </div>-->
			                    </div>
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
		$(".widget-update-button").click(function(){
			$(".form-control").css("border", "1px solid #ddd");
			var formName = $("#edit_widgets").val();
			var widgetId = $(this).attr('data-id');
			var widgetName = $("#widget"+widgetId).val();
			if(widgetName == ""){
				$("#message").html('<div class="error-message">Please enter widget name.</div>');
				$("#widget"+widgetId).focus();
				$("#widget"+widgetId).css("border", "1px solid #F44336");
			}else{
				message_instant_remove();
				$.ajax({
					type: "POST",
					url: "form_submit.php",
					data: {form_name: formName, widget_id:widgetId, display_name:widgetName},
					cache: false,
					dataType : "json",
					success: function(result){
						if(result.status == 'success'){
							$("#message").html('<div class="success-message">'+result.message+'</div>');
							message_remove();
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