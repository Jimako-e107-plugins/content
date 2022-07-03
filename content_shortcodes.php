<?php
if (!defined('e107_INIT')) { exit; }


class content_shortcodes extends e_shortcode
{

	function __construct()
	{
		// todo
		//$pref = e107::pref('content');
 
	}


	function sc_content_nextprev($parm='')
	{
		global $CONTENT_NEXTPREV;
		return $CONTENT_NEXTPREV;
	}
		
		// CONTENT_TYPE_TABLE ------------------------------------------------
		function sc_content_type_table_total($parm='')  {
		global $contenttotal;
		return $contenttotal." ".($contenttotal == 1 ? CONTENT_LAN_53 : CONTENT_LAN_54);
		}
		
		function sc_content_type_table_heading($parm='')  {
		global $CONTENT_TYPE_TABLE_HEADING, $contenttotal, $row, $tp;
		$row['content_heading'] = $tp -> toHTML($row['content_heading'], TRUE, "emotes_off, no_make_clickable");
		$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
    $row['content_query'] = "?cat.".$row['content_id'];
    $url = e107::url("content", "content", $row, "full");
		return ($contenttotal != "0" ? "<a href='".$url."'>".$row['content_heading']."</a>" : $row['content_heading'] );
		}
		
		function sc_content_cat_table_id($parm='')  {
		global $CONTENT_CAT_TABLE_ID, $contenttotal, $row, $tp;   
		return  $row['content_id'];
		}
		
		// {CONTENT_CAT_TABLE_URL}
		function sc_content_cat_table_url($parm='') {
		global $CONTENT_CAT_TABLE_URL, $contenttotal, $row, $tp;
		if ($this->var) { $row = $this->var; }
		$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
		$row['content_query'] = "?cat.".$row['content_id'];
		$url = e107::url("content", "content", $row, "full");
		return $url;
		}
		
		// {CONTENT_CONTENT_ITEM_URL}
		function sc_content_content_item_url($parm='') {
		global $CONTENT_CONTENT_ITEM_URL, $contenttotal, $row, $tp;
		if ($this->var) { $row = $this->var; }
		$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
		$row['content_query'] = "?content.".$row['content_id'];
		$url = e107::url("content", "content", $row, "full");
		return $url;		
		//return e_PLUGIN_ABS."content/content.php?content.".$row['content_id'];
		}
		
    // {CONTENT_SOCIAL_SHARE}
		function sc_content_social_share($parm='') {
		global $CONTENT_CONTENT_ITEM_URL, $contenttotal, $row, $tp;
		if ($this->var) { $row = $this->var; }
    $title =  $row['content_heading'];
		$row['content_sef'] = eHelper::title2sef($title,'dashl');
		$row['content_query'] = "?content.".$row['content_id'];
		$url = e107::url("content", "content", $row, "full");
    $text = "<div class='faq-share'>"
    .$tp->parseTemplate("{SOCIALSHARE: size=xs&type=basic&url=".$url."&title=".$title."&tags=".$this->var['content_meta']."}",true)."</div>";
			 
		return $text;		
		//return e_PLUGIN_ABS."content/content.php?content.".$row['content_id'];
		}		
		//[<a href='".e_PLUGIN_ABS."content/content.php?author.list.".$row['content_id']."'>".CONTENT_TYPE_LAN_1."</a>] 
		//[<a href='".e_PLUGIN_ABS."content/content.php?top.".$row['content_id']."'>".CONTENT_TYPE_LAN_3."</a>] 
		//[<a href='".e_PLUGIN_ABS."content/content.php?score.".$row['content_id']."'>".CONTENT_TYPE_LAN_4."</a>] 
					
		function sc_content_type_table_link($parm='')  {
		global $row, $tp;
		$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
    $row['content_query'] = "?cat.list.".$row['content_id'];
    $url1 = e107::url("content", "content", $row, "full");
    $row['content_query'] = "?list.".$row['content_id'];
    $url2 = e107::url("content", "content", $row, "full"); 
    $row['content_query'] = "?recent.".$row['content_id'];    
    $url3 = e107::url("content", "content", $row, "full");   
    
		$text = "
		[<a href='".$url1."'>".CONTENT_TYPE_LAN_0."</a>] 
		
		[<a href='".$url2."'>".CONTENT_TYPE_LAN_2."</a>] 
		
		[<a href='".$url3."'>".CONTENT_TYPE_LAN_5."</a>]";
		return $text;
		}
		
		
		function sc_content_type_table_subheading($parm='')  {
		global $CONTENT_TYPE_TABLE_SUBHEADING, $contenttotal, $row, $tp;
		$row['content_subheading'] = $tp -> toHTML($row['content_subheading'], TRUE, "emotes_off, no_make_clickable");
		return ($row['content_subheading'] ? $row['content_subheading'] : "");
		}
		
		function sc_content_type_table_icon($parm='')  {
		global $CONTENT_TYPE_TABLE_ICON, $contenttotal, $row, $aa, $content_cat_icon_path_large, $content_pref;
		if($contenttotal != "0"){
			$CONTENT_TYPE_TABLE_ICON = $aa -> getIcon("catlarge", $row['content_icon'], $content_cat_icon_path_large, "cat.".$row['content_id'], "", $content_pref["content_blank_caticon"]);
		}else{
			$CONTENT_TYPE_TABLE_ICON = $aa -> getIcon("catlarge", $row['content_icon'], $content_cat_icon_path_large, "", "", $content_pref["content_blank_caticon"]);
		}
		return $CONTENT_TYPE_TABLE_ICON;
		}
		
		// CONTENT_TYPE_TABLE_SUBMIT ------------------------------------------------
		function sc_content_type_table_submit_icon($parm='')  {
		global $CONTENT_TYPE_TABLE_SUBMIT_ICON, $plugindir, $plugindir_abs;
		return "<a href='".$plugindir_abs."content_submit.php'>".CONTENT_ICON_SUBMIT."</a>";
		}
		
		function sc_content_type_table_submit_heading($parm='') {
		global $CONTENT_TYPE_TABLE_SUBMIT_HEADING, $plugindir, $plugindir_abs;
		return "<a href='".$plugindir_abs."content_submit.php'>".CONTENT_LAN_65."</a>";
		}
		
		function sc_content_type_table_submit_subheading($parm='')   {
		global $CONTENT_TYPE_TABLE_SUBMIT_SUBHEADING;
		return CONTENT_LAN_66;
		}
		
		// CONTENT_TYPE_TABLE_MANAGER ------------------------------------------------
		function sc_content_type_table_manager_icon($parm='')   {
		global $CONTENT_TYPE_TABLE_MANAGER_ICON, $plugindir, $plugindir_abs;
		return "<a href='".$plugindir_abs."content_manager.php'>".CONTENT_ICON_CONTENTMANAGER."</a>";
		}
		
		function sc_content_type_table_manager_heading($parm='') {
		global $CONTENT_TYPE_TABLE_MANAGER_HEADING, $plugindir, $plugindir_abs;
		return "<a href='".$plugindir_abs."content_manager.php'>".CONTENT_LAN_67."</a>";
		}
		
		function sc_content_type_table_manager_subheading($parm='')  {
		global $CONTENT_TYPE_TABLE_MANAGER_SUBHEADING;
		return CONTENT_LAN_68;
		}
		
		// CONTENT_TOP_TABLE ------------------------------------------------
		function sc_content_top_table_heading($parm='')   {
		global $CONTENT_TOP_TABLE_HEADING, $row, $qs;
		$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
		return "<a href='".e_PLUGIN_ABS."content/content.php?content.".$row['content_id']."'>".$row['content_heading']."</a>";
		}
		
		function sc_content_top_table_icon($parm='')  {
		global $CONTENT_TOP_TABLE_ICON, $aa, $row, $content_pref, $content_icon_path, $qs, $mainparent;
		if($content_pref["content_top_icon"]){
		$width = (isset($content_pref["content_upload_icon_size"]) && $content_pref["content_upload_icon_size"] ? $content_pref["content_upload_icon_size"] : "100");
		$width = (isset($content_pref["content_top_icon_width"]) && $content_pref["content_top_icon_width"] ? $content_pref["content_top_icon_width"] : $width);
		return $aa -> getIcon("item", $row['content_icon'], $content_icon_path, "content.".$row['content_id'], $width, $content_pref["content_blank_icon"]);
		}
		}
		
		function sc_content_top_table_author($parm='')  {
		global $CONTENT_TOP_TABLE_AUTHOR;
		return $CONTENT_TOP_TABLE_AUTHOR;
		}
		
