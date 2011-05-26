<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');
}

//collectionklasse laden
include_once $_AS['basedir'] . 'inc/class.valuecollection.php';

//Externe Variablen per CMS WebRequest holen
$_AS['settings'] = $_AS['cms_wr']->getVal('settings');

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
$_AS['output']['temp_general']=array();
$_AS['temp']=array();
$_AS['temp']['sortindex']=array();
$_AS['temp']['validation_modes'] = array(	'false'=>$_AS['article_obj']->lang->get('article_settings_valid_false'),
																	 				'true' =>$_AS['article_obj']->lang->get('article_settings_valid_true'),
																					"regexp"=>$_AS['article_obj']->lang->get('article_settings_valid_regexp'));

// get and save sort index
for($iter = $_AS['catcol']->get(); $iter->valid(); $iter->next() ) {

	$_AS['item'] =& $iter->current();
	
		if(strpos($_AS['item']->getDataByKey('key2'),'sortindex')!==false) {
			
			if(is_array($_POST['settings']) && $_POST['action']=='save_article_settings') 
			{
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}		
			$_AS['temp']['sortindex'][str_replace('_sortindex','',$_AS['item']->getDataByKey('key2'))]=$_AS['item']->getDataByKey('value');
			$_AS['temp'][$_AS['item']->getDataByKey('key2')]= $_AS['item']->getDataByKey('value');
		}

	#}
	#
	#// get and save label
	#for($iter = $_AS['catcol']->get(); $iter->valid(); $iter->next() ) {
	#
	#$_AS['item'] =& $iter->current();
	
		if(strpos($_AS['item']->getDataByKey('key2'),'_label')!==false &&
			 strpos($_AS['item']->getDataByKey('key2'),'custom')===false) 
		{
			$_AS['temp']['label'][str_replace('_label','',$_AS['item']->getDataByKey('key2'))]=$_AS['item']->getDataByKey('value');
			$_AS['temp'][$_AS['item']->getDataByKey('key2')]= $_AS['item']->getDataByKey('value');
		}

	#}
	#
	#
	#// get and save validation
	#for($iter = $_AS['catcol']->get(); $iter->valid(); $iter->next() ) {
	#
	#$_AS['item'] =& $iter->current();
	
		if(strpos($_AS['item']->getDataByKey('key2'),'validation')!==false) 
		{
			$_AS['temp'][$_AS['item']->getDataByKey('key2')]= $_AS['item']->getDataByKey('value');
		}

	#}
	#
	#
	#// get and save validation
	#for($iter = $_AS['catcol']->get(); $iter->valid(); $iter->next() ) {
	#$_AS['item'] =& $iter->current();
	
	if($_AS['item']->getDataByKey('key2') == 'max_number_files_select') 
	{
			//Speichern?
			if(is_array($_POST['settings']) && $_POST['action']=='save_article_settings') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}
	
			$_AS['output']['temp_general'][100] = str_replace(array(
					'{lng_uni}',
					'{uni_input_name}',
					'{uni_input_value}'
			),
			array(
					$_AS['article_obj']->lang->get('article_settings_'.$_AS['item']->getDataByKey('key2')),
					$_AS['item']->getDataByKey('key2'),
					stripslashes($_AS['item']->getDataByKey('value'))
			 ),
			$_AS['tpl']['uni_input']);
				
	}

}




