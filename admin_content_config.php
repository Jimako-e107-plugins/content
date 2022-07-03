<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     Copyright (C) 2001-2002 Steve Dunstan (jalist@e107.org)
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/content/admin_content_config.php $
|     $Revision: 13011 $
|     $Id: admin_content_config.php 13011 2012-10-28 16:26:00Z e107steved $
|     $Author: e107steved $
+----------------------------------------------------------------------------+
*/

require_once("../../class2.php");

if (!e107::isInstalled('content'))
{
	e107::redirect();
}
$e_sub_cat = 'content';
$e_wysiwyg = "content_text,cat_text";
$plugindir = e_PLUGIN."content/";
$plugindir_abs = e_PLUGIN_ABS."content/";

include_lan($plugindir.'languages/'.e_LANGUAGE.'/lan_content_admin.php');

include_lan($plugindir.'languages/'.e_LANGUAGE.'/lan_content.php');

if(e_QUERY){
	$qs = explode(".", e_QUERY);
}

require_once(e_ADMIN."auth.php");
require_once($plugindir."handlers/form_handler.php");
$rs = new oldform;



require_once(e_HANDLER."userclass_class.php");
require_once($plugindir."handlers/content_class.php");
$aa = new content;
require_once($plugindir."handlers/content_db_class.php");
$adb = new contentdb;
require_once($plugindir."handlers/content_form_class.php");
$aform = new contentform;
require_once(e_HANDLER."file_class.php");
$fl = new e_file;
//e107_require_once(e_HANDLER.'arrayxstorage_class.php');
//$eArrayStorage = new ArrayData();

global $tp;
$deltest = array_flip($_POST);

// check query

$sql = e107::getDb();
 	 
if(isset($_POST['delete']))
{
	$tmp = array_pop(array_flip($_POST['delete']));
	list($delete, $del_id) = explode("_", $tmp);
}

// ##### DB ---------------------------------------------------------------------------------------

if(isset($delete) && $delete == 'cat'){
 
	$row = $sql -> retrieve($plugintable, "content_id,content_heading,content_parent", "WHERE content_id = '$del_id' ");
  $content_id = $row['content_id'];
  $content_heading = $row['content_heading'];
  $content_parent = $row['content_parent'];
 
	$checkarray = $aa -> getCategoryTree("", $content_id, TRUE);
	unset($agc);	//unset the globalised getCategoryTree array
	$checkvalidparent = implode(",", array_keys($checkarray));
	$checkqry = " content_parent REGEXP '".$aa -> CONTENTREGEXP($checkvalidparent)."' ";

	//check if subcats present
	if(count($array) > 1){
		//subcategories found don't delete
		$checkermsg .= CONTENT_ADMIN_CAT_LAN_36."<br />";
		$checksubcat = TRUE;
	}else{
		$checkermsg .= CONTENT_ADMIN_CAT_LAN_39."<br />";
		$checksubcat = FALSE;
	}
					
	//check if items present
	if($sql -> db_Count($plugintable, "(*)", "WHERE ".$checkqry." ")){
		//items found, don't delete
		$checkermsg .= CONTENT_ADMIN_CAT_LAN_37."<br />";
		$checkitems = TRUE;
	}else{
		$checkermsg .= CONTENT_ADMIN_CAT_LAN_38."<br />";
		$checkitems = FALSE;
	}
 
	if($checksubcat == FALSE && $checkitems == FALSE){
		if($sql -> delete($plugintable, "content_id='$del_id' ")){
 
			@unlink(e_PLUGIN."content/menus/content_".$content_heading."_menu.php");
			$message = CONTENT_ADMIN_CAT_LAN_23."<br />";
		}
	}else{
		$message = $checkermsg;
	}
}

if(isset($delete) && $delete == 'content'){
	if($sql -> db_Delete($plugintable, "content_id='$del_id' ")){
		$e107cache->clear($plugintable);
		$message = CONTENT_ADMIN_ITEM_LAN_3;
	}
}

if(isset($delete) && $delete == 'submitted'){
	if($sql -> db_Delete($plugintable, "content_id='$del_id' ")){
		$e107cache->clear($plugintable);
		$message = CONTENT_ADMIN_SUBMIT_LAN_8;
	}
}

