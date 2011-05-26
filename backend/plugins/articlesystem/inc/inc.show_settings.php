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
include_once $_AS['basedir'] . 'tpl/'.$_AS['article_obj']->getSetting('skin').'/tpl.settings_list.php';



$_AS['output']['body'] = '';
$_AS['output']['temp2']=array();
//Für jeden geladenenen Eintrag durchlaufen
for($iter = $_AS['catcol']->get(); $iter->valid(); $iter->next() ) {
	//Aktuellen Eintrag als Objekt bereitstellen
	$_AS['item'] =& $iter->current();

	//Kategorie zuweisen möglich?
	if($_AS['item']->getDataByKey('key2') == 'set_category') {

			//Speichern?
			if(is_array($_POST['settings']) && $_POST['action']=='save_settings') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}

			$_AS['output']['temp2'][10] = str_replace(array(
						'{idvalue}',
						'{lng_set_category}',
						'{lng_yes}',
						'{lng_no}',
						'{selected_yes}',
						'{selected_no}'
				),
				array(
						$_AS['item']->getDataByKey('idvalue'),
						$_AS['article_obj']->lang->get('settings_set_category'),
						$_AS['article_obj']->lang->get('yes'),
						$_AS['article_obj']->lang->get('no'),
						($_AS['item']->getDataByKey('value') == 1) ? 'selected="selected"' : '',
						($_AS['item']->getDataByKey('value') == 0) ? 'selected="selected"' : ''
				 ),
				$_AS['tpl']['set_category']);
	}

	
	//Kategorie mehrfach zuweisen möglich?
	if($_AS['item']->getDataByKey('key2') == 'set_category_multiple') {

			//Speichern?
			if(is_array($_POST['settings']) && $_POST['action']=='save_settings') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}

			$_AS['output']['temp2'][12] = str_replace(array(
						'{idvalue}',
						'{lng_set_category_multiple}',
						'{lng_yes}',
						'{lng_no}',
						'{selected_yes}',
						'{selected_no}'
				),
				array(
						$_AS['item']->getDataByKey('idvalue'),
						$_AS['article_obj']->lang->get('settings_set_category_multiple'),
						$_AS['article_obj']->lang->get('yes'),
						$_AS['article_obj']->lang->get('no'),
						($_AS['item']->getDataByKey('value') == 1) ? 'selected="selected"' : '',
						($_AS['item']->getDataByKey('value') == 0) ? 'selected="selected"' : ''
				 ),
				$_AS['tpl']['set_category_multiple']);
	}

	//Kategorie zuweisen möglich?
	if($_AS['item']->getDataByKey('key2') == 'use_categories_rm') {

			//Speichern?
			if(is_array($_POST['settings']) && $_POST['action']=='save_settings') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}

			$_AS['output']['temp2'][11] = str_replace(array(
						'{lng_uni}',
						'{select_uni}'
				),
				array(
						$_AS['article_obj']->lang->get('settings_use_categories_rm'),
						$_AS['article_obj']->getSelectUni('settings[use_categories_rm]', $_AS['item']->getDataByKey('value'), array('true'=>$_AS['article_obj']->lang->get('yes'),'false'=>$_AS['article_obj']->lang->get('no')))
				 ),
				$_AS['tpl']['uni_select']);
	}



	//Archiv nutzen?
	if($_AS['item']->getDataByKey('key2') == 'use_archive') {

			//Speichern?
			if(is_array($_POST['settings']) && $_POST['action']=='save_settings') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}

			$_AS['output']['temp2'][15] = str_replace(array(
						'{idvalue}',
						'{lng_use_archive}',
						'{lng_yes}',
						'{lng_no}',
						'{selected_yes}',
						'{selected_no}'
				),
				array(
						$_AS['item']->getDataByKey('idvalue'),
						$_AS['article_obj']->lang->get('settings_use_archive'),
						$_AS['article_obj']->lang->get('yes'),
						$_AS['article_obj']->lang->get('no'),
						($_AS['item']->getDataByKey('value') == 1) ? 'selected="selected"' : '',
						($_AS['item']->getDataByKey('value') == 0) ? 'selected="selected"' : ''
				 ),
				$_AS['tpl']['use_archive']);
	}
		
	//Anzahl angezeigter Artikel?
	if($_AS['item']->getDataByKey('key2') == 'number_of_month') {

			//Speichern?
			if(is_array($_POST['settings']) && $_POST['action']=='save_settings') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}

			$_AS['output']['temp2'][19] = str_replace(array(
						'{lng_number_of_month}',
						'{select_number}'
				),
				array(
						$_AS['article_obj']->lang->get('settings_number_of_month'),
						$_AS['article_obj']->getSelectMonthBack('settings[number_of_month]', $_AS['item']->getDataByKey('value'), ' selected="selected"')
				 ),
				$_AS['tpl']['number_of_month']);
	}

	//Anzahl Listeneinträge
	if($_AS['item']->getDataByKey('key2') == 'number_of_entries') {

			//Speichern?
			if(is_array($_POST['settings']) && $_POST['action']=='save_settings') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}

			$_AS['output']['temp2'][20] = str_replace(array(
						'{lng_number_of_entries}',
						'{select_number}'
				),
				array(
						$_AS['article_obj']->lang->get('settings_number_of_entries'),
						$_AS['article_obj']->getSelectUni('settings[number_of_entries]', $_AS['item']->getDataByKey('value'), array("10" => "10","25"=>"25","50"=>"50","100"=>"100"))
				 ),
				$_AS['tpl']['number_of_entries']);
	}
	//Anzahl Listeneinträge
	if($_AS['item']->getDataByKey('key2') == 'show_articles_pages_dir') {

			//Speichern?
			if(is_array($_POST['settings']) && $_POST['action']=='save_settings') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}

			$_AS['output']['temp2'][21] = str_replace(array(
					'{lng_uni}',
					'{select_uni}'
			),
			array(
					$_AS['article_obj']->lang->get('settings_show_articles_pages_dir'),
					$_AS['article_obj']->getSelectUni('settings[show_articles_pages_dir]', 
																								$_AS['item']->getDataByKey('value'), 
																								array("true" => $_AS['article_obj']->lang->get('settings_yes'),
																											"false" => $_AS['article_obj']->lang->get('settings_no'))
																							)
			 ),
			$_AS['tpl']['uni_select']);
	}


