<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');
}


$_AS['tpl']['article_settings_body'] = '

  <table cellspacing="0" cellpadding="0" border="0" width="100%" id="articlesettings">
    <tr>
      <td colspan="3">
        <form action="{formurl}#articlesettings" id="articlesettingsform" method="post" style="display:inline;">
        <input type="hidden" name="action" value="save_article_settings" />
        <table class="uber" width="100%" id="settingslist" style="margin-bottom:0">
          <tr>
            <th colspan="2" nowrap align="left">{lng_article_settings_elements}</th>
            <th nowrap align="left">&nbsp;</th>
            <th nowrap align="left">{lng_article_settings_elements_active}</th>
            <th nowrap align="left">{lng_article_settings_elements_validation}</th>
            <th nowrap align="left"></th>
          </tr>
          {body}
        </table>
        <table class="uber" width="100%" id="elementsgeneral" style="margin-top:0">
          <tr>
            <th colspan="2" nowrap align="left">{lng_article_settings_general}</th>
          </tr>
          {body_general}
        </table>

        </form>
      </td>
    </tr>
  </table>
';

$_AS['tpl']['article_element_settings_body'] = '

  <table cellspacing="0" cellpadding="0" border="0" width="100%" id="articlesettings">
    <tr>
      <td colspan="3">
        <form action="{formurl}#articlesettings" id="articlesettingsform" method="post" style="display:inline;">
        <input type="hidden" name="action" value="save_article_element_settings" />
        <input type="hidden" name="element" value="{element}" />
        <input type="hidden" name="back" value="0" id="back">
        <table class="uber" width="100%" id="settingslist">
          <tr>
            <th colspan="6" nowrap align="left">{lng_article_settings_general}</th>
          </tr>
          {body}
        </table>
        </form>
      </td>
    </tr>
  </table>
';



$_AS['tpl']['buttons'] = '
<tr>
    <td colspan="2" align="right" id="buttons_settings" style="visibility:hidden">
			<input type="checkbox" id="settings_global" name="settings_global" value="true"/>&nbsp;<label for="settings_global">{foralllangs}</label>&nbsp;
			<input name="sf_safe" value="{save2}" class="sf_buttonAction" onclick="CheckSettingsForm(document.getElementById(\'settingsform\'));" onmouseover="this.className=\'sf_buttonActionOver\'" onmouseout="this.className=\'sf_buttonAction\'" type="button">
			<input name="sf_cancel" value="{cancel}" class="sf_buttonAction" onclick="window.location=\'{back}\'" onmouseover="this.className=\'sf_buttonActionCancelOver\'" onmouseout="this.className=\'sf_buttonAction\'" type="button">
    </td>
</tr>
';


$_AS['tpl']['on_off_switches'] = '
	<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#fff\';" bgcolor="#fff" style="background:#fff">
	  <td class="entry" nowrap width="20"><input type="text" id="{element_sortindex}" name="settings[{element_sortindex}]" value="{sortindex}" style="font-size:1em;width:25px;text-align:right;"></td>
    <td class="entry">{lng_descr}</td>
    <td class="entry" nowrap align="right">&nbsp;</td>
    <td class="entry" nowrap width="187" align="right" >{select_element}</td>
    <td class="entry" nowrap" align="right"><small>{select_element_validation}</small></td>
	  <td class="entry" nowrap width="20" align="right"><a href="{url_settings}"><img src="tpl/{skin}/img/but_config.gif" alt="" title="" width="16" height="16"></a> </td>
</tr>
';