//update options
if(isset($_POST['updateoptions'])){
	$content_pref	= $aa -> UpdateContentPref($_POST['options_type']);
	$message		= CONTENT_ADMIN_CAT_LAN_22."<br /><br />";
	if($_POST['options_type'] != "0"){
		$message		.= $aa -> CreateParentMenu($_POST['options_type']);
	}
	$e107cache->clear($plugintable);
}

//update the inheritance of options
if(isset($_POST['updateinherit'])){
	foreach($_POST['id'] as $k=>$v){
		//get current
		$sql -> db_Select($plugintable, "content_pref", "content_id='".intval($k)."' ");
		$row = $sql -> db_Fetch();
 
		//$content_pref = $eArrayStorage->ReadxArray($row['content_pref']);
		$content_pref = e107::unserialize($row['content_pref']);
		//assign or remove inherit option
		if(isset($_POST['content_inherit']) && isset($_POST['content_inherit'][$k]) ){
			$content_pref['content_inherit'] = "1";
		}else{
			unset($content_pref['content_inherit']);
		}
 
		//update
		//$tmp = $eArrayStorage->WritexArray($content_pref);
		$tmp = e107::serialize($content_pref, true);
	            
		$sql2 -> db_Update($plugintable, "content_pref='{$tmp}' WHERE content_id='".intval($k)."' ");
	}
	$message		= CONTENT_ADMIN_CAT_LAN_22."<br /><br />";
	$e107cache->clear($plugintable);
}

//update manager classes into preferences
if(isset($_POST['update_manager'])){
	$content_pref	= $aa -> UpdateContentPref($_POST['options_type']);
	$message		= CONTENT_ADMIN_CAT_LAN_22."<br /><br />";
	$e107cache->clear($plugintable);
}

//update page restriction classes into preferences
if(isset($_POST['update_restrict'])){
	$content_pref	= $aa -> UpdateContentPref($_POST['options_type']);
	$message		= CONTENT_ADMIN_CAT_LAN_22."<br /><br />";
	$e107cache->clear($plugintable);
}


//pre-upload a new category icon in the create/edit category form
if(isset($_POST['uploadcaticon'])){

	$pref['upload_storagetype'] = "1";
	require_once(e_HANDLER."upload_handler.php");
	$pathiconlarge = $_POST['iconpathlarge'];
	$pathiconsmall = $_POST['iconpathsmall'];	
	$uploaded = file_upload($pathiconlarge);
	
	$icon = "";
	if($uploaded) {
		$icon = $uploaded[0]['name'];
		require_once(e_HANDLER."resize_handler.php");
		resize_image($pathiconlarge.$icon, $pathiconlarge.$icon, '48', "nocopy");
		resize_image($pathiconlarge.$icon, $pathiconsmall.$icon, '16', "copy");
		rename($pathiconsmall."thumb_".$icon , $pathiconsmall.$icon);
	}
	$message	= ($icon ? CONTENT_ADMIN_CAT_LAN_58 : CONTENT_ADMIN_CAT_LAN_59);
	
}

if(isset($_POST['create_category'])){
  
	if($_POST['cat_heading'] && $_POST['parent1'] != "none"){       
		$adb -> dbCategory("create");
	}else{
		$message	= CONTENT_ADMIN_ITEM_LAN_0;
	}
}

if(isset($_POST['update_category'])){
	if($_POST['cat_heading'] && $_POST['parent1'] != "none"){
		$adb -> dbCategory("update");
	}else{
		$message	= CONTENT_ADMIN_ITEM_LAN_0;
	}
}

if(isset($_POST['create_content'])){
	if($_POST['content_text'] && $_POST['content_heading'] && $_POST['content_author_name'] && $_POST['parent1'] != "none"){
		//$adb -> dbContentCreate("admin");
		$adb -> dbContent("create", "");
	}else{
		$message	= CONTENT_ADMIN_ITEM_LAN_0;
	}
}

if(isset($_POST['update_content'])){
	if($_POST['content_text'] && $_POST['content_heading'] && $_POST['content_author_name'] && $_POST['content_heading'] && $_POST['parent1'] != "none"){
		//$adb -> dbContentUpdate("admin");
		$adb -> dbContent("update", "");
	}else{
		$message	= CONTENT_ADMIN_ITEM_LAN_0;
	}
}

if(isset($_POST['update_order'])){
	if(isset($qs[1])){
		if(isset($qs[2])){
			$message = $adb -> dbSetOrder("all", "ci", $_POST['order']);
		}else{
			$message = $adb -> dbSetOrder("all", "ai", $_POST['order']);
		}
	}else{
		$message = $adb -> dbSetOrder("all", "cc", $_POST['order']);
	}
}

