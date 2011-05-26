<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');
}

if (empty($_AS['topic']))
	$_AS['topic'] = 'Article';

$plug_lang['area'] =  'Editorial';
$plug_lang['area_article'] =  $_AS['topic'];
$plug_lang['area_archive'] =  $_AS['topic'].' Archive';
$plug_lang['area_category'] =  'Category';
$plug_lang['area_settings'] =  'Settings';

$plug_lang['action_show_article'] =  $_AS['topic'].' Overview';
$plug_lang['action_show_archive'] =  'Archive Overview';
$plug_lang['action_show_category'] =  'Category Management';
$plug_lang['action_show_settings'] =  'Settings';
$plug_lang['action_new_article'] =  'New';
$plug_lang['action_edit_article'] =  'Edit';
$plug_lang['action_dupl_article'] =  'Duplicate';

$plug_lang['new'] =  'New';
$plug_lang['back'] =  'Back';
$plug_lang['saveback'] =  'Save And Back';
$plug_lang['saveback2'] =  'Done';
$plug_lang['save'] =  'Save';
$plug_lang['cancel'] =  'Cancel';
$plug_lang['foralllangs'] =  'For All Languages';
$plug_lang['dupl'] =  'Duplicate';
$plug_lang['create'] =  'Create';
$plug_lang['yes'] =  'Yes';
$plug_lang['no'] =  'No';
$plug_lang['active'] =  'Active';
$plug_lang['nonactive'] =  'Not Active';
$plug_lang['question_delete'] =  'Delete?';
$plug_lang['question_reset'] =  'Reset?';
$plug_lang['question_dearchive'] = 'De-Archiving?';
$plug_lang['question_archive'] = 'Archiving?';
$plug_lang['revert_selection'] =  'Revert Selection';
$plug_lang['delete_selected'] =  'Delete Selected';
$plug_lang['upload'] =  'Upload';

$plug_lang['js_get_title1']="Adjust Title?";
$plug_lang['js_get_title2']="Get Title from URL?";

$plug_lang['all'] =  'All';
$plug_lang['nothing_found'] =  'No Item Found.';
$plug_lang['found_error'] =  'Wrong Input!\n Check The Form!';

$plug_lang['showrange'] =  'Time Range';
$plug_lang['prev'] =  '‹‹‹';
$plug_lang['next'] =  '›››';
$plug_lang['add'] =  'add';

$plug_lang['start'] =  'Available From';
$plug_lang['end'] =  'Available To';
$plug_lang['created'] =  'Created';
$plug_lang['title'] =  'Title';
$plug_lang['current'] =  'Current';
$plug_lang['turnus'] =  'Turnus';
$plug_lang['actions'] =  'Action';
$plug_lang['switch_online'] =  'Switch To Online';
$plug_lang['switch_offline'] =  'Switch To Offline';
$plug_lang['switch_archive'] =  'Archiving';
$plug_lang['switch_dearchive'] =  'De-Archiving';
$plug_lang['edit'] =  'Edit';
$plug_lang['delete'] =  'Delete';
$plug_lang['notdeletable'] =  'Not Deletable!';
$plug_lang['hour'] =  ' O\'Clock';
$plug_lang['search'] =  'Search';
$plug_lang['sort_index_input_title'] =  'Sorting Index';


$plug_lang['category_filter']  =  'Filter Category';
$plug_lang['filter']  =  'filter';

$plug_lang['weekday_1'] =  'Monday';
$plug_lang['weekday_2'] =  'Tuesday';
$plug_lang['weekday_3'] =  'Wednesday';
$plug_lang['weekday_4'] =  'Thursday';
$plug_lang['weekday_5'] =  'Friday';
$plug_lang['weekday_6'] =  'Saturday';
$plug_lang['weekday_7'] =  'Sunday';

$plug_lang['month_1'] =  'January';
$plug_lang['month_2'] =  'February';
$plug_lang['month_3'] =  'March';
$plug_lang['month_4'] =  'April';
$plug_lang['month_5'] =  'May';
$plug_lang['month_6'] =  'June';
$plug_lang['month_7'] =  'July';
$plug_lang['month_8'] =  'August';
$plug_lang['month_9'] =  'September';
$plug_lang['month_10'] =  'October';
$plug_lang['month_11'] =  'November';
$plug_lang['month_12'] =  'December';

