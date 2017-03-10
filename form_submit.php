<?php
require_once('includes/query.php');
require_once('includes/config.php');

//////****** Login Form Submission ******//////

if(isset($_POST['form_name']) && ($_POST['form_name'] == 'login')){
	$username = $_POST['username'];
	$password = $_POST['password'];
	login($username, $password);
}

//////****** Create User Form Submission ******//////

if(isset($_POST['form_name']) && ($_POST['form_name'] == 'create.user')){
	
	$uname = $_POST['uname'];
	$full_name = $_POST['full-name'];
	$password = $_POST['password'];
	$repeat_password = $_POST['repeat-password'];
	$address_line1 = $_POST['address-line1'];
	$address_line2 = $_POST['address-line2'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip = $_POST['zip'];
	$email = $_POST['email'];
	$country = $_POST['country'];
	$phone = $_POST['phone'];
	$profile = '';
	// Upload user profile image
	if(is_uploaded_file($_FILES['profile']['tmp_name'])){
		$profile_name = $_FILES['profile']['name'];
		$ext = strstr($profile_name, '.');
		$profile_name = time().'-profile'.$ext;
		$upload_dir = UPLOAD_DIR.'profile/';
		$uploaded_path = $upload_dir.$profile_name;
		if(move_uploaded_file($_FILES['profile']['tmp_name'], $uploaded_path)){
			$profile = $profile_name;
		}
	}
	$logo = '';
	// Upload user dashboard logo image
	if(is_uploaded_file($_FILES['user_logo_file']['tmp_name'])){
		$user_logo_name = $_FILES['user_logo_file']['name'];
		$ext = strstr($user_logo_name, '.');
		$user_logo_name = time()."_user_logo".$ext;
		$upload_dir = UPLOAD_DIR.'user_logo/';
		$uploaded_path = $upload_dir.$user_logo_name;
		if(move_uploaded_file($_FILES['user_logo_file']['tmp_name'], $uploaded_path)){
			$logo = $user_logo_name;
		}
	}
	
	$insert_array = array(
							'full_name'	=>	addslashes($full_name),
							'uname'	=>	addslashes($uname),
							'password'	=>	md5($password),
							'email'	=>	$email,
							'phone'	=>	$phone,
							'address_line1'	=>	addslashes($address_line1),
							'address_line2'	=>	addslashes($address_line2),
							'city'	=>	addslashes($city),
							'state'	=>	addslashes($state),
							'zip'	=>	addslashes($zip),
							'country'	=> $country,
							'utype'	=>	2,
							'created' => date('Y-m-d'),
							'status' => 'A',
							'profile' => $profile,
							'logo' => $logo
						  );
	
	
	 $id = insert_row('tbl_user', $insert_array);
	 $_SESSION['msg_create_account'] = CREATE_ACCOUNT_MESSAGE;
	if($id > 0){
	header('Location:user_create');
	}
}

//////****** Update User Form Submission ******//////

if(isset($_POST['form_name']) && ($_POST['form_name'] == 'update.user')){
	$uid = $_POST['uid'];
	$row = get_multiple_rows('tbl_user','*',array('id' => $uid));
	$user_details = $row[0];
	$user_details = $row[0];
	
	$uname = $_POST['uname'];
	$full_name = $_POST['full-name'];
	$repeat_password = $_POST['repeat-password'];
	$address_line1 = $_POST['address-line1'];
	$address_line2 = $_POST['address-line2'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip = $_POST['zip'];
	$email = $_POST['email'];
	$country = $_POST['country'];
	$phone = $_POST['phone'];
	$profile = $user_details['profile'];
	$logo = $user_details['logo'];
	// Upload user profile image
	if(is_uploaded_file($_FILES['profile']['tmp_name'])){
		$profile_name = $_FILES['profile']['name'];
		$ext = strstr($profile_name, '.');
		$profile_name = time().'-profile'.$ext;
		$upload_dir = UPLOAD_DIR.'profile/';
		$uploaded_path = $upload_dir.$profile_name;
		if(move_uploaded_file($_FILES['profile']['tmp_name'], $uploaded_path)){
			$unlink_link = $upload_dir.$profile;
			unlink($unlink_link);
			$profile = $profile_name;
		}
	}
	// Upload new user dashboard logo image
	if(is_uploaded_file($_FILES['user_logo_file']['tmp_name'])){
		$user_logo_name = $_FILES['user_logo_file']['name'];
		$ext = strstr($user_logo_name, '.');
		$user_logo_name = time()."_user_logo".$ext;
		$upload_dir = UPLOAD_DIR.'user_logo/';
		$uploaded_path = $upload_dir.$user_logo_name;
		if(move_uploaded_file($_FILES['user_logo_file']['tmp_name'], $uploaded_path)){
			$logo = $user_logo_name;
		}
	}
	 
	$update_array = array(
							'full_name'	=>	addslashes($full_name),
							'uname'	=>	addslashes($uname),
							'email'	=>	$email,
							'phone'	=>	$phone,
							'address_line1'	=>	addslashes($address_line1),
							'address_line2'	=>	addslashes($address_line2),
							'city'	=>	addslashes($city),
							'state'	=>	addslashes($state),
							'zip'	=>	addslashes($zip),
							'country'	=> $country,
							'profile' => $profile,
							'logo' => $logo
						  );
	
	
	// $id = insert_row('tbl_user', $insert_array);
	 edit_row('tbl_user', $update_array,array('id' => $uid));
	 $_SESSION['msg_create_account'] = UPDATE_ACCOUNT_MESSAGE;
	header('Location:user_create?uid='.$uid);
}

//////****** Change Password ******//////

if(isset($_POST['form_name']) && ($_POST['form_name'] == 'change_pass')){
	$new_password = md5($_POST['new_password']);
	$utype = $_POST['utype'];
	$uid = $_POST['uid'];
	
	$update_array = array(
							'password'	=>	$new_password,
							'utype'	=>	$utype
						  );
	 edit_row('tbl_user', $update_array,array('id' => $uid));
	$_SESSION['msg_change_pass'] = PASSWORD_CHANGE_MESSAGE;
	header('Location:user_create?uid='.$uid);
}

//////****** Edit Widgets ******//////

if(isset($_POST['form_name']) && ($_POST['form_name'] == 'edit.widgets')){
	$widget_id=$_POST['widget_id'];
	$display_name= $_POST['display_name'];

	if( empty($widget_id) || empty($display_name)) {
		echo json_encode(array('status'=>'fail', 'message' => 'Please select all required fields.'));
	}else{
		// Duplicate Widget Display Name Check
		$resultCheck = $conn->query("SELECT * FROM widgets WHERE display_name = '$display_name' AND id != " . $widget_id);
		if($resultCheck->num_rows > 0){
			echo json_encode(array('status'=>'fail', 'message' => 'Duplicate widget name. Please check'));
		}else{
			$result = $conn->query("UPDATE  widgets 
				SET display_name = '$display_name'
				WHERE id = " . $widget_id);

			if ($result) {
				echo json_encode(array('status'=>'success', 'message' => 'Widget has been successfully updated.'));
			} else {
				echo json_encode(array('status'=>'fail', 'message' => 'Widget updation error.'));
			}
		}

	}
}

//////****** Assign Widgets To User Form Submission ******//////

if(isset($_POST['form_name']) && ($_POST['form_name'] == 'assign.widgets')){
	$user_id=$_POST['user_id'];
	$widgets_ids= $_POST['widgets_ids'];

	if( empty($user_id) || empty($widgets_ids)) {
		echo json_encode(array('status'=>'fail', 'message' => 'Please select all required fields.'));
	}else{
		$widgets_ids_array = explode(",", $widgets_ids);
		$i = 1;
		foreach($widgets_ids_array as $widget_id){
			$widget_name = $_POST['widget_name' . $widget_id];
			$result = $conn->query("INSERT INTO  user_widgets(user_id,widget_id,widget_name) values('$user_id','$widget_id','$widget_name')");
			$i++;
		}
		if ($result) {
			echo json_encode(array('status'=>'success', 'message' => 'Widgets have been successfully assigned.'));
		} else {
			echo json_encode(array('status'=>'fail', 'message' => 'Widgets assign error.'));
		}

	}
}

//////****** Edit User Widgets Form Submission ******//////

if(isset($_POST['form_name']) && ($_POST['form_name'] == 'edit.user.widget')){
	$user_id = $_POST['user_id'];
	$widget_id = $_POST['widget_id'];
	$user_widget_id = $_POST['user_widget_id'];
	$widget_name = $_POST['widget_name'];

	if( empty($user_id) || empty($widget_id) || empty($user_widget_id) || empty($widget_name) ) {
		echo json_encode(array('status'=>'fail', 'message' => 'Please select required fields.'));
	}else{
		$result = $conn->query("UPDATE user_widgets 
			SET widget_name = '$widget_name'
			WHERE id = $user_widget_id
			AND user_id = $user_id 
			AND widget_id = " . $widget_id);
		if($result) {
			echo json_encode(array('status'=>'success', 'message' => 'Widget have been successfully updated.'));
		} else {
			echo json_encode(array('status'=>'fail', 'message' => 'Widget updation error.'));
		}

	}
}

//////****** Delete User Widgets Form Submission ******//////

if(isset($_POST['form_name']) && ($_POST['form_name'] == 'delete.user.widget')){
	$user_id = $_POST['user_id'];
	$widget_id = $_POST['widget_id'];
	$user_widget_id = $_POST['user_widget_id'];

	if( empty($user_id) || empty($widget_id) || empty($user_widget_id) ) {
		echo json_encode(array('status'=>'fail', 'message' => 'Please select required fields.'));
	}else{
		$result = $conn->query("DELETE FROM user_widgets 
			WHERE id = $user_widget_id
			AND user_id = $user_id 
			AND widget_id = " . $widget_id);
		if($result) {
			// Making widgets table name array making
			$resultWidgets = $conn->query("SELECT * FROM widgets WHERE id = " . $widget_id);
			$countWidgets = $resultWidgets->num_rows;
			if($countWidgets > 0){
				while($rowWidgets = $resultWidgets->fetch_assoc()){
				 	$widget_name = $rowWidgets['name'];
				 	$change_widget_name = str_replace(" ", "_", strtolower($widget_name));
				 	$widget_table_name = $change_widget_name."_data";
				}
			}
			// Delete unassigned user widgets/charts data
			$widgetDataDeleteResult = $conn->query("DELETE FROM $widget_table_name WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
			if($widget_id == 3){
				$widgetDataDeleteResult = $conn->query("DELETE FROM  brand_sentiment_basics_data WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
			}
			if($widget_id == 6){
				$widgetDataDeleteResult = $conn->query("DELETE FROM 	marketing_performance_performance_data WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
				$widgetDataDeleteResult = $conn->query("DELETE FROM 	marketing_performance_combination_data WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
			}
			echo json_encode(array('status'=>'success', 'message' => 'Deleting widget...'));
		} else {
			echo json_encode(array('status'=>'fail', 'message' => 'Widget deletion error.'));
		}

	}
}

//////****** Import Widget Data Form Submission For Particular User ******//////

if(isset($_POST['form_name']) && ($_POST['form_name'] == 'import.widget.data')){
	$user_id = $_POST['user_id'];
	// widget type id
	$widget_id = $_POST['widget_id'];
	// widget id
	$user_widget_id = $_POST['widget'];
	$resultWidgets = $conn->query("SELECT * FROM widgets WHERE id = " . $widget_id);
	while($rowWidgets = $resultWidgets->fetch_assoc()){
	 	$widget_name = $rowWidgets['name'];
	 	$widget_display_name = $rowWidgets['display_name'];
	}
	$change_widget_name = str_replace(" ", "_", strtolower($widget_name));
	$uploaded_widget_file_name = $change_widget_name."_file";
	$upload_widget_folder_name = $change_widget_name."_files";
	$widget_data_table_name = $change_widget_name."_data";

	////**** For Brand Sentiment Basics File  ******////
	if($widget_id == 3){
		$uploaded_widget_file_basics_name = $change_widget_name."_basics_file";
		$upload_widget_folder_basics_name = $change_widget_name."_basics_files";
		$widget_data_table_basics_name = $change_widget_name."_basics_data";
	}
	////**** For Marketing Performance Widget Performance & Combination File  ******////
	if($widget_id == 6){
		$uploaded_widget_file_performance_name = $change_widget_name."_performance_file";
		$upload_widget_folder_performance_name = $change_widget_name."_performance_files";
		$widget_data_table_performance_name = $change_widget_name."_performance_data";
		$uploaded_widget_file_combination_name = $change_widget_name."_combination_file";
		$upload_widget_folder_combination_name = $change_widget_name."_combination_files";
		$widget_data_table_combination_name = $change_widget_name."_combination_data";
	}

	if(is_uploaded_file($_FILES[$uploaded_widget_file_name]['tmp_name'])){
		
		$widget_file_name = $_FILES[$uploaded_widget_file_name]['name'];

		$ext = strstr($widget_file_name, '.');
		//Check csv file type
		if($ext != ".csv"){
			echo json_encode(array('status'=>'fail', 'message' => 'Wrong file type for ' . $widget_display_name . '. Please check.'));
		}else{
			$widget_file_name = $change_widget_name."_".$user_widget_id."_user_".$user_id.$ext;
			$upload_dir = WIDGET_DIR.$upload_widget_folder_name.'/';
			$uploaded_path = $upload_dir.$widget_file_name;
			

			if(move_uploaded_file($_FILES[$uploaded_widget_file_name]['tmp_name'], $uploaded_path))
			{
				//Import uploaded file to Database
				readfile($uploaded_path);
			    $handle = fopen($uploaded_path, "r");
			    $resultTableColumns = $conn->query("SHOW COLUMNS FROM " . $widget_data_table_name);
			    $columnsArray = array();
			    while($rowWTableColumns = $resultTableColumns->fetch_assoc()){
				 	$columnsArray[] = $rowWTableColumns['Field'];
				}
				$countColumns = count($columnsArray);
				//print_r($columnsArray);


			    $i = 0;
			    while (($csvData = fgetcsv($handle, 301, ",")) !== FALSE) {
			        if($i == 0){//break;
			        	$flgFileError = "false";
			        	// Check no of csv file columns
			        	if(count($csvData) != ($countColumns - 3)){
			        		$flgFileError = "true";
			        	}
			        	// Checking csv column name with table column name
			        	for($c=0; $c < $countColumns; $c++){		
			        		if($csvData[$c] != $columnsArray[$c + 3]){
			        			$flgFileError = "true";
			        			break;
			        		}
			        	}	        	
			        	if($flgFileError == "true"){		        		
							ob_clean();
							flush();
				        	fclose($handle);
			        		echo json_encode(array('status'=>'fail', 'message' => 'Wrong file for ' . $widget_display_name . '. Please check.')); 		
					        // Delete file
			        		unlink($uploaded_path);
			        		break;
			        	}
			        }else{		        	
			        	//Delete previous data from widget table if exist
			        	if($i == 1){
			        	$resultUserWidgetDataDelete = $conn->query("DELETE FROM $widget_data_table_name WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
			        	}
			        	// Insert query generation
			        	$import_query="INSERT INTO  $widget_data_table_name(";
			        	for($j=1; $j < $countColumns; $j++){
			        		if($j == ($countColumns - 1)){
			        			$import_query .= "`".$columnsArray[$j]."`";
			        		}else{
			        			$import_query .= "`".$columnsArray[$j]."`,";
			        		}
			        	}
			        	$import_query .=") values('$user_id','$user_widget_id',";
			        	for($k=0; $k < $countColumns-3; $k++){		        		
			        		if($k == ($countColumns - 4)){
			        			$import_query .= "'".$csvData[$k]."')";
			        		}else{
				        		$import_query .= "'".$csvData[$k]."',";
			        		}
			        	}
			        	//Insert data in widget table
			        	$resultInsert = $conn->query($import_query);
			       	}
			        $i++;

			    }
			    // Close open file if not closed
				if($flgFileError == "false"){
					ob_clean();
					flush();
		        	fclose($handle);
		        }

			    $flgInsertPrimaryFileData = "false";
			    if(isset($resultInsert)){
					if($resultInsert){
						if($widget_id == 3 || $widget_id == 6){
					    	$flgInsertPrimaryFileData = "true";
					    }else{
					    	echo json_encode(array('status'=>'success', 'message' => 'Widget data have been successfully imported.'));
						}
					}else{
						if($widget_id == 3 || $widget_id == 6){
					    	$flgInsertPrimaryFileData = "false";
					    }else{
					    	// Delete other file and data
			        		$resultDelete = $conn->query("DELETE FROM $widget_data_table_name WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
			        		unlink($uploaded_path);
			        		echo json_encode(array('status'=>'fail', 'message' => 'Error in uploaded file. Please check.'));
						}
					}
				}
			}
		}

		////**** Brand Sentiment Basics Widget Data Import ******////
		if($widget_id == 3 && $flgInsertPrimaryFileData == "true"){
			if(is_uploaded_file($_FILES[$uploaded_widget_file_basics_name]['tmp_name'])){
		
				$widget_file_basics_name = $_FILES[$uploaded_widget_file_basics_name]['name'];

				$extBasics = strstr($widget_file_basics_name, '.');
				//Check csv file type
				if($extBasics != ".csv"){
					// Delete Brand Sentiment file and data
	        		$resultDelete = $conn->query("DELETE FROM $widget_data_table_name WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
	        		unlink($uploaded_path);
	        		echo json_encode(array('status'=>'fail', 'message' => 'Wrong file type for Basics Charts. Please check.'));
				}else{
					$widget_file_basics_name = $change_widget_name."_".$user_widget_id."_basics_user_".$user_id.$extBasics;
					$upload_dir = WIDGET_DIR.$upload_widget_folder_basics_name.'/';
					$uploaded_basics_path = $upload_dir.$widget_file_basics_name;
					

					if(move_uploaded_file($_FILES[$uploaded_widget_file_basics_name]['tmp_name'], $uploaded_basics_path))
					{
						//Import uploaded file to Database

						readfile($uploaded_basics_path);
					    $handleBasics = fopen($uploaded_basics_path, "r");
					    $resultTableColumns = $conn->query("SHOW COLUMNS FROM " . $widget_data_table_basics_name);
					    $columnsArray = array();
					    while($rowWTableColumns = $resultTableColumns->fetch_assoc()){
						 	$columnsArray[] = $rowWTableColumns['Field'];
						}
						$countColumns = count($columnsArray);
						//print_r($columnsArray);


					    $i = 0;
					    while (($csvData = fgetcsv($handleBasics, 301, ",")) !== FALSE) {
					        if($i == 0){
					        	$flgBasicsFileError = "false";
					        	// Check no of csv file columns
					        	if(count($csvData) != ($countColumns - 3)){
					        		$flgBasicsFileError = "true";
					        	}
					        	// Checking csv column name with table column name
					        	for($c=0; $c < $countColumns-3; $c++){		        		
					        		if($csvData[$c] != $columnsArray[$c + 3]){
					        			$flgBasicsFileError = "true";
					        			break;
					        		}
					        	}
					        	if($flgBasicsFileError == "true"){
					        		ob_clean();
									flush();
						        	fclose($handleBasics);
					        		echo json_encode(array('status'=>'fail', 'message' => 'Wrong file for Basics Charts. Please check.'));
					        		// Delete Brand Sentiment file and data
					        		$resultDelete = $conn->query("DELETE FROM $widget_data_table_name WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
					        		unlink($uploaded_path);
					        		// Delete file
					        		unlink($uploaded_basics_path);
					        		break;
					        	}
					        }else{
					        	//Delete previous data from widget basics table if exist
					        	if($i == 1){
					        	$resultUserWidgetBasicsDataDelete = $conn->query("DELETE FROM $widget_data_table_basics_name WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
					        	}
					        	// Insert query generation
					        	$import_query="INSERT INTO  $widget_data_table_basics_name(";
					        	for($j=1; $j < $countColumns; $j++){
					        		if($j == ($countColumns - 1)){
					        			$import_query .= "`".$columnsArray[$j]."`";
					        		}else{
					        			$import_query .= "`".$columnsArray[$j]."`,";
					        		}
					        	}
					        	$import_query .=") values('$user_id','$user_widget_id',";
					        	for($k=0; $k < $countColumns-3; $k++){
					        		
					        		if($k == ($countColumns - 4)){
					        			$import_query .= "'".$csvData[$k]."')";
					        		}else{
						        		$import_query .= "'".$csvData[$k]."',";
					        		}
					        	}
					        	//Insert data in widget table
					        	$resultInsertBasics = $conn->query($import_query);
					       	}
					        $i++;
					    }
					    // Close open basics file if not closed
						if($flgBasicsFileError == "false"){
							ob_clean();
							flush();
				        	fclose($handleBasics);
				        }
					    if(isset($resultInsertBasics)){
							if($resultInsertBasics){
								echo json_encode(array('status'=>'success', 'message' => 'Widget data have been successfully imported.'));
							}else{
								// Delete Brand Sentiment file and data
				        		$resultDelete = $conn->query("DELETE FROM $widget_data_table_name WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
				        		unlink($uploaded_path);
				        		// Delete file
					        	unlink($uploaded_basics_path);
					        	echo json_encode(array('status'=>'fail', 'message' => 'Error in uploaded file. Please check.'));
							}
						}
					}
				}
			}else{
				// Delete Brand Sentiment file and data
	    		$resultDelete = $conn->query("DELETE FROM $widget_data_table_name WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
	    		unlink($uploaded_path);
	    		echo json_encode(array('status'=>'fail', 'message' => 'Please upload file.'));
			}
		}
		////**** End Brand Sentiment Basics Widget Data Import ******////

		////**** Marketing Performance -- Performance & Combination Widget Data Import ******////
		if($widget_id == 6 && $flgInsertPrimaryFileData == "true"){

		////**** Performance Data Import ****////
			if(is_uploaded_file($_FILES[$uploaded_widget_file_performance_name]['tmp_name'])){
		
				$widget_file_performance_name = $_FILES[$uploaded_widget_file_performance_name]['name'];

				$extPerformance = strstr($widget_file_performance_name, '.');
				//Check csv file type
				if($extPerformance != ".csv"){
					// Delete other file and data
	        		$resultDelete = $conn->query("DELETE FROM $widget_data_table_name WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
	        		unlink($uploaded_path);
	        		echo json_encode(array('status'=>'fail', 'message' => 'Wrong file type for Performance Data Table. Please check.'));
				}else{
					$widget_file_performance_name = $change_widget_name."_".$user_widget_id."_performance_user_".$user_id.$extPerformance;
					$upload_dir = WIDGET_DIR.$upload_widget_folder_performance_name.'/';
					$uploaded_performance_path = $upload_dir.$widget_file_performance_name;
					

					if(move_uploaded_file($_FILES[$uploaded_widget_file_performance_name]['tmp_name'], $uploaded_performance_path))
					{
						//Import uploaded file to Database

						readfile($uploaded_performance_path);
					    $handlePerformance = fopen($uploaded_performance_path, "r");
					    $resultTableColumns = $conn->query("SHOW COLUMNS FROM " . $widget_data_table_performance_name);
					    $columnsArray = array();
					    while($rowWTableColumns = $resultTableColumns->fetch_assoc()){
						 	$columnsArray[] = $rowWTableColumns['Field'];
						}
						$countColumns = count($columnsArray);
						//print_r($columnsArray);


					    $i = 0;
					    while (($csvData = fgetcsv($handlePerformance, 301, ",")) !== FALSE) {
					        if($i == 0){
					        	$flgPerformanceFileError = "false";
					        	// Check no of csv file columns
					        	if(count($csvData) != ($countColumns - 3)){
					        		$flgPerformanceFileError = "true";
					        	}
					        	// Checking csv column name with table column name
					        	for($c=0; $c < $countColumns-3; $c++){		        		
					        		if($csvData[$c] != $columnsArray[$c + 3]){
					        			$flgPerformanceFileError = "true";
					        			break;
					        		}
					        	}
					        	if($flgPerformanceFileError == "true"){
					        		ob_clean();
									flush();
						        	fclose($handlePerformance);
					        		echo json_encode(array('status'=>'fail', 'message' => 'Wrong file for Performance Data Table. Please check.'));
					        		// Delete Marketing Performance file and data
					        		$resultDelete = $conn->query("DELETE FROM $widget_data_table_name WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
					        		unlink($uploaded_path);
					        		// Delete file
					        		unlink($uploaded_performance_path);
					        		break;
					        	}
					        }else{
					        	//Delete previous data from widget performance table if exist
					        	if($i == 1){
					        	$resultUserWidgetPerformanceDataDelete = $conn->query("DELETE FROM $widget_data_table_performance_name WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
					        	}
					        	// Insert query generation
					        	$import_query="INSERT INTO  $widget_data_table_performance_name(";
					        	for($j=1; $j < $countColumns; $j++){
					        		if($j == ($countColumns - 1)){
					        			$import_query .= "`".$columnsArray[$j]."`";
					        		}else{
					        			$import_query .= "`".$columnsArray[$j]."`,";
					        		}
					        	}
					        	$import_query .=") values('$user_id','$user_widget_id',";
					        	for($k=0; $k < $countColumns-3; $k++){
					        		
					        		if($k == ($countColumns - 4)){
					        			$import_query .= "'".$csvData[$k]."')";
					        		}else{
						        		$import_query .= "'".$csvData[$k]."',";
					        		}
					        	}
					        	//Insert data in widget table
					        	$resultInsertPerformance = $conn->query($import_query);
					       	}
					        $i++;
					    }
					    // Close open performance file if not closed
						if($flgPerformanceFileError == "false"){
							ob_clean();
							flush();
				        	fclose($handlePerformance);
				        }
				        $flgInsertPerformanceFileData = "false";
					    if(isset($resultInsertPerformance)){
							if($resultInsertPerformance){
								$flgInsertPerformanceFileData = "true";
								//echo json_encode(array('status'=>'success', 'message' => 'Widget data have been successfully imported.'));
							}else{
								$flgInsertPerformanceFileData = "false";
								// Delete Marketing Performance file and data
				        		$resultDelete = $conn->query("DELETE FROM $widget_data_table_name WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
				        		unlink($uploaded_path);
				        		// Delete file
					        	unlink($uploaded_performance_path);
					        	echo json_encode(array('status'=>'fail', 'message' => 'Error in uploaded file. Please check.'));
							}
						}
					}
				}
			}else{
				$flgInsertPerformanceFileData = "false";
				// Delete Marketing Performance file and data
	    		$resultDelete = $conn->query("DELETE FROM $widget_data_table_name WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
	    		unlink($uploaded_path);
	    		echo json_encode(array('status'=>'fail', 'message' => 'Please upload file.'));
			}

	 		////******* Combination Data Import ****////
	 		if($flgInsertPerformanceFileData == "true"){
				if(is_uploaded_file($_FILES[$uploaded_widget_file_combination_name]['tmp_name'])){
			
					$widget_file_combination_name = $_FILES[$uploaded_widget_file_combination_name]['name'];

					$extCombination = strstr($widget_file_combination_name, '.');
					//Check csv file type
					if($extCombination != ".csv"){
						// Delete Primary file and data
		        		$resultDelete = $conn->query("DELETE FROM $widget_data_table_name WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
		        		unlink($uploaded_path);
		        		// Delete Performance file and data
				        $resultDelete = $conn->query("DELETE FROM $widget_data_table_performance_name WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
					    unlink($uploaded_performance_path);
		        		echo json_encode(array('status'=>'fail', 'message' => 'Wrong file type for Combination Of Charts. Please check.'));
					}else{
						$widget_file_combination_name = $change_widget_name."_".$user_widget_id."_combination_user_".$user_id.$extCombination;
						$upload_dir = WIDGET_DIR.$upload_widget_folder_combination_name.'/';
						$uploaded_combination_path = $upload_dir.$widget_file_combination_name;
						

						if(move_uploaded_file($_FILES[$uploaded_widget_file_combination_name]['tmp_name'], $uploaded_combination_path))
						{
							//Import uploaded file to Database

							readfile($uploaded_combination_path);
						    $handleCombination = fopen($uploaded_combination_path, "r");
						    $resultTableColumns = $conn->query("SHOW COLUMNS FROM " . $widget_data_table_combination_name);
						    $columnsArray = array();
						    while($rowWTableColumns = $resultTableColumns->fetch_assoc()){
							 	$columnsArray[] = $rowWTableColumns['Field'];
							}
							$countColumns = count($columnsArray);
							//print_r($columnsArray);


						    $i = 0;
						    while (($csvData = fgetcsv($handleCombination, 301, ",")) !== FALSE) {
						        if($i == 0){
						        	$flgCombinationFileError = "false";
						        	// Check no of csv file columns
						        	if(count($csvData) != ($countColumns - 3)){
						        		$flgCombinationFileError = "true";
						        	}
						        	// Checking csv column name with table column name
						        	for($c=0; $c < $countColumns-3; $c++){		        		
						        		if($csvData[$c] != $columnsArray[$c + 3]){
						        			$flgCombinationFileError = "true";
						        			break;
						        		}
						        	}
						        	if($flgCombinationFileError == "true"){
						        		ob_clean();
										flush();
							        	fclose($handleCombination);
						        		echo json_encode(array('status'=>'fail', 'message' => 'Wrong file for Combination Of Charts. Please check.'));
						        		// Delete Primary file and data
						        		$resultDelete = $conn->query("DELETE FROM $widget_data_table_name WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
						        		unlink($uploaded_path);
						        		// Delete Performance file and data
								        $resultDelete = $conn->query("DELETE FROM $widget_data_table_performance_name WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
									    unlink($uploaded_performance_path);
						        		// Delete file
						        		unlink($uploaded_combination_path);
						        		break;
						        	}
						        }else{
						        	//Delete previous data from widget combination table if exist
						        	if($i == 1){
						        	$resultUserWidgetCombinationDataDelete = $conn->query("DELETE FROM $widget_data_table_combination_name WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
						        	}
						        	// Insert query generation
						        	$import_query="INSERT INTO  $widget_data_table_combination_name(";
						        	for($j=1; $j < $countColumns; $j++){
						        		if($j == ($countColumns - 1)){
						        			$import_query .= "`".$columnsArray[$j]."`";
						        		}else{
						        			$import_query .= "`".$columnsArray[$j]."`,";
						        		}
						        	}
						        	$import_query .=") values('$user_id','$user_widget_id',";
						        	for($k=0; $k < $countColumns-3; $k++){
						        		
						        		if($k == ($countColumns - 4)){
						        			$import_query .= "'".$csvData[$k]."')";
						        		}else{
							        		$import_query .= "'".$csvData[$k]."',";
						        		}
						        	}
						        	//Insert data in widget table
						        	$resultInsertCombination = $conn->query($import_query);
						       	}
						        $i++;
						    }
						    // Close open combination file if not closed
							if($flgCombinationFileError == "false"){
								ob_clean();
								flush();
					        	fclose($handleCombination);
					        }

						    if(isset($resultInsertCombination)){
								if($resultInsertCombination){
									echo json_encode(array('status'=>'success', 'message' => 'Widget data have been successfully imported.'));
								}else{
									// Delete Primary file and data
					        		$resultDelete = $conn->query("DELETE FROM $widget_data_table_name WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
					        		unlink($uploaded_path);
					        		// Delete Performance file and data
							        $resultDelete = $conn->query("DELETE FROM $widget_data_table_performance_name WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
					        		// Delete file
						        	unlink($uploaded_combination_path);
						        	echo json_encode(array('status'=>'fail', 'message' => 'Error in uploaded file. Please check.'));
								}
							}
						}
					}
				}else{
					// Delete Primary file and data
	        		$resultDelete = $conn->query("DELETE FROM $widget_data_table_name WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
	        		unlink($uploaded_path);
	        		// Delete Performance file and data
			        $resultDelete = $conn->query("DELETE FROM $widget_data_table_performance_name WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
				    unlink($uploaded_performance_path);
		    		echo json_encode(array('status'=>'fail', 'message' => 'Please upload file.'));
				}
			}
		}
		////**** End Marketing Performance-- Performance & Combination Widget Data Import ******////

	}else{
		echo json_encode(array('status'=>'fail', 'message' => 'Please upload file.'));
	}
}

//////****** Upload Dashboard Logo Form Submission ******//////

if(isset($_POST['form_name']) && ($_POST['form_name'] == 'upload.logo')){
	if(is_uploaded_file($_FILES['logo_file']['tmp_name'])){
		$logo_name = $_FILES['logo_file']['name'];
		$ext = strstr($logo_name, '.');
		$logo_name = "dashboard_logo".$ext;
		$upload_dir = UPLOAD_DIR;
		$uploaded_path = $upload_dir.$logo_name;
		if(move_uploaded_file($_FILES['logo_file']['tmp_name'], $uploaded_path)){
			$logo = $logo_name;
		}
		$resultLogoExist = $conn->query("SELECT * FROM dashboard_logo");
		if($resultLogoExist->num_rows > 0){
			while($rowLogoExist = $resultLogoExist->fetch_assoc()){
				$id = $rowLogoExist['id'];
			}
			$result = $conn->query("UPDATE dashboard_logo 
				SET logo = '$logo'
				WHERE id = " . $id);
		}else{
			$result = $conn->query("INSERT INTO dashboard_logo(logo) values('$logo')"); 
		}

		if($result) {
			echo json_encode(array('status'=>'success', 'message' => 'Logo has been successfully uploaded.'));
		} else {
			echo json_encode(array('status'=>'fail', 'message' => 'Logo uploading error.'));
		}
	}else {
		echo json_encode(array('status'=>'fail', 'message' => 'Please upload logo.'));
	}
}

?>