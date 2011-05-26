<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');
}

$_AS['tpl']['list_new_number_filter'] = '
<div style="display:block;height:33px;overflow:hidden;width:100%">
<table style="margin-top:10px;width:100%">
	<tr>
		<td class="entry nowrap">{searchform_start}{search}<input class="sf_smallbuttonAction" type="submit" value="{lng_search}" onmouseover="this.className=\'sf_smallbuttonActionOver\'" onmouseout="this.className=\'sf_smallbuttonAction\'" style="margin-left:5px;"/>{searchform_end}</td>
		<td class="entry" width="60%" align="center"><span {range_hide_styleattr}><b>{lng_showrange}</b> {startrange}{endrange}</span></td>
		<td class="entry nowrap"><input type="button" value="{new_label}" class="sf_smallbuttonAction" onclick="document.location.href=\'{new_url}\';" onmouseover="this.className=\'sf_smallbuttonActionOver\'" onmouseout="this.className=\'sf_smallbuttonAction\'" style="float:right;{hide_new_button}" ></td>
	</tr>
</table>
</div>
';


$_AS['tpl']['list_range_prevnext'] = '
<table class="uber" style="margin-bottom:0;">
	<tr>
		<td colspan="{colspan}" class="entryuser">
			<p>{select_number}{select_category}</p>
		 	<p class="zahl" {range_hide_styleattr}><a href="{prev_url}" title="">&laquo;</a>&nbsp;<a href="{next_url}" title="">&raquo;</a></p>
		</td>
	</tr>
</table>
';

$_AS['tpl']['list_prevnext'] = '
<table class="uber" style="margin-top:0;border-top:0;">
	<tr>
		<td colspan="{colspan}" class="entryuser" style="padding-left:3px;">
			<table cellspacing="0" cellpadding="0" border="0" width="100%" style="border:0;padding:0;margin:0;">
			<tr>
				<td width="10%">
				 <a href="#" title="" onclick="revertselection(\'form_article_list\');bottombuttonsswitch(\'form_article_list\');return false;" title="{revert_selection}"><img src="tpl/{skin}/img/but_changeview.gif" style="margin-right:2px;"/></a>
				</td>
				<td align="center" width="80%">
					<p class="zahl" style="text-align:center">{page_nav}</p>
				</td>
				<td align="right" width="10%" id="bottombuttons">
				 <a	style="{hide_facebook_selected_button}" href="{export_url}&db={db}&action=facebookmulti&keepThis=true&TB_iframe=true&width=655&height=450" class="thickbox" title="{facebook_pub}"><img src="plugins/articlesystem/tpl/{skin}/img/but_facebook.png" class="disabled"></a><span style="{hide_facebook_selected_button}">&nbsp;&nbsp;</span><a style="{hide_twitter_selected_button}" href="{export_url}&db={db}&action=twittermulti&keepThis=true&TB_iframe=true&width=655&height=450" class="thickbox" title="{twitter_pub}"><img src="plugins/articlesystem/tpl/{skin}/img/but_twitter.png" class="disabled"></a><span style="{hide_twitter_selected_button}">&nbsp;&nbsp;</span>
				 <a href="#" title="" onclick="if (this.childNodes[0].className==\'disabled\') {return false;};if (confirmarchive()){archivedearchiveselected(\'form_article_list\');}" title="{archivedearchive_selected}"><img src="plugins/articlesystem/tpl/{skin}/img/{archive_selected_icon}" style="margin-right:4px;{hide_archive_selected_button}" class="disabled"/></a>
				 <a href="#" title="" onclick="if (this.childNodes[0].className==\'disabled\') {return false;};onofflineselected(\'form_article_list\');" title="{onoffline_selected}" {show_onoffline_styleattr}><img src="tpl/{skin}/img/but_onoffline.gif" style="margin-right:4px;" class="disabled"/></a>
				 <a href="#" title="" onclick="if (this.childNodes[0].className==\'disabled\') {return false;};if (confirmdelete()){deleteselected(\'form_article_list\');}" title="{delete_selected}"><img src="tpl/{skin}/img/but_delete.gif" style="margin-right:4px;" class="disabled"/></a>
				</td>
			</tr>
			</table>
		</td>
	</tr>
</table>
';