		function sc_content_top_table_rating($parm='') {
		global $CONTENT_TOP_TABLE_RATING, $row;
		$row['rate_avg'] = round($row['rate_avg'], 1);
		$row['rate_avg'] = (strlen($row['rate_avg'])>1 ? $row['rate_avg'] : $row['rate_avg'].".0");
		$tmp = explode(".", $row['rate_avg']);
		$rating = "";
		$rating .= $row['rate_avg']." ";
		for($c=1; $c<= $tmp[0]; $c++){
			$rating .= "<img src='".e_IMAGE."rate/box.png' alt='' style='border:0; height:8px; vertical-align:middle' />";
		}
		if($tmp[0] < 10){
			for($c=9; $c>=$tmp[0]; $c--){
				$rating .= "<img src='".e_IMAGE."rate/empty.png' alt='' style='border:0; height:8px; vertical-align:middle' />";
			}
		}
		$rating .= "<img src='".e_IMAGE."rate/boxend.png' alt='' style='border:0; height:8px; vertical-align:middle' />";
		return $rating;
		}
		
		// CONTENT_SCORE_TABLE ------------------------------------------------
		function sc_content_score_table_heading($parm='') {
		global $CONTENT_SCORE_TABLE_HEADING, $row, $qs;
		$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
		return "<a href='".e_PLUGIN_ABS."content/content.php?content.".$row['content_id']."'>".$row['content_heading']."</a>";
		}
		
		function sc_content_score_table_icon($parm='') {
		global $CONTENT_SCORE_TABLE_ICON, $aa, $row, $content_pref, $content_icon_path, $qs, $mainparent;
		if(isset($content_pref["content_score_icon"]) && $content_pref["content_score_icon"]){
		$width = (isset($content_pref["content_upload_icon_size"]) && $content_pref["content_upload_icon_size"] ? $content_pref["content_upload_icon_size"] : "100");
		$width = (isset($content_pref["content_score_icon_width"]) && $content_pref["content_score_icon_width"] ? $content_pref["content_score_icon_width"] : $width);
		return $aa -> getIcon("item", $row['content_icon'], $content_icon_path, "content.".$row['content_id'], $width, $content_pref["content_blank_icon"]);
		}
		}
		
		function sc_content_score_table_author($parm='') {
		global $CONTENT_SCORE_TABLE_AUTHOR;
		return $CONTENT_SCORE_TABLE_AUTHOR;
		}
		
		function sc_content_score_table_score($parm='') {
		global $CONTENT_SCORE_TABLE_SCORE, $row;
		$score = $row['content_score'];
		$height = "height:8px;";
		$img = "";
		$img .= "<img src='".e_PLUGIN_ABS."content/images/score_end.png' alt='' style='$height width:1px; border:0;' />";
		$img .= "<img src='".e_PLUGIN_ABS."content/images/score.png' alt='' style='$height width:".$score."px; border:0;' />";
		$img .= "<img src='".e_PLUGIN_ABS."content/images/score_end.png' alt='' style='$height width:1px; border:0;' />";
		if($score < 100){
			$empty = 100-$score;
			$img .= "<img src='".e_PLUGIN_ABS."content/images/score_empty.png' alt='' style='$height width:".$empty."px; border:0;' />";
		}
		$img .= "<img src='".e_PLUGIN_ABS."content/images/score_end.png' alt='' style='$height width:1px; border:0;' />";
		return $score."/100 ".$img;
		}
		
		// CONTENT_SUBMIT_TYPE_TABLE ------------------------------------------------
		function sc_content_submit_type_table_heading($parm='') {
		global $CONTENT_SUBMIT_TYPE_TABLE_HEADING, $row;
		$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
		return "<a href='".e_PLUGIN_ABS."content/content.php?content.submit.".$row['content_id']."'>".$row['content_heading']."</a>";
		}
		
		function sc_content_submit_type_table_subheading($parm='') {
		global $CONTENT_SUBMIT_TYPE_TABLE_SUBHEADING, $row;
		return ($row['content_subheading'] ? $row['content_subheading'] : "");
		}
		
		function sc_content_submit_type_table_icon($parm='')  {
		global $CONTENT_SUBMIT_TYPE_TABLE_ICON, $aa, $row, $content_cat_icon_path_large, $content_pref;
		return $aa -> getIcon("catlarge", $row['content_icon'], $content_cat_icon_path_large, "content.submit.".$row['content_id'], "", $content_pref["content_blank_caticon"]);
		}
		
		// CONTENT_CONTENT_TABLEMANAGER ------------------------------------------------
		function sc_content_contentmanager_category($parm='') {
		global $CONTENT_CONTENTMANAGER_CATEGORY, $row, $content_pref;
		$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
		if( (isset($content_pref["content_manager_personal"]) && check_class($content_pref["content_manager_personal"])) || (isset($content_pref["content_manager_category"]) && check_class($content_pref["content_manager_category"])) || (isset($content_pref["content_manager_approve"]) && check_class($content_pref["content_manager_approve"])) ){
		return "<a href='".e_PLUGIN_ABS."content/content.php?content.".$row['content_id']."'>".$row['content_heading']."</a>";
		}
		}
		
		function sc_content_contentmanager_iconnew($parm='') {
		global $CONTENT_CONTENTMANAGER_ICONNEW, $row, $content_pref;
		$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
		if( (isset($content_pref["content_manager_personal"]) && check_class($content_pref["content_manager_personal"])) || (isset($content_pref["content_manager_category"]) && check_class($content_pref["content_manager_category"])) ){
		return "<a href='".e_PLUGIN_ABS."content/content.php?content.create.".$row['content_id']."'>".CONTENT_ICON_NEW."</a>";
		//return "<input type='button' onclick=\"document.location='".e_SELF."?content.create.".$row['content_id']."'\" value='new' title='new' />";
		}
		}
		
		function sc_content_contentmanager_iconedit($parm='')  {
		global $CONTENT_CONTENTMANAGER_ICONEDIT, $row, $content_pref;
		$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
		if( (isset($content_pref["content_manager_personal"]) && check_class($content_pref["content_manager_personal"])) || (isset($content_pref["content_manager_category"]) && check_class($content_pref["content_manager_category"])) ){
		return "<a href='".e_PLUGIN_ABS."content/content.php?content.".$row['content_id']."'>".CONTENT_ICON_EDIT."</a>";
		//return "<input type='button' onclick=\"document.location='".e_SELF."?content.".$row['content_id']."'\" value='edit' title='edit' />";
		}
		}
		
		function sc_content_contentmanager_iconsubm($parm='') {
		global $CONTENT_CONTENTMANAGER_ICONSUBM, $row, $content_pref, $plugintable;
		$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
		if(isset($content_pref["content_manager_approve"]) && check_class($content_pref["content_manager_approve"])){
			if(!is_object($sqls)){ $sqls = new db; }
			$num = $sqls -> db_Count($plugintable, "(*)", "WHERE content_refer = 'sa' AND content_parent='".intval($row['content_id'])."' ");
			if($num>0){
				return "<a href='".e_PLUGIN_ABS."content/content.php?content.submitted.".$row['content_id']."'>".CONTENT_ICON_SUBMIT_SMALL."</a>";
			}
		}
		}
		
		
		// CONTENT_AUTHOR_TABLE ------------------------------------------------
		function sc_content_author_table_name($parm='')  {
		global $CONTENT_AUTHOR_TABLE_NAME, $authordetails, $i, $qs, $row;
		$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
		$name = ($authordetails[$i][1] == "" ? "... ".CONTENT_LAN_29." ..." : $authordetails[$i][1]);
		$authorlink = "<a href='".e_SELF."?author.".$row['content_id']."'>".$name."</a>";
		return $authorlink;
		}
		
		function sc_content_author_table_icon($parm='') {
		global $CONTENT_AUTHOR_TABLE_ICON, $qs, $row;
		$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
		return "<a href='".e_SELF."?author.".$row['content_id']."'>".CONTENT_ICON_AUTHORLIST."</a>";
		}
		
		function sc_content_author_table_total($parm='') {
		global $CONTENT_AUTHOR_TABLE_TOTAL, $totalcontent, $mainparent, $content_pref;
		if($content_pref["content_author_amount"]){
		$CONTENT_AUTHOR_TABLE_TOTAL = $totalcontent." ".($totalcontent==1 ? CONTENT_LAN_53 : CONTENT_LAN_54);
		return $CONTENT_AUTHOR_TABLE_TOTAL;
		}
		}
		
