<?php
define('IN_PHPBB', true);
// Specify the path to you phpBB3 installation directory.
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : '';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
// The common.php file is required.
include_once($phpbb_root_path . 'common.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);

$user->setup();

global $db, $user, $auth, $template;

$sql = 'SELECT * FROM phpbb_config WHERE config_name = \'banckle_meeting\'';
$result = $db->sql_query($sql);
$row = $db->sql_fetchrow($result);

if(!empty($row))
{
	$widget = $row['config_value'];
}
else
{
	$widget = "";
}

if($widget != "")
{
	preg_match('|<iframe [^>]*(src="[^"]+")[^>]*|', $widget, $matches);
	$url = substr(rtrim($matches[1],'"'),5);
	
	
	$contents = file_get_contents($url);
	$content_arr = json_decode($contents);
	
	if(isset($content_arr->error))
	{
		$widget = "";
	}
}

echo '<div style="overflow: hidden; margin: 0pt; padding: 0pt; background: none repeat scroll 0% 0% transparent; width: 320px; height: 408px; z-index: 1000000000; position: fixed; bottom: -80px; right: 20px;">'.$widget.'</div>';

//your PHP and/or HTML code goes here

?>