for($iter = $_AS['catcol']->get(); $iter->valid(); $iter->next() ) {
//Aktuellen Eintrag als Objekt bereitstellen
$_AS['item'] =& $iter->current();

//teaser on/off
if($_AS['item']->getDataByKey('key2') == 'article_teaser') {


		$_AS['output']['temp2'][$_AS['temp']['sortindex']['article_teaser']][] = str_replace(array(
					'{lng_descr}',
					'{select_element}',
					'{sortindex}',
					'{element}',
					'{element_sortindex}',
					'{select_element_validation}',
					'{url_settings}'
			),
			array(
				$_AS['article_obj']->lang->get('article_settings_teaser'),
				($_AS['item']->getDataByKey('value')=='true'?
				$_AS['article_obj']->lang->get('settings_active'):
				$_AS['article_obj']->lang->get('settings_nonactive')),
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_sortindex'],
				$_AS['item']->getDataByKey('key2'),
				$_AS['item']->getDataByKey('key2').'_sortindex',
				$_AS['temp']['validation_modes'][$_AS['temp'][$_AS['item']->getDataByKey('key2').'_validation']],
				$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=settings&action=show_article_element_settings&element=teaser')

			 ),
		$_AS['tpl']['on_off_switches']);
		

}
//text on/off
if($_AS['item']->getDataByKey('key2') == 'article_text') {

		$_AS['output']['temp2'][$_AS['temp']['sortindex']['article_text']][] = str_replace(array(
					'{lng_descr}',
					'{select_element}',
					'{sortindex}',
					'{element}',
					'{element_sortindex}',
					'{select_element_validation}',
					'{url_settings}'
			),
			array(
				$_AS['article_obj']->lang->get('article_settings_text'),
				($_AS['item']->getDataByKey('value')=='true'?
				$_AS['article_obj']->lang->get('settings_active'):
				$_AS['article_obj']->lang->get('settings_nonactive')),
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_sortindex'],
				$_AS['item']->getDataByKey('key2'),
				$_AS['item']->getDataByKey('key2').'_sortindex',
				$_AS['temp']['validation_modes'][$_AS['temp'][$_AS['item']->getDataByKey('key2').'_validation']],
				$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=settings&action=show_article_element_settings&element=text')

			 ),
		$_AS['tpl']['on_off_switches']);
		

}

//picture1 on/off
if($_AS['item']->getDataByKey('key2') == 'article_picture1') {

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
					'{url_settings}'

			),
			array(
					$_AS['article_obj']->lang->get('article_settings_pictures'),
				($_AS['item']->getDataByKey('value')=='true'?
				$_AS['article_obj']->lang->get('settings_active'):
				$_AS['article_obj']->lang->get('settings_nonactive')),
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_sortindex'],
				$_AS['item']->getDataByKey('key2'),
				$_AS['item']->getDataByKey('key2').'_sortindex',
				$_AS['temp']['validation_modes'][$_AS['temp'][$_AS['item']->getDataByKey('key2').'_validation']],
				$add_option1,
				$_AS['article_obj']->lang->get('article_settings_no_input').'&nbsp;'.
				'<input style="width:30px;" name="settings[article_picture1_no]" value="'.
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_no'].
				'"/>',
				$_AS['article_obj']->lang->get('article_settings_element_label'),
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_label'],
				$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=settings&action=show_article_element_settings&element=picture1')

			 ),
		$_AS['tpl']['on_off_switches']);
}

//file1 on/off
if($_AS['item']->getDataByKey('key2') == 'article_file1') {


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
					'{url_settings}'
			),
			array(
				$_AS['article_obj']->lang->get('article_settings_files'),
				($_AS['item']->getDataByKey('value')=='true'?
				$_AS['article_obj']->lang->get('settings_active'):
				$_AS['article_obj']->lang->get('settings_nonactive')),
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_sortindex'],
				$_AS['item']->getDataByKey('key2'),
				$_AS['item']->getDataByKey('key2').'_sortindex',
				$_AS['temp']['validation_modes'][$_AS['temp'][$_AS['item']->getDataByKey('key2').'_validation']],
				$_AS['article_obj']->lang->get('article_settings_desc_input').'&nbsp;'.
				$_AS['article_obj']->getSelectUni(	'settings[article_file1_desc]',
																						 $_AS['temp'][$_AS['item']->getDataByKey('key2').'_desc'],
																						 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																						 				'false'=>$_AS['article_obj']->lang->get('no')),
																						'file_desc'),
				$_AS['article_obj']->lang->get('article_settings_no_input').'&nbsp;'.
				'<input style="width:30px;" name="settings[article_file1_no]" value="'.
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_no'].
				'"/>',
				$_AS['article_obj']->lang->get('article_settings_element_label'),
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_label'],
				$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=settings&action=show_article_element_settings&element=file1')
			 ),
		$_AS['tpl']['on_off_switches']);
}

