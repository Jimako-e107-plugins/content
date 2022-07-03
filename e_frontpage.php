<?php

if (!defined('e107_INIT'))
{
	exit;
}
        
include_lan(e_PLUGIN . 'content/languages/' . e_LANGUAGE . '/lan_content_frontpage.php');
class content_frontpage

// include plugin-folder in the name.

{

	// simple

	function config()
	{
		$frontPage = array();
		$frontPage['title'] = CONT_FP_3;
		$frontPage['page'][0] = array(
			'page' => '{e_PLUGIN}content/content.php',
			'title' => CONT_FP_2
		); 
		
		if ($maincat = e107::getDb()->retrieve("pcontent", "content_id, content_heading", 
		" WHERE content_parent='0'", true))
		{
			$i = 1;
			foreach($maincat as $row)
			{
				$row['url_content_id'] = $row['content_id'];
				$frontPage['page'][$i] = array(
					'page' => $PLUGINS_DIRECTORY . 'content/content.php?recent.' . $row['content_id'],
					'title' => CONT_FP_1 . ': ' . $row['content_heading']
				);
				++$i;                                                                              
				
				if ($subpages = e107::getDb()->retrieve("pcontent", "content_id, content_heading", 
				" WHERE LEFT(content_parent,1) = '" . $row['content_id'] . "' ORDER BY content_heading", TRUE))
				{
					foreach($subpages as $row2)
					{
						$frontPage['page'][$i] = array(
							'page' => '{e_PLUGIN}content/content.php?content.' . $row2['content_id'],
							'title' =>  ' - ' . $row['content_heading'] . ' - ' . $row2['content_heading']
						);
						++$i;
					}
				}
			}
		}

		return $frontPage;
	}
}

/*
$sql2 = new db;
if ($sql2 -> db_Select("pcontent", "content_id, content_heading", "LEFT(content_parent,1)='0'")) {
	while ($row = $sql2 -> db_Fetch()) {
		$front_page['content_'.$row['content_id']]['title'] = CONT_FP_1.': '.$row['content_heading'];
		$front_page['content_'.$row['content_id']]['page'][] = array('page' => $PLUGINS_DIRECTORY.'content/content.php?recent.'.$row['content_id'], 'title' => $row['content_heading'].' '.CONT_FP_2);
		if ($sql -> db_Select("pcontent", "content_id, content_heading", "content_parent = '".$row['content_id']."' ORDER BY content_heading")){
			while ($row2 = $sql -> db_Fetch()) {
				$front_page['content_'.$row['content_id']]['page'][] = array('page' => $PLUGINS_DIRECTORY.'content/content.php?content.'.$row2['content_id'], 'title' => $row2['content_heading']);
			}
		}
	}
}
*/

?>