$plug_lang['day'] =  'Day';
$plug_lang['day_plural'] =  'Days';
$plug_lang['month'] =  'Month';
$plug_lang['month_plural'] =  'Months';
$plug_lang['year'] =  'Year';
$plug_lang['year_plural'] =  'Years';

$plug_lang['settings_admin_delete']='Remove in Current Project';
$plug_lang['settings_admin_delete_confirm1']='This Articlesystem ---> {dbstr}\n and all data IN THE CURRENT PROJECT will be REMOVED?';
$plug_lang['settings_admin_delete_confirm2']='This operation cant be undone!\n\n Continue?';
$plug_lang['settings_admin_delete2']='Remove Completely';
$plug_lang['settings_admin_delete2_confirm1']='This Articlesystem ---> {dbstr}\n and all data IN ALL PROJECTS will be REMOVED?';
$plug_lang['settings_admin_new_backend']='Install in Current Project';
$plug_lang['settings_admin_new']='Add New Database';
$plug_lang['settings_admin']='Articlesystem - Database And Installation Management';
$plug_lang['settings_admin_general']='Articlesystems';
$plug_lang['settings_admin_asdb']='DATENBASE (Articlesystem)';
$plug_lang['settings_admin_section_new_backend']='New Articlesystem For The Current Project';
$plug_lang['settings_admin_section_new_backend_title']='Menu-Titel In All Languages';
$plug_lang['settings_admin_section_new']='New Database';
$plug_lang['settings_admin_notice']='<strong>Important Notice:</strong><br/>Please note, that you have to remove all additional Articlesystems befor you uninstall the Articlesystem-Plugin itself!';


$plug_lang['settings_general'] =  'General Settings';
$plug_lang['settings_specialfunctions'] =  'Special Functions';
$plug_lang['settings_set_category'] =  'Activate categories for articles ?';
$plug_lang['settings_use_categories_rm'] =  'Assign categories to sergroups?';
$plug_lang['settings_set_category_multiple'] =  'Assign articles to multiple categories?';
$plug_lang['settings_use_archive'] =  'Activate archive for articles?';
$plug_lang['settings_show_articles_pages_dir'] =  'Page navigation in reverse order? ';

$plug_lang['settings_number_of_month'] =  'Backend list view "Time Range"';
$plug_lang['settings_number_of_entries'] =  'Backend list view "Article per Page"';
$plug_lang['settings_language'] =  'Userinterface language';
$plug_lang['settings_skin'] =  'Userinterface skin';
$plug_lang['settings_selectbox_all'] =  '--- All ---';
$plug_lang['settings_yes'] =  'Yes';
$plug_lang['settings_no'] =  'No';
$plug_lang['settings_active'] =  'Active';
$plug_lang['settings_nonactive'] =  'Inactiv';
$plug_lang['settings_wysiwyg'] =  'Use WYSIWYG for article\'s text?';
$plug_lang['settings_picture_select_folders'] = 'Image select - folder(s)';
$plug_lang['settings_picture_select_subfolders'] = 'Image select - subfolders';
$plug_lang['settings_file_select_folders'] = 'File select - folder(s)';
$plug_lang['settings_file_select_subfolders'] = 'File select - subfolders';
$plug_lang['settings_file_select_filetypes'] = 'File select - file types';
$plug_lang['settings_new_articles_online'] = 'Set "Article is online" per default on creating a new article?';
$plug_lang['settings_new_articles_lang_copy'] = 'Create article duplicates in all other languages on creating a new article?';
$plug_lang['settings_global_settings'] = 'Sprachübergreifendes Speichern der Einstellungen?';
$plug_lang['settings_del_all_lang_copies'] = 'Delete article in all languages?';

$plug_lang['settings_link_show_title_input'] = 'Links - Link title?';	
$plug_lang['settings_link_select_idcats'] = 'Links (int. pages) - categories <br/><small>(separate multiple idcats with comma. No value = all selectable.)</small>';	
$plug_lang['settings_link_select_subcats'] = 'Links (int. pages) - show sub-categories?';
$plug_lang['settings_link_select_startpages'] = 'Links (int. pages) - show start pages?';
$plug_lang['settings_link_select_showpages'] = 'Links (int. pages) - show pages?';
$plug_lang['settings_link_select_choosecats'] = 'Links (int. pages) - categories selectable?';

