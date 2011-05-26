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
include_once $_AS['basedir'] . 'tpl/'.$_AS['article_obj']->getSetting('skin').'/tpl.settings_list.php';


$_AS['output']['body'] = '';
$_AS['output']['temp2']=array();

//
// categories
//
//Sprachen aus dem aktuellen Projekt bekommen
$_AS['config']['clientlangs'] = $_AS['article_obj']->getClientLangs();

//collectionklasse laden
include_once $_AS['basedir'] . 'inc/class.categorycollection.php';

//Externe Variablen per CMS WebRequest holen
$_AS['category'] = $_AS['cms_wr']->getVal('category');
$_AS['category_comment'] = $_AS['cms_wr']->getVal('category_comment');
$_AS['category_delete'] = $_AS['cms_wr']->getVal('category_delete');
$_AS['category_new'] = $_AS['cms_wr']->getVal('category_new');
$_AS['category_new_comment'] = $_AS['cms_wr']->getVal('category_new_comment');

if ($_AS['article_obj']->getSetting('use_categories_rm')=='true') {

	$sql = "SELECT
	            idgroup, name
	        FROM
	            ".$cfg_cms['db_table_prefix']."groups
	        WHERE idgroup > 2 ".$selected_groups_filter_sql." ORDER BY name";
	$rs=$adodb->Execute($sql);
	
	$_AS['tpl']['tempgroupsdata']=array();
	$_AS['tpl']['tempgroupsdata']['']=$_AS['article_obj']->lang->get('settings_selectbox_all');
	
	while (!$rs->EOF) {
	    $_AS['tpl']['tempgroupsdata'][$rs->fields[0]] = $rs->fields[1];
	    $rs->MoveNext();
	}
	$rs->Close();	

}


//catcol intialisieren
$_AS['catcol'] = new CategoryCollection();
//Eintr&auml;ge laden
$_AS['catcol']->generate();

// additional stuff for later created project pages
$_AS['temp']['cat_data']=array();
for($iter = $_AS['catcol']->get(); $iter->valid(); $iter->next() ) {
	$_AS['item'] =& $iter->current();
	$_AS['temp']['cat_data'][$_AS['item']->getDataByKey('hash')][$_AS['item']->getDataByKey('idlang')]=$_AS['item']->_data;
}
if (count($_AS['temp']['cat_data'])>0 && count($_AS['config']['clientlangs'])>0) {
	// add cat for new langs
	foreach ($_AS['temp']['cat_data'] as $catdata){
		foreach ($_AS['config']['clientlangs'] as $langid => $v){
		if (empty($catdata[$langid]) && !empty($catdata[1])){
				$_AS['singlecat'] = new SingleCategory();
				$_AS['singlecat']->loadByData($catdata[1]);
				$_AS['singlecat']->_set('idcategory','');
				$_AS['singlecat']->_set('idlang',$langid);
				$_AS['singlecat']->_set('name','');
				$_AS['singlecat']->save();
			}
		}
	}
	// remove cat if lang is missing
	foreach ($_AS['temp']['cat_data'] as $catdata){
		foreach ($catdata as $singlecatdata){
			if (!array_key_exists ( $singlecatdata['idlang'], $_AS['config']['clientlangs'] )) {
				$_AS['singlecat'] = new SingleCategory();
				$_AS['singlecat']->delete($singlecatdata['idcategory']);
			}
		}
	}
}



//Löschen von Kategorien
if($_AS['action']=='save_category' && !empty($_AS['category_delete'])) {
	//Für jede gewollte durchlaufen
	foreach($_AS['category_delete'] as $_AS['temp']['hash']) {
			$sql = "DELETE FROM
									".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_category
							WHERE
									hash='".$_AS['temp']['hash']."'";
			//echo $sql."<br>";
			$adodb->Execute($sql);
	}
}

