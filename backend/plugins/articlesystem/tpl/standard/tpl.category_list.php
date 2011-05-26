<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');
}


$_AS['tpl']['category_body_intro'] = '<form action="{formurl}#category" id="categoryform" method="post" style="display:inline;">';
$_AS['tpl']['category_body_outro'] = '</form>';

$_AS['tpl']['category_body'] = '

  <table width="100%" id="category" style="margin-top:31px;">
    <tr>
      <td colspan="2">
        <input type="hidden" name="action" value="save_category" />
        <table class="uber" id="categorylist">
          <tr>
            <th colspan="2" nowrap align="left">{lng_category}</th>
          </tr>
          {body}
        </table>
      </td>
    </tr>
  </table>

';

$_AS['tpl']['list_row'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <!-- <td class="entry" width="30" nowrap valign="top">{number}.</td> -->
    <td class="entry" nowrap><table style="border:0px !imortant;" width="100%">{fieldtable}</table></td>
    <td class="entry" align="right" width="187" nowrap valign="top"> <label for="cat_{hash}">{lng_category_delete}</label>&nbsp;<input type="checkbox" name="category_delete[]" value="{hash}" id="cat_{hash}">
   </td>
</tr>
';

$_AS['tpl']['field_row'] = '
<tr>
    <td width="10%" style="border:0px;" nowrap class="entry" >{langname}:</td>
    <td style="border:0px"><input type="text" name="{name}" value="{value}" style="width:70%;vertical-align:top;">{usergroups}</td>
</tr>';


$_AS['tpl']['list_new'] = '
<tr onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
    <!-- <td class="entry" width="30" nowrap valign="top">{lng_new}</td> -->
    <td class="entry" nowrap><table cellpadding="1" cellspacing="2" border="0" width="100%">{fieldtable}</table></td>
    <td class="entry"  align="right" width="187" nowrap valign="top">&nbsp;</td>
</tr>
';

$_AS['tpl']['buttons'] = '
<tr>
    <td colspan="3" align="right" id="buttons_category">
			<input name="sf_safe" value="{lng_button_label}" class="sf_buttonAction" onclick="CheckCategoryForm(document.getElementById(\'categoryform\'));" onmouseover="this.className=\'sf_buttonActionOver\'" onmouseout="this.className=\'sf_buttonAction\'" type="button">
    </td>
</tr>
';



?>
