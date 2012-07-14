<?php
/**
* DO NOT CHANGE
*/
if (empty($lang) || !is_array($lang))
{
    $lang = array();
}
// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
    'ACP_BM_INDEX_TITLE'                        => 'Banckle Meeting',
	'ACP_BANCKLE_MEETING'							=> 'Banckle Meeting',
	'ACP_BANCKLE_MEETING_SETTINGS'					=> 'Banckle Meeting - Settings',
	'ACP_BM_SETTINGS_TITLE'						=> 'Banckle Meeting - Settings',
	
));
?>