//Anlegen einer Kategorie in mehreren Sprachen
if(is_array($_POST['category_new']) && $_AS['action']=='save_category') {
	$_AS['temp']['found'] = false;
	//Überprüfen, ob überhaupt ein Titel in einer Sprache eingegeben wurde
	foreach($_AS['category_new'] as $_AS['temp']['idlang'] => $_AS['temp']['name']) {
			if(!empty($_AS['temp']['name'])) {
					$_AS['temp']['found'] = true;
			}
	}

	if($_AS['temp']['found'] == true) {
			$_AS['temp']['hash'] = md5(time()); //Hash für diese Kategorie
			//F&uuml;r jede Sprache durchlaufen
			foreach($_AS['category_new'] as $_AS['temp']['idlang'] => $_AS['temp']['name']) {
					$_AS['singlecategory_obj'] = new SingleCategory;

					$_AS['singlecategory_obj']->setData('idlang', $_AS['temp']['idlang']);
					$_AS['singlecategory_obj']->setData('name', $_AS['temp']['name']);
					$_AS['singlecategory_obj']->setData('hash', $_AS['temp']['hash']);
					if (is_array($_AS['category_new_comment'][$_AS['temp']['idlang']]) && count($_AS['category_new_comment'][$_AS['temp']['idlang']])>0)
						$_AS['singlecategory_obj']->setData('comment', '|'.implode('|',$_AS['category_new_comment'][$_AS['temp']['idlang']]).'|');
					else
						$_AS['singlecategory_obj']->setData('comment','');

					$_AS['singlecategory_obj']->save();
			}
	}//Ende if
}


//catcol intialisieren
$_AS['catcol'] = new CategoryCollection();

$_AS['catcol']->generate();

//Tpl einladen
include_once $_AS['basedir'] . 'tpl/'.$_AS['article_obj']->getSetting('skin').'/tpl.category_list.php';


$_AS['output']['body'] = ''; $i=1;
//F&uuml;r jeden geladenenen Eintrag durchlaufen
for($iter = $_AS['catcol']->get(); $iter->valid(); $iter->next() ) {
	//Aktuellen Eintrag als Objekt bereitstellen
	$_AS['item'] =& $iter->current();

	//Speichern? Aber keine gerade erst angelegte Kategorie
	if(is_array($_POST['category_new']) && $_POST['action']=='save_category' && $_AS['item']->getDataByKey('hash')!=$_AS['temp']['hash']) {
			//echo $_AS['item']->getDataByKey('idcategory')." - ".$_AS['category'][$_AS['item']->getDataByKey('idcategory')]."<br>";
			$_AS['item']->setData('name', $_AS['category'][$_AS['item']->getDataByKey('idcategory')]);
			if (is_array($_AS['category_comment'][$_AS['item']->getDataByKey('idcategory')]) && count($_AS['category_comment'][$_AS['item']->getDataByKey('idcategory')])>0)
				$_AS['item']->setData('comment', '|'.implode('|',$_AS['category_comment'][$_AS['item']->getDataByKey('idcategory')]).'|');
			else
				$_AS['item']->setData('comment','');
			$_AS['item']->setData('idcategory', $_AS['item']->getDataByKey('idcategory'));
			$_AS['item']->save();
	}
	
	
unset($usergroups);
if ($_AS['article_obj']->getSetting('use_categories_rm')=='true')
	$usergroups = $_AS['article_obj']->getSelectUni(	'category_comment['.$_AS['item']->getDataByKey('idcategory').'][]',
																										array_filter(explode('|',$_AS['item']->getDataByKey('comment'))),
																										$_AS['tpl']['tempgroupsdata'],
																										'default_group_select',
																										'',
																										'multiple="multiple" size="4" style="font-family:verdana;margin-left:10px;width:28%;"');

	
	$_AS['temp']['field_row'][$_AS['item']->getDataByKey('hash')][] = str_replace(array(
						'{langname}',
						'{name}',
						'{value}',
					  '{usergroups}'
			),
		 array(
						$_AS['config']['clientlangs'][$_AS['item']->getDataByKey('idlang')],
						'category['.$_AS['item']->getDataByKey('idcategory').']',
						htmlentities(stripslashes($_AS['item']->getDataByKey('name')),ENT_COMPAT,'UTF-8'),
						$usergroups						
			),
		 $_AS['tpl']['field_row']);

	
	if(!isset($_AS['output']['row'][$_AS['item']->getDataByKey('hash')])) {
			$_AS['output']['row'][$_AS['item']->getDataByKey('hash')] = str_replace(array(
						'{number}',
					 '{hash}',
					 '{lng_category_delete}'
			),
		 array(
					 $i++,
					 $_AS['item']->getDataByKey('hash'),
					 $_AS['article_obj']->lang->get('category_delete')
			),
		 $_AS['tpl']['list_row']);
	}
}//Ende for




