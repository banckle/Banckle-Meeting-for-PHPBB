<?php
class acp_banckle_meeting_info
{
    function module()
    {
        return array(
            'filename'    => 'acp_banckle_meeting',
            'title'        => 'ACP_BANCKLE_MEETING',
            'version'    => '1.0.0',
            'modes'        => array(
                'index'        => array('title' => 'ACP_BM_INDEX_TITLE', 'auth' => 'acl_a_', 'cat' => array('BanckleMeeting')),
            ),
        );
    }

    function install()
    {
		
    }

    function uninstall()
    {
    }
}
?>