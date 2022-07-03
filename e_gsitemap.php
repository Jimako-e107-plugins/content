<?php
/*
* e107 website system
*
* Copyright (C) 2008-2018 e107 Inc (e107.org)
* Released under the terms and conditions of the
* GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
*
*	gSitemap addon
*/

if (!defined('e107_INIT'))
{
	exit;
}

$plugindir		= e_PLUGIN."content/";
include_lan($plugindir.'languages/'.e_LANGUAGE.'/lan_content_sitemap.php');
 
// v2.x Standard
// there is missing lan for Download category in global lan file

class content_gsitemap
{
	function import()
	{
		$import = array();
		$sql = e107::getDb();
		$tp = e107::getParser();
		
				/* public, quests */
		$userclass_list = "0,252";
		$_t = time();
		$datequery = " AND content_datestamp < ".$_t." AND (content_enddate=0 || content_enddate>".$_t.") ";
 
		$data = $sql->retrieve("pcontent", "*", "content_class IN (" . $userclass_list . ")   ".$datequery."    ORDER BY content_datestamp ASC", true);

    $iscanonicalinstalled = e107::isInstalled('jm_canonical');
    
		foreach($data as $row)
		{
		  
		  
      $title = $row['content_heading'] = $tp -> toHTML($row['content_heading'], TRUE, "emotes_off, no_make_clickable");
		  $row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
			if($row['content_parent'] == 0){
				$row['content_query'] = "?cat.".$row['content_id'];
			}else{
				if(strpos($row['content_parent'], ".")){
					$newid = substr($row['content_parent'],2);
					$row['content_query'] = "?cat.".$row['content_id'];
				}else{
					$row['content_query'] = "?content.".$row['content_id'];
				}
			}
			$url = e107::url("content", "content", $row, "full");
			$type  =  CONT_SITEMAP_LAN_0;
			
			
						// if site using canonical urls, replace them   
			if($iscanonicalinstalled) {
			  if($record = e107::getDb()->retrieve("canonical", "can_url, can_redirect, can_title", "can_table='pcontent' AND can_pid=" . $row['content_id']))   {
			     // if redirect is set, not use this in gsitemap 
				   if($record['can_redirect'])  {  continue;  }
				   // otherwise use canonical url in sitemap 
				   $url=$record['can_url'];
				   $title = $record['can_title'];
				   $type  = CONT_SITEMAP_LAN_0;
				}			 
			}
 
 
			$import[] = array(
				'name' => $title,
			  'url' =>  $url,
				'type' => $type
			);
		}
 

		return $import;
	}
}