<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');
}

$_AS['tpl']['back'] = '
<table style="margin-bottom:5px;margin-top:5px;display:none;">
	<tr>
    <td class="entry nowrap"><input type="button" value="{back_label}" class="sf_buttonAction tmbtnnew" onclick="document.location.href=\'{back_url}\';" onmouseover="this.className=\'sf_buttonActionOver\'" onmouseout="this.className=\'sf_buttonAction\'"  style="width:auto;margin:0;float:right;"></td>
    </tr>
  </table>
';


$_AS['tpl']['body'] = '
	<script type="text/javascript" src="'.$cfg_cms['cms_html_path'].'plugins/articlesystem/js/date.js"></script>
	<script type="text/javascript" src="'.$cfg_cms['cms_html_path'].'plugins/articlesystem/js/jquery.datePicker.js"></script>
	<script type="text/javascript" src="'.$cfg_cms['cms_html_path'].'plugins/articlesystem/js/date_de.js"></script>

	<script type="text/javascript"> 	
  	<!--      
  	var tiny_active=0;	
		var htmlpath="{htmlpath}";  	
		var uplhtmlpath="{uplhtmlpath}";
		var thumbext="{thumbext}";
		var js_get_title1="{js_get_title1}";
		var js_get_title_no_title_input = false;
		var js_get_title2="{js_get_title2}";
		var rbidelement="";
		var customfield="";
		var tb_pathToImage = "'.$cfg_cms['cms_html_path'].'plugins/articlesystem/tpl/standard/img/loadingAnimation.gif";

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
		//-->
	</script>  	
		<style type="text/css"> 	
  	<!--      
		.head{width:145px !important;}
		#main textarea{font-family:arial,helvetica,sans;font-size:11px;}
		//-->
	</style>  	
	{additional_body_scripts}
  <table width="100%">
    <tr>
      <td>
        <form action="{formurl}" id="articleform" method="post" style="display:inline;" enctype="multipart/form-data">
				<input type="hidden" name="article[archived]" value="{archived}">
        <input type="hidden" name="action" value="save_article">
        <input type="hidden" name="idarticle" value="{idarticle}">
        <input type="hidden" name="idarticlemem" value="{idarticlemem}">
        <input type="hidden" name="onlinemem" value="{onlinemem}">
        <input type="hidden" name="hash" value="{hash}">
        <input type="hidden" name="apply" value="0" id="apply">
        <input type="hidden" name="arteldel" value="0" id="arteldel">
        <input type="hidden" name="addelement" value="" id="addelement">
        <input type="hidden" name="valid" value="{valid}">
        <table class="config" cellspacing="1" id="articleedit">
          <tr>
            <td class="headre" align="left">{action}</td>
            <td class="headre" colspan="2" align="right">{langcopyselect}</td>
          </tr>
          {body}
        </table>
        </form>
      </td>
    </tr>
  </table>
  
';

$_AS['tpl']['tinyscripts'] = '
		<script type="text/javascript" src="'.$cfg_cms['cms_html_path'].'plugins/articlesystem/tinymce/tiny_mce_gzip.js"></script>
		<script type="text/javascript"> 	
		<!--		
			tinyMCE_GZ.init({
				themes : "advanced",
				languages: "{language}",
				plugins : "safari,fullscreen,searchreplace,advlink,advlist,advimage,paste,inlinepopups,contextmenu",
				disk_cache : false,
				debug : false			
			});
		//-->
		</script>
	<script type="text/javascript"> 
  	<!--   

  	var SFrbTypeCall="";           
	 	function SFrb() {
			// Internal fields
			this.settings = new Array();
			this.intinyMCE = false;
			this.callerWindow = null;
		};
		SFrb.prototype.SFrbCallBack = function(field_name, url, type, win) {
			// Save away
			this.field = field_name;
			this.callerWindow = win;
			this.intinyMCE = true;
			SFrbTypeCall=type;
			if (type=="file" || type=="media")
				new_window("{sf_rb_file_url}", "rb", "", screen.width * 0.6, screen.height * 0.6, "true")
			else
				new_window("{sf_rb_image_url}", "rb", "", screen.width * 0.6, screen.height * 0.6, "true")
		}; 
		// Global instance
		var SF = new SFrb();   	

		var tiny_active=1;	

           
		tinyMCE.init({
			document_base_url:"{tinymce_docbaseurl}",
			mode : "textareas",
			editor_selector : "mceEditor",
			elements : "text",
			theme : "advanced",
			height : "200",
			width : "793",
			language : "{language}",
			plugins : "safari,searchreplace,advlink,advlist,advlink,advimage,paste,inlinepopups,contextmenu", 
			theme_advanced_buttons1 :"search,replace,separator,undo,redo,separator,cut,copy,pastetext,pasteword,separator,bold,italic,underline,strikethrough,sub,sup,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,bullist,numlist,liststyle,indent,outdent,separator,charmap,separator,image,separator,anchor,link,unlink,separator,removeformat,cleanup,separator,code",
			theme_advanced_buttons2 :"",
			theme_advanced_buttons3 :"",
			file_browser_callback : "SF.SFrbCallBack",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resize_horizontal : false,
			theme_advanced_resizing : true,
			theme_advanced_path : false,
			forced_root_block : "",
			force_br_newlines : true,
			relative_urls : true,
			fix_list_elements : true,
			auto_cleanup_word : true,
			entity_encoding : "named",
			apply_source_formatting : true,
			button_tile_map : true,
			convert_fonts_to_spans : true,
			nonbreaking_force_tab : true,
			object_resizing : false,
			plugin_insertdate_dateFormat : "%d.%m.%Y",
			plugin_insertdate_timeFormat : "%H:%M:%S",
			debug : false });


		function sf_getFile(name, value) {
			filenamesplit=name.split("/");
			filename=filenamesplit[filenamesplit.length-1];
			filenamewithoutext=filename.substring(0,filename.lastIndexOf("."));
			if (value.indexOf("idfile")!=-1)
				value="'.str_replace($cfg_client["htmlpath"],'',$cfg_client["upl_htmlpath"]).'"+name;

			if (SF.field=="href") {		
				SF.callerWindow.document.forms[0].title.value=filename;	
				SF.callerWindow.document.forms[0].href.value=value;	
			} else if (SF.field=="popupurl") {
				SF.callerWindow.document.forms[0].popupurl.value=value;
				SF.callerWindow.document.forms[0].popupname.value=filenamewithoutext;
				SF.callerWindow.buildOnClick();
			} else if (SF.field=="longdesc") {
				SF.callerWindow.document.forms[0].longdesc.value=value;
			} else if (SF.field=="src") {
				SF.callerWindow.document.forms[0].src.value=value;
				if (SF.callerWindow.generatePreview){
					SF.callerWindow.switchType(SF.callerWindow.document.forms[0].src.value);
					SF.callerWindow.generatePreview();
				}
			} 
		}
		
		function sf_getImage(name, value) {
		
			filenamesplit=name.split("/");
			filename=filenamesplit[filenamesplit.length-1];
			filenamewithoutext=filename.substring(0,filename.lastIndexOf("."));
			if (value.indexOf("idfile")!=-1)
				value="'.str_replace($cfg_client["htmlpath"],'',$cfg_client["upl_htmlpath"]).'"+name;

			if (SF.field=="src") {
				SF.callerWindow.document.forms[0].src.value=value;
				SF.callerWindow.document.forms[0].title.value=filenamewithoutext;
				SF.callerWindow.document.forms[0].alt.value=filename;

				if (SF.callerWindow.ImageDialog.showPreviewImage)
					SF.callerWindow.ImageDialog.showPreviewImage(SF.callerWindow.document.forms[0].src.value);
			} else if (SF.field=="onmouseoversrc") {
				SF.callerWindow.document.forms[0].onmouseoversrc.value=value;
			} else if (SF.field=="onmouseoutsrc") {
				SF.callerWindow.document.forms[0].onmouseoutsrc.value=value;
			} else if (SF.field=="background_image") {
				SF.callerWindow.document.forms[0].background_image.value=value;
			} else if (SF.field=="backgroundimage") {
				SF.callerWindow.document.forms[0].backgroundimage.value=value;
			}

		}


	//-->
	</script>

	<script type="text/javascript">
	/* <![CDATA[ */
		$.dpText = {
			TEXT_PREV_YEAR		:	"vorheriges Jahr",
			TEXT_PREV_MONTH		:	"vorheriger Monat",
			TEXT_NEXT_YEAR		:	"nächstes Jahr",
			TEXT_NEXT_MONTH		:	"nächster Monat",
			TEXT_CLOSE				:	"schließen",
			TEXT_CHOOSE_DATE	:	"Datum auswählen"
		}
	/* ]]> */
	</script>