		function sc_content_author_table_lastitem($parm='') {
		global $CONTENT_AUTHOR_TABLE_LASTITEM, $gen, $row, $mainparent, $content_pref;
		$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
		if($content_pref["content_author_lastitem"]){
		if(!is_object($gen)){ $gen = new convert; }
		$CONTENT_AUTHOR_TABLE_LASTITEM = preg_replace("# -.*#", "", $gen -> convert_date($row['content_datestamp'], "short"));
		$CONTENT_AUTHOR_TABLE_LASTITEM .= " : <a href='".e_PLUGIN_ABS."content/content.php?content.".$row['content_id']."'>".$row['content_heading']."</a>";
		return $CONTENT_AUTHOR_TABLE_LASTITEM;
		}
		}
		
		// CONTENT_CAT_TABLE ------------------------------------------------
		function sc_content_cat_table_info_pre($parm='')  {
		global $CONTENT_CAT_TABLE_INFO_PRE;
		if($CONTENT_CAT_TABLE_INFO_PRE === TRUE){
		$CONTENT_CAT_TABLE_INFO_PRE = " ";
		return $CONTENT_CAT_TABLE_INFO_PRE;
		}
		}
		function sc_content_cat_table_info_post($parm='') {
		global $CONTENT_CAT_TABLE_INFO_POST;
		if($CONTENT_CAT_TABLE_INFO_POST === TRUE){
		$CONTENT_CAT_TABLE_INFO_POST = " ";
		return $CONTENT_CAT_TABLE_INFO_POST;
		}
		}
		
		function sc_content_cat_table_icon($parm='') {
		global $CONTENT_CAT_TABLE_ICON, $aa, $totalitems, $row, $content_pref, $qs, $content_cat_icon_path_large, $mainparent;
		if(isset($content_pref["content_catall_icon"]) && $content_pref["content_catall_icon"]){
			//$qry = ($totalitems > 0 ? "cat.".$row['content_id'] : "");
			$qry = "cat.".$row['content_id'];
			return $aa -> getIcon("catlarge", $row['content_icon'], $content_cat_icon_path_large, $qry, "", $content_pref["content_blank_caticon"]);
		}
		}
		
		function sc_content_cat_table_heading($parm='') {
		global $CONTENT_CAT_TABLE_HEADING, $row, $totalitems, $tp;
		$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
		//return ($totalitems > 0 ? "<a href='".e_SELF."?cat.".$row['content_id']."'>".$tp -> toHTML($row['content_heading'], TRUE, "")."</a>" : $tp -> toHTML($row['content_heading'], TRUE, "") );
		return "<a href='".e_PLUGIN_ABS."content/content.php?cat.".$row['content_id']."'>".$tp -> toHTML($row['content_heading'], TRUE, "")."</a>";
		}
		
		function sc_content_cat_table_title($parm='') {
		global $CONTENT_CAT_TABLE_TITLE, $row, $totalitems, $tp;
		return  $tp -> toHTML($row['content_heading'], TRUE, "");
		}
		
		
		function sc_content_cat_table_amount($parm='') {
		global $CONTENT_CAT_TABLE_AMOUNT, $aa, $row, $totalitems, $mainparent, $content_pref;
		if(isset($content_pref["content_catall_amount"]) && $content_pref["content_catall_amount"]){
		$n = $totalitems;
		$CONTENT_CAT_TABLE_AMOUNT = $n." ".($n == "1" ? CONTENT_LAN_53 : CONTENT_LAN_54);
		return $CONTENT_CAT_TABLE_AMOUNT;
		}
		}
		
		function sc_content_cat_table_subheading($parm='') {
		global $CONTENT_CAT_TABLE_SUBHEADING, $row, $tp, $mainparent, $content_pref;
		if(isset($content_pref["content_catall_subheading"]) && $content_pref["content_catall_subheading"]){
		return ($row['content_subheading'] ? $tp -> toHTML($row['content_subheading'], TRUE, "") : "");
		}
		}
		
		function sc_content_cat_table_date($parm='') {
		global $CONTENT_CAT_TABLE_DATE, $gen, $row, $mainparent, $content_pref, $gen;
		if(isset($content_pref["content_catall_date"]) && $content_pref["content_catall_date"]){
		if(!is_object($gen)){ $gen = new convert; }
		$datestamp = preg_replace("# -.*#", "", $gen -> convert_date($row['content_datestamp'], "long"));
		$DATE = ($datestamp != "" ? $datestamp : "");
		return $DATE;
		}
		}
		
		function sc_content_cat_table_authordetails($parm='') {
		global $CONTENT_CAT_TABLE_AUTHORDETAILS;
		return $CONTENT_CAT_TABLE_AUTHORDETAILS;
		}
		
		function sc_content_cat_table_epicons($parm='') {
		global $CONTENT_CAT_TABLE_EPICONS, $row, $tp, $mainparent, $content_pref;
		$EPICONS = "";
		if($row['content_pe'] && isset($content_pref["content_catall_peicon"]) && $content_pref["content_catall_peicon"]){
			$EPICONS = $tp -> parseTemplate("{EMAIL_ITEM=".CONTENT_LAN_69." ".CONTENT_LAN_72."^plugin:content.".$row['content_id']."}");
			$EPICONS .= " ".$tp -> parseTemplate("{PRINT_ITEM=".CONTENT_LAN_70." ".CONTENT_LAN_72."^plugin:content.".$row['content_id']."}");
			$EPICONS .= " ".$tp -> parseTemplate("{PDF=".CONTENT_LAN_76." ".CONTENT_LAN_72."^plugin:content.".$row['content_id']."}");
		return $EPICONS;
		}
		}
		
		function sc_content_cat_table_comment($parm='') {
		global $CONTENT_CAT_TABLE_COMMENT, $row, $qs, $comment_total, $mainparent, $content_pref, $plugintable;

		if($row['content_comment'] && isset($content_pref["content_catall_comment"]) && $content_pref["content_catall_comment"]){
		$sqlc = new db;
		$comment_total = $sqlc -> db_Select("comments", "*",  "comment_item_id='".$row['content_id']."' AND comment_type='".$plugintable."' AND comment_pid='0' ");
				$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
        $row['content_query'] = "?cat.".$row['content_id'].".comment";
        $url = e107::url("content", "content", $row, "full");
//   return "<a style='text-decoration:none;' href='".e_PLUGIN_ABS."content/content.php?cat.".$row['content_id'].".comment'>".CONTENT_LAN_57." ".$comment_total."</a>";
    return "<a style='text-decoration:none;' href='".$url."'>".CONTENT_LAN_57." ".$comment_total."</a>";
		}
		}
		
		function sc_content_cat_table_text($parm='') {
		global $CONTENT_CAT_TABLE_TEXT, $row, $tp, $mainparent, $content_pref;

		if($row['content_text'] && isset($content_pref["content_catall_text"]) && $content_pref["content_catall_text"] && ($content_pref["content_catall_text_char"] > 0 || $content_pref["content_catall_text_char"] == 'all')){
			if($content_pref["content_catall_text_char"] == 'all'){
				$CONTENT_CAT_TABLE_TEXT = $row['content_text'];
			}else{
				$rowtext = preg_replace("/\[newpage.*?]/si", " ", $row['content_text']);
				$rowtext = $tp->toHTML($rowtext, TRUE, "nobreak");
				
				$rowtext = strip_tags($rowtext);
				$words = explode(" ", $rowtext);
				$CONTENT_CAT_TABLE_TEXT = implode(" ", array_slice($words, 0, $content_pref["content_catall_text_char"]));
				if($content_pref["content_catall_text_link"]){
        	$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
          $row['content_query'] = "?cat.".$row['content_id'];
          $url = e107::url("content", "content", $row, "full");

					$CONTENT_CAT_TABLE_TEXT .= " <a href='".$url."'>".$content_pref["content_catall_text_post"]."</a>";
				}else{
					$CONTENT_CAT_TABLE_TEXT .= " ".$content_pref["content_catall_text_post"];
				}
			}
		return $CONTENT_CAT_TABLE_TEXT;
		}
		}
		
		
		
		function sc_content_cat_table_rating($parm='') {
		global $CONTENT_CAT_TABLE_RATING, $row, $rater, $mainparent, $content_pref, $plugintable;
		$RATING = "";
		if($row['content_rate'] && isset($content_pref["content_catall_rating"]) && $content_pref["content_catall_rating"]){
		return $rater->composerating($plugintable, $row['content_id'], $enter=TRUE, $userid=FALSE);
		}
		return $RATING;
		}
		
