<?xml version="1.0" encoding="utf-8" ?>
<!DOCTYPE html>
<html lang="{BACKEND_LANG}">
<head>
  <meta charset="utf-8">
  <meta name="robots" content="noindex, nofollow" />
  <title>Sefrengo {VERSION}</title>
  <link rel="stylesheet" type="text/css" href="tpl/standard/css/styles.css" />
  <link rel="stylesheet" href="tpl/standard/css/dynCalendar.css" type="text/css" />
  <link rel="stylesheet" type="text/css" href="tpl/standard/css/sftabs.css" />
  <!--[if lt IE 7]>
  <link rel="stylesheet" type="text/css" href="tpl/standard/css/ie.css" />
  <![endif]-->
  <script src="tpl/standard/js/jquery-1.4.4.min.js" type="text/javascript"></script>
  <script src="tpl/standard/js/standard.js" type="text/javascript"></script>
  <script src="tpl/standard/js/iSefrengo.js" type="text/javascript"></script>
  <link rel="shortcut icon" href="favicon.ico" />
  <script type="text/javascript">
  <!--
function delete_confirm() {
  if(confirm('{DELETE_MSG}')) return true;
  else return false;
}
  //-->
  </script>
</head>
<body onload="{ONLOAD_FUNCTION}return true;">
<!--<div id="sf_overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>-->
<div id="header">
<p id="version" class="lizenz">
<a href="http://www.sefrengo.org/" target="_blank">Sefrengo V {VERSION}</a> | <a href="license.html" target="_blank">Lizenz</a>
</p>
<!-- BEGIN CLIENT_LANG_SELECT -->
<div class="forms">
{CLIENT_FORM}
{LANG_FORM}
</div><!-- END CLIENT_LANG_SELECT -->
<p class="logout">{LOGGED_USER}
( <a href="{LOGOUT_URL}" target="_top">{LOGOUT_WIDTH}</a> )
</p>
<div id="menu-layer0" class="clearfix">
{MAIN_MENU_ENTRYS}
</div>
<!-- BEGIN SUBMENU -->
<div id="menu_layer{COUNT}" class="menu-akt">
<p>
{SUB_MENU_ENTRYS}
</p>
</div>
<!-- END SUBMENU -->
<script type="text/javascript">
  max_subs = {MAX_SUBMENUS};
  con_layer('{ACTIVE_SUBMENU_LAYER}');
</script>
</div>
<!-- Ende header.tpl -->
