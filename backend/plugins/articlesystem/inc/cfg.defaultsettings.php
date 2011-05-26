<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');
}
    //Defaulteinstellungen, die in die DB eingetragen werden, falls nicht vorhanden
    $defaultsettings['set_category'] = '1';
    $defaultsettings['version_number'] = '1.4.3';
    $defaultsettings['number_of_month'] = '-1';
    $defaultsettings['use_archive'] = '1';
    $defaultsettings['use_categories_rm'] = 'false';
    $defaultsettings['auto_archive'] = '0';
    $defaultsettings['set_category_multiple'] = '0';
    $defaultsettings['show_articles_pages_dir'] = 'true';
    $defaultsettings['language'] = 'deutsch';
    $defaultsettings['number_of_entries'] = '25';
    $defaultsettings['skin'] = 'standard';
		$defaultsettings['wysiwyg'] = 'true';
    $defaultsettings['picture_select_folders'] = '';
    $defaultsettings['picture_select_subfolders'] = 'true';
    $defaultsettings['file_select_folders'] = '';
    $defaultsettings['file_select_subfolders'] = 'true';
    $defaultsettings['file_select_filetypes'] = '';
    $defaultsettings['max_number_files_select'] = '50';

    $defaultsettings['wysiwyg_picture_select_folders'] = '';
    $defaultsettings['wysiwyg_picture_select_subfolders'] = 'true';
    $defaultsettings['wysiwyg_file_select_folders'] = '';
    $defaultsettings['wysiwyg_file_select_subfolders'] = 'true';
    $defaultsettings['wysiwyg_file_select_filetypes'] = '';

    $defaultsettings['spfnc_facebook'] = 'false';
#    $defaultsettings['spfnc_facebook_usn'] = '';
#    $defaultsettings['spfnc_facebook_pwd'] = '';
    $defaultsettings['spfnc_facebook_app_key'] = '';
    $defaultsettings['spfnc_facebook_tpl'] = '{chop}{text}{/chop}';
#    $defaultsettings['spfnc_facebook_tpl_images'] = '{imageurl}';
#    $defaultsettings['spfnc_facebook_tpl_files'] = '{fileurl}';
#    $defaultsettings['spfnc_facebook_tpl_links'] = '{linkurl}';
#    $defaultsettings['spfnc_facebook_tpl_dates'] = '{date} - {datetime24} - {datetitle}';
    $defaultsettings['spfnc_facebook_media'] = '';
    $defaultsettings['spfnc_facebook_tpl_cfg_time'] = '{hour}:{minute} Uhr';
    $defaultsettings['spfnc_facebook_tpl_cfg_date'] = '{day}.{month}.{year}';
    $defaultsettings['spfnc_facebook_tpl_cfg_chopmaxlength'] = 300;
    $defaultsettings['spfnc_facebook_tpl_cfg_chopend'] = ' ... ';
    $defaultsettings['spfnc_facebook_url'] = '{baseurl}index.php?idcatside=&lang={idlang}&idarticle={idarticle}';
    $defaultsettings['spfnc_facebook_url_name'] = '';
    $defaultsettings['spfnc_facebook_url_caption'] = '';
    $defaultsettings['spfnc_facebook_lastsent_data_cf'] = '';
    $defaultsettings['spfnc_facebook_lastsent_date_cf'] = '';
    $defaultsettings['spfnc_facebook_url'] = '';
    $defaultsettings['spfnc_facebook_url_man'] = '';

    $defaultsettings['spfnc_twitter'] = 'false';
    $defaultsettings['spfnc_twitter_usn'] = '';
    $defaultsettings['spfnc_twitter_pwd'] = '';
    $defaultsettings['spfnc_twitter_tpl'] = '{chop}{title}{/chop}{url}';
    $defaultsettings['spfnc_twitter_tpl_cfg_time'] = '{hour}:{minute} Uhr';
    $defaultsettings['spfnc_twitter_tpl_cfg_date'] = '{day}.{month}.{year}';
    $defaultsettings['spfnc_twitter_tpl_cfg_chopmaxlength'] = 110;
    $defaultsettings['spfnc_twitter_tpl_cfg_chopend'] = ' ... ';
    $defaultsettings['spfnc_twitter_url'] = '{baseurl}index.php?idcatside=&lang={idlang}&idarticle={idarticle}';
    $defaultsettings['spfnc_twitter_lastsent_data_cf'] = '';
    $defaultsettings['spfnc_twitter_lastsent_date_cf'] = '';
    $defaultsettings['spfnc_twitter_url_man'] = '';
    $defaultsettings['spfnc_twitter_ckey'] = '';
    $defaultsettings['spfnc_twitter_csecret'] = '';
    $defaultsettings['spfnc_twitter_pin'] = '';


    $defaultsettings['new_articles_online'] = 'false';
    $defaultsettings['new_articles_lang_copy'] = 'true';
    $defaultsettings['del_all_lang_copies'] = 'true';

    $defaultsettings['lv_show_search'] = 'true';
    $defaultsettings['lv_show_range'] = 'true';
    $defaultsettings['lv_show_catfilter'] = 'true';
    $defaultsettings['lv_show_datetime'] = 'true';
    $defaultsettings['lv_show_onoffline'] = 'true';

    $defaultsettings['lv_sorting'] = 'startdate > DESC
