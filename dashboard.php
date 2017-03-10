<?php
require_once(realpath(dirname(__FILE__)).'/template_parts/header.php');

////**** Dynamic Charts/Widgets CSV/TSV file making from database ****////
$user_data_exist_widgets_ids_array = array();
$user_data_exist_widgets_names_array = array();
$user_widgets_data_array = array();
for($i=1; $i <= $countWidgets; $i++){
    // check widget exists or not for particular user
    if(array_key_exists($i, $user_widgets_ids_array)){
        foreach($user_widgets_ids_array[$i] as $user_widget_id){
            $change_widget_name = $change_widgets_names_array[$i];
            $widget_data_table_name = $change_widget_name."_data";        
            // Database charts/widgets table columns related
            $resultTableColumns = $conn->query("SHOW COLUMNS FROM " . $widget_data_table_name);
            $columnsArray = array();
            $changeColumnsArray = array();
            $countColumns=0;

            while($rowWTableColumns = $resultTableColumns->fetch_assoc()){
                // Skip first 3 columns(id, user_id, user_widget_id)
                if($countColumns>2){
                    $columnsArray[] = $rowWTableColumns['Field'];
                    $changeColumnsArray[] = "`".$rowWTableColumns['Field']."`";

                }
                $countColumns++;
            }
            $changeColumnsString = implode(",", $changeColumnsArray);
            // Database charts/widgets table data related
            $resultChart = $conn->query("SELECT $changeColumnsString FROM $widget_data_table_name WHERE user_id = $uid AND user_widget_id = " .$user_widget_id); 
            if($countChartDataRows = $resultChart->num_rows > 0){ 	            	
            	// Making data existing widgets ids array
            	$user_data_exist_widgets_ids_array[$i][] =  $user_widget_id;
            	// Making data existing widgets names array
            	$resultUserWidgetName = $conn->query("SELECT widget_name FROM user_widgets WHERE id = " . $user_widget_id);
            	while($rowUserWidgetName = $resultUserWidgetName->fetch_assoc())
                {
                    $userUserWidgetName = $rowUserWidgetName['widget_name'];
                }
            	$user_data_exist_widgets_names_array[$i][] = $userUserWidgetName;


                // only temporary file making for charts/widgets 1,3,5,6
                if($i == 1 || $i == 3 || $i == 5 || $i == 6) {
                    // File related
                    $fileExtension = (($i == 1) ? ".csv" : ".tsv");
                    $unique_user_with_id = "user_".$uid;
                    $temp_user_widget_folder_path = WIDGET_DIR.'temp_files/'.$unique_user_with_id;
                    if(!file_exists($temp_user_widget_folder_path)){
                        mkdir($temp_user_widget_folder_path, 0777, true);
                    }
                    $temp_widget_file_name = "temp_".$change_widget_name."_".$user_widget_id."_".$unique_user_with_id.$fileExtension;
                    $temp_widget_file_path = $temp_user_widget_folder_path."/".$temp_widget_file_name;
                    $chartFilePath = fopen($temp_widget_file_path, 'w');
                    $ChartDataArray = array();
                    fputcsv($chartFilePath, $columnsArray);
                    while($rowChart = $resultChart->fetch_row())
                    {
                        fputcsv($chartFilePath, $rowChart);
                    }
                    fclose($chartFilePath);
                    // Replace commas by tabs only in .tsv file type content
                    if($i != 1){
                        $path_to_file = $temp_widget_file_path;
                        $file_contents = file_get_contents($path_to_file);
                        $file_contents = str_replace(",","\t",$file_contents);
                        file_put_contents($path_to_file,$file_contents);
                    }
                    $chartFilePath = $temp_widget_file_path;
                    $user_widgets_data_array[$i][] = $chartFilePath;
                }
                // only temporary data for charts/widgets 2
                if($i == 2){
                    $chartDataString = "[";
                    $chartDataString1 = "[";
                    $k = 1;
                    while($rowChart = $resultChart->fetch_assoc()){
                        $chartDataString .= "'".$rowChart['name']."'".(($k == $countChartDataRows - 1) ? "" : ",");
                        $chartDataString1 .= "{value: ".$rowChart['value'].", name: '".$rowChart['name']."'}".(($k == $countChartDataRows - 1) ? "" : ",");
                        $k++;
                    }
                    $chartDataString .= "]";
                    $chartDataString1 .= "]"; 
                    $user_widgets_data_array[$i][] = array($chartDataString, $chartDataString1); 
                }
                if($i == 4){
                    $chartDataString = "[";
                    $l = 1;
                    while($rowChart = $resultChart->fetch_assoc()){
                        $chartDataString .= "{label: '".$rowChart['label']."', size: '".$rowChart['size']."'}".(($l == $countChartDataRows) ? "" : ",");
                        $l++;
                    }
                    $chartDataString .= "]";
                    $user_widgets_data_array[$i][] = array($chartDataString, $chartDataString1);
                    //$user_widgets_data_array[$i] = array($chartDataString, $chartDataString1);  
                }
            }
        }
        
    }
}
//print_r($user_data_exist_widgets_ids_array);
//print_r($user_widgets_data_array);
?>
	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<!--<i class="icon-arrow-left52 position-left"></i>-->
					<span class="">Home</span> - Dashboard
					<small class="display-block">Good morning, <b class="text-success"><?php echo $user_name;?>!</b></small>
				</h4>
			</div>
			<?php
			$resultLogoExist = $conn->query("SELECT * FROM tbl_user WHERE id = " . $uid);
			if($resultLogoExist->num_rows > 0){
				while($rowLogoExist = $resultLogoExist->fetch_assoc()){
					$logo = $rowLogoExist['logo'];
				}
			}
			if($logo != ""){
				?>
				<div class="user_dashboard_logo_container" style="background-color: inherit;position: absolute;top: 50%;left: 16%;margin-top: -18px">
					<img src="<?php echo UPLOAD_DIR."user_logo/".$logo;?>" alt="logo" style="width:200px;height:40px;"/>
				</div>
			<?php
			}
			?>
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

				<!-- Main charts row -->
				<div class="row">				
					<?php 
					if(array_key_exists(1, $user_data_exist_widgets_ids_array)){
						foreach ($user_data_exist_widgets_ids_array[1] as $key => $value) {
							?>
							<div class="col-md-12">
								<!-- Google Demand Chart -->						
								<div class="panel panel-flat">
									<div class="panel-heading">
										<h6 class="panel-title"><?php echo $user_data_exist_widgets_names_array[1][$key];?></h6>
										<div class="heading-elements">
											<form class="heading-form" action="#">
												<div class="form-group">
													<select class="change-date select-sm" id="select_date<?php echo $value;?>">
														<optgroup label="<i class='icon-watch pull-right'></i> Time period">
														    <?php 
														    $resultGDCType = $conn->query("SELECT DISTINCT(type) FROM google_demand_chart_data WHERE user_id = $uid AND user_widget_id = " . $value );
														    if($resultGDCType->num_rows > 0){
														    	$optionHTML = "";
														    	while($rowGDCType = $resultGDCType->fetch_assoc()){
														    		$type = $rowGDCType['type'];
														    		$resultDate = $conn->query("SELECT MAX(date) max_date ,MIN(date) min_date FROM google_demand_chart_data WHERE type='$type' AND user_widget_id = " . $value);
														    		while($rowDate = $resultDate->fetch_assoc()){
														    			$max_date = str_replace('/', '-', $rowDate['max_date']);
														    			echo $min_date = str_replace('/', '-', $rowDate['min_date']);
														    			$optionHTML .= '<option value="' . $type . '">' . date("F", strtotime($max_date)) .', ' . date("d", strtotime($max_date)) . ' - ' . date("F", strtotime($min_date)) .', ' . date("d", strtotime($min_date)) . '</option>';
														    		}
														    	}
														    	echo $optionHTML;
														    }else{
														    ?>
																<option value="val1">June, 29 - July, 5</option>
																<option value="val2">June, 22 - June 28</option>
																<option value="val3" selected="selected">June, 15 - June, 21</option>
																<option value="val4">June, 8 - June, 14</option>
															<?php
															}
															?>
														</optgroup>
													</select>
												</div>
											</form>
					                	</div>
									</div>

									<div class="container-fluid">
									</div>

									<div class="content-group-sm" id="app_sales<?php echo $value;?>"></div>
									<div id="monthly-sales-stats<?php echo $value;?>"></div>
								</div>
								<!-- /Google Demand Chart -->
							</div>
							<?php
						}
					}
					if(array_key_exists(2, $user_data_exist_widgets_ids_array)) {					
						foreach ($user_data_exist_widgets_ids_array[2] as $key => $value) {
							?>
							<div class="col-md-12">
								<!-- Market Share -->
								<div class="panel panel-flat">
									<div class="panel-heading">
										<h6 class="panel-title"><?php echo $user_data_exist_widgets_names_array[2][$key];?></h6>
										<div class="heading-elements">
											<ul class="icons-list">
						                		<li><a data-action="collapse"></a></li>
						                		<li><a data-action="reload"></a></li>
						                		<li><a data-action="close"></a></li>
						                	</ul>
					                	</div>
									</div>

									<div class="panel-body">
										<div class="chart-container has-scroll">
											<div class="chart has-fixed-height has-minimum-width" id="basic_pie<?php echo $value;?>"></div>
										</div>
									</div>
								</div>
								<!-- /Market Share -->
							</div>
							<?php
						}
					}
					if(array_key_exists(3, $user_data_exist_widgets_ids_array)) {					
						foreach ($user_data_exist_widgets_ids_array[3] as $key => $value) {
							?>
							<div class="col-md-12">						
								<!-- Brand Sentiment -->
								<div class="panel panel-flat">
									<div class="panel-heading">
										<h6 class="panel-title"><?php echo $user_data_exist_widgets_names_array[3][$key];?></h6>
										<div class="heading-elements">
											<ul class="icons-list">
						                		<li><a data-action="collapse"></a></li>
						                		<li><a data-action="reload"></a></li>
						                		<li><a data-action="close"></a></li>
						                	</ul>
					                	</div>
									</div>

									<div class="panel-body">
										<p class="content-group">This variation of a stacked bar chart adds an option to change <code>stacked</code> bar chart <code>to multiple</code> on the fly by selecting the radio button. Chart labels move according to the bar group position. This type of layout and transitions are available for both bar directions - vertical and horizontal. It uses one data set for both chart types. Vertical axes labels are optional and hidden by default.</p>
										
										<p class="content-group">
											<label class="radio-inline"><input type="radio" name="stacked-multiple" class="stacked-multiple" value="multiples" checked="checked"> Multiples</label>
											<label class="radio-inline"><input type="radio" name="stacked-multiple" class="stacked-multiple" value="stacked"> Stacked</label>
										</p>
										
										<div class="chart-container">
											<div class="chart" id="d3-bar-stacked-multiples<?php echo $value;?>"></div>
										</div>
									</div>
								</div>
								<!-- /Brand Sentiment -->

								<!-- Basic charts -->
								<div class="panel panel-flat">
									<div class="panel-heading">
										<h5 class="panel-title">Basics Charts</h5>
										<div class="heading-elements">
											<ul class="icons-list">
						                		<li><a data-action="collapse"></a></li>
						                		<li><a data-action="reload"></a></li>
						                		<li><a data-action="close"></a></li>
						                	</ul>
					                	</div>
									</div>

									<div class="panel-body">
										<div class="chart-container has-scroll">
											<div class="chart has-fixed-height has-minimum-width" id="multiple_donuts<?php echo $value;?>" style="height: 450px;"></div>
										</div>
									</div>
								</div>
								<!-- /Basic charts -->
							</div>					
							<?php
						}
					}
					if(array_key_exists(4, $user_data_exist_widgets_ids_array)){					
						foreach ($user_data_exist_widgets_ids_array[4] as $key => $value) {
							?>
							<div class="col-md-12">
								<!-- Topics and Trends -->
								<div class="panel panel-flat">
									<div class="panel-heading">
										<h6 class="panel-title"><?php echo $user_data_exist_widgets_names_array[4][$key];?></h6>
										<div class="heading-elements">
											<ul class="icons-list">
						                		<li><a data-action="collapse"></a></li>
						                		<li><a data-action="reload"></a></li>
						                		<li><a data-action="close"></a></li>
						                	</ul>
					                	</div>
									</div>

									<div class="panel-body">
										<div class="content-group">
											<h6 class="text-semibold">Basic Venn Diagram</h6>
											<p class="content-group">A <code>Venn diagram</code> is a diagram that shows all possible logical relations between a finite collection of sets. It's constructed with a collection of simple closed curves drawn in a plane, usually circles.</p>

											<div class="chart-container has-scroll text-center">
												<div class="chart svg-center" id="d3-venn-basic<?php echo $value;?>"></div>
											</div>
										</div>
									</div>
								</div>
								<!-- /Topics and Trends -->
							</div>				
							<?php
						}
					}
					if(array_key_exists(5, $user_data_exist_widgets_ids_array)) {					
						foreach ($user_data_exist_widgets_ids_array[5] as $key => $value) {
							?>
							<div class="col-md-12">
								<!-- Desktop and Mobile Performance -->
								<div class="panel panel-flat">
									<div class="panel-heading">
										<h6 class="panel-title"><?php echo $user_data_exist_widgets_names_array[5][$key];?></h6>
										<div class="heading-elements">
											<ul class="icons-list">
						                		<li><a data-action="collapse"></a></li>
						                		<li><a data-action="reload"></a></li>
						                		<li><a data-action="close"></a></li>
						                	</ul>
					                	</div>
									</div>

									<div class="panel-body">
										<p class="content-group">Example of <code>multiple series</code> line chart. The chart employs conventional margins and a number of D3 features: <code>d3.tsv</code> - load and parse data; <code>d3.time.format</code> - parse dates; <code>d3.time.scale</code> - x-position encoding; <code>d3.scale.linear</code> - y-position encoding; <code>d3.scale.category10</code>, <code>d3.scale.ordinal </code>- color encoding; <code>d3.extent</code>, <code>d3.min</code> and <code>d3.max</code> - compute domains; <code>d3.keys</code> - compute column names; <code>d3.svg.axis</code> - display axes; <code>d3.svg.line</code> - display line shape.</p>

										<div class="chart-container">
											<div class="chart" id="d3-line-multi-series<?php echo $value;?>"></div>
										</div>
									</div>
								</div>
								<!-- /Desktop and Mobile Performance -->	
							</div>
							<div class="col-md-6 col-md-offset-3">

								<div class="col-md-6">

									<!-- Available hours -->
									<div class="panel text-center">
										<div class="panel-body">
											<div class="heading-elements">
												<ul class="icons-list">
							                		<li class="dropdown text-muted">
							                			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog3"></i> <span class="caret"></span></a>
														<ul class="dropdown-menu dropdown-menu-right">
															<li><a href="#"><i class="icon-sync"></i> Update data</a></li>
															<li><a href="#"><i class="icon-list-unordered"></i> Detailed log</a></li>
															<li><a href="#"><i class="icon-pie5"></i> Statistics</a></li>
															<li><a href="#"><i class="icon-cross3"></i> Clear list</a></li>
														</ul>
							                		</li>
							                	</ul>
						                	</div>

						                	<!-- Progress counter -->
											<div class="content-group-sm svg-center position-relative" id="hours-available-progress<?php echo $value;?>"></div>
											<!-- /progress counter -->


											<!-- Bars -->
											<div id="hours-available-bars<?php echo $value;?>"></div>
											<!-- /bars -->

										</div>
									</div>
									<!-- /available hours -->

								</div>

								<div class="col-md-6">

									<!-- Productivity goal -->
									<div class="panel text-center">
										<div class="panel-body">
											<div class="heading-elements">
												<ul class="icons-list">
							                		<li class="dropdown text-muted">
							                			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog3"></i> <span class="caret"></span></a>
														<ul class="dropdown-menu dropdown-menu-right">
															<li><a href="#"><i class="icon-sync"></i> Update data</a></li>
															<li><a href="#"><i class="icon-list-unordered"></i> Detailed log</a></li>
															<li><a href="#"><i class="icon-pie5"></i> Statistics</a></li>
															<li><a href="#"><i class="icon-cross3"></i> Clear list</a></li>
														</ul>
							                		</li>
							                	</ul>
											</div>

											<!-- Progress counter -->
											<div class="content-group-sm svg-center position-relative" id="goal-progress<?php echo $value;?>"></div>
											<!-- /progress counter -->

											<!-- Bars -->
											<div id="goal-bars<?php echo $value;?>"></div>
											<!-- /bars -->

										</div>
									</div>
									<!-- /productivity goal -->

								</div>
							</div>									
							<?php
						}
					}
					if(array_key_exists(6, $user_data_exist_widgets_ids_array)) {
						foreach ($user_data_exist_widgets_ids_array[6] as $key => $value) {
					?>
							<div class="col-md-12">
								<!-- Marketing Performance-->
								<div class="panel panel-flat">
									<div class="panel-heading">
										<h6 class="panel-title"><?php echo $user_data_exist_widgets_names_array[6][$key];?></h6>
										<div class="heading-elements">
											<ul class="icons-list">
						                		<li><a data-action="collapse"></a></li>
						                		<li><a data-action="reload"></a></li>
						                		<li><a data-action="close"></a></li>
						                	</ul>
					                	</div>
									</div>

									<div class="panel-body">
										<p class="content-group">Example of simple <code>vertical</code> bar chart based on <code>D3.js</code> library. This simple bar chart is constructed from a TSV file storing the demo data. The chart employs conventional margins and a number of D3 features: <code>d3.tsv</code> - load and parse data; <code>d3.format</code> - format percentages; <code>d3.scale.ordinal</code> - x-position encoding; <code>d3.scale.linear</code> - y-position encoding; <code>d3.max</code> - compute domains; <code>d3.svg.axis</code> - display axes.</p>

										<div class="chart-container">
											<div class="chart" id="d3-bar-vertical<?php echo $value;?>"></div>
										</div>
									</div>
								</div>
								<!-- /Marketing Performance-->

								<!-- /Performance data -Table -->
								<style>
								.td-grey-bg{background-color:#d0cfcf; font-weight:900;}
								.performance-data-table i{font-size:11px;}
								</style>
								<div class="panel panel-flat">
									<div class="panel-heading">
										<h5 class="panel-title">Performance Data -Table</h5>
										<div class="heading-elements">
											<ul class="icons-list">
						                		<li><a data-action="collapse"></a></li>
						                		<li><a data-action="reload"></a></li>
						                		<li><a data-action="close"></a></li>
						                	</ul>
					                	</div>
									<a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>

									<div class="panel-body">
										<div class="table-responsive">
											<table class="table table-bordered table-framed performance-data-table">
												<thead>
													<tr>
														<th class="td-grey-bg"></th>
														<th class="td-grey-bg">Organic Estimate Revenue</th>
														<th class="td-grey-bg">MOM Change</th>
														<th class="td-grey-bg">PPC Estimate Revenue</th>
														<th class="td-grey-bg">MOM Change</th>
														<th class="td-grey-bg">Refferal Estimate Revenue</th>
														<th class="td-grey-bg">MOM Change</th>
													</tr>
												</thead>
												<tbody>
												<?php 
										            $resultPerformance = $conn->query("SELECT * FROM marketing_performance_performance_data WHERE user_id = $uid AND user_widget_id = " .$value);
										            if($countPerformanceDataRows = $resultPerformance->num_rows > 0){
										            	$p=0;
										                while($rowPerformance = $resultPerformance->fetch_assoc()){?>
											                <tr>
											                <td class="td-grey-bg"><?php echo $rowPerformance['name'];?></td>
															<td class="text-center"><i class="glyphicon glyphicon-gbp"></i><?php echo number_format($rowPerformance['Organic Estimate Revenue'],2);?></td>
															<td class="text-center"><span class="pull-left"><i class="glyphicon glyphicon-arrow-up text-success"></i></span> <?php echo $rowPerformance['MOM Change Organic'];?>%</td>
															<td class="text-center"><i class="glyphicon glyphicon-gbp"></i><?php echo number_format($rowPerformance['PPC Estimate Revenue'],2);?></td>
															<td class="text-center"><span class="pull-left"><i class="glyphicon glyphicon-arrow-down text-danger"></i></span> <?php echo $rowPerformance['MOM Change PPC'];?>%</td>
															<td class="text-center"><i class="glyphicon glyphicon-gbp"></i><?php echo number_format($rowPerformance['Refferal Estimate Revenue'],2);?></td>
															<td class="text-center"><span class="pull-left"><i class="glyphicon <?php if($p < 2){ echo " glyphicon-arrow-up text-success" ; }else{ echo " glyphicon-arrow-down text-danger"; }?>"></i></span> <?php echo $rowPerformance['MOM Change Refferal'];?>%</td>
															</tr>
										            	<?php
										            	$p++;
										            	}
										            }else{
										            ?>
														<tr>
															<td class="td-grey-bg">Tesco</td>
															<td class="text-center"><i class="glyphicon glyphicon-gbp" aria-hidden="true"></i>51,949,694.28</td>
															<td class="text-center"><span class="pull-left"><i class="glyphicon glyphicon-arrow-up text-success"></i></span> 12%</td>
															<td class="text-center"><i class="glyphicon glyphicon-gbp" aria-hidden="true"></i>5,646,705.90</td>
															<td class="text-center"><span class="pull-left"><i class="glyphicon glyphicon-arrow-down text-danger"></i></span> 8%</td>
															<td class="text-center"><i class="glyphicon glyphicon-gbp" aria-hidden="true"></i>9,034,729.44</td>
															<td class="text-center"><span class="pull-left"><i class="glyphicon glyphicon-arrow-up text-success"></i></span> 3%</td>
														</tr>
														<tr>
															<td class="td-grey-bg">Asda</td>
															<td class="text-center"><i class="glyphicon glyphicon-gbp" aria-hidden="true"></i>51,949,694.28</td>
															<td class="text-center"><span class="pull-left"><i class="glyphicon glyphicon-arrow-up text-success"></i></span> 7%</td>
															<td class="text-center"><i class="glyphicon glyphicon-gbp" aria-hidden="true"></i>5,646,705.90</td>
															<td class="text-center"><span class="pull-left"><i class="glyphicon glyphicon-arrow-down text-danger"></i></span> 4%</td>
															<td class="text-center"><i class="glyphicon glyphicon-gbp" aria-hidden="true"></i>9,034,729.44</td>
															<td class="text-center"><span class="pull-left"><i class="glyphicon glyphicon-arrow-up text-success"></i></span> 6%</td>
														</tr>
														<tr>
															<td class="td-grey-bg">Sainsburys</td>
															<td class="text-center"><i class="glyphicon glyphicon-gbp" aria-hidden="true"></i>51,949,694.28</td>
															<td class="text-center"><span class="pull-left"><i class="glyphicon glyphicon-arrow-up text-success"></i></span> 8%</td>
															<td class="text-center"><i class="glyphicon glyphicon-gbp" aria-hidden="true"></i>5,646,705.90</td class="text-center">
															<td class="text-center"><span class="pull-left"><i class="glyphicon glyphicon-arrow-down text-danger"></i></span> 6%</td>
															<td class="text-center"><i class="glyphicon glyphicon-gbp" aria-hidden="true"></i>9,034,729.44</td>
															<td class="text-center"><span class="pull-left"><i class="glyphicon glyphicon-arrow-down text-danger"></i></span> 8%</td>
														</tr>
														<tr>
															<td class="td-grey-bg">Morrisons</td>
															<td class="text-center"><i class="glyphicon glyphicon-gbp" aria-hidden="true"></i>51,949,694.28</td>
															<td class="text-center"><span class="pull-left"><i class="glyphicon glyphicon-arrow-up text-success"></i></span> 9%</td>
															<td class="text-center"><i class="glyphicon glyphicon-gbp" aria-hidden="true"></i>5,646,705.90</td>
															<td class="text-center"><span class="pull-left"><i class="glyphicon glyphicon-arrow-down text-danger"></i></span> 5%</td>
															<td class="text-center"><i class="glyphicon glyphicon-gbp" aria-hidden="true"></i>9,034,729.44</td>
															<td class="text-center"><span class="pull-left"><i class="glyphicon glyphicon-arrow-down text-danger"></i></span> 9%</td>
														</tr>
													<?php
													}
													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<!-- /Performance data -Table -->

								<!-- Combined chart -->
								<div class="panel panel-flat">
									<div class="panel-heading">
										<h6 class="panel-title text-semibold">Combination Of Charts</h6>
										<div class="heading-elements">
											<ul class="icons-list">
						                		<li><a data-action="collapse"></a></li>
						                		<li><a data-action="reload"></a></li>
						                		<li><a data-action="close"></a></li>
						                	</ul>
					                	</div>
									</div>

									<div class="panel-body">
										<div class="chart-container">
											<div class="chart" id="c3-combined-chart<?php echo $value;?>"></div>
										</div>
									</div>
								</div>
								<!-- /combined chart -->
							</div>									
					<?php
						}//End for each loop
					}// End if condition
					?>
				</div>
				<!-- /main charts row-->	

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->


		
<?php
require_once(realpath(dirname(__FILE__)).'/template_parts/footer.php');
?>