<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');
}

$_AS['tpl']['settings_head'] = '
<div style="display:block;height:33px;overflow:hidden;width:100%">
<table style="margin-top:10px;width:100%">
	<tr>
    <td class="entry nowrap">
    	<input type="button" value="{lng_settings_general}" class="sf_smallbuttonAction" onclick="document.location.href=\'{url_show_settings}\';" onmouseover="this.className=\'sf_smallbuttonActionOver\'" onmouseout="this.className=\'sf_smallbuttonAction\'" style="float:right;">
    	<input type="button" value="{lng_article_settings_elements}" class="sf_smallbuttonAction" onclick="document.location.href=\'{url_show_article_settings}\';" onmouseover="this.className=\'sf_smallbuttonActionOver\'" onmouseout="this.className=\'sf_smallbuttonAction\'" style="float:right;margin-right:10px;">
    	<input type="button" value="{lng_settings_specialfunctions}" class="sf_smallbuttonAction" onclick="document.location.href=\'{url_show_settings_specialfunctions}\';" onmouseover="this.className=\'sf_smallbuttonActionOver\'" onmouseout="this.className=\'sf_smallbuttonAction\'" style="float:right;margin-right:10px;">
    </td>
	</tr>
</table>
</div>
';



?>