//link on/off
if($_AS['item']->getDataByKey('key2') == 'article_link') {

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
					'{url_settings}'
			),
			array(
					$_AS['article_obj']->lang->get('article_settings_links'),
				($_AS['item']->getDataByKey('value')=='true'?
				$_AS['article_obj']->lang->get('settings_active'):
				$_AS['article_obj']->lang->get('settings_nonactive')),
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_sortindex'],
				$_AS['item']->getDataByKey('key2'),
				$_AS['item']->getDataByKey('key2').'_sortindex',
				$_AS['temp']['validation_modes'][$_AS['temp'][$_AS['item']->getDataByKey('key2').'_validation']],
				$_AS['article_obj']->lang->get('article_settings_desc_input').'&nbsp;'.
				$_AS['article_obj']->getSelectUni(	'settings[article_link_desc]',
																						 $_AS['temp'][$_AS['item']->getDataByKey('key2').'_desc'],
																						 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																						 				'false'=>$_AS['article_obj']->lang->get('no')),
																						'link_desc'),
				$_AS['article_obj']->lang->get('article_settings_no_input').'&nbsp;'.
				'<input style="width:30px;" name="settings[article_link_no]" value="'.
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_no'].
				'"/>',
				$_AS['article_obj']->lang->get('article_settings_element_label'),
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_label'],
				$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=settings&action=show_article_element_settings&element=link')
			 ),
		$_AS['tpl']['on_off_switches']);
}

//date on/off
if($_AS['item']->getDataByKey('key2') == 'article_date') {

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
					'{url_settings}'
			),
			array(
					$_AS['article_obj']->lang->get('article_settings_dates'),
				($_AS['item']->getDataByKey('value')=='true'?
				$_AS['article_obj']->lang->get('settings_active'):
				$_AS['article_obj']->lang->get('settings_nonactive')),
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_sortindex'],
				$_AS['item']->getDataByKey('key2'),
				$_AS['item']->getDataByKey('key2').'_sortindex',
				$_AS['temp']['validation_modes'][$_AS['temp'][$_AS['item']->getDataByKey('key2').'_validation']],
				$_AS['article_obj']->lang->get('article_settings_desc_input').'&nbsp;'.
				$_AS['article_obj']->getSelectUni(	'settings[article_date_desc]',
																						 $_AS['temp'][$_AS['item']->getDataByKey('key2').'_desc'],
																						 array(	'true' =>$_AS['article_obj']->lang->get('yes'),
																						 				'false'=>$_AS['article_obj']->lang->get('no')),
																						'date_desc'),
				$_AS['article_obj']->lang->get('article_settings_no_input').'&nbsp;'.
				'<input style="width:30px;" name="settings[article_date_no]" value="'.
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_no'].
				'"/>',
				$_AS['article_obj']->lang->get('article_settings_element_label'),
				$_AS['temp'][$_AS['item']->getDataByKey('key2').'_label'],
				$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=settings&action=show_article_element_settings&element=date')
			 ),
		$_AS['tpl']['on_off_switches']);
}
	//Customs
	
	// first label 
	for ($i=1;$i<36;$i++){
		if($_AS['item']->getDataByKey('key2') == 'article_custom'.$i.'_label') {
			
			$_AS['output']['custom_placeholder'][]='{lng_custom'.$i.'_label}';
			$_AS['output']['custom_placeholder'][]='{lng_custom'.$i.'_active}';
			$_AS['output']['custom_placeholder'][]='{url_custom'.$i.'_settings}';
			$_AS['output']['custom_placeholder'][]='{lng_custom_label}';
			$_AS['output']['custom_placeholder'][]='{lng_custom_type}';
			$_AS['output']['custom_placeholder'][]='{lng_custom_validation}';
			$_AS['output']['custom_placeholder'][]='{custom'.$i.'_label}';
			$_AS['output']['custom_placeholder'][]='{custom'.$i.'_sortindex}';
			$_AS['temp']['label']=stripslashes($_AS['item']->getDataByKey('value',true));
			
			if (strlen($_AS['temp']['label'])>32)
				$_AS['temp']['label']=substr($_AS['temp']['label'],0,32).' ...';
			
			if (empty( $_AS['temp']['label'])) {
				$_AS['output']['custom_data'][]=$_AS['article_obj']->lang->get('article_settings_custom'.$i);		
				$_AS['output']['custom_data'][]=$_AS['article_obj']->lang->get('settings_nonactive');
			} else {
				$_AS['output']['custom_data'][]=$_AS['temp']['label'].'<span style="color:#999;font-size:0.9em">&nbsp;'.$_AS['article_obj']->lang->get('article_settings_custom'.$i).'</span>';
				$_AS['output']['custom_data'][]=$_AS['article_obj']->lang->get('settings_active');
			}
			$_AS['output']['custom_data'][]=$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=settings&action=show_article_element_settings&element=custom'.$i);
			$_AS['output']['custom_data'][]=$_AS['article_obj']->lang->get('article_settings_custom_label');
			$_AS['output']['custom_data'][]=$_AS['article_obj']->lang->get('article_settings_custom_type');
			$_AS['output']['custom_data'][]=$_AS['article_obj']->lang->get('article_settings_custom_validation');
			$_AS['output']['custom_data'][]=stripslashes($_AS['item']->getDataByKey('value',true));
			$_AS['output']['custom_data'][]=$_AS['temp'][str_replace('_label','',$_AS['item']->getDataByKey('key2')).'_sortindex'];
			
		}
	}

	for ($i=1;$i<36;$i++){

		if($_AS['item']->getDataByKey('key2') == 'article_custom'.$i.'_type') {
		
		 $types=array(	'pic' =>$_AS['article_obj']->lang->get('article_settings_custom_type_pic'),
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
						 				'info' =>$_AS['article_obj']->lang->get('article_settings_custom_type_info') );
				

			 $_AS['output']['custom_placeholder'][]='{lng_custom_values}';
			 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_select_type}';
			 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_select_type_show_values_row}';
			 $_AS['output']['custom_data'][] = $_AS['article_obj']->lang->get('article_settings_custom_values');
			 $_AS['output']['custom_data'][] = $types[$_AS['item']->getDataByKey('value')];

			$_AS['output']['custom_data'][] =	(($_AS['item']->getDataByKey('value')=='select' ||
																				  $_AS['item']->getDataByKey('value')=='select2' ||
																				  $_AS['item']->getDataByKey('value')=='check' ||
																				  $_AS['item']->getDataByKey('value')=='radio')?'display:':'display:none');
		
		}
	}
	for ($i=1;$i<36;$i++){

		if($_AS['item']->getDataByKey('key2') == 'article_custom'.$i.'_validation') {
		
			 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_validation}';
			 $_AS['output']['custom_placeholder'][]='{custom'.$i.'_edit_validation_show_values_row}';
			 $_AS['output']['custom_data'][] =	$_AS['temp']['validation_modes'][$_AS['item']->getDataByKey('value')]	;
			 $_AS['output']['custom_data'][] =	(($_AS['item']->getDataByKey('value')=='regexp' )?'display:':'display:none');

		}
	}

	

}
for ($i=1;$i<36;$i++) {

	$_AS['output']['temp2'][$_AS['temp']['sortindex']['article_custom'.$i]][]  = str_replace($_AS['output']['custom_placeholder'],$_AS['output']['custom_data'],$_AS['tpl']['custom'.$i.'_label']);
}


