<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');
}

//collectionklasse laden
include_once $_AS['basedir'] . 'inc/class.valuecollection.php';

//Externe Variablen per CMS WebRequest holen
$_AS['settings'] = $_AS['cms_wr']->getVal('settings');
$_AS['element'] = $_AS['cms_wr']->getVal('element');
if (strpos($_AS['element'],'custom')!==false)
	$_AS['element']=$_AS['element'].'_';
//catcol intialisieren
$_AS['catcol'] = new ValueCollection();
//Einträge laden
$_AS['catcol']->generate();

//Tpl einladen
include_once $_AS['basedir'] . 'tpl/'.$_AS['article_obj']->getSetting('skin').'/tpl.settings_head.php';
include_once $_AS['basedir'] . 'tpl/'.$_AS['article_obj']->getSetting('skin').'/tpl.article_settings_list.php';

//
// article settings
//
$_AS['output']['body'] = '';
$_AS['output']['temp2']=array();
$_AS['temp']=array();
$_AS['temp']['sortindex']=array();

// get and save sort index
for($iter = $_AS['catcol']->get(); $iter->valid(); $iter->next() ) {

$_AS['item'] =& $iter->current();

	if(strpos($_AS['item']->getDataByKey('key2'),$_AS['element'])!==false &&
	   strpos($_AS['item']->getDataByKey('key2'),'sortindex')!==false) {
	
		if(is_array($_POST['settings']) &&
		   $_POST['action']=='save_article_element_settings' && 
			 $_AS['settings'][$_AS['item']->getDataByKey('key2')]) {
				$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
				
				$_AS['item']->save();
		}		
		$_AS['temp']['sortindex'][str_replace('_sortindex','',$_AS['item']->getDataByKey('key2'))]=$_AS['item']->getDataByKey('value');
		$_AS['temp'][$_AS['item']->getDataByKey('key2')]= $_AS['item']->getDataByKey('value');
	}
}

// get and save label
for($iter = $_AS['catcol']->get(); $iter->valid(); $iter->next() ) {

$_AS['item'] =& $iter->current();

	if(strpos($_AS['item']->getDataByKey('key2'),$_AS['element'])!==false &&
		 strpos($_AS['item']->getDataByKey('key2'),'_label')!==false &&
		 strpos($_AS['item']->getDataByKey('key2'),'custom')===false) {
		
		if(is_array($_POST['settings']) && 
			 $_POST['action']=='save_article_element_settings' && 
			 $_AS['settings'][$_AS['item']->getDataByKey('key2')]) {
			 
				$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
				
				$_AS['item']->save();
		}		
		$_AS['temp']['label'][str_replace('_label','',$_AS['item']->getDataByKey('key2'))]=$_AS['item']->getDataByKey('value');
		$_AS['temp'][$_AS['item']->getDataByKey('key2')]= $_AS['item']->getDataByKey('value');
	}
}

// get and save validation
for($iter = $_AS['catcol']->get(); $iter->valid(); $iter->next() ) {

$_AS['item'] =& $iter->current();

	if(strpos($_AS['item']->getDataByKey('key2'),$_AS['element'])!==false &&
		 strpos($_AS['item']->getDataByKey('key2'),'validation')!==false) {

		if(is_array($_POST['settings']) &&
			 $_POST['action']=='save_article_element_settings' && 
			 $_AS['settings'][$_AS['item']->getDataByKey('key2')]) {
			 
				$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
				$_AS['item']->save();
		}		
	
		$_AS['temp'][$_AS['item']->getDataByKey('key2')]= $_AS['item']->getDataByKey('value');
	}
}
// get and save desc
for($iter = $_AS['catcol']->get(); $iter->valid(); $iter->next() ) {

$_AS['item'] =& $iter->current();

	if(strpos($_AS['item']->getDataByKey('key2'),$_AS['element'])!==false &&
		 strpos($_AS['item']->getDataByKey('key2'),'desc')!==false) {
		
		if(is_array($_POST['settings']) && 
			 $_POST['action']=='save_article_element_settings' && 
			 $_AS['settings'][$_AS['item']->getDataByKey('key2')]) {
			 
				$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
				$_AS['item']->save();
		}		
	
		$_AS['temp'][$_AS['item']->getDataByKey('key2')]= $_AS['item']->getDataByKey('value');
	}
}

// get and save add option
for($iter = $_AS['catcol']->get(); $iter->valid(); $iter->next() ) {

$_AS['item'] =& $iter->current();

	if(strpos($_AS['item']->getDataByKey('key2'),$_AS['element'])!==false &&
		 strpos($_AS['item']->getDataByKey('key2'),'link')!==false && 
		 strpos($_AS['item']->getDataByKey('key2'),'link_')===false) {

		if(is_array($_POST['settings']) && 
			 $_POST['action']=='save_article_element_settings' && 
			 $_AS['settings'][$_AS['item']->getDataByKey('key2')]) {
			 
				$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
				$_AS['item']->save();
		}		
	
		$_AS['temp'][$_AS['item']->getDataByKey('key2')]= $_AS['item']->getDataByKey('value');
	}
}