if(isset($message)){
	$ns -> tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
}

// ##### End --------------------------------------------------------------------------------------

if(!e_QUERY){							 								//show main categories
	$aform -> show_manage_content("", "", "");
	require_once(e_ADMIN."footer.php");
	exit;
}else{
	$qs = explode(".", e_QUERY);

	//manage content items
	if($qs[0] == "content" && is_numeric($qs[1]) ){
		$aform -> show_manage_content("", "", "");

	//edit content item
	}elseif($qs[0] == "content" && $qs[1] == "edit" && is_numeric($qs[2]) ){
		$newqs = array_reverse($qs);
		if($newqs[0] == "cu"){										//item; update redirect
			$mainparent = $aa -> getMainParent($qs[2]);
			$message = CONTENT_ADMIN_ITEM_LAN_2."<br /><br />";
			$message .= CONTENT_ADMIN_ITEM_LAN_88." <a href='".e_SELF."?content.create.".$mainparent."'>".CONTENT_ADMIN_ITEM_LAN_90."</a><br />";
			$message .= CONTENT_ADMIN_ITEM_LAN_89." <a href='".e_SELF."?content.".$mainparent."'>".CONTENT_ADMIN_ITEM_LAN_90."</a><br />";
			$message .= CONTENT_ADMIN_ITEM_LAN_91." <a href='".e_SELF."?content.edit.".$qs[2]."'>".CONTENT_ADMIN_ITEM_LAN_90."</a><br />";
			$message .= CONTENT_ADMIN_ITEM_LAN_124." <a href='".e_PLUGIN_ABS."content/content.php?content.".$qs[2]."'>".CONTENT_ADMIN_ITEM_LAN_90."</a>";
			
			$ns -> tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
			require_once(e_ADMIN."footer.php");
			exit;
		}
		$aform -> show_create_content("admin", $userid="", $username="");

	//post submitted content item
	}elseif($qs[0] == "content" && $qs[1] == "sa" && is_numeric($qs[2]) ){
		$newqs = array_reverse($qs);
		if($newqs[0] == "cu"){										//item; submit post / update redirect
			$mainparent = $aa -> getMainParent($qs[2]);
			$message = CONTENT_ADMIN_ITEM_LAN_117."<br /><br />";
			$message .= CONTENT_ADMIN_ITEM_LAN_88." <a href='".e_SELF."?content.create.".$mainparent."'>".CONTENT_ADMIN_ITEM_LAN_90."</a><br />";
			$message .= CONTENT_ADMIN_ITEM_LAN_89." <a href='".e_SELF."?content.".$mainparent."'>".CONTENT_ADMIN_ITEM_LAN_90."</a><br />";
			$message .= CONTENT_ADMIN_ITEM_LAN_91." <a href='".e_SELF."?content.edit.".$qs[2]."'>".CONTENT_ADMIN_ITEM_LAN_90."</a><br />";
			$message .= CONTENT_ADMIN_ITEM_LAN_124." <a href='".e_PLUGIN_ABS."content/content.php?content.".$qs[2]."'>".CONTENT_ADMIN_ITEM_LAN_90."</a>";
			$ns -> tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
			require_once(e_ADMIN."footer.php");
			exit;
		}
		$aform -> show_create_content("sa", $userid="", $username="");

	//create content item
	}elseif($qs[0] == "content" && $qs[1] == "create" ){
		$newqs = array_reverse($qs);
		if($newqs[0] == "cc"){										//item; create redirect
			$mainparent = $aa -> getMainParent($qs[2]);
			$message = CONTENT_ADMIN_ITEM_LAN_1."<br /><br />";
			$message .= CONTENT_ADMIN_ITEM_LAN_88." <a href='".e_SELF."?content.create.".$mainparent."'>".CONTENT_ADMIN_ITEM_LAN_90."</a><br />";
			$message .= CONTENT_ADMIN_ITEM_LAN_89." <a href='".e_SELF."?content.".$mainparent."'>".CONTENT_ADMIN_ITEM_LAN_90."</a><br />";
			$ns -> tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
			require_once(e_ADMIN."footer.php");
			exit;
		}
		$aform -> show_create_content("admin", $userid="", $username="");



	//order : view categories
	}elseif($qs[0] == "order" && !isset($qs[1])){
		$aform -> show_order();

	//order global items of parent='2'
	}elseif($qs[0] == "order" && is_numeric($qs[1]) && !isset($qs[2]) ){
		$aform -> show_content_order("ai");

	//increase order of global items
	}elseif($qs[0] == "order" && is_numeric($qs[1]) && $qs[2] == "inc" && isset($qs[3]) ){
		$message = $adb -> dbSetOrder("inc", "ai", $qs[3]);
		$ns -> tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
		$aform -> show_content_order("ai");

	//decrease order of global items
	}elseif($qs[0] == "order" && is_numeric($qs[1]) && $qs[2] == "dec" && isset($qs[3]) ){
		$message = $adb -> dbSetOrder("dec", "ai", $qs[3]);
		$ns -> tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
		$aform -> show_content_order("ai");

	//order items with parent=2 or category='5'
	}elseif($qs[0] == "order" && is_numeric($qs[1]) && is_numeric($qs[2]) && !isset($qs[3]) ){
		$aform -> show_content_order("ci");
	
	//increase order of items in category
	}elseif($qs[0] == "order" && is_numeric($qs[1]) && is_numeric($qs[2]) && $qs[3] == "inc" && isset($qs[4]) ){
		$message = $adb -> dbSetOrder("inc", "ci", $qs[4]);
		$ns -> tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
		$aform -> show_content_order("ci");

	//decrease order of items in category
	}elseif($qs[0] == "order" && is_numeric($qs[1]) && is_numeric($qs[2]) && $qs[3] == "dec" && isset($qs[4]) ){
		$message = $adb -> dbSetOrder("dec", "ci", $qs[4]);
		$ns -> tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
		$aform -> show_content_order("ci");

	//increase category order
	}elseif($qs[0] == "order" && $qs[1] == "inc" && isset($qs[2]) ){
		$message = $adb -> dbSetOrder("inc", "cc", $qs[2]);
		$ns -> tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
		$aform -> show_order("admin");

	//decrease category order
	}elseif($qs[0] == "order" && $qs[1] == "dec" && isset($qs[2]) ){
		$message = $adb -> dbSetOrder("dec", "cc", $qs[2]);
		$ns -> tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
		$aform -> show_order("admin");




	}elseif($qs[0] == "submitted" && !isset($qs[1]) ){
		$aform -> show_submitted();




	}elseif($qs[0] == "option" && !isset($qs[1]) ){
		$aform -> show_options();

	}elseif($qs[0] == "option" && isset($qs[1]) && (is_numeric($qs[1]) || $qs[1] == "default") ){
		$aform -> show_options_cat();




	//category content manager : choose category
	}elseif($qs[0] == "manager" && !isset($qs[1]) ){
		if(!getperms("0")){ header("location:".e_SELF); exit; }
		//$aform -> show_admin_contentmanager();
		$aform -> manager();
	
	//category content manager : view contentmanager
	}elseif($qs[0] == "manager" && isset($qs[1]) && is_numeric($qs[1]) ){
		if(!getperms("0")){ header("location:".e_SELF); exit; }
		if(isset($qs[2])){
			$message = $adb -> dbAssignAdmins("admin", intval($qs[1]), $qs[2]);
			$ns -> tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
		}
		$aform -> manager_category();




	//overview all categories
	}elseif($qs[0] == "cat" && !isset($qs[1]) ){
		$aform -> manage_cat();

	//create category
	}elseif($qs[0] == "cat" && $qs[1] == "create" ){
		$newqs = array_reverse($qs);
		if($newqs[0] == "pc"){									//category; create redirect
				$message = CONTENT_ADMIN_CAT_LAN_11."<br /><br />";
				$message .= "<br /><br />".CONTENT_ADMIN_CAT_LAN_50."<br /><br />";
				$message .= "
				".CONTENT_ADMIN_CAT_LAN_44." <a href='".e_SELF."?cat.create'>".CONTENT_ADMIN_CAT_LAN_43."</a><br />
				".CONTENT_ADMIN_CAT_LAN_42." <a href='".e_SELF."?cat.edit.".$qs[2]."'>".CONTENT_ADMIN_CAT_LAN_43."</a><br />
				";
				$ns -> tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
				require_once(e_ADMIN."footer.php");
				exit;
		}
		$aform -> show_create_category();

	//edit category
	}elseif($qs[0] == "cat" && $qs[1] == "edit" && is_numeric($qs[2]) ){
		$newqs = array_reverse($qs);
		if($newqs[0] == "pu"){										//category; update redirect
				$message = CONTENT_ADMIN_CAT_LAN_12."<br /><br />
				".CONTENT_ADMIN_CAT_LAN_42." <a href='".e_SELF."?cat.edit.".$qs[2]."'>".CONTENT_ADMIN_CAT_LAN_43."</a><br />
				".CONTENT_ADMIN_CAT_LAN_53." <a href='".e_SELF."?cat'>".CONTENT_ADMIN_CAT_LAN_43."</a><br />";
				$ns -> tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
				require_once(e_ADMIN."footer.php");
				exit;
		}
		$aform -> show_create_category();



	//restrict : choose category
	}elseif($qs[0] == "restrict" && !isset($qs[1]) ){
		//if(!getperms("0")){ header("location:".e_SELF); exit; }
		$aform -> restrict();
	
	//restrict : view restrict for main parent
	}elseif($qs[0] == "restrict" && isset($qs[1]) && is_numeric($qs[1]) ){
		//if(!getperms("0")){ header("location:".e_SELF); exit; }
		$aform -> restrict_category();
	}

}