ksort($_AS['output']['temp2']);
foreach ($_AS['output']['temp2'] as $v1)
	foreach ($v1 as $v2)
		$_AS['output']['body'] .= $v2;
		
ksort($_AS['output']['temp_general'],SORT_NUMERIC);
foreach ($_AS['output']['temp_general'] as $v)
$_AS['output']['body_general'] .= $v;
		
		
		
		
//Buttons
$_AS['output']['body'] .= str_replace(array(
		'{back}'
),
array(
		$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=settings&action=show_article_settings')
),
$_AS['tpl']['buttons_articlesettings']);					

$_AS['output']['body_general'] .= str_replace(array(
		'{back}'
),
array(
		$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=settings&action=show_article_settings#elementsgeneral')
),
$_AS['tpl']['buttons_articlesettings']);					

$_AS['output']['article_settings']=str_replace(
array(
	'{formurl}',
	'{body}',
	'{body_general}',
	'{lng_save}',
	'{foralllangs}',
	'{lng_article_settings_general}',
	'{lng_article_settings_elements}',
	'{lng_article_settings_elements_options}',
	'{lng_article_settings_elements_active}',
	'{lng_article_settings_elements_validation}',
	'{skin}'
),
array(
	$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=settings'),
	$_AS['output']['body'],
	$_AS['output']['body_general'],
	$_AS['article_obj']->lang->get('save'),
	$_AS['article_obj']->lang->get('foralllangs'),
	$_AS['article_obj']->lang->get('article_settings_general'),
	$_AS['article_obj']->lang->get('article_settings_elements'),
	$_AS['article_obj']->lang->get('article_settings_elements_options'),
	$_AS['article_obj']->lang->get('article_settings_elements_active'),
	$_AS['article_obj']->lang->get('article_settings_elements_validation'),
	$_AS['article_obj']->getSetting('skin')
),
$_AS['tpl']['article_settings_body']);
	



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
