<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2014 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 */
if (!defined('e107_INIT')) { exit; }
include_lan(e_PLUGIN."content/languages/".e_LANGUAGE."/lan_content.php");

class content_notify extends notify // plugin-folder + '_notify' 
{		
	function config()
	{
		
		$config = array();
	
		$config[] = array(
			'name'			=> CONTENT_NOTIFY_LAN_2, //  "Message posted"
			'function'		=> "content",
			'category'		=> CONTENT_NOTIFY_LAN_1
		);	
		
		return $config;
	}
	
	function content($data) 
	{
	
 
		foreach ($data as $key => $value)
		{
			$message .= $key.': '.$value.'<br />';
		}
		$this->send('content', CONTENT_NOTIFY_LAN_3, $message);
	}
	
}

?>