$plug_lang['settings_lv_show_search'] = 'Show search-box in article\'s overview?';
$plug_lang['settings_lv_show_range'] = 'Show time range in article\'s overview?';
$plug_lang['settings_lv_show_catfilter'] = 'Show category select in article\'s overview?';
$plug_lang['settings_lv_customfilter'] = 'Free definable fields filter in article\'s overview <br/><small><strong>DATA FIELD(S) one below the order</strong><br/><br/>custom1-35</small>';
$plug_lang['settings_lv_show_datetime'] = 'Show availablity in article\'s overview?';
$plug_lang['settings_lv_show_onoffline'] = 'Show online/offline in article\'s overview?';
$plug_lang['settings_lv_sorting'] = 'Sorting of the article fields in the overview<br/><small><strong>DATA FIELD </strong>(see below) > <strong>SORTING</strong> (ASC = ascending, DESC = descending)<br/><br/>startdate starttime enddate endtime created lastedit title teaser text custom1-35</small>';
$plug_lang['settings_lv_fields'] = 'Article fields to show in the overview <br/><small><strong>DATA FIELD(S) one below the order</strong><br/><br/>title teaser text custom1-35</small>';

$plug_lang['settings_backend_menu_string'] = 'Title for Sefrengo\'s backend menu item';

for ($i=1;$i<36;$i++){
	$plug_lang['article_settings_custom'.$i] =  'Free definable field '.$i;
	$plug_lang['article_custom'.$i] =  'Free def. field '.$i;
}
$plug_lang['article_settings_custom_label'] =  'Title<small> (empty = inactive)</small>';
$plug_lang['article_settings_custom_alias'] =  'Element\'s-Alias';
$plug_lang['article_settings_custom_type'] =  'Type';
$plug_lang['article_settings_custom_validation'] =  'Validation';
$plug_lang['article_settings_custom_values'] =  'Values <small>(one line = one value - alternate: value||label)<br/><br/>On check- & radiobox, every value / every line creates a new option to select!</small>';
$plug_lang['article_settings_custom_value'] =  'Value';
$plug_lang['article_settings_custom_value_default'] =  'Default value for new articles';
$plug_lang['article_settings_custom_value_default_select'] = 'Preselected values (one line = onve value - like above)';
$plug_lang['article_settings_custom_multi_select'] = 'Multiple selection';
$plug_lang['article_settings_custom_vmode_defcopy']='Set default value on article duplication';
$plug_lang['article_settings_custom_vmode']='Element\'s value behaviour';

$plug_lang['article_settings_elements'] =  'Article Elements';
$plug_lang['article_settings_general'] =  'General Element Options';
$plug_lang['article_settings_elements_options'] =  'Element options';
$plug_lang['article_settings_elements_active'] =  'Active / Inactive';
$plug_lang['article_settings_elements_validation'] =  'Validation';
$plug_lang['article_settings_element_label'] ='Title <small>(optional)</small>';
$plug_lang['article_settings_files'] ='File(s)';
$plug_lang['article_settings_file_upload'] = 'File upload';
$plug_lang['article_settings_file_upload_folders'] = 'File upload - folder(s)';
$plug_lang['article_settings_pictures'] ='Image(s)';
$plug_lang['article_settings_picture_upload'] = 'Image upload';
$plug_lang['article_settings_picture_upload_folders'] = 'Image upload - folder(s)';
$plug_lang['article_settings_links'] ='Link(s)';
$plug_lang['article_settings_dates'] ='Date(s)';
$plug_lang['article_settings_dates_duration'] ='Duration';
$plug_lang['article_settings_dates_time'] ='Time';
$plug_lang['article_settings_desc_input'] ='Description';
$plug_lang['article_settings_default_values'] ='Default values';
$plug_lang['article_settings_link_input'] ='Image link';
$plug_lang['article_settings_no_input'] ='Number <small>(0 = no limitation)</small>';
$plug_lang['article_settings_max_number_files_select'] ='Max. number of items for selecting files or image via selectboxes';
$plug_lang['article_settings_max_number_use_rb'] ='Please use [ ... ] to select';




$plug_lang['article_settings_text'] ='Text';
$plug_lang['article_settings_teaser'] ='Teaser';

$plug_lang['category'] =  'Category';
$plug_lang['category_delete'] =  'Delete Category?';
$plug_lang['category_create'] =  'New Category';