// listview-settings
foreach (array(	'lv_show_search',
								'lv_show_range',
								'lv_show_catfilter',
								'lv_show_datetime',
								'lv_show_onoffline' ) as $kk => $vv)
	if($_AS['item']->getDataByKey('key2') == $vv) {
			//Speichern?
			if(is_array($_POST['settings']) && $_POST['action']=='save_settings') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}

			$_AS['output']['temp2'][25+$kk] = str_replace(array(
						'{lng_uni}',
						'{select_uni}'
				),
				array(
						$_AS['article_obj']->lang->get('settings_'.$vv),
						$_AS['article_obj']->getSelectUni('settings['.$vv.']', $_AS['item']->getDataByKey('value'), array('true'=>$_AS['article_obj']->lang->get('yes'),'false'=>$_AS['article_obj']->lang->get('no')))
				 ),
				$_AS['tpl']['uni_select']);
	}

foreach (array(	'lv_sorting',
								'lv_fields',
								'lv_customfilter' ) as $kk => $vv)
	if($_AS['item']->getDataByKey('key2') == $vv) {
			//Speichern?
			if(is_array($_POST['settings']) && $_POST['action']=='save_settings') {
					if ($vv=='lv_fields' && $_AS['settings'][$_AS['item']->getDataByKey('key2')]=='')
						$_AS['settings'][$_AS['item']->getDataByKey('key2')]='title';
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}

			$_AS['output']['temp2'][22+$kk] = str_replace(array(
						'{lng_uni}',
						'{uni_area_name}',
						'{uni_area_value}'
				),
				array(
						$_AS['article_obj']->lang->get('settings_'.$vv),
						$vv,
						stripslashes($_AS['item']->getDataByKey('value'))
				 ),
				$_AS['tpl']['uni_area']);
	}



	//Sprachauswahl
	if($_AS['item']->getDataByKey('key2') == 'language') {

			//Speichern?
			if(is_array($_POST['settings']) && $_POST['action']=='save_settings') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}

			$_AS['output']['temp2'][30] = str_replace(array(
						'{lng_language}',
						'{select_language}'
				),
				array(
						$_AS['article_obj']->lang->get('settings_language'),
						$_AS['article_obj']->getSelectLanguage('settings[language]', $_AS['item']->getDataByKey('value'))
				 ),
				$_AS['tpl']['language']);
	}


	//Skin
	if($_AS['item']->getDataByKey('key2') == 'skin') {

			//Speichern?
			if(is_array($_POST['settings']) && $_POST['action']=='save_settings') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}

			$_AS['output']['temp2'][40] = str_replace(array(
						'{lng_skin}',
						'{select_skin}'
				),
				array(
						$_AS['article_obj']->lang->get('settings_skin'),
						$_AS['article_obj']->getSelectSkin('settings[skin]', $_AS['item']->getDataByKey('value'))
				 ),
				$_AS['tpl']['skin']);
	}
	//new auto online
	if($_AS['item']->getDataByKey('key2') == 'new_articles_lang_copy') {

			//Speichern?
			if(is_array($_POST['settings']) && $_POST['action']=='save_settings') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}

			$_AS['output']['temp2'][50] = str_replace(array(
						'{lng_new_articles_lang_copy}',
						'{select_new_articles_lang_copy}'
				),
				array(
						$_AS['article_obj']->lang->get('settings_new_articles_lang_copy'),
						$_AS['article_obj']->getSelectUni('settings[new_articles_lang_copy]', $_AS['item']->getDataByKey('value'), array('true'=>$_AS['article_obj']->lang->get('yes'),'false'=>$_AS['article_obj']->lang->get('no')))
				 ),
				$_AS['tpl']['new_articles_lang_copy']);
	}
	//delete all lang copies
	if($_AS['item']->getDataByKey('key2') == 'del_all_lang_copies') {

			//Speichern?
			if(is_array($_POST['settings']) && $_POST['action']=='save_settings') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}

			$_AS['output']['temp2'][60] = str_replace(array(
						'{lng_del_all_lang_copies}',
						'{select_del_all_lang_copies}'
				),
				array(
						$_AS['article_obj']->lang->get('settings_del_all_lang_copies'),
						$_AS['article_obj']->getSelectUni('settings[del_all_lang_copies]', $_AS['item']->getDataByKey('value'), array('true'=>$_AS['article_obj']->lang->get('yes'),'false'=>$_AS['article_obj']->lang->get('no')))
				 ),
				$_AS['tpl']['del_all_lang_copies']);
	}

				
	//new auto online
	if($_AS['item']->getDataByKey('key2') == 'new_articles_online') {

			//Speichern?
			if(is_array($_POST['settings']) && $_POST['action']=='save_settings') {
					$_AS['item']->setData('value', $_AS['settings'][$_AS['item']->getDataByKey('key2')]);
					$_AS['item']->save();
			}

			$_AS['output']['temp2'][80] = str_replace(array(
						'{lng_new_articles_online}',
						'{select_new_articles_online}'
				),
				array(
						$_AS['article_obj']->lang->get('settings_new_articles_online'),
						$_AS['article_obj']->getSelectUni('settings[new_articles_online]', $_AS['item']->getDataByKey('value'), array('true'=>$_AS['article_obj']->lang->get('yes'),'false'=>$_AS['article_obj']->lang->get('no')))
				 ),
				$_AS['tpl']['new_articles_online']);
	}
	



}//Ende for

