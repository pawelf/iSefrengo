<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');
}

//collectionklasse laden
include_once $_AS['basedir'] . 'inc/class.valuecollection.php';
require_once($_AS['basedir'] . 'inc/twitteroauth/twitteroauth.php');

//Externe Variablen per CMS WebRequest holen
$_AS['settings'] = $_AS['cms_wr']->getVal('settings');

//catcol intialisieren
$_AS['catcol'] = new ValueCollection();
//Einträge laden
$_AS['catcol']->generate();

//Tpl einladen
include_once $_AS['basedir'] . 'tpl/'.$_AS['article_obj']->getSetting('skin').'/tpl.settings_head.php';
include_once $_AS['basedir'] . 'tpl/'.$_AS['article_obj']->getSetting('skin').'/tpl.settings_specialfunctions_list.php';



$_AS['output']['body'] = '';
$_AS['TMP']=array();
$_AS['output']['temp2']=array();
//Für jeden geladenenen Eintrag durchlaufen
for($iter = $_AS['catcol']->get(); $iter->valid(); $iter->next() ) {
	//Aktuellen Eintrag als Objekt bereitstellen
	$_AS['item'] =& $iter->current();


$_AS['output']['temp2'][100] = str_replace( '{lng_settings_section}',
																						$_AS['article_obj']->lang->get('spfnc_facebook_section'),
																					 	$_AS['tpl']['settings_section'] );
#

// facebook export
if($_AS['item']->getDataByKey('key2') == 'spfnc_facebook') {

	//Speichern?
	if(is_array($_POST['settings']) && $_POST['action']=='save_settings_specialfunctions') {
			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
			$_AS['item']->save();
	}

	$_AS['output']['temp2'][110] = str_replace(array(
				'{lng_uni}',
				'{select_uni}'
		),
		array(
				$_AS['article_obj']->lang->get($_AS['item']->getDataByKey('key2')),
				$_AS['article_obj']->getSelectUni(	'settings['.$_AS['item']->getDataByKey('key2').']', 
																						$_AS['item']->getDataByKey('value'), 
																						array('true'=>$_AS['article_obj']->lang->get('yes'),
																									'false'=>$_AS['article_obj']->lang->get('no')) )
		 ),
		$_AS['tpl']['uni_select']);
}

#
#if($_AS['item']->getDataByKey('key2') == 'spfnc_facebook_app_key') {
#
#	//Speichern?
#	if(is_array($_POST['settings']) && $_POST['action']=='save_settings_specialfunctions') {
#			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
#			$_AS['item']->save();
#	}
#
#	$_AS['output']['temp2'][115] = str_replace(array(
#				'{lng_uni}',
#				'{uni_input_name}',
#				'{uni_input_value}'
#		),
#		array(
#				$_AS['article_obj']->lang->get($_AS['item']->getDataByKey('key2')),
#				$_AS['item']->getDataByKey('key2'),
#				stripslashes($_AS['item']->getDataByKey('value'))
#		 ),
#		$_AS['tpl']['uni_input']);
#}



if($_AS['item']->getDataByKey('key2') == 'spfnc_facebook_lastsent_data_cf') {

	//Speichern?
	if(is_array($_POST['settings']) && $_POST['action']=='save_settings_specialfunctions') {
			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
			$_AS['item']->save();
	}

	$_AS['TMP']['select_data']=array();
	$_AS['TMP']['select_data'][]=$_AS['article_obj']->lang->get('article_non_selected_string');
	for ($i=1;$i<36;$i++)
		if ($_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='textarea')
			$_AS['TMP']['select_data']['custom'.$i]=$_AS['article_obj']->getSetting('article_custom'.$i.'_label').
																							' ('.$_AS['article_obj']->lang->get('article_custom'.$i).')';


	$_AS['output']['temp2'][118] = str_replace(array(
				'{lng_uni}',
				'{select_uni}'
		),
		array(
				$_AS['article_obj']->lang->get($_AS['item']->getDataByKey('key2')),
				$_AS['article_obj']->getSelectUni(	'settings['.$_AS['item']->getDataByKey('key2').']', 
																						$_AS['item']->getDataByKey('value'), 
																						$_AS['TMP']['select_data'] )
		 ),
		$_AS['tpl']['uni_select']);
}
#

if($_AS['item']->getDataByKey('key2') == 'spfnc_facebook_lastsent_date_cf') {

	//Speichern?
	if(is_array($_POST['settings']) && $_POST['action']=='save_settings_specialfunctions') {
			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
			$_AS['item']->save();
	}

	$_AS['TMP']['select_data']=array();
	$_AS['TMP']['select_data'][]=$_AS['article_obj']->lang->get('article_non_selected_string');
	for ($i=1;$i<36;$i++)
		if ($_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='datetime')
			$_AS['TMP']['select_data']['custom'.$i]=$_AS['article_obj']->getSetting('article_custom'.$i.'_label').
																							' ('.$_AS['article_obj']->lang->get('article_custom'.$i).')';



	$_AS['output']['temp2'][119] = str_replace(array(
				'{lng_uni}',
				'{select_uni}'
		),
		array(
				$_AS['article_obj']->lang->get($_AS['item']->getDataByKey('key2')),
				$_AS['article_obj']->getSelectUni(	'settings['.$_AS['item']->getDataByKey('key2').']', 
																						$_AS['item']->getDataByKey('value'), 
																						$_AS['TMP']['select_data'] )
		 ),
		$_AS['tpl']['uni_select']);
}




if($_AS['item']->getDataByKey('key2') == 'spfnc_facebook_tpl') {

	//Speichern?
	if(is_array($_POST['settings']) && $_POST['action']=='save_settings_specialfunctions') {
			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
			$_AS['item']->save();
	}

	$_AS['output']['temp2'][120] = str_replace(array(
				'{lng_uni}',
				'{uni_area_name}',
				'{uni_area_value}'
		),
		array(
				$_AS['article_obj']->lang->get('spfnc_facebook_tpl'),
				'spfnc_facebook_tpl',
				stripslashes($_AS['item']->getDataByKey('value'))
		 ),
		$_AS['tpl']['uni_area_long']);
}

#
#foreach (array(	'spfnc_facebook_tpl_images',
#								'spfnc_facebook_tpl_files',
#								'spfnc_facebook_tpl_links' ) as $kk => $vv) {
#	if($_AS['item']->getDataByKey('key2') == $vv) {
#			//Speichern?
#			if(is_array($_POST['settings']) && $_POST['action']=='save_settings_specialfunctions') {
#					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
#					$_AS['item']->save();
#			}
#
#			$_AS['output']['temp2'][130+$kk] = str_replace(array(
#						'{lng_uni}',
#						'{uni_area_name}',
#						'{uni_area_value}'
#				),
#				array(
#						$_AS['article_obj']->lang->get($vv),
#						$vv,
#						stripslashes($_AS['item']->getDataByKey('value'))
#				 ),
#				$_AS['tpl']['uni_area_long2']);
#	}
#}

foreach (array(	'spfnc_facebook_tpl_cfg_time',
								'spfnc_facebook_tpl_cfg_date',
								'spfnc_facebook_tpl_cfg_chopmaxlength',
								'spfnc_facebook_tpl_cfg_chopend' ) as $kk => $vv) {
	if($_AS['item']->getDataByKey('key2') == $vv) {
			//Speichern?
			if(is_array($_POST['settings']) && $_POST['action']=='save_settings_specialfunctions') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}

			$_AS['output']['temp2'][130+$kk] = str_replace(array(
						'{lng_uni}',
						'{uni_input_name}',
						'{uni_input_value}'
				),
				array(
						$_AS['article_obj']->lang->get($vv),
						$vv,
						stripslashes($_AS['item']->getDataByKey('value'))
				 ),
				$_AS['tpl']['uni_input']);
	}
}


