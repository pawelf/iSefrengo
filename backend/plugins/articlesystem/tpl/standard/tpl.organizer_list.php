<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');
}

$_AS['tpl']['list_new'] = '
<div style="display:block;height:33px;overflow:hidden;width:100%">
<table style="margin-top:10px;width:100%">
	<tr>
    <td class="entry nowrap"><input type="button" value="{new_label}" class="sf_smallbuttonAction" onclick="document.location.href=\'{new_url}\';" onmouseover="this.className=\'sf_smallbuttonActionOver\'" onmouseout="this.className=\'sf_smallbuttonAction\'" style="margin:0;float:right;"></td>
	</tr>
</table>
</div>
';


$_AS['tpl']['list_body'] = '
        <table class="uber" id="articlelist">
          {body}
        </table>
';

$_AS['tpl']['list_header'] = '
<tr>
    <th width="60%">&nbsp;{lng_name}&nbsp;</th>
    <th width="40%" nowrap>&nbsp;{lng_email}&nbsp;</th>
    <th width="200" nowrap>&nbsp;{lng_phone}&nbsp;</th>
    <th width="80" nowrap>&nbsp;{lng_actions}&nbsp;</th>
</tr>
';

$_AS['tpl']['list_row'] = '
<tr id="id_{trid}" valign="top" onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td class="entry">{anchor}{name}&nbsp;</td>
    <td class="entry" nowrap>&nbsp;{email}&nbsp;</td>
    <td class="entry" nowrap>&nbsp;{phone}&nbsp;</td>
    <td class="entry" align="right" nowrap>&nbsp;{state}&nbsp;{edit}&nbsp;{delete}&nbsp;&nbsp;</td>
</tr>
';


$_AS['tpl']['nothing_found'] = '
<tr id="id_0" valign="top">
    <td class="entry" colspan="6">&nbsp;{msg}&nbsp;&nbsp;</td>
</tr>
';




?>