// get and save add option
for($iter = $_AS['catcol']->get(); $iter->valid(); $iter->next() ) {

$_AS['item'] =& $iter->current();

	if(strpos($_AS['item']->getDataByKey('key2'),$_AS['element'])!==false &&
		 strpos($_AS['item']->getDataByKey('key2'),'no')!==false) {
		
		if(is_array($_POST['settings']) && $_POST['action']=='save_article_element_settings') {
			if ($_AS['settings'][$_AS['item']->getDataByKey('key2')]>=0) {
			
				$_AS['item']->setData('value', (int) $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
				$_AS['item']->save();
			}
		}		
	
		$_AS['temp'][$_AS['item']->getDataByKey('key2')]= $_AS['item']->getDataByKey('value');
	}
}


// get and save add options
foreach (array(	'date_time',
								'date_duration',
								'wysiwyg',
								'picture_select_subfolders',
								'file_select_subfolders',
								'wysiwyg_picture_select_subfolders',
								'wysiwyg_file_select_subfolders',
								'file_upload',
								'article_file_upload',
								'picture_upload',
								'link_show_title_input',
								'link_select_idcats',
								'link_select_subcats',
								'link_select_startpages',
								'link_select_choosecats',
								'link_select_showpages') as $vv)	{
	for($iter = $_AS['catcol']->get(); $iter->valid(); $iter->next() ) {

	$_AS['item'] =& $iter->current();

		if((strpos($_AS['item']->getDataByKey('key2'),$_AS['element'])!==false &&
		    strpos($_AS['item']->getDataByKey('key2'),$vv)!==false) ||
		   ($_AS['item']->getDataByKey('key2')==$vv && 
		    strpos($_AS['item']->getDataByKey('key2'),str_replace('1','',$_AS['element']))!==false ) ||
		   (strpos($vv,'wysiwyg')!==false && $_AS['element']=='text' ) ) {
#		   ($_AS['item']->getDataByKey('key2')=='wysiwyg' && $_AS['element']=='text' ) ) {

			if(is_array($_POST['settings']) && $_POST['action']=='save_article_element_settings') {

				if ($_AS['settings'][$_AS['item']->getDataByKey('key2')]) {
				
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
				}
			}		
		
			$_AS['temp'][$_AS['item']->getDataByKey('key2')]= $_AS['item']->getDataByKey('value');

		}
	}

	}

// get and save add options
foreach (array(	'picture_select_folders',
								'picture_upload_folders',
								'file_select_folders',
								'file_select_filetypes',
								'file_upload_folders',
								'article_file_upload_folders',
								'wysiwyg_picture_select_folders',
								'wysiwyg_file_select_folders',
								'wysiwyg_file_select_filetypes' ) as $vv)	
	for($iter = $_AS['catcol']->get(); $iter->valid(); $iter->next() ) {

	$_AS['item'] =& $iter->current();

		if((strpos($_AS['item']->getDataByKey('key2'),$_AS['element'])!==false &&
				strpos($_AS['item']->getDataByKey('key2'),$vv)!==false) ||
		   ($_AS['item']->getDataByKey('key2')==$vv &&
		    strpos($_AS['item']->getDataByKey('key2'),str_replace('1','',$_AS['element']))!==false)  ||
		   (strpos($vv,'wysiwyg')!==false && $_AS['element']=='text' ) ) {			 

			if((is_array($_POST['settings'][$_AS['item']->getDataByKey('key2')])) && $_POST['action']=='save_article_element_settings') {
				if ($_AS['settings'][$_AS['item']->getDataByKey('key2')]) {	

				$_AS['item']->setData('value', implode(',',$_POST['settings'][$_AS['item']->getDataByKey('key2')]));
					$_AS['item']->save();
				}
			}		
		
			$_AS['temp'][$_AS['item']->getDataByKey('key2')]= $_AS['item']->getDataByKey('value');
		}
	}


//Für jeden geladenenen Eintrag durchlaufen
for($iter = $_AS['catcol']->get(); $iter->valid(); $iter->next() ) {
//Aktuellen Eintrag als Objekt bereitstellen
$_AS['item'] =& $iter->current();

//teaser on/off
if(strpos($_AS['item']->getDataByKey('key2'),$_AS['element'])!==false && $_AS['item']->getDataByKey('key2') == 'article_teaser') {

	if(is_array($_POST['settings']) && $_POST['action']=='save_article_element_settings') {
			# echo $_AS['item']->getDataByKey('key2')." - ".$_AS['settings'][$_AS['item']->getDataByKey('key2')]."<br>";
			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
			$_AS['item']->save();
	}		

		$_AS['output']['temp2'][$_AS['temp']['sortindex']['article_teaser']][] = str_replace(array(
					'{lng_descr}',
					'{select_element}',
					'{sortindex}',
					'{element}',
					'{element_sortindex}',
					'{select_element_validation}',
					'{add_option1}',
					'{add_option2}',
					'{lng_element_label}',
					'{element_label}',
					'{picture_select_folders_select}',
					'{picture_select_subfolders}',
					'{file_select_folders_select}',    	
					'{file_select_subfolders}',    	
					'{file_select_filetypes_select}',    
					'{file_upload_folders}',	
					'{link_show_title_input}',    	
					'{link_select_idcats}',    	
					'{link_select_subcats}',    	
					'{link_select_startpages}',    	
					'{link_select_showpages}',    	
					'{link_select_choosecats}'
			),
			array(
				$_AS['article_obj']->lang->get('article_settings_teaser'),
				$_AS['article_obj']->getSelectUni(	'settings[article_teaser]',
																						 $_AS['item']->getDataByKey('value'),
																						 array(	"true" =>$_AS['article_obj']->lang->get('settings_active'),
																						 				"false"=>$_AS['article_obj']->lang->get('settings_nonactive')),
																							"article_teaser"),
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_sortindex'],
				$_AS['item']->getDataByKey('key2'),
				$_AS['item']->getDataByKey('key2').'_sortindex',
				$_AS['article_obj']->getSelectUni(	'settings[article_teaser_validation]',
																						 $_AS['temp'][$_AS['item']->getDataByKey('key2').'_validation'],
																						 array(	'true' =>$_AS['article_obj']->lang->get('article_settings_valid_true'),
																						 				'false'=>$_AS['article_obj']->lang->get('article_settings_valid_false')),
																						'teaser_validation'),
																						'',
																						'',
				$_AS['article_obj']->lang->get('article_settings_element_label'),
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_label'],
				'',
				'',
				'',
				'',			
				'',			
				'',			
				'',			
				'',			
				'',			
				'',			
				''	
			 ),
		$_AS['tpl']['on_off_switches_elementsettings']);
		

}
//text on/off
if(strpos($_AS['item']->getDataByKey('key2'),$_AS['element'])!==false && $_AS['item']->getDataByKey('key2') == 'article_text') {

	if(is_array($_POST['settings']) && $_POST['action']=='save_article_element_settings') {
			# echo $_AS['item']->getDataByKey('key2')." - ".$_AS['settings'][$_AS['item']->getDataByKey('key2')]."<br>";
			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
			$_AS['item']->save();
	}		

	$selected_folders_s=$_AS['temp']['wysiwyg_picture_select_folders'];
	$selected_folders_p=explode(',',$selected_folders_s);

	$selected_folders_s=$_AS['temp']['wysiwyg_file_select_folders'];
	$selected_folders_f=explode(',',$selected_folders_s);
		
	$sql = "SELECT iddirectory, dirname FROM ".$cms_db['directory']." WHERE status < 4 AND idclient='$client' ORDER BY dirname";
	$db->query($sql);
	
	$_AS['tpl']['tempdata']=array();
	$_AS['tpl']['tempdata']['']=$_AS['article_obj']->lang->get('settings_selectbox_all');
	
	while ($db->next_record())
		$_AS['tpl']['tempdata'][$db->f('iddirectory')]=addslashes($db->f('dirname'));

	$selected_types_s=$_AS['temp']['wysiwyg_file_select_filetypes'];
	$selected_types=explode(',',$selected_types_s);

	$sql = "SELECT filetype, description FROM ". $cms_db['filetype'] ." ORDER BY filetype";							
	$db->query($sql);
	
	$_AS['tpl']['tempdata_ft']=array();
	$_AS['tpl']['tempdata_ft']['']=$_AS['article_obj']->lang->get('settings_selectbox_all');

	while ($db->next_record())
		$_AS['tpl']['tempdata_ft'][$db->f('filetype')]=addslashes($db->f('filetype').(($db->f('description')!='') ? ' ('.$db->f('description').')' : '' ));



		$_AS['output']['temp2'][$_AS['temp']['sortindex']['article_text']][] = str_replace(array(
					'{lng_descr}',
					'{select_element}',
					'{sortindex}',
					'{element}',
					'{element_sortindex}',
					'{select_element_validation}',
					'{add_option2}',
					'{add_option1}',
					'{lng_element_label}',
					'{element_label}',
					'{picture_select_folders_select}',
					'{picture_select_subfolders}',
					'{file_select_folders_select}',    	
					'{file_select_subfolders}',    	
					'{file_select_filetypes_select}',    
					'{file_upload_folders}',	
					'{link_show_title_input}',    	
					'{link_select_idcats}',    	
					'{link_select_subcats}',    	
					'{link_select_startpages}',    	
					'{link_select_showpages}',    	
					'{link_select_choosecats}'
			),
			array(
				$_AS['article_obj']->lang->get('article_settings_text'),
				$_AS['article_obj']->getSelectUni(	'settings[article_text]',
																						 $_AS['item']->getDataByKey('value'),
																						 array(	"true" =>$_AS['article_obj']->lang->get('settings_active'),
																						 				"false"=>$_AS['article_obj']->lang->get('settings_nonactive')),
																							"article_text"),
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_sortindex'],
				$_AS['item']->getDataByKey('key2'),
				$_AS['item']->getDataByKey('key2').'_sortindex',
				$_AS['article_obj']->getSelectUni(	'settings[article_text_validation]',
																						 $_AS['temp'][$_AS['item']->getDataByKey('key2').'_validation'],
																						 array(	'true' =>$_AS['article_obj']->lang->get('article_settings_valid_true'),
																						 				'false'=>$_AS['article_obj']->lang->get('article_settings_valid_false')),
																						'text_validation'),
				$_AS['article_obj']->lang->get('settings_wysiwyg').'&nbsp;'.
				$_AS['article_obj']->getSelectUni(	'settings[wysiwyg]',
																						 $_AS['temp']['wysiwyg'],
																						 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																						 				'false'=>$_AS['article_obj']->lang->get('no')),
																						''),
																						'',
				$_AS['article_obj']->lang->get('article_settings_element_label'),
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_label'],
				'<br/>'.$_AS['article_obj']->lang->get('settings_picture_select_folders').'<br/>'.
				$_AS['article_obj']->getSelectUni(	'settings[wysiwyg_picture_select_folders][]',
																						$selected_folders_p,
																						$_AS['tpl']['tempdata'],
																						'select_picture_select_folders',
																						'',
																						'multiple="multiple" size="5" style="font-family:verdana;width:300px;"').'<br/>',
				'<br/>'.$_AS['article_obj']->lang->get('settings_picture_select_subfolders').'<br/>'.
				$_AS['article_obj']->getSelectUni( 'settings[wysiwyg_picture_select_subfolders]',
																					 $_AS['temp']['wysiwyg_picture_select_subfolders'],
																					 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																					 				'false'=>$_AS['article_obj']->lang->get('no')),
																					'picture_desc').'<br/>',
				'<br/>'.$_AS['article_obj']->lang->get('settings_file_select_folders').'<br/>'.
				$_AS['article_obj']->getSelectUni(	'settings[wysiwyg_file_select_folders][]',
																						$selected_folders_f,
																						$_AS['tpl']['tempdata'],
																						'select_file_select_folders',
																						'',
																						'multiple="multiple" size="5" style="font-family:verdana;width:300px;"').'<br/>',			
				'<br/>'.$_AS['article_obj']->lang->get('settings_file_select_subfolders').'<br/>'.
				$_AS['article_obj']->getSelectUni( 'settings[wysiwyg_file_select_subfolders]',
																					 $_AS['temp']['wysiwyg_file_select_subfolders'],
																					 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																					 				'false'=>$_AS['article_obj']->lang->get('no')),
																					'picture_desc').'<br/>',			
				'<br/>'.$_AS['article_obj']->lang->get('settings_file_select_filetypes').'<br/>'.
				$_AS['article_obj']->getSelectUni(	'settings[wysiwyg_file_select_filetypes][]',
																						$selected_types,
																						$_AS['tpl']['tempdata_ft'],
																						'select_file_select_subfolders',
																						'',
																						'multiple="multiple" size="5" style="font-family:verdana;width:300px;"').'<br/>',	
				'',			
				'',			
				'',			
				'',			
				'',			
				''			
			 ),
		$_AS['tpl']['on_off_switches_elementsettings']);
		

}

