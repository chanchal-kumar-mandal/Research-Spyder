<?php
define("SITE_URL", "http://127.0.0.1:81/researchspyder/");
define("ADMIN_EMAIL", "chanchal@eclecticsolutions.in");
define("LOGIN_REDIRECT", SITE_URL."dashboard");
define("LOGOUT_URL", SITE_URL);

define("IMAGE_DIR", "assets/images/");
define("UPLOAD_DIR", "assets/images/upload/");
define("WIDGET_DIR", "assets/widgets_files/");
define("CREATE_ACCOUNT_MESSAGE", "Account has been successfully created.");
define("UPDATE_ACCOUNT_MESSAGE", "Account has been successfully updated.");
define("PASSWORD_CHANGE_MESSAGE", "Password has been successfully changed.");
$page_url = $_SERVER['REQUEST_URI'];
$url = substr($page_url,1);
$url_part = explode('?',$url);
$final_url = $url_part[0];
$final_url = str_replace('-',' ',$final_url);
$final_url = str_replace('_',' ',$final_url);
define("PAGE_TITLE", ucwords($final_url));
$file_arr = explode('/',$url_part[0]);
define("PAGE_FILE", $file_arr[1]);
define("PATH_ROOT", realpath(dirname(__FILE__)).'/');
define("COPYRIGHT_TEXT", 'Copyright 2016. Research Spider');

?>