';

$_AS['tpl']['online'] = '
<tr id="row_online">
    <td class="head" width="150"><b>{lng_online}</b>&nbsp;</td>
    <td><input type="checkbox" id="online" name="article[online]" value="1" {checked}> <label for="online">{lng_online_desc}</label></td>
    <td>&nbsp;</td>
</tr>
';

$_AS['tpl']['article_start'] = '
<tr id="article_start">
    <td width="150" class="head"><b>{lng_article_start}</b>&nbsp;</td>
    <td >
      <table>
        <tr>
          <td width="160" nowrap>

            <div id="lay_article_startdate_yn" style="display:inline"><input type="checkbox"  checked="checked" id="article_startdate_yn" name="article[article_startdate_yn]" value="1" onClick="this.checked=true;if (this.checked!=true){ document.getElementById(\'article_starttime_yn\').checked=false;DisableField(this, \'article_start_hour\');DisableField(this, \'article_start_minute\')};DisableField(this, \'article_start_day\');DisableField(this, \'article_start_month\');DisableField(this, \'article_start_year\');//DisableField(this, \'article_starttime_yn\');bool=document.getElementById(\'article_starttime_yn\').checked;DisableField(this, \'article_start_hour\', (this.checked) ? !bool : true);DisableField(this, \'article_start_minute\', (this.checked) ? !bool : true);"{startdate_checked}></div>
            <div id="lay_article_start_day" style="display:inline"><input type="text" id="article_start_day" name="article[article_start_day]"  value="{day}" style="width:25px;text-align:center;font-size:1em;">.</div>
            <div id="lay_article_start_month" style="display:inline"><input type="text" id="article_start_month" name="article[article_start_month]" value="{month}" style="width:25px;text-align:center;font-size:1em;">.</div>
            <div id="lay_article_start_year" style="display:inline"><input type="text" id="article_start_year" name="article[article_start_year]" value="{year}" style="width:40px;text-align:center;font-size:1em;">&nbsp;</div>
            <div id="lay_article_start_calendar" style="display:inline">
				    	<img id="as_article_date_start" class="as_dp_button" src="'.$cfg_cms['cms_html_path'].'plugins/articlesystem/tpl/standard/img/ico_calendar.png"/>
							<script type="text/javascript" charset="utf-8">
							/* <![CDATA[ */
								$(function() {
									$("#as_article_date_start").datePicker({startDate:\'01/01/1980\',clickInput:false,createButton:false,displayClose:false,closeOnSelect:true})
									$("#as_article_date_start").click( function(){ $("#as_article_date_start").dpDisplay(); });
									
									$("#as_article_date_start").bind(
										"dpClosed",
										function(e, selectedDates)
										{
											var d = selectedDates[0];
											if (d) {
												d = new Date(d);
												document.getElementById("article_start_day").value=d.getDate();
												document.getElementById("article_start_month").value=d.getMonth()+1;
												document.getElementById("article_start_year").value=d.getFullYear();
												$("#as_article_date_end").dpSetStartDate(d.addDays(1).asString());
											}
										}
									);
									});
							/* ]]> */
							</script>

            </div>
          </td>
          <td nowrap style="padding-left:10px;">
            <div id="lay_article_starttime_yn" style="display:inline"><input type="checkbox" id="article_starttime_yn" name="article[article_starttime_yn]" value="1" onClick="if (this.checked==true){ document.getElementById(\'article_startdate_yn\').checked=true;DisableField(this, \'article_start_day\');DisableField(this, \'article_start_month\');DisableField(this, \'article_start_year\')};DisableField(this, \'article_start_hour\');DisableField(this, \'article_start_minute\');"{starttime_checked}></div>
            <div id="lay_article_start_hour" style="display:inline"><input type="text" id="article_start_hour" name="article[article_start_hour]" disabled="disabled" value="{hour}" style="width:25px;text-align:center;font-size:1em;">:</div>
            <div id="lay_article_start_minute" style="display:inline"><input type="text" id="article_start_minute" name="article[article_start_minute]" disabled="disabled" value="{minute}" style="width:25px;text-align:center;font-size:1em;"></div>
                <script language="JavaScript" type="text/javascript">
									var chk=document.getElementById("article_starttime_yn");
									var dis1=document.getElementById("article_start_hour");
									var dis2=document.getElementById("article_start_minute");
									if (chk.checked==true && dis2.disabled==true && dis1.disabled==true ){
					       		dis1.disabled=false;
					   				dis2.disabled=false;
        					}
           	    </script></td>
        </tr>
      </table>
    </td>
    <td style="font-size:1px;"><div id="error_name" style="display:none;"><img src="{path}img/{validation_icon}" alt="{error_name}" title="{error_name}"></div>&nbsp;</td>
</tr>
';

$_AS['tpl']['article_end'] = '
<tr id="article_end">
    <td width="150" class="head"><b>{lng_article_end}</b>&nbsp;</td>
    <td valign="top" >
      <table>
        <tr>
          <td width="160" nowrap>
            <div id="lay_article_enddate_yn" style="display:inline"><input type="checkbox" id="article_enddate_yn" name="article[article_enddate_yn]" value="1" onClick="if (this.checked!=true){ document.getElementById(\'article_endtime_yn\').checked=false;DisableField(this, \'article_end_hour\');DisableField(this, \'article_end_minute\')};DisableField(this, \'article_end_day\');DisableField(this, \'article_end_month\');DisableField(this, \'article_end_year\');//DisableField(this, \'article_endtime_yn\');bool=document.getElementById(\'article_endtime_yn\').checked;DisableField(this, \'article_end_hour\', (this.checked) ? !bool : true);DisableField(this, \'article_end_minute\', (this.checked) ? !bool : true);"{enddate_checked}></div>
            <div id="lay_article_end_day" style="display:inline"><input type="text" id="article_end_day" name="article[article_end_day]" value="{day}" disabled="disabled" style="width:25px;text-align:center;font-size:1em;">.</div>
            <div id="lay_article_end_month" style="display:inline"><input type="text" id="article_end_month" name="article[article_end_month]" value="{month}" disabled="disabled" style="width:25px;text-align:center;font-size:1em;">.</div>
            <div id="lay_article_end_year" style="display:inline"><input type="text" id="article_end_year" name="article[article_end_year]" value="{year}" disabled="disabled" style="width:40px;text-align:center;font-size:1em;">&nbsp;</div>
            <div id="lay_article_end_calendar" style="display:inline">
				    	<img id="as_article_date_end" class="as_dp_button" src="'.$cfg_cms['cms_html_path'].'plugins/articlesystem/tpl/standard/img/ico_calendar.png"/>
							<script type="text/javascript" charset="utf-8">
							/* <![CDATA[ */
								if (document.getElementById("article_enddate_yn").checked){
									document.getElementById("article_end_day").disabled=false;
									document.getElementById("article_end_month").disabled=false;
									document.getElementById("article_end_year").disabled=false;
								}

								$(function() {
									$("#as_article_date_end").datePicker({startDate:\'01/01/1980\',clickInput:false,createButton:false,displayClose:false,closeOnSelect:true})
									$("#as_article_date_end").click( function(){ $("#as_article_date_end").dpDisplay(); });
									
									$("#as_article_date_end").bind(
										"dpClosed",
										function(e, selectedDates)
										{
											var d = selectedDates[0];
											if (d) {
												d = new Date(d);
												
												document.getElementById("article_enddate_yn").checked="checked";
												document.getElementById("article_end_day").disabled=false;
												document.getElementById("article_end_month").disabled=false;
												document.getElementById("article_end_year").disabled=false;
												document.getElementById("article_end_day").value=d.getDate();
												document.getElementById("article_end_month").value=d.getMonth()+1;
												document.getElementById("article_end_year").value=d.getFullYear();
												$("#as_article_date_start").dpSetEndDate(d.addDays(-1).asString());
											}
										}
									);		
									});
							/* ]]> */
							</script>
            </div>
          </td>
          <td nowrap style="padding-left:10px;">
            <div id="lay_article_endtime_yn" style="display:inline"><input type="checkbox" id="article_endtime_yn" name="article[article_endtime_yn]" value="1" onClick="if (this.checked==true){ document.getElementById(\'article_enddate_yn\').checked=true;DisableField(this, \'article_end_day\');DisableField(this, \'article_end_month\');DisableField(this, \'article_end_year\');}DisableField(this, \'article_end_hour\');DisableField(this, \'article_end_minute\');"{endtime_checked}></div>
            <div id="lay_article_end_hour" style="display:inline"><input type="text" id="article_end_hour" name="article[article_end_hour]" disabled="disabled" value="{hour}" style="width:25px;text-align:center;font-size:1em;">:</div>
            <div id="lay_article_end_minute" style="display:inline"><input type="text" id="article_end_minute" name="article[article_end_minute]" disabled="disabled" value="{minute}" style="width:25px;text-align:center;font-size:1em;"></div>
                <script language="JavaScript" type="text/javascript">
									var chk=document.getElementById("article_endtime_yn");
									var dis1=document.getElementById("article_end_hour");
									var dis2=document.getElementById("article_end_minute");
									if (chk.checked==true && dis2.disabled==true && dis1.disabled==true ){
					       		dis1.disabled=false;
					   				dis2.disabled=false;
        					}
           	    </script></td>
        </tr>
      </table>
    </td>
    <td>
        <div id="error_article_end__to_small_enddate" style="display:none;"><img src="{path}img/{validation_icon}" alt="{error_to_small_enddate}" title="{error_to_small_enddate}"></div>
        <div id="error_article_end__to_small_endtime" style="display:none;"><img src="{path}img/{validation_icon}" alt="{error_to_small_endtime}" title="{error_to_small_endtime}"></div>&nbsp;
    </td>
</tr>
';

$_AS['tpl']['category'] = '
<tr id="row_category">
    <td width="150" class="head"><b>{lng_category}</b>&nbsp;</td>
    <td valign="top">{select_category}</td>
    <td>&nbsp;</td>
</tr>
';

$_AS['tpl']['title'] = '
<tr id="row_title">
    <td width="150" class="head"><b>{lng_title}</b>&nbsp;</td>
    <td valign="top"><input type="text" class="w800" id="title" name="article[title]" value="{title}" style="font-size:1em;"></td>
    <td style="font-size:1px;"><div id="error_title__empty" style="display:{validation_error_cssdisplay};"><img src="{path}img/{validation_icon}" alt="{error_empty}" title="{error_empty}"></div>&nbsp;</td>
</tr>
';

$_AS['tpl']['teaser'] = '
<tr id="row_teaser">
    <td width="150"  class="head" valign="top"><b>{lng_teaser}</b>&nbsp;</td>
    <td valign="top"><textarea id="teaser" name="article[teaser]" style="height:55px;font-size:1em;" class="w800">{teaser}</textarea></td>
    <td style="font-size:1px;"><div id="error_teaser__empty" style="display:{validation_error_cssdisplay};"><img src="{path}img/{validation_icon}" alt="{error_empty}" title="{error_empty}"></div>&nbsp;</td>
</tr>
';

$_AS['tpl']['text'] = '
<tr id="row_text">
    <td width="150"  class="head" valign="top"><b>{lng_text}</b>&nbsp;</td>
    <td valign="top"><textarea  class="{tinymce_class}w800" id="text" name="article[text]" style="font-size:1em;" rows="8">{text}</textarea></td>
    <td style="font-size:1px;"><div id="error_text__empty" style="display:{validation_error_cssdisplay};"><img src="{path}img/{validation_icon}" alt="{error_empty}" title="{error_empty}"></div>&nbsp;</td>
</tr>
';

$_AS['tpl']['organizer'] = '
<tr id="row_organizer">
    <td width="150" class="head"><b>{lng_organizer}</b>&nbsp;</td>
    <td valign="top">{select_organizer}</td>
    <td>&nbsp;</td>
</tr>
';


$_AS['tpl']['picture1'] = '
<tr id="row_picture1">
    <td width="150" class="head">
	    <table cellspacing="0" cellpadding="0" border="0" width="100%">
		    <tr>
		    	<td style="background-color:transparent;">
	    			<b>{lng_pictures}</b>
	 	    	</td>
		    	<td align="right" style="background-color:transparent;">    
						{add_elements}&nbsp;
					</td>
				</tr>
			</table>

			<div style="padding-top:5px;font-weight:normal">
				{lng_elements_sel}&nbsp;
				<button type="button" style="font-family:verdana;font-size:10px;" onclick="if (confirmdelete()) { removeelementsblock(\'image\'); }">{lng_elements_del}</button>
			</div>
    
    </td>
    <td valign="top" style="padding-right:8px;">
			{picture1sub}
		</td>
    <td style="font-size:1px;"><div id="error_text__empty" style="display:{validation_error_cssdisplay};"><img src="{path}img/{validation_icon}" alt="{error_empty}" title="{error_empty}"></div>&nbsp;</td>
</tr>
';

$_AS['tpl']['picture1sub'] = '
			<span id="elblock{idelement}">
    	<div style="clear:both;width:430px;margin:0 5px 0 0 ;float:left;">
    		<input type="hidden" name="artel[image][type]" value="image" />
    		<input type="hidden" name="artel[image][online][]" value="1" />
    		<input type="hidden" name="artel[image][idelement][]" value="{idel}" />
    		<table cellspacing="0" cellpadding="0" border="0" width="100%">
    			<tr>
    				<td colspan="2" align="right">&nbsp;</td>
    				<td colspan="2">
    					<small style="display:block;padding:0 0 2px 0">{lng_picture}</small>
    				</td>    			
    			</tr>
    			<tr>
    			  <td width="20" align="center" style="padding-top:3px;">
    					<input type="checkbox" name="artelsel_image[]" id="artelsel{idelement}" value="{idelement}" onclick="keeponeunchecked(\'image\',this);"  style="width:12px;height:12px;">
    				</td>
    				<td width="30" align="right" style="padding-right:10px;">
    					<input type="text" title="{lng_sort_index_input_title}" name="artel[image][sort_index][]" value="{sort_index}" style="width:20px;text-align:right;"/>
    				</td>
    				<td>
    					{select_picture1}
    				</td>    			
    				<td align="right">
			    		<button type="button" style="font-family:verdana;font-size:10px;width:25px;margin-right:5px;" onclick="if (confirmreset()) {clear_pic(\'{idelement}\');}">C</button>
							<button type="button" style="font-family:verdana;font-size:10px;width:25px;" onclick="rbidelement=\'{idelement}\';new_window(\'{rb_image_url}\', \'rb\', \'\', screen.width * 0.6, screen.height * 0.6, \'true\');">...</button>
    				</td>
    			</tr>
    			<tr>
    				<td colspan="2" width="25" align="right">&nbsp;</td>
    				<td colspan="3">
    					<div id="picture_preview{idelement}" style="display:none;width:370px;overflow:hidden;padding:5px 0 5px 0"></div>
    				</td>
    			</tr>
    			<tr style="display:{showhide_link}">
    				<td colspan="2" align="right">&nbsp;</td>
    				<td colspan="2">
    					<small style="display:block;padding:0 0 2px 0">{lng_picture_link}</small>
    				</td>    			
    			</tr>
    			<tr style="display:{showhide_link}">
    			  <td width="20" align="center" style="padding-top:3px;">
							&nbsp;
    				</td>
    				<td width="30" align="right" style="padding-right:10px;">
							&nbsp;
    				</td>
    				<td>
    					<input type="text" style="width:300px;" name="artel[image][value_uni][]" id="image_value_uni{idelement}" value="{picture1_uni}" onchange="previewpicturelink(this.value,htmlpath,thumbext,\'{idelement}\');">
    				</td>    			
    				<td align="right">
			    		<button type="button" style="font-family:verdana;font-size:10px;width:25px;margin-right:5px;" onclick="if (confirmreset()) {clear_piclink(\'{idelement}\');}">C</button>
							<button type="button" style="font-family:verdana;font-size:10px;width:25px;" onclick="rbidelement=\'{idelement}\';new_window(\'{rb_link_url}\', \'rb\', \'\', screen.width * 0.6, screen.height * 0.6, \'true\');">...</button>
    				</td>
    			</tr>
    		</table>
			</div>
    	<div style="width:350px;float:right;">

    		<table cellspacing="0" cellpadding="0" border="0" width="100%">
    			<tr>
    				<td>    					
    					<small style="display:block;padding:0 0 2px 0">{lng_picture1_title}</small>
    				</td>    			
    			</tr>
    			<tr>
    				<td style="padding-bottom:15px;">
    					<input type="text" style="width:350px" id="picture1_title{idelement}" name="artel[image][title][]" value="{picture1_title}" style="font-size:1em;"/>
    					<span style="display:{showhide_desc}">
	    					<small style="display:block;padding:5px 0 2px 0">{lng_picture1_description}</small>
	    					<textarea style="width:350px;display:block;" id="picture1_desc{idelement}" name="artel[image][description][]" style="font-size:1em;">{picture1_description}</textarea>
							</span>
    				</td>
    			</tr>    		
    		</table>
			</div>
      <script type="text/javascript">
     	<!-- 
     		if (document.getElementById("image_value_uni{idelement}").value!="")
					previewpicturelink("{picture1_uni}","{htmlpath}","{thumb_ext}","{idelement}");
				else				
					previewpicture("{selected_picture1}","{htmlpath}","{thumb_ext}","{idelement}");
			//-->
	    </script>
			<div style="clear:both;height:1px;width:1px;overflow:hidden;">&nbsp</div>
			</span>
';



$_AS['tpl']['file1'] = '
<tr id="row_file1">
    <td width="150" class="head">    
	    <table cellspacing="0" cellpadding="0" border="0" width="100%">
		    <tr>
		    	<td style="background-color:transparent;">
		    	<b>{lng_files}</b>
	 	    	</td>
		    	<td align="right" style="background-color:transparent;">
			    	{add_elements}&nbsp;
					</td>
				</tr>
			</table>
	
			<div style="padding-top:5px;font-weight:normal">
				{lng_elements_sel}&nbsp;
				<button type="button" style="font-family:verdana;font-size:10px;" onclick="if (confirmdelete()) {removeelementsblock(\'file\'); }">{lng_elements_del}</button>
			</div>
	    
    </td>
    <td valign="top" style="padding-right:8px;">
			{file1sub}
		</td>
    <td style="font-size:1px;"><div id="error_text__empty" style="display:{validation_error_cssdisplay};"><img src="{path}img/{validation_icon}" alt="{error_empty}" title="{error_empty}"></div>&nbsp;</td>
</tr>
';

$_AS['tpl']['file1sub'] = '
			<span id="elblock{idelement}">
    	<div style="clear:both;width:430px;margin:0 5px 0 0 ;float:left;">
    		<input type="hidden" name="artel[file][type]" value="file" />
    		<input type="hidden" name="artel[file][online][]" value="1" />
    		<input type="hidden" name="artel[file][idelement][]" value="{idel}" />
    		<table cellspacing="0" cellpadding="0" border="0" width="100%">
    			<tr>
    				<td colspan="2">&nbsp;</td>
    				<td colspan="2">
    					<small style="display:block;padding:0 0 2px 0">{lng_file}</small>
    				</td>    			
    			</tr>
    			<tr>
    			  <td width="20" align="center" style="padding-top:3px;">
    					<input type="checkbox" name="artelsel_file[]" id="artelsel{idelement}" value="{idelement}" onclick="keeponeunchecked(\'file\',this);"  style="width:12px;height:12px;">
    				</td>
    				<td width="30" align="right" style="padding-right:10px;">
    					<input type="text" title="{lng_sort_index_input_title}" name="artel[file][sort_index][]" value="{sort_index}" style="width:20px;text-align:right;"/>
    				</td>
    				<td>
    					{select_file1}
    				</td>    			
    				<td align="right">
			    		<button type="button" style="font-family:verdana;font-size:10px;width:25px;margin-right:5px;" onclick="if (confirmreset()) {clear_file(\'{idelement}\');}">C</button>
							<button type="button" style="font-family:verdana;font-size:10px;width:25px;" onclick="rbidelement=\'{idelement}\';new_window(\'{rb_file_url}\', \'rb\', \'\', screen.width * 0.6, screen.height * 0.6, \'true\');">...</button>
    				</td>
    			</tr>
    			<tr>
    				<td colspan="2" width="25" align="right">&nbsp;</td>
    				<td colspan="3">
    					<div id="file_preview{idelement}" style="display:none;width:370px;overflow:hidden;padding:5px 0 5px 0"></div>
    				</td>
    			</tr>
    			<tr style="display:{showhide_upload}">
    				<td colspan="2">&nbsp;</td>
    				<td colspan="2">
    					<small style="display:block;padding:4px 0 2px 0">{lng_file_upload}</small>			
							{select_file_upload_folder}<br/>
							<input type="file" style="width:350px;" name="file{idelement}_upload[]" style="font-size:1em;" onchange="$(\'#btn_save_back\').remove();"/>
    				</td>    			
    			</tr>

    		</table>
			</div>
    	<div style="width:350px;float:right;">

    		<table cellspacing="0" cellpadding="0" border="0" width="100%">
    			<tr>
    				<td>    					
    					<small style="display:block;padding:0 0 2px 0">{lng_file1_title}</small>
    				</td>    			
    			</tr>
    			<tr>
    				<td style="padding-bottom:15px;">
    					<input type="text" style="width:350px;" id="file1_title{idelement}" name="artel[file][title][]" value="{file1_title}" style="font-size:1em;" onchange="previewfile(document.getElementById(\'file{idelement}\').value,\'{htmlpath}\',\'\',\'{idelement}\');"/>
    					<span style="display:{showhide_desc}">
	    					<small style="display:block;padding:5px 0 2px 0">{lng_file1_description}</small>
	    					<textarea style="width:350px;display:block;" id="file1_desc{idelement}" name="artel[file][description][]" value="" style="font-size:1em;">{file1_description}</textarea>
							</span>
    				</td>
    			</tr>    		
    		</table>
			</div>
      <script type="text/javascript">
      <!-- 
				previewfile("{selected_file1}","{htmlpath}","{file1_title}","{idelement}");
			//-->
	    </script>
			<div style="clear:both;height:1px;width:1px;overflow:hidden;">&nbsp</div>
			</span>
';




$_AS['tpl']['link'] = '
<tr id="row_link">
    <td width="150" class="head">
	    <table cellspacing="0" cellpadding="0" border="0" width="100%">
		    <tr>
		    	<td style="background-color:transparent;">
		    		<b>{lng_link}</b>
		    	</td>
		    	<td align="right" style="background-color:transparent;">
			    	{add_elements}&nbsp;
					</td>
				</tr>
			</table>
			<div style="padding-top:5px;font-weight:normal">
				{lng_elements_sel}&nbsp;
				<button type="button" style="font-family:verdana;font-size:10px;" onclick="if (confirmdelete()) { removeelementsblock(\'link\'); }">{lng_elements_del}</button>
			</div>
    
    </td>
    <td valign="top" style="padding-right:8px;">
			{linksub}
		</td>
    <td style="font-size:1px;"><div id="error_text__empty" style="display:{validation_error_cssdisplay};"><img src="{path}img/{validation_icon}" alt="{error_empty}" title="{error_empty}"></div>&nbsp;</td>
</tr>
';

$_AS['tpl']['linksub'] = '
			<span id="elblock{idelement}">
    	<div style="clear:both;width:430px;margin:0 5px 0 0 ;float:left;">
    		<input type="hidden" name="artel[link][type]" value="link" />
    		<input type="hidden" name="artel[link][online][]" value="1" />
    		<input type="hidden" name="artel[link][idelement][]" value="{idel}" />
    		<table cellspacing="0" cellpadding="0" border="0" width="100%">
    			<tr>
    				<td colspan="2">&nbsp;</td>
    				<td colspan="2">
    					<small style="display:block;padding:0 0 2px 0">{lng_link_url}</small>
    				</td>    			
    			</tr>
    			<tr>
    			  <td width="20" align="center" style="padding-top:3px;">
    					<input type="checkbox" name="artelsel_link[]" id="artelsel{idelement}" value="{idelement}" onclick="keeponeunchecked(\'link\',this);" style="width:12px;height:12px;">
    				</td>
    				<td width="30" align="right" style="padding-right:10px;">
    					<input type="text" title="{lng_sort_index_input_title}" name="artel[link][sort_index][]" value="{sort_index}" style="width:20px;text-align:right;"/>
    				</td>
    				<td>
    					<input type="text" style="width:300px;" name="artel[link][value_txt][]" id="link_value_txt{idelement}" value="{link_txt}" onchange="previewlink(this.value,\'{idelement}\');">
    				</td>    			
    				<td align="right">
			    		<button type="button" style="font-family:verdana;font-size:10px;width:25px;margin-right:5px;" onclick="if (confirmreset()) {clear_link(\'{idelement}\');}">C</button>
							<button type="button" style="font-family:verdana;font-size:10px;width:25px;" onclick="rbidelement=\'{idelement}\';new_window(\'{rb_link_url}\', \'rb\', \'\', screen.width * 0.6, screen.height * 0.6, \'true\');">...</button>
    				</td>
    			</tr>
    			<tr>
    				<td colspan="2" width="25" align="right">&nbsp;</td>
    				<td colspan="3">
    					<div id="link_preview{idelement}" style="display:none;width:370px;overflow:hidden;padding:5px 0 5px 0"></div>
    				</td>
    			</tr>
    		</table>
			</div>
    	<div style="width:350px;float:right;">
    		<table cellspacing="0" cellpadding="0" border="0" width="100%">
    			<tr>
    				<td>    					
    					<small style="display:block;padding:0 0 2px 0">{lng_link_title}</small>
    				</td>    			
    			</tr>
    			<tr>
    				<td style="padding-bottom:15px;">
    					<input type="text" style="width:350px;" id="link_title{idelement}" name="artel[link][title][]" value="{link_title}" style="font-size:1em;" onchange="previewlink(document.getElementById(\'link_value_txt{idelement}\').value,\'{idelement}\');"/>
    					<span style="display:{showhide_desc}">
	    					<small style="display:block;padding:5px 0 2px 0">{lng_link_description}</small>
	    					<textarea style="width:350px;display:block;" id="link_desc{idelement}" name="artel[link][description][]" value="" style="font-size:1em;">{link_description}</textarea>
							</span>
    				</td>
    			</tr>    		
    		</table>
			</div>
		  <script type="text/javascript">
		  <!-- 
				previewlink(document.getElementById("link_value_txt{idelement}").value,"{idelement}");
			//-->
		  </script>
		  <div style="clear:both;height:1px;width:1px;overflow:hidden;">&nbsp</div>
		  </span>
';

$_AS['tpl']['date'] = '
<tr id="row_date">
    <td width="150" class="head">
	    <table cellspacing="0" cellpadding="0" border="0" width="100%">
		    <tr>
		    	<td style="background-color:transparent;">
		    		<b>{lng_date}</b>
		    	</td>
		    	<td align="right" style="background-color:transparent;">
			    	{add_elements}&nbsp;
					</td>
				</tr>
			</table>
			<div style="padding-top:5px;font-weight:normal">
				{lng_elements_sel}&nbsp;
				<button type="button" style="font-family:verdana;font-size:10px;" onclick="if (confirmdelete()) {removeelementsblock(\'date\'); }">{lng_elements_del}</button>
			</div>
    
    </td>
    <td valign="top" style="padding-right:8px;">
			{datesub}
		</td>
    <td style="font-size:1px;"><div id="error_text__empty" style="display:{validation_error_cssdisplay};"><img src="{path}img/{validation_icon}" alt="{error_empty}" title="{error_empty}"></div>&nbsp;</td>
</tr>
';

$_AS['tpl']['datesub'] = '
			<span id="elblock{idelement}">
    	<div style="clear:both;width:230px;margin:0 5px 0 0 ;float:left;">
    		<input type="hidden" name="artel[date][type]" value="date" />
    		<input type="hidden" name="artel[date][online][]" value="1" />
    		<input type="hidden" name="artel[date][idelement][]" value="{idel}" />
    		<table cellspacing="0" cellpadding="0" border="0" width="100%">
    			<tr>
    				<td colspan="2">&nbsp;</td>
    				<td colspan="2">
    					<small style="display:block;padding:0 0 2px 0">{lng_date_date}</small>
    				</td>    			
    			</tr>
    			<tr>
    			  <td width="20" align="center" style="padding-top:3px;">
    					<input type="checkbox" name="artelsel_date[]" id="artelsel{idelement}" value="{idelement}" onclick="keeponeunchecked(\'date\',this);" style="width:12px;height:12px;">
    				</td>
    				<td width="30" align="right" style="padding-right:10px;">
    					<input type="text" title="{lng_sort_index_input_title}" name="artel[date][sort_index][]" value="{sort_index}" style="width:20px;text-align:right;"/>
    				</td>

    				<td>
							<input type="text" id="date{idelement}_day" maxlength="2" value="{date_day}" onchange="setdate(\'date\',\'{idelement}\');"  style="width:25px;text-align:center;font-size:1em;"/>.&nbsp;
			    		<input type="text" maxlength="2" id="date{idelement}_month" value="{date_month}" onchange="setdate(\'date\',\'{idelement}\');"  style="width:25px;text-align:center;font-size:1em;"/>.&nbsp;
			    		<input type="text" maxlength="4" id="date{idelement}_year" value="{date_year}" onchange="setdate(\'date\',\'{idelement}\');"  style="width:40px;text-align:center;font-size:1em;"/>&nbsp;
				    	<input type="hidden" id="date{idelement}_date" value="{date_date}">
				    	<img id="as_dp_button{idelement}" class="as_dp_button" src="'.$cfg_cms['cms_html_path'].'plugins/articlesystem/tpl/standard/img/ico_calendar.png"/>
    				</td>    			
    				<td align="right">
    				</td>
    			</tr>
    			<tr>
    				<td colspan="2" width="25" align="right">&nbsp;</td>
    				<td colspan="3">
    					<span style="display:{showhide_time}">
	    					<small style="display:block;padding:5px 0 2px 0">{lng_date_time}</small>
								<input type="text" id="date{idelement}_hour" maxlength="2" value="{date_hour}" onchange="settime(\'date\',\'{idelement}\');"  style="width:25px;text-align:center;font-size:1em;"/>:&nbsp;
				    		<input type="text" maxlength="2" id="date{idelement}_minute" value="{date_minute}" onchange="settime(\'date\',\'{idelement}\');"  style="width:25px;text-align:center;font-size:1em;"/>
				    		<input type="hidden" id="date{idelement}_time" value="{date_time}">
				    		<input type="hidden" id="date{idelement}" name="artel[date][value_txt][]" value="{date}">
							</span>&nbsp;
    				</td>
    			</tr>
    			<tr>
    				<td colspan="2" width="25" align="right">&nbsp;</td>
    				<td colspan="3">
    					<span style="display:{showhide_duration}">
	    					<small style="display:block;padding:5px 0 2px 0">{lng_date_duration}</small>
				    		<input type="text" id="date" name="artel[date][value_uni][]" value="{date_duration}">
							</span>&nbsp;
    				</td>
    			</tr>
    		</table>
			</div>

			<script type="text/javascript" charset="utf-8">
			/* <![CDATA[ */
				$(function() {
					$("#as_dp_button{idelement}").datePicker({startDate:\'01/01/1980\',clickInput:false,createButton:false,displayClose:false,closeOnSelect:true})
					$("#as_dp_button{idelement}").click( function(){ $("#as_dp_button{idelement}").dpDisplay(); });
							
							$("#as_dp_button{idelement}").bind(
								"dpClosed",
								function(e, selectedDates)
								{
									var d = selectedDates[0];
									if (d) {
										d = new Date(d);
										document.getElementById("date{idelement}_day").value=d.getDate();
										document.getElementById("date{idelement}_month").value=d.getMonth()+1;
										document.getElementById("date{idelement}_year").value=d.getFullYear();
										setdate(\'date\',\'{idelement}\');
									}
								}
							);
					});
			/* ]]> */
			</script>
			
    	<div style="width:550px;float:right;">
    		<table cellspacing="0" cellpadding="0" border="0" width="100%">
    			<tr>
    				<td>    					
    					<small style="display:block;padding:0 0 2px 0">{lng_date_title}</small>
    				</td>    			
    			</tr>
    			<tr>
    				<td style="padding-bottom:15px;">
    					<input type="text" style="width:550px;" id="date_title{idelement}" name="artel[date][title][]" value="{date_title}" style="font-size:1em;" onchange="previewdate(document.getElementById(\'date_value_txt{idelement}\').value,\'{idelement}\');"/>
    					<span style="display:{showhide_desc}">
	    					<small style="display:block;padding:5px 0 2px 0">{lng_date_description}</small>
	    					<textarea style="width:550px;height:53px;display:block;" id="date_desc{idelement}" name="artel[date][description][]" value="" style="font-size:1em;">{date_description}</textarea>
							</span>
    				</td>
    			</tr>    		
    		</table>
			</div>

		  <div style="clear:both;height:1px;width:1px;overflow:hidden;">&nbsp</div>
		  </span>
';



for ($i=1;$i<36;$i++)
	$_AS['tpl']['custom'.$i] = '
	<tr id="row_custom'.$i.'">
	    <td width="150" class="head"><b>{lng_custom'.$i.'}</b>&nbsp;</td>
	    <td valign="top"><input type="text" class="w800" id="custom'.$i.'" name="article[custom'.$i.']" value="{custom'.$i.'}" style="font-size:1em;" {readonly}></td>
    <td style="font-size:1px;"><div id="error_text__empty" style="display:{validation_error_cssdisplay};"><img src="{path}img/{validation_icon}" alt="{error_empty}" title="{error_empty}"></div>&nbsp;</td>

	</tr>
	';
for ($i=1;$i<36;$i++)
	$_AS['tpl']['custom'.$i.'_textarea'] = '
	<tr id="row_custom'.$i.'">
	    <td width="150" class="head"><b>{lng_custom'.$i.'}</b>&nbsp;</td>
	    <td valign="top"><textarea {wysiwyg} id="custom'.$i.'" name="article[custom'.$i.']" style="font-size:1em;" rows="8" class="w800" {readonly}>{custom'.$i.'}</textarea></td>
    <td style="font-size:1px;"><div id="error_text__empty" style="display:{validation_error_cssdisplay};"><img src="{path}img/{validation_icon}" alt="{error_empty}" title="{error_empty}"></div>&nbsp;</td>

	</tr>
	';
for ($i=1;$i<36;$i++)
	$_AS['tpl']['custom'.$i.'_date'] = '
	<tr id="row_custom'.$i.'">
	    <td width="150" class="head"><b>{lng_custom'.$i.'}</b>&nbsp;</td>
	    <td><input type="text" id="custom'.$i.'_day" maxlength="2" value="{custom'.$i.'_day}" onchange="setdate(\'custom\','.$i.');"  style="width:25px;text-align:center;font-size:1em;"/>.&nbsp;
	    		<input type="text" maxlength="2" id="custom'.$i.'_month" value="{custom'.$i.'_month}" onchange="setdate(\'custom\','.$i.');"  style="width:25px;text-align:center;font-size:1em;"/>.&nbsp;
	    		<input type="text" maxlength="4" id="custom'.$i.'_year" value="{custom'.$i.'_year}" onchange="setdate(\'custom\','.$i.');"  style="width:40px;text-align:center;font-size:1em;"/>&nbsp;
	    		<input type="hidden" id="custom'.$i.'" name="article[custom'.$i.']" value="{custom'.$i.'}">
				  <img id="as_dp_button_custom'.$i.'" class="as_dp_button" src="'.$cfg_cms['cms_html_path'].'plugins/articlesystem/tpl/standard/img/ico_calendar.png"/>
					<script type="text/javascript" charset="utf-8">
					/* <![CDATA[ */
						$(function() {
							$("#as_dp_button_custom'.$i.'").datePicker({startDate:\'01/01/1980\',clickInput:false,createButton:false,displayClose:false,closeOnSelect:true})
							$("#as_dp_button_custom'.$i.'").click( function(){ $("#as_dp_button_custom'.$i.'").dpDisplay(); });
									
									$("#as_dp_button_custom'.$i.'").bind(
										"dpClosed",
										function(e, selectedDates)
										{
											var d = selectedDates[0];
											if (d) {
												d = new Date(d);
												document.getElementById("custom'.$i.'_day").value=d.getDate();
												document.getElementById("custom'.$i.'_month").value=d.getMonth()+1;
												document.getElementById("custom'.$i.'_year").value=d.getFullYear();
												setdate(\'custom\',\''.$i.'\');
											}
										}
									);
							});
					/* ]]> */
					</script>	    		
    		</td>
    <td style="font-size:1px;"><div id="error_text__empty" style="display:{validation_error_cssdisplay};"><img src="{path}img/{validation_icon}" alt="{error_empty}" title="{error_empty}"></div>&nbsp;</td>

	</tr>
	';
	
for ($i=1;$i<36;$i++)
	$_AS['tpl']['custom'.$i.'_datetime'] = '
	<tr id="row_custom'.$i.'">
	    <td width="150" class="head"><b>{lng_custom'.$i.'}</b>&nbsp;</td>
	    <td><input {readonly} type="text" id="custom'.$i.'_day" maxlength="2" value="{custom'.$i.'_day}" onchange="setdatetime(\'custom\','.$i.');"  style="width:25px;text-align:center;font-size:1em;"/>.&nbsp;
	    		<input {readonly} type="text" maxlength="2" id="custom'.$i.'_month" value="{custom'.$i.'_month}" onchange="setdatetime(\'custom\','.$i.');"  style="width:25px;text-align:center;font-size:1em;"/>.&nbsp;
	    		<input {readonly} type="text" maxlength="4" id="custom'.$i.'_year" value="{custom'.$i.'_year}" onchange="setdatetime(\'custom\','.$i.');"  style="width:40px;text-align:center;font-size:1em;"/>&nbsp;
				  <img style="{hidecalicon}" id="as_dp_button_custom'.$i.'" class="as_dp_button" src="'.$cfg_cms['cms_html_path'].'plugins/articlesystem/tpl/standard/img/ico_calendar.png"/>&nbsp;&nbsp;
	    		<input {readonly} type="text" id="custom'.$i.'_hour" maxlength="2" value="{custom'.$i.'_hour}" onchange="setdatetime(\'custom\','.$i.');"  style="width:25px;text-align:center;font-size:1em;"/>:&nbsp;
	    		<input {readonly} type="text" maxlength="2" id="custom'.$i.'_minute" value="{custom'.$i.'_minute}" onchange="setdatetime(\'custom\','.$i.');"  style="width:25px;text-align:center;font-size:1em;"/>
	    		<input type="hidden" id="custom'.$i.'" name="article[custom'.$i.']" value="{custom'.$i.'}">
					<script type="text/javascript" charset="utf-8">
					/* <![CDATA[ */
						$(function() {
							$("#as_dp_button_custom'.$i.'").datePicker({startDate:\'01/01/1980\',clickInput:false,createButton:false,displayClose:false,closeOnSelect:true})
							$("#as_dp_button_custom'.$i.'").click( function(){ $("#as_dp_button_custom'.$i.'").dpDisplay(); });
									
									$("#as_dp_button_custom'.$i.'").bind(
										"dpClosed",
										function(e, selectedDates)
										{
											var d = selectedDates[0];
											if (d) {
												d = new Date(d);
												document.getElementById("custom'.$i.'_day").value=d.getDate();
												document.getElementById("custom'.$i.'_month").value=d.getMonth()+1;
												document.getElementById("custom'.$i.'_year").value=d.getFullYear();
												setdatetime(\'custom\',\''.$i.'\');
											}
										}
									);
							});
					/* ]]> */
					</script>	    		
    		</td>
    <td style="font-size:1px;"><div id="error_text__empty" style="display:{validation_error_cssdisplay};"><img src="{path}img/{validation_icon}" alt="{error_empty}" title="{error_empty}"></div>&nbsp;</td>

	</tr>
	';
	
for ($i=1;$i<36;$i++)
	$_AS['tpl']['custom'.$i.'_time'] = '
	<tr id="row_custom'.$i.'">
	    <td width="150" class="head"><b>{lng_custom'.$i.'}</b>&nbsp;</td>
	    <td><input type="text" id="custom'.$i.'_hour" maxlength="2" value="{custom'.$i.'_hour}" onchange="settime(\'custom\','.$i.');"  style="width:25px;text-align:center;font-size:1em;"/>:&nbsp;
	    		<input type="text" maxlength="2" id="custom'.$i.'_minute" value="{custom'.$i.'_minute}" onchange="settime(\'custom\','.$i.');"  style="width:25px;text-align:center;font-size:1em;"/>
	    		<input type="hidden" id="custom'.$i.'" name="article[custom'.$i.']" value="{custom'.$i.'}"></td>
    <td style="font-size:1px;"><div id="error_text__empty" style="display:{validation_error_cssdisplay};"><img src="{path}img/{validation_icon}" alt="{error_empty}" title="{error_empty}"></div>&nbsp;</td>

	</tr>
	';
for ($i=1;$i<36;$i++)
	$_AS['tpl']['custom'.$i.'_select'] = '
	<tr id="row_custom'.$i.'">
	    <td width="150" class="head"><b>{lng_custom'.$i.'}</b>&nbsp;</td>
	    <td valign="top">{custom'.$i.'_select}{custom'.$i.'_mem}{custom'.$i.'_input}</td>
    <td style="font-size:1px;"><div id="error_text__empty" style="display:{validation_error_cssdisplay};"><img src="{path}img/{validation_icon}" alt="{error_empty}" title="{error_empty}"></div>&nbsp;</td>

	</tr>
	';
	
for ($i=1;$i<36;$i++)
	$_AS['tpl']['custom'.$i.'_checkradio'] = '
	<tr id="row_custom'.$i.'">
	    <td width="150" class="head"><b>{lng_custom'.$i.'}</b>&nbsp;</td>
	    <td valign="top">{custom'.$i.'_select}{custom'.$i.'_mem}</td>
    <td style="font-size:1px;"><div id="error_text__empty" style="display:{validation_error_cssdisplay};"><img src="{path}img/{validation_icon}" alt="{error_empty}" title="{error_empty}"></div>&nbsp;</td>

	</tr>
	';
	
for ($i=1;$i<36;$i++)
	$_AS['tpl']['custom'.$i.'_info'] = '
	<tr id="row_custom'.$i.'">
	    <td width="150" class="head"><b>{lng_custom'.$i.'}</b>&nbsp;</td>
	    <td valign="top">{custom'.$i.'}</td>
    <td style="font-size:1px;"><div id="error_text__empty" style="display:{validation_error_cssdisplay};"><img src="{path}img/{validation_icon}" alt="{error_empty}" title="{error_empty}"></div>&nbsp;</td>

	</tr>
	';	
	
$_AS['tpl']['buttons'] = '
<tr id="row_buttons">
    <td width="150" class="head">&nbsp;</td>
    <td class="content7" align="right" colspan="2">

			<input name="sf_safe" value="{saveback2}" id="btn_save_back" class="sf_buttonAction" onclick="document.getElementById(\'apply\').value = 0; CheckEventForm(document.getElementById(\'articleform\'));" onmouseover="this.className=\'sf_buttonActionOver\'" onmouseout="this.className=\'sf_buttonAction\'" type="button">
			<input name="sf_apply" value="{save}" class="sf_buttonAction" onclick="document.getElementById(\'apply\').value = 1; CheckEventForm(document.getElementById(\'articleform\'));" onmouseover="this.className=\'sf_buttonActionOver\'" onmouseout="this.className=\'sf_buttonAction\'" type="button">
			<input name="sf_cancel" value="{cancel}" class="sf_buttonAction" onclick="window.location=\'{back}\'" onmouseover="this.className=\'sf_buttonActionCancelOver\'" onmouseout="this.className=\'sf_buttonAction\'" type="button">
    </td>
</tr>
';














$_AS['tpl']['custom_picture'] = '
<tr id="row_picture1">
    <td width="150" class="head">
	    			<b>{lng_pictures}</b>
    </td>
    <td valign="top" style="padding-right:8px;">
			{picture1sub}
		</td>
    <td style="font-size:1px;"><div id="error_text__empty" style="display:{validation_error_cssdisplay};"><img src="{path}img/{validation_icon}" alt="{error_empty}" title="{error_empty}"></div>&nbsp;</td>
</tr>
';

$_AS['tpl']['custom_picture_sub'] = '
    	<div style="clear:both;width:430px;margin:0 5px 0 0 ;float:left;">
    		<input type="hidden" name="article[{custom_field}]" id="article[{custom_field}]"/>
    		
    		<table cellspacing="0" cellpadding="0" border="0" width="100%">
    			<tr>
    				<td colspan="2" align="right">&nbsp;</td>
    				<td colspan="2">
    					<small style="display:block;padding:0 0 2px 0">{lng_picture}</small>
    				</td>    			
    			</tr>
    			<tr>
    			  <td width="20" align="center" style="padding-top:3px;">
    				</td>
    				<td width="30" align="right" style="padding-right:10px;">
    				</td>
    				<td>
    					{select_picture1}
    				</td>    			
    				<td align="right">
			    		<button type="button" style="font-family:verdana;font-size:10px;width:25px;margin-right:5px;" onclick="if (confirmreset()) {clear_pic(\'{idelement}\');}">C</button>
							<button type="button" style="font-family:verdana;font-size:10px;width:25px;" onclick="rbidelement=\'{idelement}\';customfield=\'{custom_field}\';new_window(\'{rb_image_url}\', \'rb\', \'\', screen.width * 0.6, screen.height * 0.6, \'true\');">...</button>
    				</td>
    			</tr>
    			<tr>
    				<td colspan="2" width="25" align="right">&nbsp;</td>
    				<td colspan="2">
    					<div id="picture_preview{idelement}" style="display:none;width:370px;overflow:hidden;padding:5px 0 5px 0"></div>
    				</td>
    			</tr>
    			<tr style="display:{showhide_link}">
    				<td colspan="2" align="right">&nbsp;</td>
    				<td colspan="2">
    					<small style="display:block;padding:0 0 2px 0">{lng_picture_link}</small>
    				</td>    			
    			</tr>
    			<tr style="display:{showhide_link}">
    			  <td width="20" align="center" style="padding-top:3px;">
							&nbsp;
    				</td>
    				<td width="30" align="right" style="padding-right:10px;">
							&nbsp;
    				</td>
    				<td>
    					<input type="text" style="width:300px;" name="article[{custom_field}_link]" id="image_value_uni{idelement}" value="{custom_field_link}" onchange="previewpicturelink(this.value,htmlpath,thumbext,\'{idelement}\');set_custom_pic(\'{custom_field}\',\'{idelement}\');">
    				</td>    			
    				<td align="right">
			    		<button type="button" style="font-family:verdana;font-size:10px;width:25px;margin-right:5px;" onclick="if (confirmreset()) {clear_piclink(\'{idelement}\');}">C</button>
							<button type="button" style="font-family:verdana;font-size:10px;width:25px;" onclick="rbidelement=\'{idelement}\';customfield=\'{custom_field}\';new_window(\'{rb_link_url}\', \'rb\', \'\', screen.width * 0.6, screen.height * 0.6, \'true\');">...</button>
    				</td>
    			</tr>
    			<tr style="display:{showhide_upload}">
    				<td colspan="2">&nbsp;</td>
    				<td colspan="2">
    					<small style="display:block;padding:4px 0 2px 0">{lng_picture_upload}</small>			
							{select_picture_upload_folder}<br/>
							<input type="file" style="width:350px;" name="{custom_field}_upload[]" style="font-size:1em;" onchange="$(\'#btn_save_back\').remove();"/>
    				</td>    			
    			</tr>

    		</table>
			</div>
    	<div style="width:350px;float:right;">

    		<table cellspacing="0" cellpadding="0" border="0" width="100%">
    			<tr>
    				<td>    					
    					<small style="display:block;padding:0 0 2px 0">{lng_picture1_title}</small>
    				</td>    			
    			</tr>
    			<tr>
    				<td style="padding-bottom:15px;">
    					<input type="text" style="width:350px" id="picture1_title{idelement}" name="article[{custom_field}_title]" value="{custom_field_title_value}" style="font-size:1em;" onchange="set_custom_pic(\'{custom_field}\',\'{idelement}\');"/>
    					<span style="display:{showhide_desc}">
	    					<small style="display:block;padding:5px 0 2px 0">{lng_picture1_description}</small>
	    					<textarea style="width:350px;display:block;" id="picture1_desc{idelement}" name="article[{custom_field}_desc]" style="font-size:1em;" onchange="set_custom_pic(\'{custom_field}\',\'{idelement}\');">{custom_field_desc_value}</textarea>
							</span>
    				</td>
    			</tr>    		
    		</table>
			</div>
      <script type="text/javascript">
     	<!-- 
				set_custom_pic(\'{custom_field}\',\'{idelement}\');
     		if (document.getElementById("image_value_uni{idelement}").value!="")
					previewpicturelink("{custom_field_link}","{htmlpath}","{thumb_ext}","{idelement}");
				else				
					previewpicture("{selected_picture1}","{htmlpath}","{thumb_ext}","{idelement}");
			//-->
	    </script>
			<div style="clear:both;height:1px;width:1px;overflow:hidden;">&nbsp</div>
			
';



$_AS['tpl']['custom_file'] = '
<tr id="row_file1">
    <td width="150" class="head">  
    	<b>{lng_files}</b>
    </td>
    <td  style="padding-right:8px;">
			{file1sub}
		</td>
    <td style="font-size:1px;"><div id="error_text__empty" style="display:{validation_error_cssdisplay};"><img src="{path}img/{validation_icon}" alt="{error_empty}" title="{error_empty}"></div>&nbsp;</td>
</tr>
';

$_AS['tpl']['custom_file_sub'] = '
    	<div style="clear:both;width:430px;margin:0 5px 0 0 ;float:left;">
    		<input type="hidden" name="article[{custom_field}]" id="article[{custom_field}]" value=""/>
    		<table cellspacing="0" cellpadding="0" border="0" width="100%">
    			<tr>
    				<td colspan="2">&nbsp;</td>
    				<td colspan="2">
    					<small style="display:block;padding:0 0 2px 0">{lng_file}</small>
    				</td>    			
    			</tr>
    			<tr>
    			  <td width="20" align="center" style="padding-top:3px;"></td>
    				<td width="30" align="right" style="padding-right:10px;"></td>
    				<td>
    					{select_file1}
    				</td>    			
    				<td align="right">
			    		<button type="button" style="font-family:verdana;font-size:10px;width:25px;margin-right:5px;" onclick="if (confirmreset()) {clear_file(\'{idelement}\');set_custom_file(\'{custom_field}\',\'{idelement}\');}">C</button>
							<button type="button" style="font-family:verdana;font-size:10px;width:25px;" onclick="rbidelement=\'{idelement}\';customfield=\'{custom_field}\';new_window(\'{rb_file_url}\', \'rb\', \'\', screen.width * 0.6, screen.height * 0.6, \'true\');">...</button>
    				</td>
    			</tr>
    			<tr>
    				<td colspan="2" width="25" align="right">&nbsp;</td>
    				<td colspan="2">
    					<div id="file_preview{idelement}" style="display:none;width:370px;overflow:hidden;padding:5px 0 5px 0"></div>
    				</td>
    			</tr>
    			<tr style="display:{showhide_upload}">
    				<td colspan="2">&nbsp;</td>
    				<td colspan="2">
    					<small style="display:block;padding:0 0 2px 0">{lng_file_upload}</small>			
							{select_file_upload_folder}<br/>
							<input type="file" style="width:350px;" name="{custom_field}_upload[]" style="font-size:1em;" onchange="$(\'#btn_save_back\').remove();"/>
    				</td>    			
    			</tr>
    		</table>
			</div>
    	<div style="width:350px;float:right;">
    		<table cellspacing="0" cellpadding="0" border="0" width="100%">
    			<tr>
    				<td>    					
    					<small style="display:block;padding:0 0 2px 0">{lng_file1_title}</small>
    				</td>    			
    			</tr>
    			<tr>
    				<td style="padding-bottom:15px;">
    					<input type="text" style="width:350px;" id="file1_title{idelement}" name="article[{custom_field}_title]" value="{file1_title}" style="font-size:1em;" onchange="previewfile(document.getElementById(\'file{idelement}\').value,\'{htmlpath}\',\'\',\'{idelement}\');set_custom_file(\'{custom_field}\',\'{idelement}\');"/>
    					<span style="display:{showhide_desc}">
	    					<small style="display:block;padding:5px 0 2px 0">{lng_file1_description}</small>
	    					<textarea style="width:350px;display:block;" id="file1_desc{idelement}" name="article[{custom_field}_desc]" value="" style="font-size:1em;" onchange="set_custom_file(\'{custom_field}\',\'{idelement}\');">{file1_description}</textarea>
							</span>
    				</td>
    			</tr>    		
    		</table>
			</div>
      <script type="text/javascript">
      <!-- 
				set_custom_file(\'{custom_field}\',\'{idelement}\');
				previewfile("{selected_file1}","{htmlpath}","{file1_title}","{idelement}");
			//-->
	    </script>
			<div style="clear:both;height:1px;width:1px;overflow:hidden;">&nbsp</div>
';




$_AS['tpl']['custom_link'] = '
<tr id="row_link">
    <td width="150" class="head">
		    		<b>{lng_link}</b>
    </td>
    <td valign="top" style="padding-right:8px;">
			{linksub}
		</td>
    <td style="font-size:1px;"><div id="error_text__empty" style="display:{validation_error_cssdisplay};"><img src="{path}img/{validation_icon}" alt="{error_empty}" title="{error_empty}"></div>&nbsp;</td>
</tr>
';

$_AS['tpl']['custom_link_sub'] = '
    	<div style="clear:both;width:430px;margin:0 5px 0 0 ;float:left;">
    		<input type="hidden" name="article[{custom_field}]" id="article[{custom_field}]" value=""/>
    		<table cellspacing="0" cellpadding="0" border="0" width="100%">
    			<tr>
    				<td colspan="2">&nbsp;</td>
    				<td colspan="2">
    					<small style="display:block;padding:0 0 2px 0">{lng_link_url}</small>
    				</td>    			
    			</tr>
    			<tr>
    			  <td width="20" align="center" style="padding-top:3px;">
    				</td>
    				<td width="30" align="right" style="padding-right:10px;">
    				</td>
    				<td>
    					<input type="text" style="width:300px;" name="article[{custom_field}_value]" id="link_value_txt{idelement}" value="{link_txt}" onchange="previewlink(this.value,\'{idelement}\');set_custom_link(\'{custom_field}\',\'{idelement}\');">
    				</td>    			
    				<td align="right">
			    		<button type="button" style="font-family:verdana;font-size:10px;width:25px;margin-right:5px;" onclick="if (confirmreset()) {clear_link(\'{idelement}\');set_custom_link(\'{custom_field}\',\'{idelement}\');}">C</button>
							<button type="button" style="font-family:verdana;font-size:10px;width:25px;" onclick="rbidelement=\'{idelement}\';customfield=\'{custom_field}\';new_window(\'{rb_link_url}\', \'rb\', \'\', screen.width * 0.6, screen.height * 0.6, \'true\');">...</button>
    				</td>
    			</tr>
    			<tr>
    				<td colspan="2" width="25" align="right">&nbsp;</td>
    				<td colspan="2">
    					<div id="link_preview{idelement}" style="display:none;width:370px;overflow:hidden;padding:5px 0 5px 0"></div>
    				</td>
    			</tr>
    		</table>
			</div>
    	<div style="width:350px;float:right;">
    		<table cellspacing="0" cellpadding="0" border="0" width="100%">
    			<tr id="title_row{idelement}" style="display:{showhide_title}">
    				<td>
   						<small style="display:block;padding:0 0 2px 0">{lng_link_title}</small>
    				</td>    			
    			</tr>
    			<tr>
    				<td style="padding-bottom:15px;">
    					<span style="display:{showhide_title}">
	    					<input type="text" style="width:350px;" id="link_title{idelement}" name="article[{custom_field}_title]" value="{link_title}" style="font-size:1em;" onchange="previewlink(document.getElementById(\'link_value_txt{idelement}\').value,\'{idelement}\');set_custom_link(\'{custom_field}\',\'{idelement}\');"/>
							</span>
    					<span style="display:{showhide_desc}">
	    					<small style="display:block;padding:5px 0 2px 0">{lng_link_description}</small>
	    					<textarea style="width:350px;display:block;" id="link_desc{idelement}" name="article[{custom_field}_desc]" value="" style="font-size:1em;" onchange="set_custom_link(\'{custom_field}\',\'{idelement}\');">{link_description}</textarea>
							</span>
    				</td>
    			</tr>    		
    		</table>
			</div>
		  <script type="text/javascript">
		  <!-- 
				set_custom_link(\'{custom_field}\',\'{idelement}\');
				previewlink(document.getElementById("link_value_txt{idelement}").value,"{idelement}");
			//-->
		  </script>
		  <div style="clear:both;height:1px;width:1px;overflow:hidden;">&nbsp</div>
';




?>