//backend menu string
if(is_array($_AS['settings']) && $_POST['action']=='save_settings' && !empty($_AS['settings']['backend_menu_string'])) {

	$lang_arr=$_AS['article_obj']->getClientLangs();

	$l=0;
	
	if (count($lang_arr)>1) {

		$sql = "SELECT value FROM ".$cms_db['values']." WHERE group_name='lang' AND idlang='0' AND key1='nav_".$_AS['db']."' AND idclient='$client'";
		$db->query($sql);
		$db->next_record();
		$mstringall=$db->f('value');

		if (!empty($mstringall)) {
			$sql = "DELETE FROM ".$cms_db['values']." WHERE group_name='lang' AND idlang='0' AND key1='nav_".$_AS['db']."' AND idclient='$client'";
			$db->query($sql);
		}

		foreach ($lang_arr as $k => $v) {
		
			$sql = "SELECT value FROM ".$cms_db['values']." WHERE group_name='lang' AND idlang='".$k."' AND key1='nav_".$_AS['db']."' AND idclient='$client'";
			$db->query($sql);
			$db->next_record();
			$mstring=$db->f('value');
	
			if (empty($mstring) && $k==$lang) {

				$sql = "INSERT INTO ".$cfg_cms['db_table_prefix']."values VALUES ('', ".$client.", ".$k.", 'lang', 'nav_".$_AS['db']."', '', '', '', '".$_AS['settings']['backend_menu_string']."', 0, NULL, NULL, 'txt', NULL, NULL, 0);";
				$db->query($sql);		

			} else if (empty($mstring)) {

				if (empty($mstringall)) {
					$sql = "SELECT value FROM ".$cms_db['values']." WHERE group_name='lang' AND idlang='1' AND key1='nav_".$_AS['db']."' AND idclient='$client'";
					$db->query($sql);
					$db->next_record();
					$mstringall=$db->f('value');
				} 
			
				if (empty($mstringall)) 
					$mstringall=$_AS['settings']['backend_menu_string'];

				$sql = "INSERT INTO ".$cfg_cms['db_table_prefix']."values VALUES ('', ".$client.", ".$k.", 'lang', 'nav_".$_AS['db']."', '', '', '', '".$mstringall."', 0, NULL, NULL, 'txt', NULL, NULL, 0);";
				$db->query($sql);		

			}
			
		}

		$l=$lang;

	} 
		
	
	$sql = "UPDATE ".$cms_db['values']." SET value='".$_AS['settings']['backend_menu_string']."' WHERE group_name='lang' AND idlang='".$l."' AND key1='nav_".$_AS['db']."' AND idclient='$client'";
	$db->query($sql);

}