if($_AS['item']->getDataByKey('key2') == 'spfnc_facebook_media') {

	//Speichern?
	if(is_array($_POST['settings']) && $_POST['action']=='save_settings_specialfunctions') {
			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
			$_AS['item']->save();
	}

	$_AS['TMP']['select_data']=array();
	$_AS['TMP']['select_data'][]=$_AS['article_obj']->lang->get('article_non_selected_string');
	for ($i=1;$i<36;$i++)
		if (($_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='image' ||
				$_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='file' ||
				$_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='text') && 
				$_AS['article_obj']->getSetting('article_custom'.$i.'_label')!='')
			$_AS['TMP']['select_data']['custom'.$i]=$_AS['article_obj']->getSetting('article_custom'.$i.'_label').
																							' ('.$_AS['article_obj']->lang->get('article_custom'.$i).')';



	$_AS['output']['temp2'][140] = str_replace(array(
				'{lng_uni}',
				'{select_uni}'
		),
		array(
				$_AS['article_obj']->lang->get($_AS['item']->getDataByKey('key2')),
				$_AS['article_obj']->getSelectUni(	'settings['.$_AS['item']->getDataByKey('key2').']', 
																						$_AS['item']->getDataByKey('value'), 
																						$_AS['TMP']['select_data'] )
		 ),
		$_AS['tpl']['uni_select']);
}


