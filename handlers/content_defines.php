<?php
/* $Id: content_defines.php 11346 2010-02-17 18:56:14Z secretr $ */
if (!defined('e107_INIT')) { exit; }
 
$imagedir = e_PLUGIN."content/";
$imagedir  = e_PLUGIN_ABS."content/";

include_lan(e_PLUGIN."content/languages/".e_LANGUAGE."/lan_content.php");
include_lan(e_PLUGIN."content/languages/".e_LANGUAGE."/lan_content_admin.php");

if (!defined('CONTENT_ICON_EDIT')) { define("CONTENT_ICON_EDIT", "<img src='".$imagedir."images/maintain_16.png' alt='".CONTENT_ICON_LAN_0."' title='".CONTENT_ICON_LAN_0."' style='border:0; cursor:pointer;' />"); }
if (!defined('CONTENT_ICON_LINK')) { define("CONTENT_ICON_LINK", "<img src='".$imagedir."images/leave_16.png' alt='".CONTENT_ICON_LAN_15."' title='".CONTENT_ICON_LAN_15."' style='border:0; cursor:pointer;' />"); }
if (!defined('CONTENT_ICON_DELETE')) { define("CONTENT_ICON_DELETE", "<img src='".$imagedir."images/delete_16.png' alt='".CONTENT_ICON_LAN_1."' title='".CONTENT_ICON_LAN_1."' style='border:0; cursor:pointer;' />"); }
if (!defined('CONTENT_ICON_DELETE_BASE')) { define("CONTENT_ICON_DELETE_BASE", $imagedir."images/delete_16.png"); }
if (!defined('CONTENT_ICON_OPTIONS')) { define("CONTENT_ICON_OPTIONS", "<img src='".$imagedir."images/cat_settings_16.png' alt='".CONTENT_ICON_LAN_2."' title='".CONTENT_ICON_LAN_2."' style='border:0; cursor:pointer;' />"); }
if (!defined('CONTENT_ICON_USER')) { define("CONTENT_ICON_USER", "<img src='".$imagedir."images/users_16.png' alt='".CONTENT_ICON_LAN_3."' title='".CONTENT_ICON_LAN_3."' style='border:0; cursor:pointer;' />"); }
if (!defined('CONTENT_ICON_FILE')) { define("CONTENT_ICON_FILE", "<img src='".$imagedir."images/file_16.png' alt='".CONTENT_ICON_LAN_4."' title='".CONTENT_ICON_LAN_4."' style='border:0; cursor:pointer;' />"); }
if (!defined('CONTENT_ICON_NEW')) { define("CONTENT_ICON_NEW", "<img src='".$imagedir."images/articles_16.png' alt='".CONTENT_ICON_LAN_5."' title='".CONTENT_ICON_LAN_5."' style='border:0; cursor:pointer;' />"); }
if (!defined('CONTENT_ICON_SUBMIT')) { define("CONTENT_ICON_SUBMIT", "<img src='".$imagedir."images/submit_32.png' alt='".CONTENT_ICON_LAN_6."' title='".CONTENT_ICON_LAN_6."' style='border:0; cursor:pointer;' />"); }
if (!defined('CONTENT_ICON_SUBMIT_SMALL')) { define("CONTENT_ICON_SUBMIT_SMALL", "<img src='".$imagedir."images/submit_16.png' alt='".CONTENT_ICON_LAN_6."' title='".CONTENT_ICON_LAN_6."' style='border:0; cursor:pointer;' />"); }
if (!defined('CONTENT_ICON_AUTHORLIST')) { define("CONTENT_ICON_AUTHORLIST", "<img src='".$imagedir."images/personal.png' alt='".CONTENT_ICON_LAN_7."' title='".CONTENT_ICON_LAN_7."' style='border:0; cursor:pointer;' />"); }
if (!defined('CONTENT_ICON_WARNING')) { define("CONTENT_ICON_WARNING", "<img src='".$imagedir."images/warning_16.png' alt='".CONTENT_ICON_LAN_8."' title='".CONTENT_ICON_LAN_8."' style='border:0; cursor:pointer;' />"); }
if (!defined('CONTENT_ICON_OK')) { define("CONTENT_ICON_OK", "<img src='".$imagedir."images/ok_16.png' alt='".CONTENT_ICON_LAN_9."' title='".CONTENT_ICON_LAN_9."' style='border:0; cursor:pointer;' />"); }
if (!defined('CONTENT_ICON_ERROR')) { define("CONTENT_ICON_ERROR", "<img src='".$imagedir."images/error_16.png' alt='".CONTENT_ICON_LAN_10."' title='".CONTENT_ICON_LAN_10."' style='border:0; cursor:pointer;' />"); }
if (!defined('CONTENT_ICON_ORDERCAT')) { define("CONTENT_ICON_ORDERCAT", "<img src='".$imagedir."images/view_remove.png' alt='".CONTENT_ICON_LAN_11."' title='".CONTENT_ICON_LAN_11."' style='border:0; cursor:pointer;' />"); }
if (!defined('CONTENT_ICON_ORDERALL')) { define("CONTENT_ICON_ORDERALL", "<img src='".$imagedir."images/window_new.png' alt='".CONTENT_ICON_LAN_12."' title='".CONTENT_ICON_LAN_12."' style='border:0; cursor:pointer;' />"); }
if (!defined('CONTENT_ICON_CONTENTMANAGER')) { define("CONTENT_ICON_CONTENTMANAGER", "<img src='".$imagedir."images/manager_48.png' alt='".CONTENT_ICON_LAN_14."' title='".CONTENT_ICON_LAN_14."' style='border:0; cursor:pointer;' />"); }
if (!defined('CONTENT_ICON_CONTENTMANAGER_SMALL')) { define("CONTENT_ICON_CONTENTMANAGER_SMALL", "<img src='".$imagedir."images/manager_16.png' alt='".CONTENT_ICON_LAN_13."' title='".CONTENT_ICON_LAN_13."' style='border:0; cursor:pointer;' />"); }
if (!defined('CONTENT_ICON_ORDER_UP')) { define("CONTENT_ICON_ORDER_UP", "<img src='".$imagedir."images/up.png' alt='".CONTENT_ADMIN_ITEM_LAN_63."' title='".CONTENT_ADMIN_ITEM_LAN_63."' />"); }
if (!defined('CONTENT_ICON_ORDER_DOWN')) { define("CONTENT_ICON_ORDER_DOWN", "<img src='".$imagedir."images/down.png' alt='".CONTENT_ADMIN_ITEM_LAN_64."' title='".CONTENT_ADMIN_ITEM_LAN_64."' />"); }

?>