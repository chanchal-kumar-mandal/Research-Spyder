<?php
require_once('includes/query.php');
require_once('includes/config.php');
// Delete user temporay folder with files
$unique_user_with_id = "user_".$_SESSION['uid'];
$temp_user_widget_folder_path = WIDGET_DIR.'temp_files/'.$unique_user_with_id;

if(file_exists($temp_user_widget_folder_path)){
	// Delete all files from user teporary folder
	array_map('unlink', glob("$temp_user_widget_folder_path/*.*"));
    rmdir($temp_user_widget_folder_path);
}
session_destroy();
header('Location:'.LOGOUT_URL);
?>