if($_AS['item']->getDataByKey('key2') == 'spfnc_facebook_url') {

	//Speichern?
	if(is_array($_POST['settings']) && $_POST['action']=='save_settings_specialfunctions') {
			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
			$_AS['item']->save();
	}

	$_AS['output']['temp2'][150] = str_replace(array(
				'{lng_uni}',
				'{uni_input_name}',
				'{uni_input_value}'
		),
		array(
				$_AS['article_obj']->lang->get($_AS['item']->getDataByKey('key2')),
				$_AS['item']->getDataByKey('key2'),
				stripslashes($_AS['item']->getDataByKey('value'))
		 ),
		$_AS['tpl']['uni_input_long']);
}

if($_AS['item']->getDataByKey('key2') == 'spfnc_facebook_url_name') {

	//Speichern?
	if(is_array($_POST['settings']) && $_POST['action']=='save_settings_specialfunctions') {
			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
			$_AS['item']->save();
	}

	$_AS['TMP']['select_data']=array();
	$_AS['TMP']['select_data'][]=$_AS['article_obj']->lang->get('article_non_selected_string');
	$_AS['TMP']['select_data']['title']=$_AS['article_obj']->lang->get('article_title');
	for ($i=1;$i<36;$i++)
		if ($_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='text' && 
				$_AS['article_obj']->getSetting('article_custom'.$i.'_label')!='')
			$_AS['TMP']['select_data']['custom'.$i]=$_AS['article_obj']->getSetting('article_custom'.$i.'_label').
																							' ('.$_AS['article_obj']->lang->get('article_custom'.$i).')';



	$_AS['output']['temp2'][160] = str_replace(array(
				'{lng_uni}',
				'{select_uni}'
		),
		array(
				$_AS['article_obj']->lang->get($_AS['item']->getDataByKey('key2')),
				$_AS['article_obj']->getSelectUni(	'settings['.$_AS['item']->getDataByKey('key2').']', 
																						$_AS['item']->getDataByKey('value'), 
																						$_AS['TMP']['select_data'] )
		 ),
		$_AS['tpl']['uni_select']);
}


if($_AS['item']->getDataByKey('key2') == 'spfnc_facebook_url_caption') {

	//Speichern?
	if(is_array($_POST['settings']) && $_POST['action']=='save_settings_specialfunctions') {
			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
			$_AS['item']->save();
	}

	$_AS['TMP']['select_data']=array();
	$_AS['TMP']['select_data'][]=$_AS['article_obj']->lang->get('article_non_selected_string');
	$_AS['TMP']['select_data']['teaser']=$_AS['article_obj']->lang->get('article_teaser');
	for ($i=1;$i<36;$i++)
		if (($_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='textarea' ||
				$_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='text') && 
				$_AS['article_obj']->getSetting('article_custom'.$i.'_label')!='')
			$_AS['TMP']['select_data']['custom'.$i]=$_AS['article_obj']->getSetting('article_custom'.$i.'_label').
																							' ('.$_AS['article_obj']->lang->get('article_custom'.$i).')';



	$_AS['output']['temp2'][170] = str_replace(array(
				'{lng_uni}',
				'{select_uni}'
		),
		array(
				$_AS['article_obj']->lang->get($_AS['item']->getDataByKey('key2')),
				$_AS['article_obj']->getSelectUni(	'settings['.$_AS['item']->getDataByKey('key2').']', 
																						$_AS['item']->getDataByKey('value'), 
																						$_AS['TMP']['select_data'] )
		 ),
		$_AS['tpl']['uni_select']);
}