		// CONTENT_CAT_LIST_TABLE ------------------------------------------------
		function sc_content_cat_list_table_info_pre($parm='') {
		global $CONTENT_CAT_LIST_TABLE_INFO_PRE;
		if($CONTENT_CAT_LIST_TABLE_INFO_PRE === TRUE){
		$CONTENT_CAT_LIST_TABLE_INFO_PRE = " ";
		return $CONTENT_CAT_LIST_TABLE_INFO_PRE;
		}
		}
		function sc_content_cat_list_table_info_post($parm='')  {
		global $CONTENT_CAT_LIST_TABLE_INFO_POST;
		if($CONTENT_CAT_LIST_TABLE_INFO_POST === TRUE){
		$CONTENT_CAT_LIST_TABLE_INFO_POST = " ";
		return $CONTENT_CAT_LIST_TABLE_INFO_POST;
		}
		}
		
		function sc_content_cat_list_table_icon($parm='') {
		global $CONTENT_CAT_LIST_TABLE_ICON, $aa, $row, $qs, $content_pref, $content_cat_icon_path_large, $mainparent;
		if(isset($content_pref["content_cat_icon"]) && $content_pref["content_cat_icon"]){
		return $aa -> getIcon("catlarge", $row['content_icon'], $content_cat_icon_path_large, "", "", $content_pref["content_blank_caticon"]);;
		}
		}
		
		function sc_content_cat_list_table_heading($parm='') {
		global $CONTENT_CAT_LIST_TABLE_HEADING, $tp, $row, $totalparent, $tp;
		$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
    $row['content_query'] = "?cat.".$row['content_id'].".view";
    $url = e107::url("content", "content", $row, "full");   
		//return ($totalparent > 0 ? "<a href='".e_SELF."?cat.".$row['content_id'].".view'>".$tp -> toHTML($row['content_heading'], TRUE, "")."</a>" : $tp -> toHTML($row['content_heading'], TRUE, "") );
		return "<a href='".$url."'>".$tp -> toHTML($row['content_heading'], TRUE, "")."</a>";
		}
		
		function sc_content_cat_list_table_summary($parm='') {
		global $CONTENT_CAT_LIST_TABLE_SUMMARY, $tp, $row, $mainparent;
		return ($row['content_summary'] ? $tp -> toHTML($row['content_summary'], TRUE, "") : "");
		}
		
		function sc_content_cat_list_table_text($parm='') {
		global $CONTENT_CAT_LIST_TABLE_TEXT, $tp, $row, $mainparent, $content_pref;
		
		if($row['content_text'] && isset($content_pref["content_cat_text"]) && $content_pref["content_cat_text"] && ($content_pref["content_cat_text_char"] > 0 || $content_pref["content_cat_text_char"] == 'all')){
			if($content_pref["content_cat_text_char"] == 'all'){
				//$CONTENT_CAT_LIST_TABLE_TEXT = $row['content_text'];
				$CONTENT_CAT_LIST_TABLE_TEXT = $tp->toHTML($row['content_text'], TRUE, "constants");
			}else{
				$rowtext = preg_replace("/\[newpage.*?]/si", " ", $row['content_text']);
				$rowtext = $tp->toHTML($rowtext, TRUE, "nobreak, constants");
				
				$rowtext = strip_tags($rowtext);
				$words = explode(" ", $rowtext);
				$CONTENT_CAT_LIST_TABLE_TEXT = implode(" ", array_slice($words, 0, $content_pref["content_cat_text_char"]));
				if($content_pref["content_cat_text_link"]){
          $row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
          $row['content_query'] = "?cat.".$row['content_id'].".view";
          $url = e107::url("content", "content", $row, "full");
					$CONTENT_CAT_LIST_TABLE_TEXT .= " <a href='".$url."'>".$content_pref["content_cat_text_post"]."</a>";
				}else{
					$CONTENT_CAT_LIST_TABLE_TEXT .= " ".$content_pref["content_cat_text_post"];
				}
			}
		return $CONTENT_CAT_LIST_TABLE_TEXT;
		}
		}
		
		function sc_content_cat_list_table_amount($parm='') {
		global $CONTENT_CAT_LIST_TABLE_AMOUNT, $aa, $row, $mainparent, $content_pref, $totalparent;
		if(isset($content_pref["content_cat_amount"]) && $content_pref["content_cat_amount"]){
		$n = $totalparent;
		$n = $n." ".($n == "1" ? CONTENT_LAN_53 : CONTENT_LAN_54);
		return $n;
		}
		}
		
		function sc_content_cat_list_table_subheading($parm='') {
		global $CONTENT_CAT_LIST_TABLE_SUBHEADING, $tp, $row, $mainparent, $content_pref;
		if(isset($content_pref["content_cat_subheading"]) && $content_pref["content_cat_subheading"]){
		return ($row['content_subheading'] ? $tp -> toHTML($row['content_subheading'], TRUE, "") : "");
		}
		}
		
		function sc_content_cat_list_table_date($parm='') {
		global $CONTENT_CAT_LIST_TABLE_DATE, $row, $gen, $mainparent, $content_pref, $gen;
		if(isset($content_pref["content_cat_date"]) && $content_pref["content_cat_date"]){
		if(!is_object($gen)){ $gen = new convert; }
		$datestamp = preg_replace("# -.*#", "", $gen -> convert_date($row['content_datestamp'], "long"));
		return ($datestamp != "" ? $datestamp : "");
		}
		}
		
		function sc_content_cat_list_table_authordetails($parm='') {
		global $CONTENT_CAT_LIST_TABLE_AUTHORDETAILS;
		return $CONTENT_CAT_LIST_TABLE_AUTHORDETAILS;
		}
		
		function sc_content_cat_list_table_epicons($parm='') {
		global $CONTENT_CAT_LIST_TABLE_EPICONS, $row, $tp, $qs, $mainparent, $content_pref;
		$EPICONS = "";
		if( (isset($content_pref["content_cat_peicon"]) && $content_pref["content_cat_peicon"] && $row['content_pe']) || (isset($content_pref["content_cat_peicon_all"]) && $content_pref["content_cat_peicon_all"])){
			$EPICONS = $tp -> parseTemplate("{EMAIL_ITEM=".CONTENT_LAN_69." ".CONTENT_LAN_72."^plugin:content.$qs[1]}");
			$EPICONS .= " ".$tp -> parseTemplate("{PRINT_ITEM=".CONTENT_LAN_70." ".CONTENT_LAN_72."^plugin:content.$qs[1]}");
			$EPICONS .= " ".$tp -> parseTemplate("{PDF=".CONTENT_LAN_76." ".CONTENT_LAN_72."^plugin:content.$qs[1]}");
		return $EPICONS;
		}
		}
		
		function sc_content_cat_list_table_comment($parm='') {
		global $CONTENT_CAT_LIST_TABLE_COMMENT, $qs, $row, $comment_total, $mainparent, $content_pref, $sql, $plugintable;
		if($row['content_comment'] && isset($content_pref["content_cat_comment"]) && $content_pref["content_cat_comment"]){
			$comment_total = $sql -> db_Count("comments", "(*)",  "WHERE comment_item_id='".intval($qs[1])."' AND comment_type='".$plugintable."' AND comment_pid='0' ");
			$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
      $row['content_query'] = "?cat.".$qs[1].".comment";
      $url = e107::url("content", "content", $row, "full");
//   return "<a style='text-decoration:none;' href='".e_PLUGIN_ABS."content/content.php?cat.".$qs[1].".comment'>".CONTENT_LAN_57." ".$comment_total."</a>";
      return "<a style='text-decoration:none;' href='".$url."'>".CONTENT_LAN_57." ".$comment_total."</a>";
		}
		}
		
		function sc_content_cat_list_table_rating($parm='') {
		global $CONTENT_CAT_LIST_TABLE_RATING, $row, $rater, $content_pref, $mainparent, $plugintable;
		$RATING = "";
		if( (isset($content_pref["content_cat_rating_all"]) && $content_pref["content_cat_rating_all"]) || (isset($content_pref["content_cat_rating"]) && $content_pref["content_cat_rating"] && $row['content_rate'])){
			return $rater->composerating($plugintable, $row['content_id'], $enter=TRUE, $userid=FALSE);
		}
		return $RATING;
		}
		
		// CONTENT_CAT_LISTSUB ------------------------------------------------
		function sc_content_cat_listsub_table_icon($parm='') {
		global $CONTENT_CAT_LISTSUB_TABLE_ICON, $aa, $row, $content_pref, $qs, $mainparent, $content_cat_icon_path_small;
		
		if(isset($content_pref["content_catsub_icon"]) && $content_pref["content_catsub_icon"]){
		
		return $aa -> getIcon("catsmall", $row['content_icon'], $content_cat_icon_path_small, "cat.".$row['content_id'], "", $content_pref["content_blank_caticon"]);
		}
		}
		