//picture1 on/off
if(strpos($_AS['item']->getDataByKey('key2'),$_AS['element'])!==false && $_AS['item']->getDataByKey('key2') == 'article_picture1') {

	if(is_array($_POST['settings']) && $_POST['action']=='save_article_element_settings') {
			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
			$_AS['item']->save();
	}		

	$add_option1=	$_AS['article_obj']->lang->get('article_settings_desc_input').'&nbsp;'.
								$_AS['article_obj']->getSelectUni( 'settings[article_picture1_desc]',
																									 $_AS['temp'][$_AS['item']->getDataByKey('key2').'_desc'],
																									 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																									 				'false'=>$_AS['article_obj']->lang->get('no')),
																									'picture_desc').
								'<br/>'.
								$_AS['article_obj']->lang->get('article_settings_link_input').'&nbsp;'.
								$_AS['article_obj']->getSelectUni( 'settings[article_picture1_link]',
																									 $_AS['temp'][$_AS['item']->getDataByKey('key2').'_link'],
																									 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																									 				'false'=>$_AS['article_obj']->lang->get('no')),
																									'picture_link',
																									'',
																									'style="margin-top:2px;"');



	$selected_folders_s=$_AS['temp']['picture_select_folders'];
	$selected_folders=explode(',',$selected_folders_s);
	
	$sql = "SELECT iddirectory, dirname FROM ".$cms_db['directory']." WHERE status < 4 AND idclient='$client' ORDER BY dirname";
	$db->query($sql);
	
	
	$_AS['tpl']['tempdata']=array();
	$_AS['tpl']['tempdata']['']=$_AS['article_obj']->lang->get('settings_selectbox_all');
	
	while ($db->next_record())
		$_AS['tpl']['tempdata'][$db->f('iddirectory')]=addslashes($db->f('dirname'));

	$_AS['output']['temp2'][$_AS['temp']['sortindex']['article_picture1']][] = str_replace(array(
					'{lng_descr}',
					'{select_element}',
					'{sortindex}',
					'{element}',
					'{element_sortindex}',
					'{select_element_validation}',
					'{add_option1}',
					'{add_option2}',
					'{lng_element_label}',
					'{element_label}',
					'{picture_select_folders_select}',
					'{picture_select_subfolders}',
					'{file_select_folders_select}',    	
					'{file_select_subfolders}',    	
					'{file_select_filetypes_select}',    
					'{file_upload_folders}',	
					'{link_show_title_input}',    	
					'{link_select_idcats}',    	
					'{link_select_subcats}',    	
					'{link_select_startpages}',    	
					'{link_select_showpages}',    	
					'{link_select_choosecats}'
			),
			array(
				$_AS['article_obj']->lang->get('article_settings_pictures'),
				$_AS['article_obj']->getSelectUni(	'settings[article_picture1]',
																						 $_AS['item']->getDataByKey('value'),
																						 array(	"true" =>$_AS['article_obj']->lang->get('settings_active'),
																						 				"false"=>$_AS['article_obj']->lang->get('settings_nonactive')),
																							"article_picture1"),
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_sortindex'],
				$_AS['item']->getDataByKey('key2'),
				$_AS['item']->getDataByKey('key2').'_sortindex',
				$_AS['article_obj']->getSelectUni(	'settings[article_picture1_validation]',
																						 $_AS['temp'][$_AS['item']->getDataByKey('key2').'_validation'],
																						 array(	'true' =>$_AS['article_obj']->lang->get('article_settings_valid_true'),
																						 				'false'=>$_AS['article_obj']->lang->get('article_settings_valid_false')),
																						'picture1_validation'),
				$add_option1,
				$_AS['article_obj']->lang->get('article_settings_no_input').'&nbsp;'.
				'<input style="width:30px;" name="settings[article_picture1_no]" value="'.
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_no'].
				'"/>'.'<br/>',
				$_AS['article_obj']->lang->get('article_settings_element_label'),
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_label'],
				'<br/>'.$_AS['article_obj']->lang->get('settings_picture_select_folders').'<br/>'.
				$_AS['article_obj']->getSelectUni(	'settings[picture_select_folders][]',
																						$selected_folders,
																						$_AS['tpl']['tempdata'],
																						'select_picture_select_folders',
																						'',
																						'multiple="multiple" size="5" style="font-family:verdana;width:300px;"').'<br/>',
				'<br/>'.$_AS['article_obj']->lang->get('settings_picture_select_subfolders').'<br/>'.
				$_AS['article_obj']->getSelectUni( 'settings[picture_select_subfolders]',
																					 $_AS['temp']['picture_select_subfolders'],
																					 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																					 				'false'=>$_AS['article_obj']->lang->get('no')),
																					'picture_desc').'<br/>',
				'',			
				'',			
				'',	
				'',		
				'',			
				'',			
				'',			
				'',			
				''			
			 ),
		$_AS['tpl']['on_off_switches_elementsettings']);
}




//file1 on/off
if(strpos($_AS['item']->getDataByKey('key2'),$_AS['element'])!==false && $_AS['item']->getDataByKey('key2') == 'article_file1') {

	if(is_array($_POST['settings']) && $_POST['action']=='save_article_element_settings') {
			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
			$_AS['item']->save();
	}		

	$selected_folders_s=$_AS['temp']['file_select_folders'];
	$selected_folders=explode(',',$selected_folders_s);
				
	$sql = "SELECT iddirectory, dirname FROM ".$cms_db['directory']." WHERE status < 4 AND idclient='$client' ORDER BY dirname";
	$db->query($sql);
	
	$_AS['tpl']['tempdata']=array();
	$_AS['tpl']['tempdata']['']=$_AS['article_obj']->lang->get('settings_selectbox_all');

	while ($db->next_record())
		$_AS['tpl']['tempdata'][$db->f('iddirectory')]=$db->f('dirname');

	$selected_types_s=$_AS['temp']['file_select_filetypes'];

	$selected_types=explode(',',$selected_types_s);

	$sql = "SELECT filetype, description FROM ". $cms_db['filetype'] ." ORDER BY filetype";							
	$db->query($sql);
	
	$_AS['tpl']['tempdata_ft']=array();
	$_AS['tpl']['tempdata_ft']['']=$_AS['article_obj']->lang->get('settings_selectbox_all');

	while ($db->next_record())
		$_AS['tpl']['tempdata_ft'][$db->f('filetype')]=addslashes($db->f('filetype').(($db->f('description')!='') ? ' ('.$db->f('description').')' : '' ));


	$selected_upload_folders_s=$_AS['temp']['article_file_upload_folders'];
	$selected_upload_folders=explode(',',$selected_upload_folders_s);
	
	$sql = "SELECT iddirectory, dirname FROM ".$cms_db['directory']." WHERE status < 4 AND idclient='$client' ORDER BY dirname";
	$db->query($sql);
	
	
	$_AS['tpl']['tempdata']=array();
	$_AS['tpl']['tempdata']['']=$_AS['article_obj']->lang->get('settings_selectbox_all');
	$_AS['tpl']['tempdata_upl']['']=$_AS['article_obj']->lang->get('settings_selectbox_all');
	
	while ($db->next_record()){
		$_AS['tpl']['tempdata'][$db->f('iddirectory')]=addslashes($db->f('dirname'));
		if (in_array($db->f('iddirectory'),$selected_folders) || empty($selected_folders_s))
			$_AS['tpl']['tempdata_upl'][$db->f('iddirectory')]=$db->f('dirname');
	}


	$_AS['output']['temp2'][$_AS['temp']['sortindex']['article_file1']][] = str_replace(array(
					'{lng_descr}',
					'{select_element}',
					'{sortindex}',
					'{element}',
					'{element_sortindex}',
					'{select_element_validation}',
					'{add_option1}',
					'{add_option2}',
					'{lng_element_label}',
					'{element_label}',
					'{picture_select_folders_select}',
					'{picture_select_subfolders}',
					'{file_select_folders_select}',    	
					'{file_select_subfolders}',    	
					'{file_select_filetypes_select}',    
					'{file_upload_folders}',	
					'{link_show_title_input}',    	
					'{link_select_idcats}',    	
					'{link_select_subcats}',    	
					'{link_select_startpages}',    	
					'{link_select_showpages}',    	
					'{link_select_choosecats}',
			),
			array(
				$_AS['article_obj']->lang->get('article_settings_files'),
				$_AS['article_obj']->getSelectUni(	'settings[article_file1]',
																						 $_AS['item']->getDataByKey('value'),
																							 array(	"true" => $_AS['article_obj']->lang->get('settings_active'),	
																							 				"false" => $_AS['article_obj']->lang->get('settings_nonactive')),
																							"article_file1"),
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_sortindex'],
				$_AS['item']->getDataByKey('key2'),
				$_AS['item']->getDataByKey('key2').'_sortindex',
				$_AS['article_obj']->getSelectUni(	'settings[article_file1_validation]',
																						 $_AS['temp'][$_AS['item']->getDataByKey('key2').'_validation'],
																						 array(	'true' =>$_AS['article_obj']->lang->get('article_settings_valid_true'),
																						 				'false'=>$_AS['article_obj']->lang->get('article_settings_valid_false')),
																						'file1_validation'),
				$_AS['article_obj']->lang->get('article_settings_desc_input').'&nbsp;'.
				$_AS['article_obj']->getSelectUni(	'settings[article_file1_desc]',
																						 $_AS['temp'][$_AS['item']->getDataByKey('key2').'_desc'],
																						 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																						 				'false'=>$_AS['article_obj']->lang->get('no')),
																						'file_desc').'<br/>'.
																						$_AS['article_obj']->lang->get('article_settings_file_upload').'&nbsp;'.
																						$_AS['article_obj']->getSelectUni( 'settings[article_file_upload]',
																																							 $_AS['temp']['article_file_upload'],
																																							 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																																							 				'false'=>$_AS['article_obj']->lang->get('no')),
																																							'file_upload',
																																							'',
																																							'style="margin-top:2px;"'),
				$_AS['article_obj']->lang->get('article_settings_no_input').'&nbsp;'.
				'<input style="width:30px;" name="settings[article_file1_no]" value="'.
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_no'].
				'"/>'.'<br/>',
				$_AS['article_obj']->lang->get('article_settings_element_label'),
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_label'],
				'',			
				'',			
				'<br/>'.$_AS['article_obj']->lang->get('settings_file_select_folders').'<br/>'.
				$_AS['article_obj']->getSelectUni(	'settings[file_select_folders][]',
																						$selected_folders,
																						$_AS['tpl']['tempdata'],
																						'select_file_select_folders',
																						'',
																						'multiple="multiple" size="5" style="font-family:verdana;width:300px;"').'<br/>',			
				'<br/>'.$_AS['article_obj']->lang->get('settings_file_select_subfolders').'<br/>'.
				$_AS['article_obj']->getSelectUni( 'settings[file_select_subfolders]',
																					 $_AS['temp']['file_select_subfolders'],
																					 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																					 				'false'=>$_AS['article_obj']->lang->get('no')),
																					'picture_desc').'<br/>',			
				'<br/>'.$_AS['article_obj']->lang->get('settings_file_select_filetypes').'<br/>'.
				$_AS['article_obj']->getSelectUni(	'settings[file_select_filetypes][]',
																						$selected_types,
																						$_AS['tpl']['tempdata_ft'],
																						'select_file_select_subfolders',
																						'',
																						'multiple="multiple" size="5" style="font-family:verdana;width:300px;"').'<br/>',
				'<br/>'.$_AS['article_obj']->lang->get('article_settings_file_upload_folders').'<br/>'.
																						$_AS['article_obj']->getSelectUni(	'settings[article_file_upload_folders][]',
																																								$selected_upload_folders,
																																								$_AS['tpl']['tempdata'],
																																								'select_file_select_folders',
																																								'',
																																								'multiple="multiple" size="5" style="font-family:verdana;width:300px;"').'<br/>',
			
				'',			
				'',			
				'',			
				'',			
				''			
			 ),
		$_AS['tpl']['on_off_switches_elementsettings']);
}