$_AS['tpl']['on_off_switches_elementsettings'] = '
	<tr bgcolor="#e8e8e8" style="background:#e8e8e8">
	    <td class="entry" nowrap width="20"><input type="text" id="{element_sortindex}" name="settings[{element_sortindex}]" value="{sortindex}" style="font-size:1em;width:25px;text-align:right;"></td>
	    <td class="entry" colspan="4">{lng_descr}</td>
	    <td class="entry" style="text-align:right;">{select_element}</td>
	</tr>

	<tr >
	    <td style="border-bottom:1px solid #e8e8e8;background:#e8e8e8;" class="entry" nowrap width="20"></td>
	    <td class="uber" colspan="4" nowrap>{lng_article_settings_general_options}</td>
      <th  class="uber" align="left">{lng_article_settings_general_validation}</th>
	</tr>
	<tr>
	    <td style="background:#e8e8e8;border-bottom:1px solid #e8e8e8;" class="entry" nowrap width="20"></td>
	    <td class="entry" colspan="2" style="border-bottom:1px solid #fff;border-right:1px solid #fff;""><small>{lng_element_label}&nbsp;<input type="text" id="{element}_label" name="settings[{element}_label]" value="{element_label}" style="font-size:1em;width:200px;"></td>
	    <td class="entry" nowrap width="200" style="text-align:right;border-bottom:1px solid #fff;">&nbsp;</td>
	    <td class="entry" rowspan="2" width="200" style="text-align:right;">{add_option2}<br>{add_option1}</td>
	    <td class="entry" nowrap width="20" align="right" style="border-bottom:1px solid #fff;">{select_element_validation}</td>
	</tr>
	<tr>
	    <td  style="background:#e8e8e8;" class="entry" nowrap width="20"></td>
	    <td class="entry" colspan="3">	    
	    <small style="white-space:wrap;display:block;width:400px;margin-top:-10px;padding-bottom:5px;">
			{picture_select_folders_select}    	
			{picture_select_subfolders}    	
			{file_select_folders_select}    	
			{file_select_subfolders}    	
			{file_select_filetypes_select}    	
			{file_upload_folders}    	
			{link_show_title_input}    	
			{link_select_idcats}    	
			{link_select_subcats}    	
			{link_select_startpages}    	
			{link_select_showpages}    	
			{link_select_choosecats} 
    	</small></td>
	    <td class="entry" nowrap width="20" align="right"></td>
	</tr>
';


for ($i=1;$i<36;$i++)
	$_AS['tpl']['custom'.$i.'_label'] = '
	<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#fff\';" bgcolor="#fff" style="background:#fff">
	    <td class="entry" nowrap width="20"><input type="text" id="custom'.$i.'_sortindex" name="settings[article_custom'.$i.'_sortindex]" value="{custom'.$i.'_sortindex}" style="font-size:1em;width:25px;text-align:right;"></td>
	    <td class="entry">{lng_custom'.$i.'_label}</td>
	    <td class="entry" nowrap width="200"><small>{lng_custom_type} <strong>{custom'.$i.'_select_type}</strong></small></td>
	    <td class="entry" nowrap style="text-align:right;">{lng_custom'.$i.'_active}</td>
	    <td class="entry" nowrap align="right"><small>{custom'.$i.'_validation}</small></td>
	    <td class="entry" nowrap width="20" align="right"><a href="{url_custom'.$i.'_settings}"><img src="tpl/{skin}/img/but_config.gif" alt="" title="" width="16" height="16"></a> </td>
	</tr>
	';
	
