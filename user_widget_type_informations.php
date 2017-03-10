<?php
header('note-type: application/json');
require_once(realpath(dirname(__FILE__)).'/' .'includes/connection.php');

//Fetching Values from URL
$user_id=$_POST['user_id'];

if( empty($user_id)) {
	echo json_encode(array('status'=>'fail', 'message' => 'Please select user.'));
}else{
	$resultUserWidgets = $conn->query("SELECT DISTINCT widget_id FROM user_widgets WHERE user_id = " . $user_id);
	if($resultUserWidgets->num_rows > 0){
		$user_widgets_ids_array = array();
		while($rowUserWidgets = $resultUserWidgets->fetch_assoc()){
			$user_widgets_ids_array[] = $rowUserWidgets['widget_id'];
		}
		$user_widgets_ids = implode(",", $user_widgets_ids_array);

		$resultWidgets = $conn->query("SELECT * FROM widgets WHERE id IN ($user_widgets_ids)");
		$user_widgets_info = array();
		$i =0;
		while($rowWidgets = $resultWidgets->fetch_assoc()){
			$user_widgets_info[$i]['id'] = $rowWidgets['id'];
			$user_widgets_info[$i]['name'] = $rowWidgets['name'];
			$user_widgets_info[$i]['display_name'] = $rowWidgets['display_name'];
			$i++;
		}
		echo json_encode(array('status'=>'success', 'data' => json_encode($user_widgets_info)));
	}else{
		echo json_encode(array('status'=>'fail', 'message' => 'No widget type found.'));
	}
}

?>