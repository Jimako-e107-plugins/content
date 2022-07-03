<?php
/**
 * @file
 * v2.x Standard  - Simple mod-rewrite module.
 */
if(!defined('e107_INIT'))
{
	exit;
}

/**
 * Class links_page_url.
 *
 * plugin-folder + '_url' 
 */
 
/*
content.php
cat.1
cat.1.view
content_manager.php

*/

class content_url
{
	function config()
	{
  
		$config = array();
 
    $config['content_manager'] = array(
		'regex'    => '^content_manager/(.*)',
		'sef'      => 'content_manager/{content_query}',
		'redirect' => '{e_PLUGIN}content/content_manager.php$1'
	 ); 
   
    $config['content'] = array(
    'alias'         => '{alias}',
		'regex'    => '^{alias}/(.*)/(.*)',
		'sef'      => '{alias}/{content_sef}/{content_query}',
		'redirect' => '{e_PLUGIN}content/content.php$2'
	 );   
   
    $config['content-temp'] = array(
    'alias'         => '{alias}',
		'regex'    => '^{alias}/(.*)',
		'sef'      => '{alias}/{content_query}',
		'redirect' => '{e_PLUGIN}content/content.php$1'
	 );  
 
    $config['index'] = array(
    'alias'         => '{alias}',
		'regex'    => '^{alias}\/?$',
		'sef'      => '{alias}',
		'redirect' => '{e_PLUGIN}content/content.php'
	 ); 
   
  return $config;
  
	}
}