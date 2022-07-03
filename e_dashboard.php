<?php
/**
 *	e107 Content plugin
 *
 *	@package	e107_plugins
 *	@subpackage	content
 *	@version 	$Id$;
 */
 
if (!defined('e107_INIT')) { exit; }

include_lan(e_PLUGIN.'content/languages/'.e_LANGUAGE.'/lan_content_admin.php');

require_once($plugindir."handlers/content_class.php");

class content_dashboard // include plugin-folder in the name.
{
	function chart()
	{
		return false;
	}
	
	/* change against verstion 1 - before there were displayed all categories in expanded way. 
	Now are displayes all main categories with number of all content (in all subdirectories) */
	
	function status()
	{
		$sql = e107::getDb();
    $aa = new content;
		if($maincat = $sql -> retrieve("pcontent", "content_id, content_heading", " WHERE  content_parent  = '0' ORDER BY content_heading", true))
		{
			$i = 0;
			foreach($maincat as $row)
			{
 				$count = 0;
				$array			= $aa -> getCategoryTree("", $row['content_id'], TRUE);
				$validparent	= implode(",", array_keys($array));
				$qrycat			= " content_parent REGEXP '".$aa -> CONTENTREGEXP($validparent)."' ";
				
			  $count = $sql -> count("pcontent", "(*)", "WHERE ".$qrycat."  AND content_refer != 'sa' ");
			  $var[$i]['icon'] 	= "<img src='".e_PLUGIN_ABS."content/images/content_16.png' style='width: 16px; height: 16px; vertical-align: bottom' alt='' /> ";
				$var[$i]['title'] 	= $row['content_heading'];
				$var[$i]['url']		= e_PLUGIN."content/admin_content_config.php?content.".$row['content_id'];
				$var[$i]['total'] 	= $count;
			  $i = $i + 1;
			}
		}
		return $var;
	}	
 
}
?>