$sql = "SELECT value FROM ".$cms_db['values']." WHERE group_name='lang' AND idlang='0' AND key1='nav_".$_AS['db']."' AND idclient='$client'";
$db->query($sql);
$db->next_record();
$_AS['temp']['backend_lang_all']=$db->f('value');

$sql = "SELECT value FROM ".$cms_db['values']." WHERE group_name='lang' AND idlang='".$lang."' AND key1='nav_".$_AS['db']."' AND idclient='$client'";
$db->query($sql);
$db->next_record();
$_AS['temp']['backend_lang']=$db->f('value');

if (empty($_AS['temp']['backend_lang']))
	$_AS['temp']['backend_lang']=$_AS['temp']['backend_lang_all'];


$_AS['output']['temp2'][90] = str_replace(array('{lng_uni}',
																								'{uni_input_name}',
																								'{uni_input_value}'
																								),
																					array($_AS['article_obj']->lang->get('settings_backend_menu_string'),
																								'backend_menu_string',
																								htmlentities(stripslashes($_AS['temp']['backend_lang']),ENT_COMPAT,'UTF-8')
																								),
																					$_AS['tpl']['uni_input']);

//Buttons
$_AS['output']['temp2'][9999] = str_replace(array(
			'{back}'
	),
	array(
			$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=settings&action=show_settings')
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
		'save_settings',
		$_AS['article_obj']->lang->get('foralllangs'),
		$_AS['article_obj']->lang->get('settings_general')
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