$plug_lang['article_elements_sel'] =  'Delete';
$plug_lang['article_elements_del'] =  'Selection';

$plug_lang['article_langcopyfrom'] =  'Get Contents From Language ...';
$plug_lang['article_online'] =  'Online';
$plug_lang['article_online_desc'] =  'Article Is Online';
$plug_lang['article_article_start'] =  'Available from';
$plug_lang['article_article_end'] =  'Available to';
$plug_lang['article_article_weekday'] =  'Article Weekday';
$plug_lang['article_category'] =  'Category';
$plug_lang['article_title'] =  'Title';
$plug_lang['article_teaser'] =  'Teaser';
$plug_lang['article_text'] =  'Text';
$plug_lang['article_pictures'] =  'Picture(s)';
$plug_lang['article_picture'] =  'Picture';
$plug_lang['article_picture_link'] =  'Link';
$plug_lang['article_picture1_description'] =  'Description';
$plug_lang['article_picture_upload'] =  'Picture-Upload';
$plug_lang['article_picture1_title'] =  'Title';
$plug_lang['article_links'] =  'Link(s)';
$plug_lang['article_link_url'] =  'Link-URL';
$plug_lang['article_link_title'] =  'Title';
$plug_lang['article_link_description'] =  'Description';
$plug_lang['article_dates'] =  'Date(s)';
$plug_lang['article_date_date'] =  'Date';
$plug_lang['article_date_time'] =  'Time';
$plug_lang['article_date_duration'] =  'Duration';
$plug_lang['article_date_title'] =  'Title';
$plug_lang['article_date_description'] =  'Description';

$plug_lang['article_files'] =  'File(s)';
$plug_lang['article_file'] =  'File';
$plug_lang['article_file_upload'] =  'File-Upload';
$plug_lang['article_file1_title'] =  'Title';
$plug_lang['article_file1_description'] =  'Description';
$plug_lang['article_non_selected_string'] =  '--- Selection ---';
$plug_lang['article_copy'] =  'Copy';

$plug_lang['article_settings_custom_type_text']='Single line text field';
$plug_lang['article_settings_custom_type_textarea']='Text field';
$plug_lang['article_settings_custom_type_wysiwyg']='Text field (WYSIWYG)';
$plug_lang['article_settings_custom_type_select']='Value seletion';
$plug_lang['article_settings_custom_type_select2']='Value selection and input';
$plug_lang['article_settings_custom_type_check']='Checkbox';
$plug_lang['article_settings_custom_type_radio']='Radio';
$plug_lang['article_settings_custom_type_date']='Date';
$plug_lang['article_settings_custom_type_time']='Time';
$plug_lang['article_settings_custom_type_pic']='Image';
$plug_lang['article_settings_custom_type_file']='File';
$plug_lang['article_settings_custom_type_link']='Link';
$plug_lang['article_settings_custom_type_info']='Info text (no input)';


$plug_lang['article_error_to_small_enddate'] =  'End date is below the start date.';
$plug_lang['article_error_to_small_endtime'] =  'End time is below the start time.';
$plug_lang['article_error_title_empty'] =  'No title.';
$plug_lang['article_error_text_empty'] =  'No text.';
$plug_lang['article_error_empty_field'] =  'Required!';

$plug_lang['article_settings_valid_true'] =  'Not empty';
$plug_lang['article_settings_valid_false'] =  'None';
$plug_lang['article_settings_valid_regexp'] =  'RegExp';
$plug_lang['article_settings_valid_settings'] =  'Validation settings';
$plug_lang['article_settings_valid_errmsg'] =  'Error messages';
$plug_lang['article_settings_valid_regexp'] =  'Reg.-Expressions';


$plug_lang['module_artsel_archived'] =  'arc';
$plug_lang['module_artsel_offline'] =  'off';
$plug_lang['module_artsel_online'] =  'on';


$plug_lang['err_0703'] = 'No Upload Possible.';
$plug_lang['err_0705'] = 'Wrong Filetype.';
$plug_lang['err_0706'] = 'No Target-Directory Found.';
$plug_lang['err_1421'] = 'Upload failed!';
$plug_lang['err_1420'] = 'Wrong Characters Within The Filename!';
$plug_lang['err_1424'] = $plug_lang['err_1421'] . ' File Couldn\' Be Written Into The Choosen Directory!';
$plug_lang['err_1423'] = 'Upload Successfully But Database-Operation Failed!';