if($_AS['item']->getDataByKey('key2') == 'spfnc_facebook_url_man') {

	//Speichern?
	if(is_array($_POST['settings']) && $_POST['action']=='save_settings_specialfunctions') {
			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
			$_AS['item']->save();
	}

	$_AS['TMP']['select_data']=array();
	$_AS['TMP']['select_data'][]=$_AS['article_obj']->lang->get('article_non_selected_string');
	for ($i=1;$i<36;$i++)
		if ($_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='link' && 
				$_AS['article_obj']->getSetting('article_custom'.$i.'_label')!='')
			$_AS['TMP']['select_data']['custom'.$i]=$_AS['article_obj']->getSetting('article_custom'.$i.'_label').
																							' ('.$_AS['article_obj']->lang->get('article_custom'.$i).')';


	$_AS['output']['temp2'][180] = str_replace(array(
				'{lng_uni}',
				'{select_uni}'
		),
		array(
				$_AS['article_obj']->lang->get($_AS['item']->getDataByKey('key2')),
				$_AS['article_obj']->getSelectUni(	'settings['.$_AS['item']->getDataByKey('key2').']', 
																						$_AS['item']->getDataByKey('value'), 
																						$_AS['TMP']['select_data'] )
		 ),
		$_AS['tpl']['uni_select']);

}






// twitter export
$_AS['output']['temp2'][200] = str_replace( '{lng_settings_section}',
																						$_AS['article_obj']->lang->get('spfnc_twitter_section'),
																					 	$_AS['tpl']['settings_section'] );



if($_AS['item']->getDataByKey('key2') == 'spfnc_twitter') {

	//Speichern?
	if(is_array($_POST['settings']) && $_POST['action']=='save_settings_specialfunctions') {
			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
			$_AS['item']->save();
	}

	$_AS['output']['temp2'][210] = str_replace(array(
				'{lng_uni}',
				'{select_uni}'
		),
		array(
				$_AS['article_obj']->lang->get($_AS['item']->getDataByKey('key2')),
				$_AS['article_obj']->getSelectUni(	'settings['.$_AS['item']->getDataByKey('key2').']', 
																						$_AS['item']->getDataByKey('value'), 
																						array('true'=>$_AS['article_obj']->lang->get('yes'),
																									'false'=>$_AS['article_obj']->lang->get('no')) )
		 ),
		$_AS['tpl']['uni_select']);
}


if($_AS['item']->getDataByKey('key2') == 'spfnc_twitter_ckey') {

	//Speichern?
	if(is_array($_POST['settings']) && $_POST['action']=='save_settings_specialfunctions') {
			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
			$_AS['item']->save();
	}

	$_AS['output']['temp2'][215] = str_replace(array(
				'{lng_uni}',
				'{uni_input_name}',
				'{uni_input_value}'
		),
		array(
				$_AS['article_obj']->lang->get($_AS['item']->getDataByKey('key2')),
				$_AS['item']->getDataByKey('key2'),
				stripslashes($_AS['item']->getDataByKey('value'))
		 ),
		$_AS['tpl']['uni_input']);

	$_AS['TMP']['twitter_ckey']= $_AS['item']->getDataByKey('value');

}


if($_AS['item']->getDataByKey('key2') == 'spfnc_twitter_csecret') {

	//Speichern?
	if(is_array($_POST['settings']) && $_POST['action']=='save_settings_specialfunctions') {
			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
			$_AS['item']->save();
	}

	$_AS['output']['temp2'][216] = str_replace(array(
				'{lng_uni}',
				'{uni_input_name}',
				'{uni_input_value}'
		),
		array(
				$_AS['article_obj']->lang->get($_AS['item']->getDataByKey('key2')),
				$_AS['item']->getDataByKey('key2'),
				stripslashes($_AS['item']->getDataByKey('value'))
		 ),
		$_AS['tpl']['uni_input']);
		
		$_AS['TMP']['twitter_csecret']=$_AS['item']->getDataByKey('value');
}