		// CONTENT_CAT_LISTSUB ------------------------------------------------
		function sc_content_cat_listsub_table_icon_large($parm='') {
		global $CONTENT_CAT_LISTSUB_TABLE_ICON, $aa, $row, $content_pref, $qs, $mainparent, $content_cat_icon_path_large;
		 
		if(isset($content_pref["content_catsub_icon"]) && $content_pref["content_catsub_icon"]){    
		return $aa -> getIcon("catlarge", $row['content_icon'], $content_cat_icon_path_large, "cat.".$row['content_id'], "", $content_pref["content_blank_caticon"]);
		}
		}
		
		function sc_content_cat_listsub_table_heading($parm='')  {
		global $CONTENT_CAT_LISTSUB_TABLE_HEADING, $tp, $row, $totalsubcat, $tp;
		$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
		$row['content_query'] = "?cat.".$row['content_id'];
    $url = e107::url("content", "content", $row, "full");
		//return ($totalsubcat > 0 ? "<a href='".e_SELF."?cat.".$row['content_id']."'>".$tp -> toHTML($row['content_heading'], TRUE, "")."</a>" : $tp -> toHTML($row['content_heading'], TRUE, "") );
		return "<a href='".$url."'>".$tp -> toHTML($row['content_heading'], TRUE, "")."</a>";
		}
		
		function sc_content_cat_listsub_table_amount($parm='') {
		global $CONTENT_CAT_LISTSUB_TABLE_AMOUNT, $aa, $row, $content_pref, $mainparent, $totalsubcat;
		if(isset($content_pref["content_catsub_amount"]) && $content_pref["content_catsub_amount"]){
		$n = $totalsubcat;
		$n = $n." ".($n == "1" ? CONTENT_LAN_53 : CONTENT_LAN_54);
		return $n;
		}
		}
		
		function sc_content_cat_listsub_table_subheading($parm='') {
		global $CONTENT_CAT_LISTSUB_TABLE_SUBHEADING, $row, $tp, $content_pref, $mainparent;
		if(isset($content_pref["content_catsub_subheading"]) && $content_pref["content_catsub_subheading"]){
		return ($row['content_subheading'] ? $tp -> toHTML($row['content_subheading'], TRUE, "") : "");
		}
		}
		
		// CONTENT_SEARCH_TABLE ------------------------------------------------
		function sc_content_search_table_select($parm='') {
		global $CONTENT_SEARCH_TABLE_SELECT;
		return $CONTENT_SEARCH_TABLE_SELECT;
		}
		
		function sc_content_search_table_order($parm='') {
		global $CONTENT_SEARCH_TABLE_ORDER;
		return $CONTENT_SEARCH_TABLE_ORDER;
		}
		
		function sc_content_search_table_keyword($parm='') {
		global $CONTENT_SEARCH_TABLE_KEYWORD;
		return $CONTENT_SEARCH_TABLE_KEYWORD;
		}
		
		// CONTENT_SEARCHRESULT_TABLE ------------------------------------------------
		function sc_content_searchresult_table_icon($parm='')  {
		global $CONTENT_SEARCHRESULT_TABLE_ICON, $aa, $row, $content_icon_path, $qs, $content_pref, $mainparent;
		$width = (isset($content_pref["content_upload_icon_size"]) && $content_pref["content_upload_icon_size"] ? $content_pref["content_upload_icon_size"] : "100");
		return $aa -> getIcon("item", $row['content_icon'], $content_icon_path, "content.".$row['content_id'], $width, $content_pref["content_blank_icon"]);
		}
		
		function sc_content_searchresult_table_heading($parm='')   {
		global $CONTENT_SEARCHRESULT_TABLE_HEADING, $row, $qs, $tp;
		return ($row['content_heading'] ? "<a href='".e_PLUGIN_ABS."content/content.php?content.".$row['content_id']."'>".$tp -> toHTML($row['content_heading'], TRUE, "")."</a>" : "");
		}
		
		function sc_content_searchresult_table_subheading($parm='')  {
		global $CONTENT_SEARCHRESULT_TABLE_SUBHEADING, $row, $tp;
		return ($row['content_subheading'] ? $tp -> toHTML($row['content_subheading'], TRUE, "") : "");
		}
		
		function sc_content_searchresult_table_authordetails($parm='') {
		global $CONTENT_SEARCHRESULT_TABLE_AUTHORDETAILS, $qs, $aa, $row;
		$authordetails = $aa -> getAuthor($row['content_author']);
		$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
		$CONTENT_SEARCHRESULT_TABLE_AUTHORDETAILS = $authordetails[1];
		if(USER){
			if(is_numeric($authordetails[3])){
				$CONTENT_SEARCHRESULT_TABLE_AUTHORDETAILS .= " <a href='".e_BASE."user.php?id.".$authordetails[0]."' title='".CONTENT_LAN_40."'>".CONTENT_ICON_USER."</a>";
			}else{
				$CONTENT_SEARCHRESULT_TABLE_AUTHORDETAILS .= " ".CONTENT_ICON_USER;
			}
		}else{
			$CONTENT_SEARCHRESULT_TABLE_AUTHORDETAILS .= " ".CONTENT_ICON_USER;
		}
		$CONTENT_SEARCHRESULT_TABLE_AUTHORDETAILS .= " <a href='".e_SELF."?author.".$row['content_id']."' title='".CONTENT_LAN_39."'>".CONTENT_ICON_AUTHORLIST."</a>";
		return $CONTENT_SEARCHRESULT_TABLE_AUTHORDETAILS;
		}
		
		function sc_content_searchresult_table_date($parm='') {
		global $CONTENT_SEARCHRESULT_TABLE_DATE, $gen, $row;
		$datestamp = preg_replace("# -.*#", "", $gen -> convert_date($row['content_datestamp'], "short"));
		return $datestamp;
		}
		
		function sc_content_searchresult_table_text($parm='')  {
		global $CONTENT_SEARCHRESULT_TABLE_TEXT, $row, $tp;
		return ($row['content_text'] ? $tp -> toHTML($row['content_text'], TRUE, "") : "");
		}
		
		// CONTENT_RECENT_TABLE ------------------------------------------------
		function sc_content_recent_table_infopre($parm='') {
		global $CONTENT_RECENT_TABLE_INFOPRE;
		if($CONTENT_RECENT_TABLE_INFOPRE === TRUE){
		$CONTENT_RECENT_TABLE_INFOPRE = " ";
		return $CONTENT_RECENT_TABLE_INFOPRE;
		}
		}
		function sc_content_recent_table_infopost($parm='') {
		global $CONTENT_RECENT_TABLE_INFOPOST;
		if($CONTENT_RECENT_TABLE_INFOPOST === TRUE){
		$CONTENT_RECENT_TABLE_INFOPOST = " ";
		return $CONTENT_RECENT_TABLE_INFOPOST;
		}
		}
		
		function sc_content_recent_table_icon($parm='')  {
		global $CONTENT_RECENT_TABLE_ICON, $aa, $row, $content_icon_path, $content_pref, $mainparent;
		if(isset($content_pref["content_list_icon"]) && $content_pref["content_list_icon"]){
		$width = (isset($content_pref["content_upload_icon_size"]) && $content_pref["content_upload_icon_size"] ? $content_pref["content_upload_icon_size"] : "100");
		return $aa -> getIcon("item", $row['content_icon'], $content_icon_path, "content.".$row['content_id'], $width, $content_pref["content_blank_icon"]);
		}
		}
		
		//  {CONTENT_RECENT_TABLE_HEADING}
		function sc_content_recent_table_heading($parm='') {
		global $CONTENT_RECENT_TABLE_HEADING, $row, $tp;
		if ($this->var) { $row = $this->var; }
		$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
		return ($row['content_heading'] ? "<a href='".e_PLUGIN_ABS."content/content.php?content.".$row['content_id']."'>".$tp->toHTML($row['content_heading'], TRUE, "")."</a>" : "");
		}
		
