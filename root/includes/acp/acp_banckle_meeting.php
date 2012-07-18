<?php
class acp_banckle_meeting
{
   var $u_action;
   var $new_config;
   function main($id, $mode)
   {
      global $db, $user, $auth, $template;
      global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
      switch($mode)
      {
         case 'index':		 	
            $this->page_title = 'ACP_BANCKLE_MEETING';
            $this->tpl_name = 'acp_banckle_meeting';						
			
			if(isset($_REQUEST['panel']))
			{
				$panel = $_REQUEST['panel'];
			}
			else
			{
				$panel = 'default';
			}
			
			$sql = 'SELECT * FROM phpbb_config WHERE config_name = \'banckle_meeting\'';
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			
			$data = array();
			
			if($row)
			{
				$data['is_active'] = 1;
				$widget_code = $row['config_value'];
			}
			else
			{
				$data['is_active'] = 0;
				$widget_code = "";
			}
						
			if(isset($_POST['widget_code']) && !empty($_POST['widget_code']))
			{
				if(isset($_POST['deactivate'])) $widget_code = "";
				else
				$widget_code = $_POST['widget_code'];
				
				
				if(empty($widget_code)){
					$sql = 'DELETE FROM phpbb_config WHERE config_name = \'banckle_meeting\'';
					$data['active'] = 0;
					$dbresult = $db->sql_query($sql);
					
					$contents = file_get_contents('../index.php');
					
					if(strpos($contents,"include_once('banckle_meeting_widget.php');") !== FALSE)
					{
						$final_str =  str_replace("include_once('banckle_meeting_widget.php');"," ",$contents);
						file_put_contents('../index.php',$final_str);										
					}
					
				}
				else
				{
					$sql = 'INSERT INTO phpbb_config SET config_name = \'banckle_meeting\', config_value = \''. mysql_real_escape_string($widget_code).'\'';
					$dbresult = $db->sql_query($sql);					
					$data['active'] = 1;
					
					$contents = file_get_contents('../index.php');
					
					if(strpos($contents,"include_once('banckle_meeting_widget.php');") === FALSE)
					{
						$pos = strpos($contents,"page_footer();");
						$final_str = substr($contents,0,$pos-1) . " include_once('banckle_meeting_widget.php'); " . substr($contents,$pos,100);
						file_put_contents('../index.php',$final_str);
					}					
				}				
				
				
				$data['panel'] = "default";
			}
			
			//$template->assign_block_vars('data',$data);			
			
			
			$template->assign_vars(array(
    			'CURRENT_URL'    => $this->getCurrentPageUrl(),
				'DASHBOARD_URL'	 => $this->getCurrentPageUrl(array('panel'=>'')),
				'IS_ACTIVE'			 => $data['is_active'],
				'PANEL'			=> $panel,
				'TOKEN'			=> $token,
				'ERROR'			=> $data['error'],
				'WIDGET_CODE'	=> $widget_code
			));				

            break;		 
      }
   }
   
	function getCurrentPageUrl(array $newparams = array(), $remove_others=false, array $remove_exceptions=array())
	{
		$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
		if ($_SERVER["SERVER_PORT"] != "80")
		{
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} 
		else 
		{
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		
		$url_arr = parse_url($pageURL);
		$pageURL = $url_arr['scheme'] . "://" . $url_arr['host'] . $url_arr['path'];
		
		if(count($_SERVER['QUERY_STRING']) > 0 || count($newparams) > 0)
		{
			$pageURL .= "?";
		}
		
		if($remove_others == false)
		{
			if(count($_SERVER['QUERY_STRING']) > 0)
			{
				parse_str($_SERVER['QUERY_STRING'],$params);
			}
		}
		else
		{
			$param = array();
			
			if(count($remove_exceptions) > 0)
			{
				if(count($_SERVER['QUERY_STRING']) > 0)
				{
					parse_str($_SERVER['QUERY_STRING'],$params);
					
					foreach($params as $key => $param)
					{
						if(!in_array($key,$remove_exceptions))
						{
							unset($params[$key]);
						}
					}			
				}			
			}		
		}
		
		$params = array_merge($params,$newparams);
		
		foreach($params as $key => $param){
			if(empty($param) && $param != 0) unset($params[$key]);
		}
				
		
		$pageURL .= http_build_query($params,'','&');
		
		return $pageURL;
	}		
   
}
?>