if($_AS['item']->getDataByKey('key2') == 'spfnc_twitter_pin') {

	$_AS['TMP']['twitter_pin_db']=stripslashes($_AS['item']->getDataByKey('value'));
  $_AS['TMP']['twitter_pin_post']=$_AS['settings'][$_AS['item']->getDataByKey('key2')];
	$_AS['TMP']['twitter_pin_langstr']=$_AS['article_obj']->lang->get($_AS['item']->getDataByKey('key2'));
  $_AS['TMP']['twitter_pin']=$_AS['TMP']['twitter_pin_db'];
	if ($_AS['TMP']['twitter_pin_post']!=$_AS['TMP']['twitter_pin_db'] && !empty($_AS['TMP']['twitter_pin_post']))
		$_AS['TMP']['twitter_pin']=$_AS['TMP']['twitter_pin_post'];
	if ($_AS['TMP']['twitter_pin_post']!=$_AS['TMP']['twitter_pin_db'] && empty($_AS['TMP']['twitter_pin_post']))
		$_AS['TMP']['twitter_pin']='';

	if (!empty($_AS['TMP']['twitter_csecret']) && !empty($_AS['TMP']['twitter_ckey'])) {
	
		if (empty($_AS['TMP']['twitter_pin'])) {
	
			$_AS['twitter_oauth'] = new TwitterOAuth($_AS['TMP']['twitter_ckey'],$_AS['TMP']['twitter_csecret']);
			$_AS['twitter_request'] = $_AS['twitter_oauth']->getRequestToken();
			@file_put_contents($_AS['basedir'].'twitter_request_token',  $_AS['twitter_request']['oauth_token']);
			@file_put_contents($_AS['basedir'].'twitter_request_token_secret', $_AS['twitter_request']['oauth_token_secret']);
			$_AS['TMP']['twitter_pin_langstr']=str_replace('{url}',
																											$_AS['twitter_oauth']->getAuthorizeURL($_AS['twitter_request']),
																											$_AS['article_obj']->lang->get($_AS['item']->getDataByKey('key2').'_empty'));
		} else if ($_AS['TMP']['twitter_pin_post']!=$_AS['TMP']['twitter_pin_db']) {
	
			$_AS['twitter_oauth'] = new TwitterOAuth($_AS['TMP']['twitter_ckey'],
																							 $_AS['TMP']['twitter_csecret'],
																							 @file_get_contents($_AS['basedir'].'twitter_request_token'),
																							 @file_get_contents($_AS['basedir'].'twitter_request_token_secret'));
			$_AS['twitter_request'] = $_AS['twitter_oauth']->getAccessToken(NULL, $_AS['TMP']['twitter_pin']);
			@file_put_contents($_AS['basedir'].'twitter_access_token',  $_AS['twitter_request']['oauth_token']);
			@file_put_contents($_AS['basedir'].'twitter_access_token_secret', $_AS['twitter_request']['oauth_token_secret']);
		}
	
	//Speichern?
	if(is_array($_POST['settings']) && $_POST['action']=='save_settings_specialfunctions') {
			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
			$_AS['item']->save();
	}

	$_AS['output']['temp2'][217] = str_replace(array(
				'{lng_uni}',
				'{uni_input_name}',
				'{uni_input_value}'
		),
		array(
				$_AS['TMP']['twitter_pin_langstr'],
				$_AS['item']->getDataByKey('key2'),
				stripslashes($_AS['item']->getDataByKey('value'))
		 ),
		$_AS['tpl']['uni_input_pass']);
		}
				
}

if($_AS['item']->getDataByKey('key2') == 'spfnc_twitter_lastsent_data_cf') {

	//Speichern?
	if(is_array($_POST['settings']) && $_POST['action']=='save_settings_specialfunctions') {
			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
			$_AS['item']->save();
	}

	$_AS['TMP']['select_data']=array();
	$_AS['TMP']['select_data'][]=$_AS['article_obj']->lang->get('article_non_selected_string');
	for ($i=1;$i<36;$i++)
		if ($_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='textarea' && 
				$_AS['article_obj']->getSetting('article_custom'.$i.'_label')!='')
			$_AS['TMP']['select_data']['custom'.$i]=$_AS['article_obj']->getSetting('article_custom'.$i.'_label').
																							' ('.$_AS['article_obj']->lang->get('article_custom'.$i).')';



	$_AS['output']['temp2'][218] = str_replace(array(
				'{lng_uni}',
				'{select_uni}'
		),
		array(
				$_AS['article_obj']->lang->get($_AS['item']->getDataByKey('key2')),
				$_AS['article_obj']->getSelectUni(	'settings['.$_AS['item']->getDataByKey('key2').']', 
																						$_AS['item']->getDataByKey('value'), 
																						$_AS['TMP']['select_data'] )
		 ),
		$_AS['tpl']['uni_select']);
}


