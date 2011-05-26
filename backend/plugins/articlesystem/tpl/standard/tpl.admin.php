<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');
}
$_AS['tpl']['be_navi'] = '
<style type="text/css">
.grey {color:grey}
#main .tab {
	color:#144282;
	font-size:11px !important;
	text-decoration:none;
	margin:0;padding:2px 5px 2px 5px;
	border-top:1px solid white;
	border-left:1px solid white;
	border-right:1px solid white;
}
#main .tab:hover {
	color:#144282;
	font-size:11px !important;
	text-decoration:none;
	margin:0;padding:2px 5px 2px 5px;
	border-top:1px solid white;
	border-left:1px solid white;
	border-right:1px solid white;
}
#main{
padding:0 10px 0 10px;
}

*html #main{
padding:0 0 0 0;
}
*+html #main{
padding:0 0 0 0;
}

.entryuser table td{
	border:none;
	margin:0;
	padding:0;
	font-size:10px;
}

td.entryuser select {
	font:10px verdana,helvetica,arial,geneva,sans-serif;
	border:none;
	float:left;
	margin:2px 5px 2px 0;
	border:1px solid #D6D6D6;
}
.thinbuttons{
	margin:0;;
	margin-bottom:1px;
	padding-top:0;
	background-position: 0 -32px ;padding-bottom:0;
	margin-left:10px;
}

td.head{
padding-top:5px !important;
font-size:11px !important;

}
td.head td {
font-size:11px !important;
white-space:nowrap;
}

/* die Buttons unten */
input.sf_smallbuttonAction,
.fileblockactive #rightsmenucoat input.sf_buttonAction{
	background:url(tpl/{sf_skin}/img/bg_button.gif) #F4F7FB repeat-x;
	background-position: 0 -32px ;
	border:1px solid #8E8E8E;
	color:#000000;
	cursor:pointer;
	font:bold 10px verdana,helvetica,arial,geneva,sans-serif;
	margin:0;
	margin-bottom:1px;
	padding:0 10px 0 10px;
	width:auto;
}

.search_input{
	height:12px !important;
	padding:0 !important;
}

*html .search_input{
	height:17px !important;
	padding:0 !important;
	margin-bottom:3px;
}

*+html .search_input{
	height:13px !important;
	margin-bottom:1px;
}

input.sf_smallbuttonActionOver,
.fileblockactive #rightsmenucoat input.sf_buttonActionCancelOver{
	background:url(tpl/{sf_skin}/img/bg_button.gif) #F4F7FB repeat-x;
	border:1px solid #99CC01;
	background-position: 0 -2px ;
	color:#000000;
	cursor:pointer;
	font:bold 10px verdana,helvetica,arial,geneva,sans-serif;
	margin:0;
	margin-bottom:1px;
	
	padding:0 10px 0 10px;
	width:auto;
}
*html input.sf_smallbuttonAction {
	margin-bottom:3px;

}
*html input.sf_smallbuttonActionOver {
	margin-bottom:3px;
}
*html td.entryuser select {
	margin:2px 5px 2px 0;
}


*+html td.entryuser select {
	margin:1px 5px -2px 0 !important;
}


td.entryuser p.zahl{
	display:block !important;
	float:none !important;
	text-align:right;
	margin:4px 0;

}
*html td.entryuser p.zahl{
	margin-top:1px !important;
	margin-bottom:1px !important;
}
*+html td.entryuser p.zahl{
	margin-top:4px !important;
	margin-bottom:3px !important;
}
*+html td.entryuser{
	padding-bottom:2px;
}
td.entryuser img{
	margin-top:2px;
}
.uber{
	background:#fff;
	font:bold 12px verdana,helvetica,arial,geneva,sans-serif;
	vertical-align:middle;
}
.uber{
	border:1px solid #D6D6D6;
	font-size:10px;
	padding:2px 5px;
	text-align:left;
	white-space:nowrap;
}

.uber{
	border:1px solid #D6D6D6;
	padding:2px 5px;
	vertical-align:top;
}

