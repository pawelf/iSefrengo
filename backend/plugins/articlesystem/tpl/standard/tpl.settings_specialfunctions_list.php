<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');
}

$_AS['tpl']['settings_body'] = '
  <table cellspacing="0" cellpadding="0" border="0" width="100%" id="settings">
    <tr>
      <td colspan="2">

        <form action="{formurl}" id="settingsform" method="post" style="display:inline;">
        <input type="hidden" name="action" value="{action}" />
        <table class="uber" width="100%" id="settingslist">

          {body}
        </table>
        </form>
      </td>
    </tr>
  </table>
  <br/><br/>
';
 


$_AS['tpl']['settings_section'] = '
					</table>        
				  <table class="uber" width="100%" id="settingslist" style="padding:0;margin:0;border-bottom:0 !important;">
          <tr>
            <th colspan="2" nowrap align="left" style="border-bottom:0 !important;border-top:0 !important;font-size:12px;">{lng_settings_section}</th>
          </tr>
				 </table>
         <table class="uber" width="100%" id="settingslist" style="padding:0;margin:0;border-top:0 !important;border-bottom:0 !important;">
';


$_AS['tpl']['buttons'] = '
<tr>
    <td colspan="2" align="right" id="buttons_settings">
			<input type="checkbox" id="settings_global" name="settings_global" value="true"/>&nbsp;<label for="settings_global">{foralllangs}</label>&nbsp;
			<input name="sf_safe" value="{save}" class="sf_buttonAction" onclick="CheckSettingsForm(document.getElementById(\'settingsform\'));" onmouseover="this.className=\'sf_buttonActionOver\'" onmouseout="this.className=\'sf_buttonAction\'" type="button">
    </td>
</tr>
';




$_AS['tpl']['uni_select'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td  class="entry" nowrap>{lng_uni}</td>
    <td class="entry" align="right" nowrap >{select_uni}</td>
</tr>
';
$_AS['tpl']['uni_select_multiple'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td  class="entry" nowrap>{lng_uni_select_multiple}
    												<input type="hidden" id="{select_uni_multiple_nameid}" name="settings[{select_uni_multiple_nameid}]" value="{uni_select_multiple}"></td>
    <td class="entry" align="right" nowrap >{select_uni_select_multiple}</td>
</tr>
';	

$_AS['tpl']['uni_input'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td  class="entry" nowrap>{lng_uni}</td>
    <td class="entry" align="right" nowrap><input type="text" id="{uni_input_name}" name="settings[{uni_input_name}]" value="{uni_input_value}" style="text-align:right;font-family:verdana;width:182px;"></td>
</tr>
';
$_AS['tpl']['uni_input_long'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td  class="entry" nowrap>{lng_uni}</td>
    <td class="entry" align="right" nowrap><input type="text" id="{uni_input_name}" name="settings[{uni_input_name}]" value="{uni_input_value}" style="text-align:right;font-family:verdana;width:382px;"></td>
</tr>
';
$_AS['tpl']['uni_area'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td  class="entry" nowrap>{lng_uni}</td>
    <td class="entry" align="right" nowrap><textarea id="{uni_area_name}" name="settings[{uni_area_name}]" style="font-family:courier, mono;font-size:11px;height:110px;width:178px;">{uni_area_value}</textarea></td>
</tr>
';

$_AS['tpl']['uni_area_long'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td  class="entry" nowrap>{lng_uni}</td>
    <td class="entry" align="right" nowrap><textarea id="{uni_area_name}" name="settings[{uni_area_name}]" style="font-family:courier, mono;font-size:11px;height:110px;width:378px;">{uni_area_value}</textarea></td>
</tr>
';
$_AS['tpl']['uni_area_long2'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td  class="entry" nowrap>{lng_uni}</td>
    <td class="entry" align="right" nowrap><textarea id="{uni_area_name}" name="settings[{uni_area_name}]" style="font-family:courier, mono;font-size:11px;height:55px;width:378px;">{uni_area_value}</textarea></td>
</tr>
';

$_AS['tpl']['uni_input_pass'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td  class="entry" nowrap>{lng_uni}</td>
    <td class="entry" align="right" nowrap><input type="password" id="{uni_input_name}" name="settings[{uni_input_name}]" value="{uni_input_value}" style="text-align:right;font-family:verdana;width:182px;"></td>
</tr>
';

$_AS['tpl']['db_setting_curr'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td  class="entry" nowrap>{lng_uni}</td>
    <td class="entry" align="right" nowrap></td>
</tr>
';
$_AS['tpl']['db_setting_action'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td  class="entry" nowrap>{lng_uni}</td>
    <td class="entry" align="right" nowrap><input type="submit" id="{uni_input_name}" name="settings[{uni_input_name}]" value="{uni_input_value}" style="text-align:right;font-family:verdana;width:122px;"></td>
</tr>
';


?>