//link on/off
if(strpos($_AS['item']->getDataByKey('key2'),$_AS['element'])!==false && $_AS['item']->getDataByKey('key2') == 'article_link') {

	if(is_array($_POST['settings']) && $_POST['action']=='save_article_element_settings') {
			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
			$_AS['item']->save();
	}		

	$_AS['output']['temp2'][$_AS['temp']['sortindex']['article_link']][] = str_replace(array(
					'{lng_descr}',
					'{select_element}',
					'{sortindex}',
					'{element}',
					'{element_sortindex}',
					'{select_element_validation}',
					'{add_option1}',
					'{add_option2}',
					'{lng_element_label}',
					'{element_label}',
					'{picture_select_folders_select}',
					'{picture_select_subfolders}',
					'{file_select_folders_select}',    	
					'{file_select_subfolders}',    	
					'{file_select_filetypes_select}',    
					'{file_upload_folders}',	
					'{link_show_title_input}',    	
					'{link_select_idcats}',    	
					'{link_select_subcats}',    	
					'{link_select_startpages}',    	
					'{link_select_showpages}',    	
					'{link_select_choosecats}'
			),
			array(
					$_AS['article_obj']->lang->get('article_settings_links'),
				$_AS['article_obj']->getSelectUni(	'settings[article_link]',
																						 $_AS['item']->getDataByKey('value'),
																							 array(	"true" =>$_AS['article_obj']->lang->get('settings_active'),
																							 				"false"=>$_AS['article_obj']->lang->get('settings_nonactive')),
																							"article_link"),
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_sortindex'],
				$_AS['item']->getDataByKey('key2'),
				$_AS['item']->getDataByKey('key2').'_sortindex',
				$_AS['article_obj']->getSelectUni(	'settings[article_link_validation]',
																						 $_AS['temp'][$_AS['item']->getDataByKey('key2').'_validation'],
																						 array(	'true' =>$_AS['article_obj']->lang->get('article_settings_valid_true'),
																						 				'false'=>$_AS['article_obj']->lang->get('article_settings_valid_false')),
																						'link_validation'),
				$_AS['article_obj']->lang->get('article_settings_desc_input').'&nbsp;'.
				$_AS['article_obj']->getSelectUni(	'settings[article_link_desc]',
																						 $_AS['temp'][$_AS['item']->getDataByKey('key2').'_desc'],
																						 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																						 				'false'=>$_AS['article_obj']->lang->get('no')),
																						'link_desc'),
				$_AS['article_obj']->lang->get('article_settings_no_input').'&nbsp;'.
				'<input style="width:30px;" name="settings[article_link_no]" value="'.
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_no'].
				'"/>'.'<br/>',
				$_AS['article_obj']->lang->get('article_settings_element_label'),
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_label'],
				'',			
				'',			
				'',			
				'',
				'',			
				'',			
				'',			
				'<br/>'.$_AS['article_obj']->lang->get('settings_link_select_idcats').'<br/>'.
				'<input name="settings[link_select_idcats]" value="'.$_AS['temp']['link_select_idcats'].'"/>',		
				'<br/>'.$_AS['article_obj']->lang->get('settings_link_select_subcats').'<br/>'.
				$_AS['article_obj']->getSelectUni( 'settings[link_select_subcats]',
																					 $_AS['temp']['link_select_subcats'],
																					 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																					 				'false'=>$_AS['article_obj']->lang->get('no')),
																					'').'<br/>',			
				'<br/>'.$_AS['article_obj']->lang->get('settings_link_select_startpages').'<br/>'.
				$_AS['article_obj']->getSelectUni( 'settings[link_select_startpages]',
																					 $_AS['temp']['link_select_startpages'],
																					 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																					 				'false'=>$_AS['article_obj']->lang->get('no')),
																					'').'<br/>',			
				'<br/>'.$_AS['article_obj']->lang->get('settings_link_select_showpages').'<br/>'.
				$_AS['article_obj']->getSelectUni( 'settings[link_select_showpages]',
																					 $_AS['temp']['link_select_showpages'],
																					 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																					 				'false'=>$_AS['article_obj']->lang->get('no')),
																					'').'<br/>',
				'<br/>'.$_AS['article_obj']->lang->get('settings_link_select_choosecats').'<br/>'.
				$_AS['article_obj']->getSelectUni( 'settings[link_select_choosecats]',
																					 $_AS['temp']['link_select_choosecats'],
																					 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																					 				'false'=>$_AS['article_obj']->lang->get('no')),
																					'').'<br/>',			
			 ),
		$_AS['tpl']['on_off_switches_elementsettings']);
}

//date on/off
if(strpos($_AS['item']->getDataByKey('key2'),$_AS['element'])!==false && $_AS['item']->getDataByKey('key2') == 'article_date') {

	if(is_array($_POST['settings']) && $_POST['action']=='save_article_element_settings') {
			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
			$_AS['item']->save();
	}		

	$_AS['output']['temp2'][$_AS['temp']['sortindex']['article_date']][] = str_replace(array(
					'{lng_descr}',
					'{select_element}',
					'{sortindex}',
					'{element}',
					'{element_sortindex}',
					'{select_element_validation}',
					'{add_option1}',
					'{add_option2}',
					'{lng_element_label}',
					'{element_label}',
					'{picture_select_folders_select}',
					'{picture_select_subfolders}',
					'{file_select_folders_select}',    	
					'{file_select_subfolders}',    	
					'{file_select_filetypes_select}',    
					'{file_upload_folders}',	
					'{link_show_title_input}',    	
					'{link_select_idcats}',    	
					'{link_select_subcats}',    	
					'{link_select_startpages}',    	
					'{link_select_showpages}',    	
					'{link_select_choosecats}'

			),
			array(
					$_AS['article_obj']->lang->get('article_settings_dates'),
				$_AS['article_obj']->getSelectUni(	'settings[article_date]',
																						 $_AS['item']->getDataByKey('value'),
																							 array(	"true" =>$_AS['article_obj']->lang->get('settings_active'),
																							 				"false"=>$_AS['article_obj']->lang->get('settings_nonactive')),
																							"article_date"),
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_sortindex'],
				$_AS['item']->getDataByKey('key2'),
				$_AS['item']->getDataByKey('key2').'_sortindex',
				$_AS['article_obj']->getSelectUni(	'settings[article_date_validation]',
																						 $_AS['temp'][$_AS['item']->getDataByKey('key2').'_validation'],
																						 array(	'true' =>$_AS['article_obj']->lang->get('article_settings_valid_true'),
																						 				'false'=>$_AS['article_obj']->lang->get('article_settings_valid_false')),
																						'date_validation'),
				$_AS['article_obj']->lang->get('article_settings_desc_input').'&nbsp;'.
				$_AS['article_obj']->getSelectUni(	'settings[article_date_desc]',
																						 $_AS['temp'][$_AS['item']->getDataByKey('key2').'_desc'],
																						 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																						 				'false'=>$_AS['article_obj']->lang->get('no')),
																						'date_desc').'<br/>'.
				$_AS['article_obj']->lang->get('article_settings_dates_time').'&nbsp;'.
				$_AS['article_obj']->getSelectUni(	'settings[article_date_time]',
																						 $_AS['temp'][$_AS['item']->getDataByKey('key2').'_time'],
																						 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																						 				'false'=>$_AS['article_obj']->lang->get('no')),
																						'date_desc').'<br/>'.
				$_AS['article_obj']->lang->get('article_settings_dates_duration').'&nbsp;'.
				$_AS['article_obj']->getSelectUni(	'settings[article_date_duration]',
																						 $_AS['temp'][$_AS['item']->getDataByKey('key2').'_duration'],
																						 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																						 				'false'=>$_AS['article_obj']->lang->get('no')),
																						'date_desc'),
				$_AS['article_obj']->lang->get('article_settings_no_input').'&nbsp;'.
				'<input style="width:30px;" name="settings[article_date_no]" value="'.
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_no'].
				'"/>'.'<br/>',
				$_AS['article_obj']->lang->get('article_settings_element_label'),
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_label'],
				'',
				'',
				'',			
				'',			
				'',
				'',			
				'',			
				'',			
				'',			
				'',			
				'',			
				''			

			 ),
		$_AS['tpl']['on_off_switches_elementsettings']);
}




	//Customs
	
	// first label 