$plug_lang['spfnc_publish'] = 'Publish'; 
$plug_lang['spfnc_facebook_section'] = 'facebook-Publishing';
$plug_lang['spfnc_facebook_manualsentconfirm'] = 'Successfully published?';
$plug_lang['spfnc_facebook'] = 'Activate functionality';
$plug_lang['spfnc_facebook_app_key'] = 'Application API-key';
$plug_lang['spfnc_facebook_tpl'] = 'Description Template<small><br/><br/><strong>Please note:</strong><br/>Max. length for the description = 1000 characters. Line breaks will be ignored.<br/><br/>It\'s possible to use all article elements (more information within the Articlesystem output module),<br/>except {images} {files} {links} {dates}.</small>';
$plug_lang['spfnc_facebook_tpl_cfg_time'] = '<small>Time Format (for template\s elements)</small>';
$plug_lang['spfnc_facebook_tpl_cfg_date'] = '<small>Date format (for template\s elements)</small>';
$plug_lang['spfnc_facebook_tpl_cfg_chopmaxlength'] = ' <small>Length for text shortening {chop}{/chop}</small>';
$plug_lang['spfnc_facebook_tpl_cfg_chopend'] = '<small>String at the end of the shortened text</small>';
$plug_lang['spfnc_facebook_lastsent_data_cf'] = 'Free def. field to save the last published description';
$plug_lang['spfnc_facebook_lastsent_date_cf'] = 'Free def. field to save the last publishing date';
$plug_lang['spfnc_facebook_media'] = 'Media file';
$plug_lang['spfnc_facebook_url'] = 'Article\'s link-URL-template <br/><small>Possible elements: {baseurl}, {idlang}, {idarticle}, {idcategory}</small>';
$plug_lang['spfnc_facebook_url_name'] = 'Article\'s link title';
$plug_lang['spfnc_facebook_url_caption'] = 'Article\'s link description' ;
$plug_lang['spfnc_facebook_url_man'] = 'Free link-URL <small>for use if no link to the article should be generated/used</small>';


$plug_lang['spfnc_twitter_section'] = 'twitter-Publishing';
$plug_lang['spfnc_twitter'] = 'Activate functionality';
$plug_lang['spfnc_twitter_ckey'] = 'Application consumer key <small>(<a href="http://twitter.com/apps/new" onclick="void(window.open(this.href, \'\', \'\')); return false;">registration</a>)</small>';
$plug_lang['spfnc_twitter_csecret'] = 'Application consumer secret';
$plug_lang['spfnc_twitter_pin_empty'] = 'PIN (<a href="{url}" onclick="void(window.open(this.href, \'\', \'\')); return false;">generate</a> PIN)';
$plug_lang['spfnc_twitter_pin'] = 'PIN';
$plug_lang['spfnc_twitter_tpl'] = 'Contents template <small><br/><br/><strong>Please note:</strong><br/>Max. length for the contents = 140 characters.<br/>Use the element {url} for a link within your contents-<br/>The element {url} should not be included in the text shortening element {chop}{/chop}.<br/><br/>It\'s possible to use all article elements (more information within the Articlesystem output module),<br/>except {images} {files} {links} {dates}.';
$plug_lang['spfnc_twitter_tpl_cfg_time'] = '<small>Time Format (for template\s elements)</small>';
$plug_lang['spfnc_twitter_tpl_cfg_date'] = '<small>Date format (for template\s elements)</small>';
$plug_lang['spfnc_twitter_tpl_cfg_chopmaxlength'] = ' <small>Length for text shortening {chop}{/chop}</small>';
$plug_lang['spfnc_twitter_tpl_cfg_chopend'] = '<small>String at the end of the shortened text</small>';
$plug_lang['spfnc_twitter_lastsent_data_cf'] = 'Free def. field to save the last published description';
$plug_lang['spfnc_twitter_lastsent_date_cf'] = 'Free def. field to save the last publishing date';
$plug_lang['spfnc_twitter_url'] = 'Article\'s link-URL-template <br/><small>Possible elements: {baseurl}, {idlang}, {idarticle}, {idcategory}</small>';
$plug_lang['spfnc_twitter_url_man'] = 'Free link-URL <small>for use if no link to the article should be generated/used</small>';



?>