		function sc_content_recent_table_subheading($parm='') {
		global $CONTENT_RECENT_TABLE_SUBHEADING, $tp, $content_pref, $qs, $row, $mainparent;
		
		if (isset($content_pref["content_list_subheading"]) && $content_pref["content_list_subheading"] && $row['content_subheading'] && $content_pref["content_list_subheading_char"] && $content_pref["content_list_subheading_char"] != "" && $content_pref["content_list_subheading_char"] != "0"){
			if(strlen($row['content_subheading']) > $content_pref["content_list_subheading_char"]) {
				$row['content_subheading'] = substr($row['content_subheading'], 0, $content_pref["content_list_subheading_char"]).$content_pref["content_list_subheading_post"];
			}
			$CONTENT_RECENT_TABLE_SUBHEADING = ($row['content_subheading'] != "" && $row['content_subheading'] != " " ? $row['content_subheading'] : "");
		}else{
			$CONTENT_RECENT_TABLE_SUBHEADING = ($row['content_subheading'] ? $row['content_subheading'] : "");
		}
		return $tp->toHTML($CONTENT_RECENT_TABLE_SUBHEADING, TRUE, "");
		}
		
		function sc_content_recent_table_summary($parm='') {
		global $CONTENT_RECENT_TABLE_SUMMARY, $content_pref, $tp, $qs, $row, $mainparent;
		if (isset($content_pref["content_list_summary"]) && $content_pref["content_list_summary"]){
			if($row['content_summary'] && $content_pref["content_list_summary_char"] && $content_pref["content_list_summary_char"] != "" && $content_pref["content_list_summary_char"] != "0"){
				if(strlen($row['content_summary']) > $content_pref["content_list_summary_char"]) {
					$row['content_summary'] = substr($row['content_summary'], 0, $content_pref["content_list_summary_char"]).$content_pref["content_list_summary_post"];
				}
				$CONTENT_RECENT_TABLE_SUMMARY = ($row['content_summary'] != "" && $row['content_summary'] != " " ? $row['content_summary'] : "");
			}else{
				$CONTENT_RECENT_TABLE_SUMMARY = ($row['content_summary'] ? $row['content_summary'] : "");
			}
		return $tp->toHTML($CONTENT_RECENT_TABLE_SUMMARY, TRUE, "");
		}
		}
		
		function sc_content_recent_table_text($parm='') {
		global $CONTENT_RECENT_TABLE_TEXT, $content_pref, $qs, $row, $mainparent, $tp;
		$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
		if(isset($content_pref["content_list_text"]) && $content_pref["content_list_text"] && $content_pref["content_list_text_char"] > 0){
			$rowtext = preg_replace("/\[newpage.*?]/si", " ", $row['content_text']);
			//$rowtext = str_replace ("<br />", " ", $rowtext);
			$rowtext = $tp->toHTML($rowtext, TRUE, "nobreak");
			$rowtext = strip_tags($rowtext);
			$words = explode(" ", $rowtext);
			$CONTENT_RECENT_TABLE_TEXT = implode(" ", array_slice($words, 0, $content_pref["content_list_text_char"]));
			if($CONTENT_RECENT_TABLE_TEXT){
				if($content_pref["content_list_text_link"]){
					$CONTENT_RECENT_TABLE_TEXT .= " <a href='".e_PLUGIN_ABS."content/content.php?content.".$row['content_id']."'>".$content_pref["content_list_text_post"]."</a>";
				}else{
					$CONTENT_RECENT_TABLE_TEXT .= " ".$content_pref["content_list_text_post"];
				}
			}
		}
		return $CONTENT_RECENT_TABLE_TEXT;
		}
		
		function sc_content_recent_table_date($parm='') {
		global $CONTENT_RECENT_TABLE_DATE, $content_pref, $qs, $row, $mainparent;
		if(isset($content_pref["content_list_date"]) && $content_pref["content_list_date"]){
		$datestyle = ($content_pref["content_list_datestyle"] ? $content_pref["content_list_datestyle"] : "%d %b %Y");
		return strftime($datestyle, $row['content_datestamp']);
		}
		}
		
		function sc_content_recent_table_epicons($parm='') {
		global $CONTENT_RECENT_TABLE_EPICONS, $tp, $content_pref, $qs, $row, $mainparent;
		$CONTENT_RECENT_TABLE_EPICONS = "";
		if(isset($content_pref["content_list_peicon"]) && $content_pref["content_list_peicon"]){
			if($row['content_pe'] || isset($content_pref["content_list_peicon_all"]) && $content_pref["content_list_peicon_all"]){
				$CONTENT_RECENT_TABLE_EPICONS = $tp -> parseTemplate("{EMAIL_ITEM=".CONTENT_LAN_69." ".CONTENT_LAN_71."^plugin:content.".$row['content_id']."}");
				$CONTENT_RECENT_TABLE_EPICONS .= " ".$tp -> parseTemplate("{PRINT_ITEM=".CONTENT_LAN_70." ".CONTENT_LAN_71."^plugin:content.".$row['content_id']."}");
				$CONTENT_RECENT_TABLE_EPICONS .= " ".$tp -> parseTemplate("{PDF=".CONTENT_LAN_76." ".CONTENT_LAN_71."^plugin:content.".$row['content_id']."}");
			}
		}
		return $CONTENT_RECENT_TABLE_EPICONS;
		}
		
		function sc_content_recent_table_authordetails($parm='')  {
		global $CONTENT_RECENT_TABLE_AUTHORDETAILS;
		return $CONTENT_RECENT_TABLE_AUTHORDETAILS;
		}
		
		function sc_content_recent_table_editicon($parm='')  {
		global $CONTENT_RECENT_TABLE_EDITICON, $content_pref, $qs, $row, $mainparent, $plugindir, $plugindir_abs;
		$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
		if(ADMIN && getperms("P") && isset($content_pref["content_list_editicon"]) && $content_pref["content_list_editicon"]){
		return $CONTENT_RECENT_TABLE_EDITICON = "<a href='".$plugindir_abs."admin_content_config.php?content.edit.".$row['content_id']."'>".CONTENT_ICON_EDIT."</a>";
		}
		}
		
		function sc_content_recent_table_refer($parm='')  {
		global $CONTENT_RECENT_TABLE_REFER, $content_pref, $qs, $row, $mainparent;
		if($content_pref["content_log"] && $content_pref["content_list_refer"]){
			$refercounttmp = explode("^", $row['content_refer']);
			$CONTENT_RECENT_TABLE_REFER = ($refercounttmp[0] ? $refercounttmp[0] : "0");
			if($CONTENT_RECENT_TABLE_REFER > 0){
				return $CONTENT_RECENT_TABLE_REFER;
			}
		}
		}
		
		function sc_content_recent_table_rating($parm='')  {
		global $CONTENT_RECENT_TABLE_RATING, $rater, $row, $qs, $content_pref, $plugintable, $mainparent;
		if($content_pref["content_list_rating"]){
			if($content_pref["content_list_rating_all"] || $row['content_rate']){
				return $rater->composerating($plugintable, $row['content_id'], $enter=FALSE, $userid=FALSE);
			}
		}
		}
		
		function sc_content_recent_table_parent($parm='') {
		global $CONTENT_RECENT_TABLE_PARENT, $content_pref, $mainparent, $row, $array, $aa;
		
		if(isset($content_pref["content_list_parent"]) && $content_pref["content_list_parent"]){  
		return $aa -> getCrumbItem($row['content_parent'], $array);
		}
		}
		
		// CONTENT_ARCHIVE_TABLE ------------------------------------------------
		function sc_content_archive_table_letters($parm='')  {
		global $CONTENT_ARCHIVE_TABLE_LETTERS, $content_pref, $mainparent;
		if($content_pref["content_archive_letterindex"]){
		return $CONTENT_ARCHIVE_TABLE_LETTERS;
		}
		}
		
		function sc_content_archive_table_heading($parm='')  {
		global $CONTENT_ARCHIVE_TABLE_HEADING, $row, $qs;
		if ($this->var) { $row = $this->var; }
		$row['content_sef'] = eHelper::title2sef($row['content_heading'],'dashl');
		return "<a href='".e_PLUGIN_ABS."content/content.php?content.".$row['content_id']."'>".$row['content_heading']."</a>";
		}
		
		function sc_content_archive_table_date($parm='') {
		global $CONTENT_ARCHIVE_TABLE_DATE, $row, $content_pref, $qs, $mainparent;
		if(isset($content_pref["content_archive_date"]) && $content_pref["content_archive_date"]){
		$datestyle = ($content_pref["content_archive_datestyle"] ? $content_pref["content_archive_datestyle"] : "%d %b %Y");
		return strftime($datestyle, $row['content_datestamp']);
		}
		}
		
		function sc_content_archive_table_author($parm='') {
		global $CONTENT_ARCHIVE_TABLE_AUTHOR;
		return $CONTENT_ARCHIVE_TABLE_AUTHOR;
		}
		