starttime > DESC 
enddate > DESC
endtime >DESC
created > DESC
title > ASC';

    $defaultsettings['lv_customfilter'] = '';

    $defaultsettings['lv_fields'] = 'title';

		$defaultsettings['link_show_title_input'] = 'true';	
		$defaultsettings['link_select_idcats'] = '';	
		$defaultsettings['link_select_subcats'] = 'true';
		$defaultsettings['link_select_startpages'] = 'true';
		$defaultsettings['link_select_choosecats'] = 'true';
		$defaultsettings['link_select_showpages'] = 'true';

		for ($i=1;$i<36;$i++) {
    	$defaultsettings['article_custom'.$i.'_label'] = '';
    	$defaultsettings['article_custom'.$i.'_alias'] = '';
    	$defaultsettings['article_custom'.$i.'_validation'] = 'false';
			$defaultsettings['article_custom'.$i.'_sortindex'] = 60+($i*10);
			$defaultsettings['article_custom'.$i.'_type'] = 'text';
			$defaultsettings['article_custom'.$i.'_validation_rule_text'] = '"Nicht leer"';
			$defaultsettings['article_custom'.$i.'_validation_rule_regexp'] = '/./';
			$defaultsettings['article_custom'.$i.'_select_values'] = 'Value 1'."\n".'Value 2'."\n".'Value n'."\n";
			$defaultsettings['article_custom'.$i.'_value'] = '';
			$defaultsettings['article_custom'.$i.'_vmode'] = '';
			$defaultsettings['article_custom'.$i.'_value_default_select'] = '';
			$defaultsettings['article_custom'.$i.'_multi_select'] = 'false';

			$defaultsettings['article_custom'.$i.'_link_desc'] = 'false';
			$defaultsettings['article_custom'.$i.'_file1_desc'] = 'false';
			$defaultsettings['article_custom'.$i.'_picture1_desc'] = 'false';
			$defaultsettings['article_custom'.$i.'_picture1_link'] = 'false';
			$defaultsettings['article_custom'.$i.'_date_desc'] = 'false';

	    $defaultsettings['article_custom'.$i.'_picture_select_folders'] = '';
	    $defaultsettings['article_custom'.$i.'_picture_select_subfolders'] = 'true';
	    $defaultsettings['article_custom'.$i.'_picture_upload'] = 'false';
	    $defaultsettings['article_custom'.$i.'_picture_upload_folders'] = '';

	    $defaultsettings['article_custom'.$i.'_file_select_folders'] = '';
	    $defaultsettings['article_custom'.$i.'_file_select_subfolders'] = 'true';
	    $defaultsettings['article_custom'.$i.'_file_select_filetypes'] = '';
	    $defaultsettings['article_custom'.$i.'_file_upload'] = 'false';
	    $defaultsettings['article_custom'.$i.'_file_upload_folders'] = '';
	
			$defaultsettings['article_custom'.$i.'_link_show_title_input'] = 'true';	
			$defaultsettings['article_custom'.$i.'_link_select_idcats'] = '';	
			$defaultsettings['article_custom'.$i.'_link_select_subcats'] = 'true';
			$defaultsettings['article_custom'.$i.'_link_select_startpages'] = 'true';
			$defaultsettings['article_custom'.$i.'_link_select_choosecats'] = 'true';
			$defaultsettings['article_custom'.$i.'_link_select_showpages'] = 'true';
		}

		$defaultsettings['article_text'] = 'true';
		$defaultsettings['article_teaser'] = 'false';
    $defaultsettings['article_file1'] = 'false';
		$defaultsettings['article_picture1'] = 'false';
		$defaultsettings['article_link'] = 'false';
		$defaultsettings['article_date'] = 'false';

		$defaultsettings['article_text_label'] = '';
		$defaultsettings['article_teaser_label'] = '';
    $defaultsettings['article_file1_label'] = '';
		$defaultsettings['article_picture1_label'] = '';
		$defaultsettings['article_link_label'] = '';
		$defaultsettings['article_date_label'] = '';
		
		$defaultsettings['article_link_desc'] = 'false';
		$defaultsettings['article_file1_desc'] = 'false';
		$defaultsettings['article_picture1_desc'] = 'false';
		$defaultsettings['article_picture1_link'] = 'false';
		$defaultsettings['article_date_desc'] = 'false';
		$defaultsettings['article_date_time'] = 'false';
		$defaultsettings['article_date_duration'] = 'false';

		$defaultsettings['article_link_no'] = '0';
		$defaultsettings['article_file1_no'] = '0';
		$defaultsettings['article_picture1_no'] = '0';
		$defaultsettings['article_date_no'] = '0';

		$defaultsettings['article_file_upload'] = 'false';
		$defaultsettings['article_picture_upload'] = 'false';
		$defaultsettings['article_file_upload_folders'] = '';
		$defaultsettings['article_picture_upload_folders'] = '';
		
		$defaultsettings['article_teaser_sortindex'] = '10';
		$defaultsettings['article_text_sortindex'] = '20';
    $defaultsettings['article_file1_sortindex'] = '40';
		$defaultsettings['article_picture1_sortindex'] = '30';
		$defaultsettings['article_link_sortindex'] = '50';
		$defaultsettings['article_date_sortindex'] = '60';
		
		$defaultsettings['article_teaser_validation'] = 'false';
		$defaultsettings['article_text_validation'] = 'true';
    $defaultsettings['article_file1_validation'] = 'false';
		$defaultsettings['article_picture1_validation'] = 'false';
		$defaultsettings['article_link_validation'] = 'false';
		$defaultsettings['article_date_validation'] = 'false';

		$defaultsettings['article_teaser_validation_rule_text'] = '"Nicht leer"';
		$defaultsettings['article_text_validation_rule_text'] = '"Nicht leer"';
    $defaultsettings['article_file1_validation_rule_text'] = '"Nicht leer"';
		$defaultsettings['article_picture1_validation_rule_text'] = '"Nicht leer"';
		$defaultsettings['article_link_validation_rule_text'] = '"Nicht leer"';
		$defaultsettings['article_date_validation_rule_text'] = '"Nicht leer"';

		$defaultsettings['article_teaser_validation_rule_regexp'] = '/./';
		$defaultsettings['article_text_validation_rule_regexp'] = '/./';
    $defaultsettings['article_file1_validation_rule_regexp'] = '/./';
		$defaultsettings['article_picture1_validation_rule_regexp'] = '/./';
		$defaultsettings['article_link_validation_rule_regexp'] = '/./';
		$defaultsettings['article_date_validation_rule_regexp'] = '/./';


    //Mögliche Auswahl für das "Anzahl Artikele"-Selectfeld
    $number_of_month = array(1, 2, 3, 6, 12, 24, -1);

    //Mögliche Auswahl für das Turnus-Selectfeld
    $turnus = array(0, 1, 2, 3, 4, 5);

    //Sprachen die unter lang/SPRACHE.php vorhanden sind
    $languages = array('deutsch','english');

    //Skins die unter tpl/SKIN/ vorhanden sind
    $skins = array('standard');

    //Anzeige des Artikelsystems
    $display['per_page'] = 30;
    $display['date'] = "d.m.Y";
    $display['time'] = "H:i";

?>