// ##### End --------------------------------------------------------------------------------------

 
// ##### Display options --------------------------------------------------------------------------
function admin_content_config_adminmenu()
{
	global $pref;
	if (!isset($pref['plug_installed']['content'])) return '';
	
                global $sql, $plugintable, $aa;

				//toggle to show categories in admin right hand menu
				$showadmincat = TRUE;

				if(e_QUERY){
					$qs		=	explode(".", e_QUERY);
				}

				if(isset($qs[0]) && $qs[0] == "cat" && isset($qs[1]) && $qs[1] == "create"){
					$act	= $qs[0].".".$qs[1];

				}elseif(isset($qs[0]) && $qs[0] == "content" && isset($qs[1]) && $qs[1] == "create"){
					$act	= $qs[0].".".$qs[1];

				}else{
					$act	= (isset($qs[0]) ? $qs[0] : "");
				}

                if($act==""){$act="content";}

                $var['content']['text']			= CONTENT_ADMIN_MENU_LAN_0;
                $var['content']['link']			= e_SELF;

                $var['content.create']['text']	= CONTENT_ADMIN_MENU_LAN_1;
                $var['content.create']['link']	= e_SELF."?content.create";

                $var['cat']['text']				= CONTENT_ADMIN_MENU_LAN_2;
                $var['cat']['link']				= e_SELF."?cat";

				$var['cat.create']['text']		= CONTENT_ADMIN_MENU_LAN_3;
                $var['cat.create']['link']		= e_SELF."?cat.create";

				$var['order']['text']			= CONTENT_ADMIN_MENU_LAN_15;
                $var['order']['link']			= e_SELF."?order";

				$var['option']['text']			= CONTENT_ADMIN_MENU_LAN_6;
                $var['option']['link']			= e_SELF."?option";

				if(getperms("0")){ 
					$var['manager']['text']			= CONTENT_ADMIN_MENU_LAN_17;
					$var['manager']['link']			= e_SELF."?manager";
				}

                if($submittedcontents = $sql -> db_Count($plugintable, "(*)", "WHERE content_refer ='sa' ")){
                        $var['submitted']['text']	= CONTENT_ADMIN_MENU_LAN_4." (".$submittedcontents.")";
                        $var['submitted']['link']	= e_SELF."?submitted";
                }

			 
        e107::getNav()->admin(CONTENT_ADMIN_MENU_LAN_6, $act, $var, false, false, $sortlist);
        
				if(isset($qs[0]) && $qs[0] == "option" && isset($qs[1])){
					unset($var);
					$var=array();
					$var['creation']['text']		= CONTENT_ADMIN_MENU_LAN_7;
					$var['catcreation']['text']		= CONTENT_ADMIN_MENU_LAN_23;
					$var['submission']['text']		= CONTENT_ADMIN_MENU_LAN_8;
					$var['paththeme']['text']		= CONTENT_ADMIN_MENU_LAN_9;
					$var['general']['text']			= CONTENT_ADMIN_MENU_LAN_10;
					$var['menu']['text']			= CONTENT_ADMIN_MENU_LAN_14;

					$sql = new db;
					$content_heading = $category_total			= $sql -> retrieve($plugintable, "content_heading", "content_id='".$qs[1]."' ");
					//list($content_heading)	= $sql -> db_Fetch();
               
					content_show_admin_menu(CONTENT_ADMIN_MENU_LAN_6.": ".$content_heading."", $act, $var, TRUE);         
           
					unset($var);
					$var=array();
					$var['recentpages']['text']		= CONTENT_ADMIN_MENU_LAN_11;
					$var['catpages']['text']		= CONTENT_ADMIN_MENU_LAN_12;
					$var['contentpages']['text']	= CONTENT_ADMIN_MENU_LAN_13;
					$var['authorpage']['text']		= CONTENT_ADMIN_MENU_LAN_18;
					$var['archivepage']['text']		= CONTENT_ADMIN_MENU_LAN_16;
					$var['toppage']['text']			= CONTENT_ADMIN_MENU_LAN_20;
					$var['scorepage']['text']		= CONTENT_ADMIN_MENU_LAN_22;     
					content_show_admin_menu(CONTENT_ADMIN_MENU_LAN_21.": ".$content_heading."", $act, $var, TRUE);
				
				}else{
						
						if($showadmincat){
							$sql2 = new db;
							if($category_total = $sql2 -> db_Select($plugintable, "content_id, content_heading", "content_parent='0' ")){
								while($row = $sql2 -> db_Fetch()){

									unset($var);
									$var=array();

									$array		= $aa -> getCategoryTree("", $row['content_id'], FALSE);	//get all categories from each main parent
									$newarray	= array_merge_recursive($array);

									$newparent=array();
									for($a=0;$a<count($newarray);$a++){
										for($b=0;$b<count($newarray[$a]);$b++){
											$newparent[$newarray[$a][$b]] = $newarray[$a][$b+1];
											$b++;
										}
									}

									foreach($newparent as $key => $value){
										$var['c'.$key]['text']	= $value;
										$var['c'.$key]['link']	= e_SELF."?content.".$key;
									}
									if( isset($qs[0]) && $qs[0] == "content" && isset($qs[1]) && $qs[1] == "create"){
										$act = "";
									}elseif( isset($qs[0]) && $qs[0] == "cat" && isset($qs[1]) && ($qs[1] == "create" || $qs[1] == "edit") ){
										$act = "";
									}elseif( isset($qs[0]) && $qs[0] == "order" ){
										$act = "";
									}elseif( isset($qs[0]) && $qs[0] == "manager" ){
										$act = "";
									}else{
										if(isset($qs[0]) && isset($qs[1]) ){
											$act = "c".$qs[1];
										}else{
											$act = "c";
										}
									}
                  e107::getNav()->admin(CONTENT_ADMIN_MENU_LAN_5." : ".$row['content_heading']."", $act, $var, false, false, $sortlist);
									 
								}
							}
						}
				}

}
// ##### End --------------------------------------------------------------------------------------