		// CONTENT_CONTENT_TABLE ------------------------------------------------
		function sc_content_content_table_info_pre($parm='') {
		global $CONTENT_CONTENT_TABLE_INFO_PRE;
		if($CONTENT_CONTENT_TABLE_INFO_PRE === TRUE){
		$CONTENT_CONTENT_TABLE_INFO_PRE = " ";
		return $CONTENT_CONTENT_TABLE_INFO_PRE;
		}
		}
		function sc_content_content_table_info_post($parm='') {
		global $CONTENT_CONTENT_TABLE_INFO_POST;
		if($CONTENT_CONTENT_TABLE_INFO_POST === TRUE){
		$CONTENT_CONTENT_TABLE_INFO_POST = " ";
		return $CONTENT_CONTENT_TABLE_INFO_POST;
		}
		}
		
		function sc_content_content_table_info_pre_headdata($parm='')  {
		global $CONTENT_CONTENT_TABLE_INFO_PRE_HEADDATA;
		if($CONTENT_CONTENT_TABLE_INFO_PRE_HEADDATA === TRUE){
		$CONTENT_CONTENT_TABLE_INFO_PRE_HEADDATA = " ";
		return $CONTENT_CONTENT_TABLE_INFO_PRE_HEADDATA;
		}
		}
		function sc_content_content_table_info_post_headdata($parm='') {
		global $CONTENT_CONTENT_TABLE_INFO_POST_HEADDATA;
		if($CONTENT_CONTENT_TABLE_INFO_POST_HEADDATA === TRUE){
		$CONTENT_CONTENT_TABLE_INFO_POST_HEADDATA = " ";
		return $CONTENT_CONTENT_TABLE_INFO_POST_HEADDATA;
		}
		}
		/* {CONTENT_CONTENT_TABLE_PARENT} */
		function sc_content_content_table_parent($parm=NULL) {
		global $CONTENT_CONTENT_TABLE_PARENT, $aa, $array, $row, $content_pref, $mainparent;
		if ($this->var) { $row = $this->var; }
		// always display, ignore prefs
		if($parm['view']) {
		  return $aa -> getCrumbItem($row['content_parent'], $array);
		}
 
		if(isset($content_pref["content_content_parent"]) && $content_pref["content_content_parent"]){
		return $aa -> getCrumbItem($row['content_parent'], $array);
		}
		}
		
		function sc_content_content_table_icon($parm='') {
		global $CONTENT_CONTENT_TABLE_ICON, $qs, $row, $aa, $content_pref, $content_icon_path, $mainparent;
		if(isset($content_pref["content_content_icon"]) && $content_pref["content_content_icon"]){
		$width = (isset($content_pref["content_upload_icon_size"]) && $content_pref["content_upload_icon_size"] ? $content_pref["content_upload_icon_size"] : "100");
		return $aa -> getIcon("item", $row['content_icon'], $content_icon_path, "", $width, $content_pref["content_blank_icon"]);
		}
		}
		// {CONTENT_CONTENT_TABLE_HEADING}
		function sc_content_content_table_heading($parm='') {
		global $CONTENT_CONTENT_TABLE_HEADING, $row, $tp;
		if ($this->var) { $row = $this->var; }
		$CONTENT_CONTENT_TABLE_HEADING = ($row['content_heading'] ? $tp -> toHTML($row['content_heading'], TRUE, "") : "");
		return $CONTENT_CONTENT_TABLE_HEADING;
		}
		
		function sc_content_content_table_refer($parm='')  {
		global $CONTENT_CONTENT_TABLE_REFER, $sql, $qs, $content_pref, $plugintable, $mainparent;
		if(isset($content_pref["content_content_refer"]) && $content_pref["content_content_refer"]){
			$sql -> db_Select($plugintable, "content_refer", "content_id='".intval($qs[1])."' ");
			list($content_refer) = $sql -> db_Fetch();
			$refercounttmp = explode("^", $content_refer);
			$CONTENT_CONTENT_TABLE_REFER = ($refercounttmp[0] ? $refercounttmp[0] : "");
		return $CONTENT_CONTENT_TABLE_REFER;
		}
		}
		
		function sc_content_content_table_subheading($parm='') {
		global $CONTENT_CONTENT_TABLE_SUBHEADING, $row, $tp, $content_pref, $qs, $mainparent;
		$CONTENT_CONTENT_TABLE_SUBHEADING = ($content_pref["content_content_subheading"] && $row['content_subheading'] ? $tp -> toHTML($row['content_subheading'], TRUE, "") : "");
		return $CONTENT_CONTENT_TABLE_SUBHEADING;
		}
		
		function sc_content_content_table_comment($parm='') {
		global $CONTENT_CONTENT_TABLE_COMMENT, $cobj, $qs, $content_pref, $mainparent, $row, $plugintable;
		if((isset($content_pref["content_content_comment"]) && $content_pref["content_content_comment"] && $row['content_comment']) || $content_pref["content_content_comment_all"] ){
		return $cobj -> count_comments($plugintable, $qs[1]);
		}
		}
		
		/*  {CONTENT_CONTENT_TABLE_DATE} */ 
		function sc_content_content_table_date($parm='')  {
		global $CONTENT_CONTENT_TABLE_DATE, $gen, $row, $qs, $content_pref, $mainparent;
		if ($this->var) { $row = $this->var; }
		if(isset($content_pref["content_content_date"]) && $content_pref["content_content_date"]){
			$gen = new convert;
			$datestamp = preg_replace("# -.*#", "", $gen -> convert_date($row['content_datestamp'], "long"));
			$CONTENT_CONTENT_TABLE_DATE = ($datestamp != "" ? $datestamp : "");
		return $CONTENT_CONTENT_TABLE_DATE;
		}
		}
		
		function sc_content_content_table_authordetails($parm='') {
		global $CONTENT_CONTENT_TABLE_AUTHORDETAILS;
		return $CONTENT_CONTENT_TABLE_AUTHORDETAILS;
		}
		
		function sc_content_content_table_epicons($parm='') {
		global $CONTENT_CONTENT_TABLE_EPICONS, $content_pref, $qs, $row, $tp, $mainparent;
		$CONTENT_CONTENT_TABLE_EPICONS = "";
		if(($content_pref["content_content_peicon"] && $row['content_pe']) || $content_pref["content_content_peicon_all"]){
			$CONTENT_CONTENT_TABLE_EPICONS = $tp -> parseTemplate("{EMAIL_ITEM=".CONTENT_LAN_69." ".CONTENT_LAN_71."^plugin:content.".$row['content_id']."}");
			$CONTENT_CONTENT_TABLE_EPICONS .= " ".$tp -> parseTemplate("{PRINT_ITEM=".CONTENT_LAN_70." ".CONTENT_LAN_71."^plugin:content.".$row['content_id']."}");
			$CONTENT_CONTENT_TABLE_EPICONS .= " ".$tp -> parseTemplate("{PDF=".CONTENT_LAN_76." ".CONTENT_LAN_71."^plugin:content.".$row['content_id']."}");
		return $CONTENT_CONTENT_TABLE_EPICONS;
		}
		}
		
		function sc_content_content_table_editicon($parm='') {
		global $CONTENT_CONTENT_TABLE_EDITICON, $content_pref, $qs, $row, $plugindir, $mainparent;
		if(ADMIN && getperms("P") && isset($content_pref["content_content_editicon"])){
			$CONTENT_CONTENT_TABLE_EDITICON = "<a href='".$plugindir_abs."admin_content_config.php?content.edit.".$row['content_id']."'>".CONTENT_ICON_EDIT."</a>";
		return $CONTENT_CONTENT_TABLE_EDITICON;
		}
		}
		
		function sc_content_content_table_rating($parm='') {
		global $CONTENT_CONTENT_TABLE_RATING, $content_pref, $qs, $row, $rater, $plugintable, $mainparent;
		if(($content_pref["content_content_rating"] && $row['content_rate']) || $content_pref["content_content_rating_all"] ){
			//return $rater->composerating($plugintable, $row['content_id'], $enter=TRUE, $userid=FALSE);
			$tmp = $_SERVER['QUERY_STRING'];
			$_SERVER['QUERY_STRING'] .= ".rated";
			$text = $rater->composerating($plugintable, $row['content_id'], $enter=TRUE, $userid=FALSE);
			$_SERVER['QUERY_STRING'] = $tmp;
			return $text;
		}
		}
		
