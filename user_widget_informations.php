<?php
header('note-type: application/json');
require_once(realpath(dirname(__FILE__)).'/' .'includes/connection.php');

//Fetching Values from URL
$user_id=$_POST['user_id'];
$widget_id=$_POST['widget_id'];

if( empty($user_id)) {
	echo json_encode(array('status'=>'fail', 'message' => 'Please select user.'));
}else{
	$resultUserWidgets = $conn->query("SELECT * FROM user_widgets WHERE user_id = $user_id AND widget_id = " . $widget_id);
	$user_widgets_info = array();
	if($resultUserWidgets->num_rows > 0){
		$i =0;
		while($rowUserWidgets = $resultUserWidgets->fetch_assoc()){
			$user_widgets_info[$i]['id'] = $rowUserWidgets['id'];
			$user_widgets_info[$i]['widget_name'] = $rowUserWidgets['widget_name'];
			$i++;
		}
	}
	echo json_encode(array('status'=>'success', 'data' => json_encode($user_widgets_info)));
}

?>