// ##### Display options original show_admin_menu doesn't work anymore   see https://github.com/e107inc/e107/issues/3139  -------------------------------
if (!function_exists('content_show_admin_menu')) {
	function content_show_admin_menu($title, $active_page, $e107_vars, $js = FALSE, $sub_link = FALSE, $sortlist = FALSE) {
		global $ns, $BUTTON, $BUTTON_OVER, $BUTTONS_START, $BUTTONS_END, $SUB_BUTTON, $SUB_BUTTON_OVER, $SUB_BUTTONS_START, $SUB_BUTTONS_END;
		$id_title = "yop_".str_replace(" ", "", $title);
						
		if (!isset($BUTTONS_START)) {
			$BUTTONS_START = "<div style='text-align:center; width:100%'><table class='fborder' style='width:98%;'>\n";
		}
		if (!isset($BUTTON)) {
			$BUTTON = "<tr><td class='button'><div style='width:100%;'><a style='cursor:hand; cursor:pointer; text-decoration:none;' {ONCLICK} >{LINK_TEXT}</a></div></td></tr>\n";
		}
		if (!isset($BUTTON_OVER)) {
			$BUTTON_OVER = "<tr><td class='button'><div style='width:100%;'><a style='cursor:hand; cursor:pointer; text-decoration:none;' {ONCLICK} ><b>&laquo;&nbsp;{LINK_TEXT}&nbsp;&raquo;</b></a></div></td></tr>\n";
		}
		if (!isset($BUTTONS_END)) {
			$BUTTONS_END = "</table></div>\n";
		}
		if (!isset($SUB_BUTTON)) {
			$SUB_BUTTON = "<a style='text-decoration:none;' href='{LINK_URL}'>{LINK_TEXT}</a><br />";
		}
		if (!isset($SUB_BUTTON_OVER)) {
			$SUB_BUTTON_OVER = "<b> &laquo; <a style='text-decoration:none;' href='{LINK_URL}'>{LINK_TEXT}</a> &raquo; </b><br />";
		}
		if (!isset($SUB_BUTTONS_START)) {
			$SUB_BUTTONS_START = "<div style='width:100%'><table class='fborder' style='width:98%;'>
			<tr><td class='button'><a style='cursor:hand; cursor:pointer; text-decoration:none;'
			onclick=\"expandit('{SUB_HEAD_ID}');\" >{SUB_HEAD}</a></td></tr>
			<tr id='{SUB_HEAD_ID}' style='display: none' ><td class='forumheader3' style='text-align:left;'>";
		}
		if (!isset($SUB_BUTTONS_END)) {
			$SUB_BUTTONS_END = "</td></tr></table></div>";
		}

		if ($sortlist == TRUE) {
			$temp = $e107_vars;
			unset($e107_vars);
			foreach (array_keys($temp) as $key) {
				$func_list[] = $temp[$key]['text'];
			}

			usort($func_list, 'strcoll');

			foreach ($func_list as $func_text) {
				foreach (array_keys($temp) as $key) {
					if ($temp[$key]['text'] == $func_text) {
						$e107_vars[] = $temp[$key];
					}
				}
			}
		}

		$search[0] = "/\{LINK_TEXT\}(.*?)/si";
		$search[1] = "/\{LINK_URL\}(.*?)/si";
		$search[2] = "/\{ONCLICK\}(.*?)/si";
		$search[3] = "/\{SUB_HEAD\}(.*?)/si";
		$search[4] = "/\{SUB_HEAD_ID\}(.*?)/si";

		if ($sub_link) {
			$replace[0] = '';
			$replace[1] = '';
			$replace[2] = '';
			$replace[3] = $title;
			$replace[4] = $id_title;
			$text = preg_replace($search, $replace, $SUB_BUTTONS_START);
		} else {
			$text = $BUTTONS_START;
		}

		foreach (array_keys($e107_vars) as $act) 
		{
			if (!isset($e107_vars[$act]['perm']) || !$e107_vars[$act]['perm'] || getperms($e107_vars[$act]['perm'])) 
			{
				if ($active_page == $act || (str_replace("?", "", e_PAGE.e_QUERY) == str_replace("?", "", $act))) 
				{
					$BUTTON_TEMPLATE = $sub_link ? $SUB_BUTTON_OVER : $BUTTON_OVER;
				} 
				else 
				{
					$BUTTON_TEMPLATE = $sub_link ? $SUB_BUTTON : $BUTTON;
				}
				$replace[0] = str_replace(" ", "&nbsp;", $e107_vars[$act]['text']);
				$replace[1] = varset($e107_vars[$act]['link'], '');
				if (!empty($e107_vars[$act]['include'])) 
				{
					$replace[2] = $e107_vars[$act]['include'];
				} 
				else 
				{
					$replace[2] = $js ? "onclick=\"showhideit('".$act."');\"" : "onclick=\"document.location='".$e107_vars[$act]['link']."'; disabled=true;\"";
				}
				$replace[3] = $title;
				$replace[4] = $id_title;
				$text .= preg_replace($search, $replace, $BUTTON_TEMPLATE);
			}
		}
		$text .= $sub_link ? $SUB_BUTTONS_END : $BUTTONS_END;

		if ($title == "" || $sub_link) {
			return $text;
		} else {
			$ns -> tablerender($title, $text, array('id' => $id_title, 'style' => 'button_menu'));
		}
	}
}

if (!function_exists("parse_admin"))
{
	function parse_admin($ADMINLAYOUT)
	{
		$sc = e107::getScBatch('admin');
		$tp = e107::getParser();
		$adtmp = explode("\n", $ADMINLAYOUT);
		
		for ($a = 0; $a < count($adtmp); $a++)
		{
			if (preg_match("/{.+?}/", $adtmp[$a]))
			{
				echo $tp->parseTemplate($adtmp[$a], true, $sc);
			}
			else
			{
				echo $adtmp[$a];
			}
		}
	}
}

require_once(e_ADMIN."footer.php");

?>