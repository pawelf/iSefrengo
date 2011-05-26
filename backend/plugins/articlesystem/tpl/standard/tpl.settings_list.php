<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');
}

$_AS['tpl']['settings_body'] = '
  <table cellspacing="0" cellpadding="0" border="0" width="100%" id="settings">
    <tr>
      <td colspan="2">

        <form action="{formurl}#settings" id="settingsform" method="post" style="display:inline;">
        <input type="hidden" name="action" value="{action}" />
        <table class="uber" width="100%" id="settingslist">
          <tr>
            <th colspan="2" nowrap align="left">{lng_settings_general}</th>
          </tr>
          {body}
        </table>
        </form>
      </td>
    </tr>
  </table>
';
 


$_AS['tpl']['settings_section'] = '
					</table>        
				  <table class="uber" width="100%" id="settingslist" style="padding:0;margin:0;border-bottom:0 !important;">
          <tr>
            <th colspan="2" nowrap align="left" style="border-bottom:0 !important;border-top:0 !important;">{lng_settings_section}</th>
          </tr>
				 </table>
         <table class="uber" width="100%" id="settingslist" style="padding:0;margin:0;border-top:0 !important;border-bottom:0 !important;">
';

$_AS['tpl']['set_organizer'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td class="entry nowrap">{lng_set_organizer}</td>
    <td class="entry" align="right" nowrap" width="187">
        <select name="settings[set_organizer]" size="1">
            <option value="1" {selected_yes}>{lng_yes}</option>
            <option value="0" {selected_no}>{lng_no}</option>
        </select>
    </td>
</tr>
';


$_AS['tpl']['set_category'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td class="entry" nowrap>{lng_set_category}</td>
    <td class="entry" align="right" nowrap width="187">
        <select name="settings[set_category]" size="1">
            <option value="1" {selected_yes}>{lng_yes}</option>
            <option value="0" {selected_no}>{lng_no}</option>
        </select>
    </td>
</tr>
';


$_AS['tpl']['use_archive'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td class="entry" nowrap>{lng_use_archive}</td>
    <td class="entry" align="right" nowrap width="187">
        <select name="settings[use_archive]" size="1">
            <option value="1" {selected_yes}>{lng_yes}</option>
            <option value="0" {selected_no}>{lng_no}</option>
        </select>
    </td>
</tr>
';

$_AS['tpl']['set_category_multiple'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td class="entry" nowrap>{lng_set_category_multiple}</td>
    <td class="entry" align="right" nowrap width="187">
        <select name="settings[set_category_multiple]" size="1">
            <option value="1" {selected_yes}>{lng_yes}</option>
            <option value="0" {selected_no}>{lng_no}</option>
        </select>
    </td>
</tr>
';


$_AS['tpl']['number_of_month'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td class="entry" nowrap>{lng_number_of_month}</td>
    <td class="entry" align="right" nowrap width="187">{select_number}</td>
</tr>
';
$_AS['tpl']['number_of_entries'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td class="entry" nowrap>{lng_number_of_entries}</td>
    <td class="entry" align="right" nowrap width="187">{select_number}</td>
</tr>
';

$_AS['tpl']['language'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td class="entry" nowrap>{lng_language}</td>
    <td class="entry" align="right" nowrap width="187">{select_language}</td>
</tr>
';


$_AS['tpl']['skin'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td class="entry" nowrap>{lng_skin}</td>
    <td class="entry" align="right" nowrap width="187">{select_skin}</td>
</tr>
';

$_AS['tpl']['wysiwyg'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td class="entry" nowrap>{lng_wysiwyg}</td>
    <td class="entry" align="right" nowrap width="187">{select_wysiwyg}</td>
</tr>
';
$_AS['tpl']['new_articles_online'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td class="entry" nowrap>{lng_new_articles_online}</td>
    <td class="entry" align="right" nowrap width="187">{select_new_articles_online}</td>
</tr>
';
$_AS['tpl']['new_articles_lang_copy'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td class="entry" nowrap>{lng_new_articles_lang_copy}</td>
    <td class="entry" align="right" nowrap width="187">{select_new_articles_lang_copy}</td>
</tr>
';
$_AS['tpl']['del_all_lang_copies'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td class="entry" nowrap>{lng_del_all_lang_copies}</td>
    <td class="entry" align="right" nowrap width="187">{select_del_all_lang_copies}</td>
</tr>
';

$_AS['tpl']['buttons'] = '
<tr>
    <td colspan="2" align="right" id="buttons_settings">
			<input type="checkbox" id="settings_global" name="settings_global" value="true"/>&nbsp;<label for="settings_global">{foralllangs}</label>&nbsp;
			<input name="sf_safe" value="{save}" class="sf_buttonAction" onclick="CheckSettingsForm(document.getElementById(\'settingsform\'));" onmouseover="this.className=\'sf_buttonActionOver\'" onmouseout="this.className=\'sf_buttonAction\'" type="button">
    </td>
</tr>
';




$_AS['tpl']['picture_select_folders'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td class="entry" nowrap>{lng_picture_select_folders}
    												<input type="hidden" id="picture_select_folders" name="settings[article_picture_select_folders]" value="{picture_select_folders}"></td>
    <td class="entry" align="right" nowrap width="187">{select_picture_select_folders}</td>
</tr>
';	
$_AS['tpl']['picture_select_subfolders'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td class="entry" nowrap>{lng_picture_select_subfolders}</td>
    <td class="entry" align="right" nowrap width="187">{select_picture_select_subfolders}</td>
</tr>
';	

$_AS['tpl']['file_select_folders'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td class="entry" nowrap>{lng_file_select_folders}
    												<input type="hidden" id="file_select_folders" name="settings[article_file_select_folders]" value="{file_select_folders}"></td>
    <td class="entry" align="right" nowrap width="187">{select_file_select_folders}</td>
</tr>
';		

$_AS['tpl']['file_select_subfolders'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td class="entry" nowrap>{lng_file_select_subfolders}</td>
    <td class="entry" align="right" nowrap width="187">{select_file_select_subfolders}</td>
</tr>
';	

$_AS['tpl']['file_select_filetypes'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td class="entry" nowrap>{lng_file_select_filetypes}
    												<input type="hidden" id="file_select_filetypes" name="settings[article_file_select_filetypes]" value="{file_select_filetypes}"></td>
    <td class="entry" align="right" nowrap width="187">{select_file_select_filetypes}</td>
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