if($_AS['item']->getDataByKey('key2') == 'spfnc_twitter_lastsent_date_cf') {

	//Speichern?
	if(is_array($_POST['settings']) && $_POST['action']=='save_settings_specialfunctions') {
			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
			$_AS['item']->save();
	}

	$_AS['TMP']['select_data']=array();
	$_AS['TMP']['select_data'][]=$_AS['article_obj']->lang->get('article_non_selected_string');
	for ($i=1;$i<36;$i++)
		if ($_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='datetime' && 
				$_AS['article_obj']->getSetting('article_custom'.$i.'_label')!='')
			$_AS['TMP']['select_data']['custom'.$i]=$_AS['article_obj']->getSetting('article_custom'.$i.'_label').
																							' ('.$_AS['article_obj']->lang->get('article_custom'.$i).')';



	$_AS['output']['temp2'][219] = str_replace(array(
				'{lng_uni}',
				'{select_uni}'
		),
		array(
				$_AS['article_obj']->lang->get($_AS['item']->getDataByKey('key2')),
				$_AS['article_obj']->getSelectUni(	'settings['.$_AS['item']->getDataByKey('key2').']', 
																						$_AS['item']->getDataByKey('value'), 
																						$_AS['TMP']['select_data'] )
		 ),
		$_AS['tpl']['uni_select']);
}

if($_AS['item']->getDataByKey('key2') == 'spfnc_twitter_tpl') {

	//Speichern?
	if(is_array($_POST['settings']) && $_POST['action']=='save_settings_specialfunctions') {
			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
			$_AS['item']->save();
	}

	$_AS['output']['temp2'][220] = str_replace(array(
				'{lng_uni}',
				'{uni_area_name}',
				'{uni_area_value}'
		),
		array(
				$_AS['article_obj']->lang->get('spfnc_twitter_tpl'),
				'spfnc_twitter_tpl',
				stripslashes($_AS['item']->getDataByKey('value'))
		 ),
		$_AS['tpl']['uni_area_long']);
}

#foreach (array(	'spfnc_twitter_tpl_images',
#								'spfnc_twitter_tpl_files',
#								'spfnc_twitter_tpl_links' ) as $kk => $vv) {
#	if($_AS['item']->getDataByKey('key2') == $vv) {
#			//Speichern?
#			if(is_array($_POST['settings']) && $_POST['action']=='save_settings_specialfunctions') {
#					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
#					$_AS['item']->save();
#			}
#
#			$_AS['output']['temp2'][230+$kk] = str_replace(array(
#						'{lng_uni}',
#						'{uni_area_name}',
#						'{uni_area_value}'
#				),
#				array(
#						$_AS['article_obj']->lang->get($vv),
#						$vv,
#						stripslashes($_AS['item']->getDataByKey('value'))
#				 ),
#				$_AS['tpl']['uni_area_long2']);
#	}
#}

#foreach (array(	'spfnc_twitter_tpl_images',
#								'spfnc_twitter_tpl_files',
#								'spfnc_twitter_tpl_links' ) as $kk => $vv) {
#	if($_AS['item']->getDataByKey('key2') == $vv) {
#			//Speichern?
#			if(is_array($_POST['settings']) && $_POST['action']=='save_settings_specialfunctions') {
#					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
#					$_AS['item']->save();
#			}
#
#			$_AS['output']['temp2'][230+$kk] = str_replace(array(
#						'{lng_uni}',
#						'{uni_area_name}',
#						'{uni_area_value}'
#				),
#				array(
#						$_AS['article_obj']->lang->get($vv),
#						$vv,
#						stripslashes($_AS['item']->getDataByKey('value'))
#				 ),
#				$_AS['tpl']['uni_area_long2']);
#	}
#}

