<?php
header('note-type: application/json');
require_once(realpath(dirname(__FILE__)).'/' .'includes/connection.php');

//Fetching Values from URL
$user_id=$_POST['user_id'];
$widget_id=$_POST['widget_id'];
$user_widget_id=$_POST['widget'];
$resultWidgets = $conn->query("SELECT * FROM widgets WHERE id = " . $widget_id);
while($rowWidgets = $resultWidgets->fetch_assoc()){
 	$widget_name = $rowWidgets['name'];
}
$change_widget_name = str_replace(" ", "_", strtolower($widget_name));
$widget_data_table_name = $change_widget_name."_data";

if( empty($user_id) || empty($widget_id)) {
	echo json_encode(array('status'=>'fail', 'message' => 'Please select user and widget.'));
}else{
	$resultUserWidgets = $conn->query("SELECT * FROM $widget_data_table_name WHERE user_id = $user_id AND user_widget_id = " . $user_widget_id);
	if($resultUserWidgets->num_rows > 0){
		echo json_encode(array('status'=>'success', 'data' => "exist"));
	}else{
		echo json_encode(array('status'=>'success', 'data' => "not exist"));
	}
	
}

?>