for ($i=1;$i<36;$i++)
	$_AS['tpl']['custom'.$i.'_elementsettings'] = '
	<tr bgcolor="#e8e8e8" style="background:#e8e8e8">
	    <td class="entry" nowrap width="20"><input type="text" id="custom'.$i.'_sortindex" name="settings[article_custom'.$i.'_sortindex]" value="{custom'.$i.'_sortindex}" style="font-size:1em;width:25px;text-align:right;"></td>
	    <td class="entry" colspan="5">{lng_custom'.$i.'_label}</td>
	</tr>

	<tr >
	    <td style="border-bottom:1px solid #e8e8e8;background:#e8e8e8;" class="entry" nowrap width="20"></td>
	    <td class="uber" colspan="4" nowrap>{lng_article_settings_general_options}</td>
      <th  class="uber" align="left">{lng_article_settings_general_validation}</th>
	</tr>
	<tr>
	    <td style="background:#e8e8e8;border-bottom:1px solid #e8e8e8;" class="entry" nowrap width="20"></td>
	    <td class="entry" colspan="2" style="border-bottom:1px solid #fff;border-right:1px solid #fff;""><small>{lng_custom_label}</small>&nbsp;<input type="text" id="custom'.$i.'_label" name="settings[article_custom'.$i.'_label]" value="{custom'.$i.'_label}" style="font-size:1em;width:200px;"></td>
	    <td class="entry" nowrap width="200" style="text-align:right;border-bottom:1px solid #fff;"><small>{lng_custom_alias}</small>&nbsp;<input type="text" id="custom'.$i.'_label" name="settings[article_custom'.$i.'_alias]" value="{custom'.$i.'_alias}" style="font-size:1em;width:110px;"></td>
	    <td class="entry" nowrap width="200" style="text-align:right;border-bottom:1px solid #fff;"><small>{lng_custom_type}</small>&nbsp;{custom'.$i.'_select_type}</td>
	    <td class="entry" nowrap width="20" align="right" style="border-bottom:1px solid #fff;">{custom'.$i.'_validation}</td>
	</tr>
	<tr>
	    <td  style="background:#e8e8e8;" class="entry" nowrap width="20"></td>
	    <td class="entry" colspan="3">	    
	    <small style="white-space:wrap;display:block;width:400px;margin-top:-10px;padding-bottom:5px;">
			{custom'.$i.'_picture_select_folders_select}    	
			{custom'.$i.'_picture_select_subfolders}    	
			{custom'.$i.'_picture_upload_folders_select}    	
			{custom'.$i.'_file_select_folders_select}    	
			{custom'.$i.'_file_select_subfolders}    	
			{custom'.$i.'_file_select_filetypes_select} 
			{custom'.$i.'_file_upload_folders_select}    	
			{custom'.$i.'_link_show_title_input}    	
			{custom'.$i.'_link_select_idcats}    	
			{custom'.$i.'_link_select_subcats}    	
			{custom'.$i.'_link_select_startpages}    	
			{custom'.$i.'_link_select_showpages}    	
			{custom'.$i.'_link_select_choosecats}    	
    	</small></td>
	    <td class="entry" nowrap width="200" style="text-align:right;">{custom'.$i.'_add_option1}</td>
	    <td class="entry" nowrap width="20" align="right"></td>
	</tr>
	<tr id="custom'.$i.'_edit_validation_row0"  style="{custom'.$i.'_edit_validation_show_values_row};" >
	    <td style="border-bottom:1px solid #e8e8e8;background:#e8e8e8;" class="entry" nowrap width="20"></td>
	    <td class="uber" colspan="5" nowrap>{lng_custom_valid_settings}</td>
	</tr>

	<tr id="custom'.$i.'_edit_validation_row1"  style="{custom'.$i.'_edit_validation_show_values_row};" bgcolor="#ffffff">
	    <td  style="border-bottom:1px solid #e8e8e8;background:#e8e8e8;" class="entry" nowrap width="20"></td>
	    <td class="entry" colspan="3" nowrap align="right"><span style="float:left;">{lng_custom_valid_errmsg} </span><textarea  wrap="off" id="custom'.$i.'_validation_rule_text" name="settings[article_custom'.$i.'_validation_rule_text]" style="font-size:1em;width:450px;height:62px;margin-top:3px;">{custom'.$i.'_validation_rule_text}</textarea></td>
	    <td class="entry" colspan="2" nowrap align="right"><span style="float:left;">{lng_custom_valid_regexp} </span><textarea  wrap="off" id="custom'.$i.'_validation_rule_regexp" name="settings[article_custom'.$i.'_validation_rule_regexp]" style="font-size:1em;width:210px;height:61px;margin-top:3px;">{custom'.$i.'_validation_rule_regexp}</textarea></td>
	</tr>
	
	<tr id="custom'.$i.'_select_values_row1"  style="{custom'.$i.'_select_type_show_values_row};" >
	    <td style="border-bottom:1px solid #e8e8e8;background:#e8e8e8;" class="entry" nowrap width="20"></td>
	    <td class="uber" colspan="5" nowrap>{lng_default_values}</td>
	</tr>
	<tr id="custom'.$i.'_select_values_row2"  style="{custom'.$i.'_select_type_show_values_row};" bgcolor="#ffffff">
	    <td style="background:#e8e8e8;" class="entry" nowrap width="20"></td>
	    <td class="entry" colspan="2" nowrap>{lng_custom_values}<br/><br/><small>{lng_custom'.$i.'_vmode_select}<small>&nbsp;{custom'.$i.'_vmode_select1}</td>
	    <td class="entry" colspan="3" nowrap><textarea id="custom'.$i.'_select_values" name="settings[article_custom'.$i.'_select_values]" style="font-size:1em;width:510px;height:122px;margin-top:3px;">{custom'.$i.'_select_values}</textarea><br/>
	    <small>{lng_custom_value_default_select}</small><br/>
	    <textarea id="custom'.$i.'_select_values" name="settings[article_custom'.$i.'_value_default_select]" style="font-size:1em;width:510px;height:61px;margin-top:3px;">{custom'.$i.'_value_default_select}</textarea></td>
	</tr>
	<tr id="custom'.$i.'_value_row1"  style="{custom'.$i.'_select_type_show_value_row};" >
	    <td style="border-bottom:1px solid #e8e8e8;background:#e8e8e8;" class="entry" nowrap width="20"></td>
	    <td class="uber" colspan="5" nowrap>{lng_default_values}</td>	
	</tr>
	<tr id="custom'.$i.'_value_row2"  style="{custom'.$i.'_select_type_show_value_row};" bgcolor="#ffffff">
	    <td style="background:#e8e8e8;" class="entry" nowrap width="20"></td>
	    <td class="entry" colspan="2" nowrap>{lng_custom_value}<br/><br/><small>{lng_custom'.$i.'_vmode_select}<small>&nbsp;{custom'.$i.'_vmode_select2}</td>
	    <td class="entry" colspan="3" nowrap><textarea id="custom'.$i.'_values" name="settings[article_custom'.$i.'_value]" style="font-size:1em;width:510px;height:122px;margin-top:3px;">{custom'.$i.'_value}</textarea></td>
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
$_AS['tpl']['buttons_articlesettings'] = '
<tr>
    <td colspan="7" align="right" id="buttons_articlesettings">
			<input type="checkbox" id="settings_global" name="settings_global" value="true"/>&nbsp;<label for="settings_global">{foralllangs}</label>&nbsp;
			<input name="sf_safe" value="{lng_save}" class="sf_buttonAction" onclick="CheckSettingsForm(document.getElementById(\'articlesettingsform\'));" onmouseover="this.className=\'sf_buttonActionOver\'" onmouseout="this.className=\'sf_buttonAction\'" type="button">
    </td>