if(strpos($_AS['item']->getDataByKey('key2'),$_AS['element'])!==false && strpos($_AS['item']->getDataByKey('key2'),'custom')!==false) {

	$i=(int) str_replace('custom','',str_replace('_','',$_AS['element']));

		if($_AS['item']->getDataByKey('key2') == 'article_custom'.$i.'_label') {
		
			if(is_array($_POST['settings']) && $_POST['action']=='save_article_element_settings') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}					

			 $_AS['output']['custom_placeholder'][]='{lng_default_values}';
			 $_AS['output']['custom_placeholder'][]='{lng_custom'.$i.'_label}';
			 $_AS['output']['custom_placeholder'][]='{lng_custom_label}';
			 $_AS['output']['custom_placeholder'][]='{lng_custom_type}';
			 $_AS['output']['custom_placeholder'][]='{lng_custom_validation}';
			 $_AS['output']['custom_placeholder'][]='{lng_custom_valid_settings}';
			 $_AS['output']['custom_placeholder'][]='{lng_custom_valid_errmsg}';
			 $_AS['output']['custom_placeholder'][]='{lng_custom_valid_regexp}';
			 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_label}';
			 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_sortindex}';

			 $_AS['temp']['label']=stripslashes($_AS['item']->getDataByKey('value',true));

			 $_AS['output']['custom_data'][]=$_AS['article_obj']->lang->get('article_settings_default_values');

			 	if (empty( $_AS['temp']['label']))
					$_AS['output']['custom_data'][]=$_AS['article_obj']->lang->get('article_settings_custom'.$i);		
				else
					$_AS['output']['custom_data'][]=stripslashes($_AS['item']->getDataByKey('value',true)).'<span style="color:#999;font-size:0.9em">&nbsp;'.$_AS['article_obj']->lang->get('article_settings_custom'.$i).'</span>';

			 $_AS['output']['custom_data'][]=$_AS['article_obj']->lang->get('article_settings_custom_label');
			 $_AS['output']['custom_data'][]=$_AS['article_obj']->lang->get('article_settings_custom_type');
			 $_AS['output']['custom_data'][]=$_AS['article_obj']->lang->get('article_settings_custom_validation');
			 $_AS['output']['custom_data'][]=$_AS['article_obj']->lang->get('article_settings_valid_settings');
			 $_AS['output']['custom_data'][]=$_AS['article_obj']->lang->get('article_settings_valid_errmsg');
			 $_AS['output']['custom_data'][]=$_AS['article_obj']->lang->get('article_settings_valid_regexp');
			 $_AS['output']['custom_data'][]=stripslashes($_AS['item']->getDataByKey('value',true));
			 $_AS['output']['custom_data'][]=$_AS['temp'][str_replace('_label','',$_AS['item']->getDataByKey('key2')).'_sortindex'];

		}


		if($_AS['item']->getDataByKey('key2') == 'article_custom'.$i.'_alias') {
		
			if(is_array($_POST['settings']) && $_POST['action']=='save_article_element_settings') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}					

			 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_alias}';
			 $_AS['output']['custom_placeholder'][]='{lng_custom_alias}';
			 $_AS['output']['custom_data'][]=stripslashes($_AS['item']->getDataByKey('value',true));
			 $_AS['output']['custom_data'][]=$_AS['article_obj']->lang->get('article_settings_custom_alias');			 

		}

		if($_AS['item']->getDataByKey('key2') == 'article_custom'.$i.'_multi_select') {
		
			if(is_array($_POST['settings']) && $_POST['action']=='save_article_element_settings') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}					

			$_AS['temp']['custom'.$i.'_multi_select']=$_AS['article_obj']->lang->get('article_settings_custom_multi_select').'&nbsp;'.
			 																					$_AS['article_obj']->getSelectUni(	'settings[article_custom'.$i.'_multi_select]',
																																							 $_AS['item']->getDataByKey('value'),
																																							 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																																							 				'false'=>$_AS['article_obj']->lang->get('no')),
																																							'article_custom'.$i.'_multi_select',
																																							'');
		
		}


		if($_AS['item']->getDataByKey('key2') == 'article_custom'.$i.'_type') {
		
				if(is_array($_POST['settings']) && $_POST['action']=='save_article_element_settings') {
						$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
						$_AS['item']->save();
				}					
				if (empty($_AS['settings']['article_custom'.$i.'_type']))
					$_AS['settings']['article_custom'.$i.'_type']=$_AS['item']->getDataByKey('value');
				$_AS['output']['custom_placeholder'][]='{lng_custom_values}';
				$_AS['output']['custom_placeholder'][]='{lng_custom_value}';
				$_AS['output']['custom_placeholder'][]='{custom'.$i.'_select_type}';
				$_AS['output']['custom_placeholder'][]='{custom'.$i.'_select_type_show_values_row}';
				$_AS['output']['custom_placeholder'][]='{custom'.$i.'_select_type_show_value_row}';
				
				$_AS['output']['custom_data'][] = $_AS['article_obj']->lang->get('article_settings_custom_values');
				
				$_AS['output']['custom_data'][] = (($_AS['item']->getDataByKey('value')=='text' || 
																						$_AS['item']->getDataByKey('value')=='textarea'|| 
																						$_AS['item']->getDataByKey('value')=='wysiwyg')?
																						$_AS['article_obj']->lang->get('article_settings_custom_value_default'):
																						$_AS['article_obj']->lang->get('article_settings_custom_value'));
																						
				$_AS['output']['custom_data'][] =	$_AS['article_obj']->getSelectUni(	'settings[article_custom'.$i.'_type]',
																																							 $_AS['item']->getDataByKey('value'),
																																							 array(	'pic' =>$_AS['article_obj']->lang->get('article_settings_custom_type_pic'),
																																							 				'file' =>$_AS['article_obj']->lang->get('article_settings_custom_type_file'),
																																							 				'link' =>$_AS['article_obj']->lang->get('article_settings_custom_type_link'),
																																											'text' =>$_AS['article_obj']->lang->get('article_settings_custom_type_text'),
																																							 				'textarea' =>$_AS['article_obj']->lang->get('article_settings_custom_type_textarea'),
																																							 				'wysiwyg' =>$_AS['article_obj']->lang->get('article_settings_custom_type_wysiwyg'),
																																							 				'select'=>$_AS['article_obj']->lang->get('article_settings_custom_type_select'),
																																							 				'select2'=>$_AS['article_obj']->lang->get('article_settings_custom_type_select2'),
																																							 				'check' =>$_AS['article_obj']->lang->get('article_settings_custom_type_check'),
																																							 				'radio' =>$_AS['article_obj']->lang->get('article_settings_custom_type_radio'),
																																							 				'date' =>$_AS['article_obj']->lang->get('article_settings_custom_type_date'),
																																							 				'time' =>$_AS['article_obj']->lang->get('article_settings_custom_type_time'),
																																							 				'datetime' =>$_AS['article_obj']->lang->get('article_settings_custom_type_date').'+'.$_AS['article_obj']->lang->get('article_settings_custom_type_time'),
																																							 				'info' =>$_AS['article_obj']->lang->get('article_settings_custom_type_info')),
				
																																							'article_custom'.$i.'_type',
																																							'CheckSettingsForm(document.getElementById(\'articlesettingsform\'));',
																																							'size="1" style="width:170px;"');
																																							
				$_AS['output']['custom_data'][] =	(($_AS['item']->getDataByKey('value')=='select' ||
																				  $_AS['item']->getDataByKey('value')=='select2' ||
																				  $_AS['item']->getDataByKey('value')=='check' ||
																				  $_AS['item']->getDataByKey('value')=='radio')?'display:':'display:none');
																				  
				$_AS['output']['custom_data'][] =	(($_AS['item']->getDataByKey('value')=='info' ||
																						$_AS['item']->getDataByKey('value')=='text' ||
																						$_AS['item']->getDataByKey('value')=='textarea' ||
																						$_AS['item']->getDataByKey('value')=='wysiwyg')?'display:':'display:none');
				
	 if ($_AS['item']->getDataByKey('value')=='select' || $_AS['item']->getDataByKey('value')=='select2') {
			
			 $_AS['output']['custom_placeholder'][]= '{custom'.$i.'_add_option1}';
			 $_AS['output']['custom_data'][] =	$_AS['temp']['custom'.$i.'_multi_select'];
																																							
		}
																																							
		if ( $_AS['item']->getDataByKey('value')=='wysiwyg') {
			
				 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_add_option1}';
				 $_AS['output']['custom_data'][] =	'';
			
				$selected_folders_s=$_AS['temp']['article_custom'.$i.'_picture_select_folders'];
				$selected_folders=explode(',',$selected_folders_s);
				$selected_upload_folders_s=$_AS['temp']['article_custom'.$i.'_picture_upload_folders'];
				$selected_upload_folders=explode(',',$selected_upload_folders_s);
				
				$sql = "SELECT iddirectory, dirname FROM ".$cms_db['directory']." WHERE status < 4 AND idclient='$client' ORDER BY dirname";
				$db->query($sql);
				
				
				$_AS['tpl']['tempdata']=array();
				$_AS['tpl']['tempdata']['']=$_AS['article_obj']->lang->get('settings_selectbox_all');
				$_AS['tpl']['tempdata_upl']['']=$_AS['article_obj']->lang->get('settings_selectbox_all');
				
				while ($db->next_record()){
					$_AS['tpl']['tempdata'][$db->f('iddirectory')]=addslashes($db->f('dirname'));
					if (in_array($db->f('iddirectory'),$selected_folders) || empty($selected_folders_s))
						$_AS['tpl']['tempdata_upl'][$db->f('iddirectory')]=$db->f('dirname');
				}
			
				$_AS['output']['custom_placeholder'][] = '{custom'.$i.'_picture_select_folders_select}';
				$_AS['output']['custom_data'][] = '<br/>'.$_AS['article_obj']->lang->get('settings_picture_select_folders').'<br/>'.
																					$_AS['article_obj']->getSelectUni(	'settings[article_custom'.$i.'_picture_select_folders][]',
																																							$selected_folders,
																																							$_AS['tpl']['tempdata'],
																																							'select_picture_select_folders',
																																							'',
																																							'multiple="multiple" size="5" style="font-family:verdana;width:300px;"').'<br/>';
					
				 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_picture_select_subfolders}';
				 $_AS['output']['custom_data'][] =	'<br/>'.$_AS['article_obj']->lang->get('settings_picture_select_subfolders').'<br/>'.
																						$_AS['article_obj']->getSelectUni( 'settings[article_custom'.$i.'_picture_select_subfolders]',
																																							 $_AS['temp']['article_custom'.$i.'_picture_select_subfolders'],
																																							 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																																							 				'false'=>$_AS['article_obj']->lang->get('no')),
																																							'picture_desc').'<br/>';			

				$_AS['output']['custom_placeholder'][] = '{custom'.$i.'_picture_upload_folders_select}';
				$_AS['output']['custom_data'][] = '';

				$selected_folders_s=$_AS['temp']['article_custom'.$i.'_file_select_folders'];
				$selected_folders=explode(',',$selected_folders_s);
				$selected_upload_folders_s=$_AS['temp']['article_custom'.$i.'_file_upload_folders'];
				$selected_upload_folders=explode(',',$selected_upload_folders_s);
							
				$sql = "SELECT iddirectory, dirname FROM ".$cms_db['directory']." WHERE status < 4 AND idclient='$client' ORDER BY dirname";
				$db->query($sql);
				
				$_AS['tpl']['tempdata']=array();
				$_AS['tpl']['tempdata']['']=$_AS['article_obj']->lang->get('settings_selectbox_all');
				$_AS['tpl']['tempdata_upl']['']=$_AS['article_obj']->lang->get('settings_selectbox_all');
				
				while ($db->next_record()) {
					$_AS['tpl']['tempdata'][$db->f('iddirectory')]=$db->f('dirname');
					if (in_array($db->f('iddirectory'),$selected_folders) || empty($selected_folders_s))
						$_AS['tpl']['tempdata_upl'][$db->f('iddirectory')]=$db->f('dirname');
				}
				
				$_AS['output']['custom_placeholder'][] = '{custom'.$i.'_file_select_folders_select}';
				$_AS['output']['custom_data'][] = '<br/>'.$_AS['article_obj']->lang->get('settings_file_select_folders').'<br/>'.
																					$_AS['article_obj']->getSelectUni(	'settings[article_custom'.$i.'_file_select_folders][]',
																																							$selected_folders,
																																							$_AS['tpl']['tempdata'],
																																							'select_file_select_folders',
																																							'',
																																							'multiple="multiple" size="5" style="font-family:verdana;width:300px;"').'<br/>';
					
				$_AS['output']['custom_placeholder'][] = '{custom'.$i.'_file_upload_folders_select}';
				$_AS['output']['custom_data'][] = '';
					
				$_AS['output']['custom_placeholder'][]='{custom'.$i.'_file_select_subfolders}';
				$_AS['output']['custom_data'][] =	'<br/>'.$_AS['article_obj']->lang->get('settings_file_select_subfolders').'<br/>'.
																					$_AS['article_obj']->getSelectUni( 'settings[article_custom'.$i.'_file_select_subfolders]',
																																						 $_AS['temp']['article_custom'.$i.'_file_select_subfolders'],
																																						 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																																						 				'false'=>$_AS['article_obj']->lang->get('no')),
																																						'file_desc').'<br/>';			
			
					$selected_types_s=$_AS['temp']['article_custom'.$i.'_file_select_filetypes'];
					$selected_types=explode(',',$selected_types_s);
					
					$sql = "SELECT filetype, description FROM ". $cms_db['filetype'] ." ORDER BY filetype";							
					$db->query($sql);
					
					$_AS['tpl']['tempdata']=array();
					$_AS['tpl']['tempdata']['']=$_AS['article_obj']->lang->get('settings_selectbox_all');
					
					while ($db->next_record())
						$_AS['tpl']['tempdata'][$db->f('filetype')]=addslashes($db->f('filetype').(($db->f('description')!='') ? ' ('.$db->f('description').')' : '' ));
			
				 	$_AS['output']['custom_placeholder'][]='{custom'.$i.'_file_select_filetypes_select}';
					$_AS['output']['custom_data'][] = '<br/>'.$_AS['article_obj']->lang->get('settings_file_select_filetypes').'<br/>'.
																						$_AS['article_obj']->getSelectUni(	'settings[article_custom'.$i.'_file_select_filetypes][]',
																																								$selected_types,
																																								$_AS['tpl']['tempdata'],
																																								'select_file_select_filetypes',
																																								'',
																																								'multiple="multiple" size="5" style="font-family:verdana;width:300px;"').'<br/>';
			
			
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_link_show_title_input}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_link_select_idcats}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_link_select_subcats}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_link_select_startpages}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_link_select_showpages}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_link_select_choosecats}';
			
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
			
			}	else if ($_AS['item']->getDataByKey('value')=='pic') {
			
				 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_add_option1}';
				 $_AS['output']['custom_data'][] =	$_AS['article_obj']->lang->get('article_settings_desc_input').'&nbsp;'.
																						$_AS['article_obj']->getSelectUni( 'settings[article_custom'.$i.'_picture1_desc]',
																																							 $_AS['temp']['article_custom'.$i.'_picture1_desc'],
																																							 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																																							 				'false'=>$_AS['article_obj']->lang->get('no')),
																																							'picture_desc').
																						'<br/>'.
																						$_AS['article_obj']->lang->get('article_settings_link_input').'&nbsp;'.
																						$_AS['article_obj']->getSelectUni( 'settings[article_custom'.$i.'_picture1_link]',
																																							 $_AS['temp']['article_custom'.$i.'_picture1_link'],
																																							 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																																							 				'false'=>$_AS['article_obj']->lang->get('no')),
																																							'picture_link',
																																							'',
																																							'style="margin-top:2px;"').
																						'<br/>'.
																						$_AS['article_obj']->lang->get('article_settings_picture_upload').'&nbsp;'.
																						$_AS['article_obj']->getSelectUni( 'settings[article_custom'.$i.'_picture_upload]',
																																							 $_AS['temp']['article_custom'.$i.'_picture_upload'],
																																							 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																																							 				'false'=>$_AS['article_obj']->lang->get('no')),
																																							'picture_upload',
																																							'',
																																							'style="margin-top:2px;"');
			
				$selected_folders_s=$_AS['temp']['article_custom'.$i.'_picture_select_folders'];
				$selected_folders=explode(',',$selected_folders_s);
				$selected_upload_folders_s=$_AS['temp']['article_custom'.$i.'_picture_upload_folders'];
				$selected_upload_folders=explode(',',$selected_upload_folders_s);
				
				$sql = "SELECT iddirectory, dirname FROM ".$cms_db['directory']." WHERE status < 4 AND idclient='$client' ORDER BY dirname";
				$db->query($sql);
				
				
				$_AS['tpl']['tempdata']=array();
				$_AS['tpl']['tempdata']['']=$_AS['article_obj']->lang->get('settings_selectbox_all');
				$_AS['tpl']['tempdata_upl']['']=$_AS['article_obj']->lang->get('settings_selectbox_all');
				
				while ($db->next_record()){
					$_AS['tpl']['tempdata'][$db->f('iddirectory')]=addslashes($db->f('dirname'));
					if (in_array($db->f('iddirectory'),$selected_folders) || empty($selected_folders_s))
						$_AS['tpl']['tempdata_upl'][$db->f('iddirectory')]=$db->f('dirname');
				}
			
				$_AS['output']['custom_placeholder'][] = '{custom'.$i.'_picture_select_folders_select}';
				$_AS['output']['custom_data'][] = '<br/>'.$_AS['article_obj']->lang->get('settings_picture_select_folders').'<br/>'.
																					$_AS['article_obj']->getSelectUni(	'settings[article_custom'.$i.'_picture_select_folders][]',
																																							$selected_folders,
																																							$_AS['tpl']['tempdata'],
																																							'select_picture_select_folders',
																																							'',
																																							'multiple="multiple" size="5" style="font-family:verdana;width:300px;"').'<br/>';
					
				 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_picture_select_subfolders}';
				 $_AS['output']['custom_data'][] =	'<br/>'.$_AS['article_obj']->lang->get('settings_picture_select_subfolders').'<br/>'.
																						$_AS['article_obj']->getSelectUni( 'settings[article_custom'.$i.'_picture_select_subfolders]',
																																							 $_AS['temp']['article_custom'.$i.'_picture_select_subfolders'],
																																							 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																																							 				'false'=>$_AS['article_obj']->lang->get('no')),
																																							'picture_desc').'<br/>';			

				$_AS['output']['custom_placeholder'][] = '{custom'.$i.'_picture_upload_folders_select}';
				$_AS['output']['custom_data'][] = '<br/>'.$_AS['article_obj']->lang->get('article_settings_picture_upload_folders').'<br/>'.
																					$_AS['article_obj']->getSelectUni(	'settings[article_custom'.$i.'_picture_upload_folders][]',
																																							$selected_upload_folders,
																																							$_AS['tpl']['tempdata_upl'],
																																							'select_picture_upload_folders',
																																							'',
																																							'multiple="multiple" size="5" style="font-family:verdana;width:300px;"').'<br/>';
			
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_file_select_folders_select}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_file_select_subfolders}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_file_select_filetypes_select}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_file_upload_folders_select}';
			
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_link_show_title_input}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_link_select_idcats}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_link_select_subcats}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_link_select_startpages}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_link_select_showpages}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_link_select_choosecats}';
			
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
			
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
			
			}	else if ($_AS['item']->getDataByKey('value')=='file') {
			
				 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_add_option1}';
				 $_AS['output']['custom_data'][] =	$_AS['article_obj']->lang->get('article_settings_desc_input').'&nbsp;'.
																						$_AS['article_obj']->getSelectUni( 'settings[article_custom'.$i.'_file1_desc]',
																																							 $_AS['temp']['article_custom'.$i.'_file1_desc'],
																																							 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																																							 				'false'=>$_AS['article_obj']->lang->get('no')),
																																							'file_desc').
																						'<br/>'.
																						$_AS['article_obj']->lang->get('article_settings_file_upload').'&nbsp;'.
																						$_AS['article_obj']->getSelectUni( 'settings[article_custom'.$i.'_file_upload]',
																																							 $_AS['temp']['article_custom'.$i.'_file_upload'],
																																							 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																																							 				'false'=>$_AS['article_obj']->lang->get('no')),
																																							'file_upload',
																																							'',
																																							'style="margin-top:2px;"');
			
				$selected_folders_s=$_AS['temp']['article_custom'.$i.'_file_select_folders'];
				$selected_folders=explode(',',$selected_folders_s);
				$selected_upload_folders_s=$_AS['temp']['article_custom'.$i.'_file_upload_folders'];
				$selected_upload_folders=explode(',',$selected_upload_folders_s);
							
				$sql = "SELECT iddirectory, dirname FROM ".$cms_db['directory']." WHERE status < 4 AND idclient='$client' ORDER BY dirname";
				$db->query($sql);
				
				$_AS['tpl']['tempdata']=array();
				$_AS['tpl']['tempdata']['']=$_AS['article_obj']->lang->get('settings_selectbox_all');
				$_AS['tpl']['tempdata_upl']['']=$_AS['article_obj']->lang->get('settings_selectbox_all');
				
				while ($db->next_record()) {
					$_AS['tpl']['tempdata'][$db->f('iddirectory')]=$db->f('dirname');
					if (in_array($db->f('iddirectory'),$selected_folders) || empty($selected_folders_s))
						$_AS['tpl']['tempdata_upl'][$db->f('iddirectory')]=$db->f('dirname');
				}
				
				$_AS['output']['custom_placeholder'][] = '{custom'.$i.'_file_select_folders_select}';
				$_AS['output']['custom_data'][] = '<br/>'.$_AS['article_obj']->lang->get('settings_file_select_folders').'<br/>'.
																					$_AS['article_obj']->getSelectUni(	'settings[article_custom'.$i.'_file_select_folders][]',
																																							$selected_folders,
																																							$_AS['tpl']['tempdata'],
																																							'select_file_select_folders',
																																							'',
																																							'multiple="multiple" size="5" style="font-family:verdana;width:300px;"').'<br/>';
					
				$_AS['output']['custom_placeholder'][] = '{custom'.$i.'_file_upload_folders_select}';
				$_AS['output']['custom_data'][] = '<br/>'.$_AS['article_obj']->lang->get('article_settings_file_upload_folders').'<br/>'.
																					$_AS['article_obj']->getSelectUni(	'settings[article_custom'.$i.'_file_upload_folders][]',
																																							$selected_upload_folders,
																																							$_AS['tpl']['tempdata_upl'],
																																							'select_file_upload_folders',
																																							'',
																																							'multiple="multiple" size="5" style="font-family:verdana;width:300px;"').'<br/>';
					
				$_AS['output']['custom_placeholder'][]='{custom'.$i.'_file_select_subfolders}';
				$_AS['output']['custom_data'][] =	'<br/>'.$_AS['article_obj']->lang->get('settings_file_select_subfolders').'<br/>'.
																					$_AS['article_obj']->getSelectUni( 'settings[article_custom'.$i.'_file_select_subfolders]',
																																						 $_AS['temp']['article_custom'.$i.'_file_select_subfolders'],
																																						 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																																						 				'false'=>$_AS['article_obj']->lang->get('no')),
																																						'file_desc').'<br/>';			
			
					$selected_types_s=$_AS['temp']['article_custom'.$i.'_file_select_filetypes'];
					$selected_types=explode(',',$selected_types_s);
					
					$sql = "SELECT filetype, description FROM ". $cms_db['filetype'] ." ORDER BY filetype";							
					$db->query($sql);
					
					$_AS['tpl']['tempdata']=array();
					$_AS['tpl']['tempdata']['']=$_AS['article_obj']->lang->get('settings_selectbox_all');
					
					while ($db->next_record())
						$_AS['tpl']['tempdata'][$db->f('filetype')]=addslashes($db->f('filetype').(($db->f('description')!='') ? ' ('.$db->f('description').')' : '' ));
			
				 	$_AS['output']['custom_placeholder'][]='{custom'.$i.'_file_select_filetypes_select}';
					$_AS['output']['custom_data'][] = '<br/>'.$_AS['article_obj']->lang->get('settings_file_select_filetypes').'<br/>'.
																						$_AS['article_obj']->getSelectUni(	'settings[article_custom'.$i.'_file_select_filetypes][]',
																																								$selected_types,
																																								$_AS['tpl']['tempdata'],
																																								'select_file_select_filetypes',
																																								'',
																																								'multiple="multiple" size="5" style="font-family:verdana;width:300px;"').'<br/>';
			
			
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_picture_select_folders_select}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_picture_select_subfolders}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_picture_upload_folders_select}';
			
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_link_show_title_input}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_link_select_idcats}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_link_select_subcats}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_link_select_startpages}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_link_select_showpages}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_link_select_choosecats}';
			
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 			
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 
				 
			}	else if ($_AS['item']->getDataByKey('value')=='link') {
			
				 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_add_option1}';
				 $_AS['output']['custom_data'][] =	$_AS['article_obj']->lang->get('article_settings_desc_input').'&nbsp;'.
																						$_AS['article_obj']->getSelectUni( 'settings[article_custom'.$i.'_link_desc]',
																																							 $_AS['temp']['article_custom'.$i.'_link_desc'],
																																							 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																																							 				'false'=>$_AS['article_obj']->lang->get('no')),
																																							'link_desc');
			
				 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_link_show_title_input}';
				 $_AS['output']['custom_data'][] =	'<br/>'.$_AS['article_obj']->lang->get('settings_link_show_title_input').'<br/>'.
																						$_AS['article_obj']->getSelectUni( 'settings[article_custom'.$i.'_link_show_title_input]',
																																							 $_AS['temp']['article_custom'.$i.'_link_show_title_input'],
																																							 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																																							 				'false'=>$_AS['article_obj']->lang->get('no')),
																																							'custom_link_show_title_input').'<br/>';	
			
				 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_link_select_idcats}';
				 $_AS['output']['custom_data'][] =	'<br/>'.$_AS['article_obj']->lang->get('settings_link_select_idcats').'<br/>'.
																						'<input name="settings[article_custom'.$i.'_link_select_idcats]" value="'.$_AS['temp']['article_custom'.$i.'_link_select_idcats'].'" style="width:300px;"/>'.'<br/>';
			
			
				 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_link_select_subcats}';
				 $_AS['output']['custom_data'][] =	'<br/>'.$_AS['article_obj']->lang->get('settings_link_select_subcats').'<br/>'.
																						$_AS['article_obj']->getSelectUni( 'settings[article_custom'.$i.'_link_select_subcats]',
																																							 $_AS['temp']['article_custom'.$i.'_link_select_subcats'],
																																							 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																																							 				'false'=>$_AS['article_obj']->lang->get('no')),
																																							'custom_link_select_subcats').'<br/>';	
			
				 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_link_select_startpages}';
				 $_AS['output']['custom_data'][] =	'<br/>'.$_AS['article_obj']->lang->get('settings_link_select_startpages').'<br/>'.
																						$_AS['article_obj']->getSelectUni( 'settings[article_custom'.$i.'_link_select_startpages]',
																																							 $_AS['temp']['article_custom'.$i.'_link_select_startpages'],
																																							 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																																							 				'false'=>$_AS['article_obj']->lang->get('no')),
																																							'custom_link_select_startpages').'<br/>';	
			
				 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_link_select_showpages}';
				 $_AS['output']['custom_data'][] =	'<br/>'.$_AS['article_obj']->lang->get('settings_link_select_showpages').'<br/>'.
																						$_AS['article_obj']->getSelectUni( 'settings[article_custom'.$i.'_link_select_showpages]',
																																							 $_AS['temp']['article_custom'.$i.'_link_select_showpages'],
																																							 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																																							 				'false'=>$_AS['article_obj']->lang->get('no')),
																																							'custom_link_select_showpages').'<br/>';	
			
				 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_link_select_choosecats}';
				 $_AS['output']['custom_data'][] =	'<br/>'.$_AS['article_obj']->lang->get('settings_link_select_choosecats').'<br/>'.
																						$_AS['article_obj']->getSelectUni( 'settings[article_custom'.$i.'_link_select_choosecats]',
																																							 $_AS['temp']['article_custom'.$i.'_link_select_choosecats'],
																																							 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																																							 				'false'=>$_AS['article_obj']->lang->get('no')),
																																							'link_select_choosecats').'<br/>';	
			
			
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_picture_select_folders_select}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_picture_select_subfolders}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_picture_upload_folders_select}';
			
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_file_select_folders_select}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_file_select_subfolders}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_file_select_filetypes_select}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_file_upload_folders_select}';
				 
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 			
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
			
			} else {
			
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_picture_select_folders_select}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_picture_select_subfolders}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_picture_upload_folders_select}';
			
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_file_select_folders_select}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_file_select_subfolders}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_file_select_filetypes_select}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_file_upload_folders_select}';
			
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_link_show_title_input}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_link_select_idcats}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_link_select_subcats}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_link_select_startpages}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_link_select_showpages}';
				 $_AS['output']['custom_placeholder'][] = '{custom'.$i.'_link_select_choosecats}';
			
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 			
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
			
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 $_AS['output']['custom_data'][] = '';
				 			
				 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_add_option1}';
				 $_AS['output']['custom_data'][] = '';
			
			}
		
		}



			
		if($_AS['item']->getDataByKey('key2') == 'article_custom'.$i.'_vmode') {

			if(is_array($_POST['settings']) && $_POST['action']=='save_article_element_settings') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}					

			$_AS['output']['custom_placeholder'][] =	(($_AS['settings'][ 'article_custom'.$i.'_type']=='select' ||
																			  $_AS['settings'][ 'article_custom'.$i.'_type']=='select2' ||
																			  $_AS['settings'][ 'article_custom'.$i.'_type']=='check' ||
																			  $_AS['settings'][ 'article_custom'.$i.'_type']=='radio')?'{custom'.$i.'_vmode_select1}':'{custom'.$i.'_vmode_select2}');
																			  
			$_AS['output']['custom_placeholder'][] =	(($_AS['settings'][ 'article_custom'.$i.'_type']=='info' ||
																					$_AS['settings'][ 'article_custom'.$i.'_type']=='text' ||
																					$_AS['settings'][ 'article_custom'.$i.'_type']=='textarea' ||
																					$_AS['settings'][ 'article_custom'.$i.'_type']=='wysiwyg')?'{custom'.$i.'_vmode_select1}':'{custom'.$i.'_vmode_select2}');
																						

			$_AS['output']['custom_placeholder'][]='{lng_custom'.$i.'_vmode_select}';

			$_AS['output']['custom_data'][] = $_AS['article_obj']->getSelectUni(	'settings[article_custom'.$i.'_vmode]',
																																						 $_AS['item']->getDataByKey('value'),
																																						 array(	''=>$_AS['article_obj']->lang->get('article_non_selected_string'),
																																						 				'defcopy' =>$_AS['article_obj']->lang->get('article_settings_custom_vmode_defcopy')),
																																						'article_custom'.$i.'_vmode',
																																						'');
			$_AS['output']['custom_data'][] =	'';
			$_AS['output']['custom_data'][] =	$_AS['article_obj']->lang->get('article_settings_custom_vmode');

		
		}

		if($_AS['item']->getDataByKey('key2') == 'article_custom'.$i.'_validation') {
		
			if(is_array($_POST['settings']) && $_POST['action']=='save_article_element_settings') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}					

			 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_validation}';
			 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_edit_validation_show_values_row}';
			 $_AS['output']['custom_data'][] =	$_AS['article_obj']->getSelectUni(	'settings[article_custom'.$i.'_validation]',
																																							 $_AS['item']->getDataByKey('value'),
																																							 array(	'false'=>$_AS['article_obj']->lang->get('article_settings_valid_false'),
																																							 				'true' =>$_AS['article_obj']->lang->get('article_settings_valid_true'),
																						 																					"regexp"=>$_AS['article_obj']->lang->get('article_settings_valid_regexp')),
																																							'article_custom'.$i.'_validation',
																																							'customs_change_validation(this,'.$i.');');
			$_AS['output']['custom_data'][] =	(($_AS['item']->getDataByKey('value')=='regexp' )?'display:':'display:none');

		
		}