$_AS['tpl']['list_body'] = '
				<script type="text/javascript"> 	
				<!--			
				$(document).ready(
					function(){
					// thickbox init
					tb_init(\'a.thickbox\');//pass where to apply thickbox
				});
				
				function confirmdelete(){
					check1 = confirm("{question_delete}");
					if (check1 == false)
						return false;
					else
						return true;
				}
				
				function confirmreset(){
					check1 = confirm("{question_reset}");
					if (check1 == false)
						return false;
					else
						return true;
				}		
				function confirmarchive(){
					check1 = confirm("{question_archive}");
					if (check1 == false)
						return false;
					else
						return true;
				}	
				function revertselection(form) {
					var chkbxs=document.getElementsByName("article_sel[]");
					end = document.forms[form].length;
					for (i=0; i < end; i++ ) {
						if (chkbxs[i].checked) {
								chkbxs[i].checked = false
						} else {
								chkbxs[i].checked = true;
						}
					}
				}				
				
				function bottombuttonsswitch(form) {
					var chkbxs=document.getElementsByName("article_sel[]");
					var somechecked=false;
					
					for (i=0; i < chkbxs.length; i++ ) {
						if (chkbxs[i].checked)
							 var somechecked=true;
					}
					var bottomicons = document.getElementById("bottombuttons").getElementsByTagName("IMG");
					for (i=0; i < bottomicons.length; i++ )
						if (somechecked==true && bottomicons[i].className!="enabled") {
								bottomicons[i].className="enabled";
						}
					for (i=0; i < bottomicons.length; i++ )
						if (somechecked==false && bottomicons[i].className!="disabled")
								bottomicons[i].className="disabled";
				}				
				
				
				function deleteselected(form) {
					document.forms[form].action = document.forms[form].action+"&action=delete_article";
					document.forms[form].submit();
				}	
				function onofflineselected(form) {
					document.forms[form].action = document.forms[form].action+"&action=onlineoffline_article";
					document.forms[form].submit();
				}	
				function archivedearchiveselected(form) {
					document.forms[form].action = document.forms[form].action+"&action=archivedearchive_article";
					document.forms[form].submit();
				}	
				//-->
				</script>	 	
				{list_range_prevnext}
				<table class="uber" id="articlelist"	style="margin-bottom:0;margin-top:0;border-top:0;">
					<form name="form_article_list" id="form_article_list" method="post" action="{formurl}" style="margin:0;padding:0;display:inline;">
					{body}
					</form>

				</table>					
				{list_prevnext}
				<script type="text/javascript"> 	
				<!--			
				bottombuttonsswitch(\'form_article_list\');
				//-->
				</script>	 	
';

$_AS['tpl']['list_header'] = '
<tr class="notxtdeco">
		<th align="center">&nbsp;</th>
		<th width="80" align="left" nowrap {show_datetime_hide_styleattr}>{lng_start}&nbsp;</th>
		<th width="80" align="left" nowrap {show_datetime_hide_styleattr}>{lng_end}&nbsp;</th>
		{list_header_fieldssub}
		{lng_category}
		<th width="80" align="left" nowrap>{lng_created}&nbsp;</th>
<!--<th width="55" align="left" nowrap>{lng_current}&nbsp;</th>-->
		<th width="80" nowrap>{lng_actions}&nbsp;</th>
</tr>
';

$_AS['tpl']['list_row'] = '
<tr id="id_{trid}_{online}_{turnus_type}" valign="top" onMouseOver="this.style[\'background\']=\'#FFF7CE\';" onMouseOut="this.style[\'background\']=\'#ffffff\';" bgcolor="#ffffff">
		<td class="entry" valign="center" align="center"><input type="checkbox" name="article_sel[]" value="{idarticle}" style="margin-top:3px;width:12px;height:12px;" onclick="bottombuttonsswitch(\'form_article_list\');"/>{anchor}</td>
		<td class="entry" nowrap style="padding-top:4px;{show_datetime_hide_css}" >{startdate}&nbsp;&nbsp;{starttime}&nbsp;</td>
		<td class="entry" nowrap style="padding-top:4px;{show_datetime_hide_css}" >{enddate}&nbsp;&nbsp;{endtime}&nbsp;</td>
	 	{list_row_fieldssub}
	 	{category}
	 	<td class="entry" nowrap style="padding-top:4px;">{created}&nbsp;</td>
<!--<td class="entry" align="center" nowrap style="padding-top:4px;">{current}&nbsp;</td>-->
		<td class="entry" align="right" nowrap>{facebook}{twitter}&nbsp;{edit}&nbsp;&nbsp;{dupl}&nbsp;&nbsp;{archived}&nbsp;&nbsp;{state}&nbsp;&nbsp;{delete}&nbsp;</td>
</tr>
';

$_AS['tpl']['list_row_fieldssub'] = '
		<td class="entry"	 {colwidth} style="padding-right:4px;white-space:normal">{value}</td>
';

$_AS['tpl']['list_header_fieldssub'] = '
		<th align="left">{lng_value}&nbsp;</th>

';


$_AS['tpl']['nothing_found'] = '
<tr id="id_0_0_0" valign="top" style="background-color:white;">
		<td class="entry" colspan="{colspan}" height="23" style="padding-top:4px;">&nbsp;{msg}&nbsp;&nbsp;</td>
</tr>
';




?>