</tr>
';

$_AS['tpl']['buttons_articleelementsettings'] = '
<tr>
    <td colspan="7" align="right" id="buttons_articlesettings">
			<div style="float:right;vertical-align:top;"><input type="checkbox" id="settings_global" name="settings_global" value="true"/>&nbsp;<label for="settings_global">{foralllangs}</label>&nbsp;
			<input name="sf_safe" value="{lng_saveback2}" id="btn_save_back" class="sf_buttonAction" onclick="document.getElementById(\'back\').value = 1;CheckSettingsForm(document.getElementById(\'articlesettingsform\'));" onmouseover="this.className=\'sf_buttonActionOver\'" onmouseout="this.className=\'sf_buttonAction\'" type="button">
			<input name="sf_safe" value="{lng_save}" class="sf_buttonAction" onclick="CheckSettingsForm(document.getElementById(\'articlesettingsform\'));" onmouseover="this.className=\'sf_buttonActionOver\'" onmouseout="this.className=\'sf_buttonAction\'" type="button">
			<input name="sf_cancel" value="{lng_back}" class="sf_buttonAction" onclick="window.location=\'{back}\'" onmouseover="this.className=\'sf_buttonActionCancelOver\'" onmouseout="this.className=\'sf_buttonAction\'" type="button">
    	</div>
    </td>
</tr>
';

$_AS['tpl']['uni_input'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <td  class="entry" nowrap>{lng_uni}</td>
    <td class="entry" align="right" nowrap><input type="text" id="{uni_input_name}" name="settings[{uni_input_name}]" value="{uni_input_value}" style="text-align:right;font-family:verdana;width:182px;"></td>
</tr>
';
?>
