<?php
require_once(realpath(dirname(__FILE__)).'/' .'query.php');
if(isset($_POST['action']) && ($_POST['action'] == 'check_email')){
$uid = $_POST['uid'];
$email = $_POST['email'];
//exit();
if(isset($uid) && ($uid > 0)){

$chk = check_row('tbl_user','email','id != '.$uid.' AND email = "'.$email.'"');
if($chk > 0){
echo 0;
} else {
echo 1;
}

} else {
$chk = get_multiple_rows('tbl_user','email',array('email' => $email));
if(count($chk) > 0){
echo 0;
} else {
echo 1;
}
}

exit();
}



if(isset($_POST['action']) && ($_POST['action'] == 'check_uname')){
$uid = $_POST['uid'];
$uname = $_POST['uname'];
//exit();
if(isset($uid) && ($uid > 0)){

$chk = check_row('tbl_user','uname','id != '.$uid.' AND uname = "'.$uname.'"');
if($chk > 0){
echo 0;
} else {
echo 1;
}

} else {
$chk = get_multiple_rows('tbl_user','uname',array('uname' => $uname));
if(count($chk) > 0){
echo 0;
} else {
echo 1;
}
}

exit();
}




if(isset($_POST['action']) && ($_POST['action'] == 'login_recover')){
$email = $_POST['email'];
$chk = get_multiple_rows('tbl_user','email',array('email' => $_POST['email']));
if(count($chk) > 0){
// mail send here for password recovery
$rand_string = rand_string( 20 );
edit_row(tbl_user, array('password' => md5($rand_string)),array('email' => $email));
$to = $email;
$subject = "New Password";
$txt = "Your New Password for Site http://researchspyder.com is: ".$rand_string;
$headers = "From: ".ADMIN_EMAIL . "\r\n";

mail($to,$subject,$txt,$headers);

	

echo ' succ';
} else {
echo 'err';
}


exit();
}

?>