#		if($_AS['item']->getDataByKey('key2') == 'article_custom'.$i.'_validation') {
#		
#			if(is_array($_POST['settings']) && $_POST['action']=='save_article_element_settings') {
#					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
#					$_AS['item']->save();
#			}					
#
#			 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_validation}';
#			 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_edit_validation_show_values_row}';
#			 $_AS['output']['custom_data'][] =	$_AS['article_obj']->getSelectUni(	'settings[article_custom'.$i.'_validation]',
#																																							 $_AS['item']->getDataByKey('value'),
#																																							 array(	'false'=>$_AS['article_obj']->lang->get('article_settings_valid_false'),
#																																							 				'true' =>$_AS['article_obj']->lang->get('article_settings_valid_true'),
#																						 																					"regexp"=>$_AS['article_obj']->lang->get('article_settings_valid_regexp')),
#																																							'article_custom'.$i.'_validation',
#																																							'customs_change_validation(this,'.$i.');');
#			$_AS['output']['custom_data'][] =	(($_AS['item']->getDataByKey('value')=='regexp' )?'display:':'display:none');
#
#		
#		}

		if($_AS['item']->getDataByKey('key2') == 'article_custom'.$i.'_validation_rule_text') {
		
			if(is_array($_POST['settings']) && $_POST['action']=='save_article_element_settings') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}					

			 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_validation_rule_text}';
			 $_AS['output']['custom_data'][] =	stripslashes($_AS['item']->getDataByKey('value',true));
		
		} 

		if($_AS['item']->getDataByKey('key2') == 'article_custom'.$i.'_validation_rule_regexp') {
		
			if(is_array($_POST['settings']) && $_POST['action']=='save_article_element_settings') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}					

			 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_validation_rule_regexp}';
			 $_AS['output']['custom_data'][] =	stripslashes($_AS['item']->getDataByKey('value',true));
		
		}


		if($_AS['item']->getDataByKey('key2') == 'article_custom'.$i.'_select_values') {
		
			if(is_array($_POST['settings']) && $_POST['action']=='save_article_element_settings') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}					
		
			 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_select_values}';
			 $_AS['output']['custom_data'][] =	stripslashes($_AS['item']->getDataByKey('value'));
		
		}


		if($_AS['item']->getDataByKey('key2') == 'article_custom'.$i.'_value_default_select') {
		
			if(is_array($_POST['settings']) && $_POST['action']=='save_article_element_settings') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}					
				$_AS['output']['custom_placeholder'][]='{lng_custom_value_default_select}';
			 	$_AS['output']['custom_placeholder'][]='{custom'.$i.'_value_default_select}';
				$_AS['output']['custom_data'][] = $_AS['article_obj']->lang->get('article_settings_custom_value_default_select');
			 	$_AS['output']['custom_data'][] =	stripslashes($_AS['item']->getDataByKey('value'));
		
		
		}

		if($_AS['item']->getDataByKey('key2') == 'article_custom'.$i.'_value') {
		
			if(is_array($_POST['settings']) && $_POST['action']=='save_article_element_settings') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}					
		
			 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_value}';
			 $_AS['output']['custom_data'][] =	stripslashes($_AS['item']->getDataByKey('value'));
		
		}




}


}