foreach (array(	'spfnc_twitter_tpl_cfg_time',
								'spfnc_twitter_tpl_cfg_date',
								'spfnc_twitter_tpl_cfg_chopmaxlength',
								'spfnc_twitter_tpl_cfg_chopend' ) as $kk => $vv) {
	if($_AS['item']->getDataByKey('key2') == $vv) {
			//Speichern?
			if(is_array($_POST['settings']) && $_POST['action']=='save_settings_specialfunctions') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}

			$_AS['output']['temp2'][240+$kk] = str_replace(array(
						'{lng_uni}',
						'{uni_input_name}',
						'{uni_input_value}'
				),
				array(
						$_AS['article_obj']->lang->get($vv),
						$vv,
						stripslashes($_AS['item']->getDataByKey('value'))
				 ),
				$_AS['tpl']['uni_input']);
	}
}
if($_AS['item']->getDataByKey('key2') == 'spfnc_twitter_url') {

	//Speichern?
	if(is_array($_POST['settings']) && $_POST['action']=='save_settings_specialfunctions') {
			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
			$_AS['item']->save();
	}

	$_AS['output']['temp2'][250] = str_replace(array(
				'{lng_uni}',
				'{uni_input_name}',
				'{uni_input_value}'
		),
		array(
				$_AS['article_obj']->lang->get($_AS['item']->getDataByKey('key2')),
				$_AS['item']->getDataByKey('key2'),
				stripslashes($_AS['item']->getDataByKey('value'))
		 ),
		$_AS['tpl']['uni_input_long']);
}


if($_AS['item']->getDataByKey('key2') == 'spfnc_twitter_url_man') {

	//Speichern?
	if(is_array($_POST['settings']) && $_POST['action']=='save_settings_specialfunctions') {
			$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
			$_AS['item']->save();
	}


	$_AS['TMP']['select_data']=array();
	$_AS['TMP']['select_data'][]=$_AS['article_obj']->lang->get('article_non_selected_string');
	for ($i=1;$i<36;$i++)
		if (($_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='text') && 
				$_AS['article_obj']->getSetting('article_custom'.$i.'_label')!='')
			$_AS['TMP']['select_data']['custom'.$i]=$_AS['article_obj']->getSetting('article_custom'.$i.'_label').
																							' ('.$_AS['article_obj']->lang->get('article_custom'.$i).')';



	$_AS['output']['temp2'][252] = str_replace(array(
				'{lng_uni}',
				'{select_uni}'
		),
		array(
				$_AS['article_obj']->lang->get($_AS['item']->getDataByKey('key2')),
				$_AS['article_obj']->getSelectUni(	'settings['.$_AS['item']->getDataByKey('key2').']', 
																						$_AS['item']->getDataByKey('value'), 
																						$_AS['TMP']['select_data'] )
		 ),
		$_AS['tpl']['uni_select']);

}









}//Ende for

//Buttons
$_AS['output']['temp2'][199] = str_replace(array(
			'{back}'
	),
	array(
			$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=settings&action=show_settings_specialfunctions')
	),
	$_AS['tpl']['buttons']);

//Buttons
$_AS['output']['temp2'][299] = str_replace(array(
			'{back}'
	),
	array(
			$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=settings&action=show_settings_specialfunctions')
	),
	$_AS['tpl']['buttons']);


ksort($_AS['output']['temp2'],SORT_NUMERIC);
foreach ($_AS['output']['temp2'] as $v)
$_AS['output']['body'] .= $v;

$_AS['output']['settings']=str_replace(
	array(
		'{formurl}',
		'{body}',
		'{save}',
		'{action}',
		'{foralllangs}',
		'{lng_settings_general}'
	),
	array(
		$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=settings'),
		$_AS['output']['body'],
		$_AS['article_obj']->lang->get('save'),
		'save_settings_specialfunctions',
		$_AS['article_obj']->lang->get('foralllangs'),
		$_AS['article_obj']->lang->get('settings_specialfunctions')
	),
	$_AS['tpl']['settings_body']);






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
		$_AS['article_obj']->lang->get('article_settings_elements')
	),
	$_AS['tpl']['settings_head']);


echo $_AS['output']['head'];
echo $_AS['output']['settings'];
				
?>