</style>

<script type="text/javascript"> 	
	<!--      

  function disableEnterKey(e)
  {
       var key;

       if(window.event)
            key = window.event.keyCode;     //IE
       else
            key = e.which;     //firefox

       if(key == 13)
            return false;
       else
            return true;
  }

	//-->
</script>  	

<div id="main" style="">
  <h5>{lng_settings_admin}</h5>
';



$_AS['tpl']['settings_body'] = '
        <form action="{formurl}#dbsettings" id="adminform" name="adminform" method="post" style="display:inline;">

  <table cellspacing="0" cellpadding="0" border="0" width="100%" id="settings">
    <tr>
      <td colspan="2">

			<input name="settings[db_new]" value="{save}" class="sf_smallbuttonAction" type="button" onClick="document.getElementById(\'action\').value=\'new\';adminform.submit();" style="width:200px;float:right;" onmouseover="this.className=\'sf_smallbuttonActionOver\'" onmouseout="this.className=\'sf_smallbuttonAction\'" >
        <input type="hidden" name="action" value="save_db_settings" />
        <input type="hidden" id="db" name="settings[db]" value="" />
        <input type="hidden" id="action" name="settings[action]" value="" />
        <table class="uber" width="100%" id="settingslist">
          <tr>
            <th colspan="2" nowrap align="left">{lng_admin_asdb}</th>
          </tr>
          {body}
        </table>
        
      </td>
    </tr>
  </table>
   </form>
  
  <span style="font-size:11px;"><br/>{lng_settings_admin_notice}</span>
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



$_AS['tpl']['db_setting_curr'] = '
<tr>
    <td colspan="2" class="entry" nowrap>{lng_uni}</td>
</tr>
';
$_AS['tpl']['db_setting_action'] = '
<tr>
  <td  class="entry" nowrap style="border-right:0;border-bottom:0;">{lng_uni}</td>
	{showhide}
	    <td class="entry" align="right" nowrap style="border-left:0;border-bottom:0;">
	      <small>{lng_new_backend_title}&nbsp;</small>
	      <input name="settings[db_new_backend_title]" value="" type="text" style="width:195px" onKeyPress="return disableEnterKey(event)">
				<input value="{uni3_input_value}" class="sf_smallbuttonAction" type="button" onclick="document.getElementById(\'action\').value=\'install\';document.getElementById(\'db\').value=\'{db}\';adminform.submit();" style="text-align:right;width:200px"  onmouseover="this.className=\'sf_smallbuttonActionOver\'" onmouseout="this.className=\'sf_smallbuttonAction\'">
	    </td>
	</tr>
	<tr>
  <td  class="entry" nowrap style="border-right:0;border-top:0;"></td>
	{/showhide}
  <td class="entry" align="right" nowrap style="border-left:0;border-top:0;">
  	<input type="button" class="sf_smallbuttonAction" onclick="if (confirm(\'{delete2_txt1}\')) { if (confirm(\'{delete_txt2}\')) {document.getElementById(\'db\').value=\'{db}\';document.getElementById(\'action\').value=\'delete\';adminform.submit();} else return false;} else return false;" value="{uni2_input_value}" style="text-align:right;font-family:verdana;width:200px;" onmouseover="this.className=\'sf_smallbuttonActionOver\'" onmouseout="this.className=\'sf_smallbuttonAction\'">
		{hideshow}
		<input type="button" class="sf_smallbuttonAction" onclick="if (confirm(\'{delete_txt1}\')) { if (confirm(\'{delete_txt2}\')) {document.getElementById(\'db\').value=\'{db}\';document.getElementById(\'action\').value=\'uninstall\';adminform.submit();} else return false; }  else return false;" value="{uni1_input_value}" style="text-align:right;font-family:verdana;width:200px" onmouseover="this.className=\'sf_smallbuttonActionOver\'" onmouseout="this.className=\'sf_smallbuttonAction\'">
		{/hideshow}
	</td>
</tr>
';


?>