if(isset($_AS['output']['row'])) {
	//Erst wenn alle Felder bekannt/vorhanden sind diese im Tpl ersetzen
	foreach($_AS['output']['row'] as $_AS['temp']['hash'] => $_AS['temp']['tpl']) {

			$_AS['output']['row'][$_AS['temp']['hash']] = str_replace(array(
						'{fieldtable}'
					),
					array(
						//Implodieren, wenn mehr als eine Zeile vorhanden ist
						(count($_AS['temp']['field_row'][$_AS['temp']['hash']])>1) ? implode("\n",$_AS['temp']['field_row'][$_AS['temp']['hash']]) : $_AS['temp']['field_row'][$_AS['temp']['hash']][0]
			),
			$_AS['temp']['tpl']);
	}
}//Ende if

//Neue Kategorie
$_AS['temp']['new_category'] = array();
foreach($_AS['config']['clientlangs'] as $_AS['temp']['idlang'] => $_AS['temp']['langname']) {
unset($usergroups);
if ($_AS['article_obj']->getSetting('use_categories_rm')=='true')
	$usergroups = $_AS['article_obj']->getSelectUni(	'category_new_comment['.$_AS['temp']['idlang'].'][]',
																										'',
																										$_AS['tpl']['tempgroupsdata'],
																										'default_group_select',
																										'',
																										'multiple="multiple" size="4" style="font-family:verdana;margin-left:10px;width:28%;"');
																										
	$_AS['temp']['new_category'][] = str_replace(array(
						'{langname}',
						'{name}',
						'{value}',
						'{usergroups}'
	),
	array(
						$_AS['temp']['langname'],
						'category_new['.$_AS['temp']['idlang'].']',
						'',
						$usergroups						
	),
	$_AS['tpl']['field_row']);
}

$_AS['output']['new_category'] = str_replace(array(
			'{lng_new}',
			'{fieldtable}',
			'{lng_category_create}'
	),
	array(
			$_AS['article_obj']->lang->get('new'),
			//Implodieren, wenn mehr als eine Zeile vorhanden ist
			(count($_AS['temp']['new_category'])>1) ? implode("\n",$_AS['temp']['new_category']) : $_AS['temp']['new_category'][0],
			$_AS['article_obj']->lang->get('category_create')
	),
	$_AS['tpl']['list_new']);



//Implodieren, wenn mehr als eine Zeile vorhanden ist
if(count($_AS['output']['row']) >= 1) {
	$_AS['output']['body'] = implode("\n",$_AS['output']['row']);
} else {
	$_AS['output']['body'] =	$_AS['output']['row'][0];
}


//Buttons
$_AS['output']['body'] .= str_replace(array(
			'{back}',
			'{lng_button_label}'
	),
	array(
			$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=settings&action=show_settings'),
			$_AS['article_obj']->lang->get('save')
	),
	$_AS['tpl']['buttons']);

if(count($_AS['output']['row']) >= 1) 
$_AS['output']['category']=str_replace(
	array(
		'{formurl}',
		'{body}',
		'{lng_category}'
	),
	array(
		$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=category'),
		$_AS['output']['body'],
		$_AS['article_obj']->lang->get('category')
	),
	$_AS['tpl']['category_body']);


//Buttons
$_AS['output']['new_category'] .= str_replace(array(
			'{back}',
			'{lng_button_label}'
	),
	array(
			$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=settings&action=show_settings'),
			$_AS['article_obj']->lang->get('create')
	),
	$_AS['tpl']['buttons']);





$_AS['output']['new_category']=str_replace(
	array(
		'{body}',
		'{lng_category}'
	),
	array(
		$_AS['output']['new_category'],
		$_AS['article_obj']->lang->get('category_create')
	),
	$_AS['tpl']['category_body']);



$_AS['output']['category_body_intro']=str_replace(
	array(
		'{formurl}'
	),
	array(
		$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=category')
	),
	$_AS['tpl']['category_body_intro']);

//output
echo $_AS['output']['category_body_intro'];		
echo $_AS['output']['new_category'];			
echo $_AS['output']['category'];
echo $_AS['output']['outro'];

				
?>
