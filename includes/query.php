<?php
require_once(realpath(dirname(__FILE__)).'/' .'connection.php');
require_once(realpath(dirname(__FILE__)).'/' .'functions.php');
function login($user_name, $password){
	global $conn;
	$query = "SELECT * FROM tbl_user WHERE uname='".$user_name."' AND password='".md5($password)."'";
	$result = $conn->query($query);
	
	$row = $result->fetch_assoc();
	$check = count($row);
	if($check > 0){
		$uid = $row['id'];
		$fname = $row['fname'];
		
		$lname = $row['lname'];
		$uname = $row['uname'];
		$email = $row['email'];
		$utype = $row['utype'];
		$created = $row['created'];
		$_SESSION['is_login'] = true;
		$_SESSION['uname'] = $uname;
		$_SESSION['utype'] = $utype;
		$_SESSION['uid'] = $uid;
		header('Location:'.LOGIN_REDIRECT);
	} else {
		header('Location:'.SITE_URL.'?login=error');
	}
}



function insert_row($tbl_name, $insert_array){
	global $conn;
	$set = '';
	if(is_array($insert_array)){
	
	$set .= " SET ";
	$set_val = '';
	foreach($insert_array as $keys => $vals){
		$set_val .= ', '.$keys.' = "'.$vals.'"';
	}
	$set .= substr($set_val,2);
	}
	
	 $sql = "INSERT INTO ".$tbl_name.$set;
	 $conn->query($sql);
     return $last_id = $conn->insert_id;
	//return $sql;
}



function get_multiple_rows($tbl_name,$fields_array,$where_array){
global $conn;
$tbl = $tbl_name;
$query = 'SELECT ';
$select = '';
if(is_array($fields_array)){
	foreach($fields_array as $flds){
		$select .= ', '.$flds;
	}
	$select = substr($select,2);
} else {
	$select = '*';
}

$where_clause = '';
if(is_array($where_array)){
	$where_clause .= ' WHERE ';
	$where = '';
	foreach($where_array as $key => $val){
		$where .= ' AND '.$key.' = "'.$val.'"';
	}
	$where_clause .= substr($where,5);
}

 $query .= $select.' FROM '.$tbl.$where_clause;
//echo '<hr />';
$result = $conn->query($query);

$return = array();
while($row = $result->fetch_assoc()) {
	$return[] = $row;
}

return $return;
}


function rand_string( $length ) {

$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
return substr(str_shuffle($chars),0,$length);

}


function edit_row($tbl_name, $update_data_array,$where_array){

global $conn;
$tbl = $tbl_name;



$set = '';
if(is_array($update_data_array)){

$set .= " SET ";
$set_val = '';
foreach($update_data_array as $keys => $vals){
	$set_val .= ', '.$keys.' = "'.$vals.'"';
}
$set .= substr($set_val,2);
}



$where_clause = '';
$where = '';
if(is_array($where_array)){
$where_clause .= " WHERE ";
	foreach($where_array as $key => $val){
		$where .= ' AND '.$key.' = "'.$val.'"';
	}
	$where_clause .= substr($where,5);
}

$sql = "UPDATE ".$tbl.$set.$where_clause;


if ($conn->query($sql) === TRUE) {
    echo "Record Updated successfully";
} else {
    echo "Error Updating record: " . $conn->error;
}

}


function check_row($tbl_name,$fields,$where_clause){

global $conn;
$query = 'SELECT ';
$select = '';
if(isset($fields)){
	$select = $fields;
} else {
	$select = '*';
}


$where_clause = ' WHERE '.$where_clause;

//return $query .= $select.' FROM '.$tbl_name.$where_clause;
$query .= $select.' FROM '.$tbl_name.$where_clause;
//exit;
$result = $conn->query($query);

/*$return = array();
while($row = $result->fetch_assoc()) {
	$return[] = $row;
}*/


	
	$row = $result->fetch_assoc();
	$check = count($row);


//$row = $result->fetch_assoc();

//return count($return);
return $check;
}


 

function all_country_list($fld_name,$fld_id,$fld_class,$select_val,$map){
global $conn;
$query = 'SELECT * FROM tbl_countries WHERE status="Y"';

$result = $conn->query($query);

$return = '<select name="'.$fld_name.'" id="'.$fld_id.'" class="'.$fld_class.'">';

while($row = $result->fetch_assoc()) {

	
	
	 $opt = $row['title'];

	if($row['id'] == $select_val){
		if($map == 1){
			$map_img = strtolower($row['iso_code']).'.png';
			$src = IMAGE_DIR.'flags/'.$map_img;
			$return .= '<option style="background-image:url('.$src.') no-repeat scroll right center; display:block; padding-right:20px;" selected="selected" value="'.$row['id'].'">'.$opt.'</option>';
		}else{
			$return .= '<option selected="selected" value="'.$row['id'].'">'.$opt.'</option>';
		}
	
		
	} else {
		if($map == 1){
			$map_img = strtolower($row['iso_code']).'.png';
			$src = IMAGE_DIR.'flags/'.$map_img;
			$return .= '<option style="background-image:url('.$src.') no-repeat scroll right center; display:block; padding-right:20px;" value="'.$row['id'].'">'.$opt.'</option>';
		}else{
			$return .= '<option value="'.$row['id'].'">'.$opt.'</option>';
		}
	}
	
}
$return .= '</select>';
return $return;

}



function delete_rows($tbl_name,$where_array){
global $conn;
$tbl = $tbl_name;

$sql = "DELETE FROM ".$tbl;


$where_clause = '';
$where = '';
if(is_array($where_array)){
$where_clause .= " WHERE ";
	foreach($where_array as $key => $val){
		$where .= ' AND '.$key.' = "'.$val.'"';
	}
	$where_clause .= substr($where,5);
}

$sql .= $where_clause;

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

}



?>