		function sc_content_content_table_file($parm='') {
		global $CONTENT_CONTENT_TABLE_FILE, $row, $content_file_path, $content_pref, $mainparent;
		if($content_pref["content_content_attach"]){
		$filestmp = explode("[file]", $row['content_file']);
		foreach($filestmp as $key => $value) { 
			if($value == "") { 
				unset($filestmp[$key]); 
			} 
		} 
		$files = array_values($filestmp);
		$content_files_popup_name = str_replace("'", "", $row['content_heading']);
		$file = "";
		$filesexisting = "0";
		for($i=0;$i<count($files);$i++){
			if(file_exists($content_file_path.$files[$i])){
				$filesexisting = $filesexisting+1;
				$file .= "<a href='".$content_file_path.$files[$i]."' rel='external'>".CONTENT_ICON_FILE."</a> ";						
			}else{
				$file .= "&nbsp;";
			}
		}
		$CONTENT_CONTENT_TABLE_FILE = ($filesexisting == "0" ? "" : CONTENT_LAN_41." ".($filesexisting == 1 ? CONTENT_LAN_42 : CONTENT_LAN_43)." ".$file." ");
		return $CONTENT_CONTENT_TABLE_FILE;
		}
		}
		
		function sc_content_content_table_score($parm='')  {
		global $CONTENT_CONTENT_TABLE_SCORE, $row;
		$score = $row['content_score'];
		if($score){
			$height = "height:8px;";
			$img = "";
			$img .= "<img src='".e_PLUGIN_ABS."content/images/score_end.png' alt='' style='$height width:1px; border:0;' />";
			$img .= "<img src='".e_PLUGIN_ABS."content/images/score.png' alt='' style='$height width:".$score."px; border:0;' />";
			$img .= "<img src='".e_PLUGIN_ABS."content/images/score_end.png' alt='' style='$height width:1px; border:0;' />";
			if($score < 100){
				$empty = 100-$score;
				$img .= "<img src='".e_PLUGIN_ABS."content/images/score_empty.png' alt='' style='$height width:".$empty."px; border:0;' />";
			}
			$img .= "<img src='".e_PLUGIN_ABS."content/images/score_end.png' alt='' style='$height width:1px; border:0;' />";
			return $img." ".$score;
		}
		}
		
		function sc_content_content_table_summary($parm='') {
		global $CONTENT_CONTENT_TABLE_SUMMARY;
		return $CONTENT_CONTENT_TABLE_SUMMARY;
		}
		
		function sc_content_content_table_text($parm='')  {
		global $CONTENT_CONTENT_TABLE_TEXT;
		return $CONTENT_CONTENT_TABLE_TEXT;
		}
		
		function sc_content_content_table_images($parm='')  {
		global $CONTENT_CONTENT_TABLE_IMAGES, $row, $content_image_path, $aa, $tp, $authordetails, $content_pref, $mainparent;
		
		if($content_pref["content_content_images"]){   
		$authordetails = $aa -> getAuthor($row['content_author']);
		$imagestmp = explode("[img]", $row['content_image']);
		foreach($imagestmp as $key => $value) { 
			if($value == "") { 
				unset($imagestmp[$key]); 
			} 
		} 
		$images = array_values($imagestmp);
		
		$content_image_popup_name = $row['content_heading'];
		$CONTENT_CONTENT_TABLE_IMAGES = "";
		require_once(e_PLUGIN."content/popup/popup_handler.php");
		$pp = new popup;
		$datestamp = e107::getDateConvert()->convert_date($row['content_datestamp'], "long");
		for($i=0;$i<count($images);$i++){		
			$oSrc = $content_image_path.$images[$i];
			$oSrcThumb = $content_image_path."thumb_".$images[$i];
		
			$oIconWidth = (isset($content_pref["content_upload_image_size_thumb"]) && $content_pref["content_upload_image_size_thumb"] ? $content_pref["content_upload_image_size_thumb"] : "100");
			
			$oMaxWidth = (isset($content_pref["content_upload_image_size"]) && $content_pref["content_upload_image_size"] ? $content_pref["content_upload_image_size"] : "500");
			
			$subheading	= $tp -> toHTML($row['content_subheading'], TRUE);
			$popupname	= $tp -> toHTML($content_image_popup_name, TRUE);
			$author		= $tp -> toHTML($authordetails[1], TRUE);
			$oTitle		= $popupname." ".($i+1);
			$oText		= $popupname." ".($i+1)."<br />".$subheading."<br />".$author." (".$datestamp.")";
			$CONTENT_CONTENT_TABLE_IMAGES .= $pp -> popup($oSrc, $oSrcThumb, $oIconWidth, $oMaxWidth, $oTitle, $oText);
		}
			
		return $CONTENT_CONTENT_TABLE_IMAGES;
		}
		}
		
		function sc_content_content_table_custom_tags($parm='')   {
		global $CONTENT_CONTENT_TABLE_CUSTOM_TAGS;
		return $CONTENT_CONTENT_TABLE_CUSTOM_TAGS;
		}
		
		function sc_content_content_table_pagenames($parm='')  {
		global $CONTENT_CONTENT_TABLE_PAGENAMES;
		return $CONTENT_CONTENT_TABLE_PAGENAMES;
		}
		
		function sc_content_content_table_next_page($parm='') {
		global $CONTENT_CONTENT_TABLE_NEXT_PAGE;
		return $CONTENT_CONTENT_TABLE_NEXT_PAGE;
		}
		
		function sc_content_content_table_prev_page($parm='') {
		global $CONTENT_CONTENT_TABLE_PREV_PAGE;
		return $CONTENT_CONTENT_TABLE_PREV_PAGE;
		}
		
		
		
		
		// PRINT PAGE ------------------------------------------------
		
		//content images (from uploaded area) used in the print page
		function sc_content_print_images($parm='') {
		global $CONTENT_PRINT_IMAGES, $row, $content_image_path, $tp, $content_pref, $mainparent;
		if($content_pref["content_content_images"]){
		$imagestmp = explode("[img]", $row['content_image']);
		foreach($imagestmp as $key => $value) { 
			if($value == "") { 
				unset($imagestmp[$key]); 
			} 
		} 
		$images = array_values($imagestmp);
		$CONTENT_PRINT_IMAGES = "";
		for($i=0;$i<count($images);$i++){		
			$oSrc = $content_image_path.$images[$i];
			$oSrcThumb = $content_image_path."thumb_".$images[$i];
		
			$iconwidth = (isset($content_pref["content_upload_image_size_thumb"]) && $content_pref["content_upload_image_size_thumb"] ? $content_pref["content_upload_image_size_thumb"] : "100");
			if($iconwidth){
				$style = "style='width:".$iconwidth."px;'";
			}
			
			//use $image if $thumb doesn't exist
			if(file_exists($oSrc)){
				if(!file_exists($oSrcThumb)){
					$thumb = $oSrc;
				}else{
					$thumb = $oSrcThumb;
				}
				$CONTENT_PRINT_IMAGES .= "<img src='".$thumb."' ".$style." alt='' /><br /><br />";
			}
		}
		return $CONTENT_PRINT_IMAGES;
		}
		}
		
		
		// PDF PAGE ------------------------------------------------
		
		//content images (from uploaded area) used in the pdf creation
		function sc_content_pdf_images($parm='') {
		global $CONTENT_PDF_IMAGES, $row, $content_image_path, $tp, $content_pref, $mainparent;
		if($content_pref["content_content_images"]){
		$imagestmp = explode("[img]", $row['content_image']);
		foreach($imagestmp as $key => $value) { 
			if($value == "") { 
				unset($imagestmp[$key]); 
			} 
		} 
		$images = array_values($imagestmp);
		$CONTENT_PDF_IMAGES = "";
		for($i=0;$i<count($images);$i++){		
			$oSrc = $content_image_path.$images[$i];
			$oSrcThumb = $content_image_path."thumb_".$images[$i];
		
			$iconwidth = (isset($content_pref["content_upload_image_size_thumb"]) && $content_pref["content_upload_image_size_thumb"] ? $content_pref["content_upload_image_size_thumb"] : "100");
			if($iconwidth){
				$style = "style='width:".$iconwidth."px;'";
			}
			
			//use $image if $thumb doesn't exist
			if(file_exists($oSrc)){
				if(!file_exists($oSrcThumb)){
					$thumb = $oSrc;
				}else{
					$thumb = $oSrcThumb;
				}
				$thumb = $oSrc;
				$CONTENT_PDF_IMAGES .= "<img src='".$thumb."' ".$style." alt='' />";
			}
		}
		return $CONTENT_PDF_IMAGES;
		}
	}
}



 