if ($_AS['cms_wr']->getVal('back')=='1') {
	$_AS['temp']['url'] = $sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=settings&action=show_article_settings');
	sf_header_redirect(  $_AS['temp']['url'] );
}



$_AS['output']['temp2'][$_AS['temp']['sortindex']['article_custom'.$i]][]  = str_replace($_AS['output']['custom_placeholder'],$_AS['output']['custom_data'],$_AS['tpl']['custom'.$i.'_elementsettings']);


ksort($_AS['output']['temp2']);
foreach ($_AS['output']['temp2'] as $v1)
	foreach ($v1 as $v2)
		$_AS['output']['body'] .= $v2;
		
//Buttons
$_AS['output']['body'] .= str_replace(array(
		'{back}',
		'{lng_back}'
),
array(
		$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=settings&action=show_article_settings'),
		$_AS['article_obj']->lang->get('back'),
),
$_AS['tpl']['buttons_articleelementsettings']);					

$_AS['output']['article_settings']=str_replace(
array(
	'{formurl}',
	'{body}',
	'{element}',
	'{lng_save}',
	'{lng_saveback2}',
	'{foralllangs}',
	'{lng_article_settings_general}',
	'{lng_article_settings_general_options}',
	'{lng_article_settings_general_active}',
	'{lng_article_settings_general_validation}'
),
array(
	$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=settings'),
	$_AS['output']['body'],
	str_replace('_','',$_AS['element']),
	$_AS['article_obj']->lang->get('save'),
	$_AS['article_obj']->lang->get('saveback2'),
	$_AS['article_obj']->lang->get('foralllangs'),
	$_AS['article_obj']->lang->get('article_settings_general'),
	$_AS['article_obj']->lang->get('article_settings_general_options'),
	$_AS['article_obj']->lang->get('article_settings_general_active'),
	$_AS['article_obj']->lang->get('article_settings_general_validation')
),
$_AS['tpl']['article_element_settings_body']);



$_AS['output']['head']=str_replace(
	array(
		'{url_show_settings}',
		'{url_show_settings_specialfunctions}',
		'{url_show_article_settings}',
		'{lng_settings_general}',
		'{lng_settings_specialfunctions}',
		'{lng_article_settings_elements}'
	),
	array(
		$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=settings&action=show_settings'),
		$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=settings&action=show_settings_specialfunctions'),
		$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=settings&action=show_article_settings'),
		$_AS['article_obj']->lang->get('settings_general'),
		$_AS['article_obj']->lang->get('settings_specialfunctions'),
		$_AS['article_obj']->lang->get('article_settings_elements'),
	),
	$_AS['tpl']['settings_head']);

echo $_AS['output']['head'];
echo $_AS['output']['article_settings'];



?>
