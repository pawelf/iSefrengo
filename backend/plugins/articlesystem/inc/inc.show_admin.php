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
include_once $_AS['basedir'] . 'tpl/'.$_AS['article_obj']->getSetting('skin').'/tpl.admin.php';


$sql = "SHOW TABLES";
$db->query($sql);
$db->next_record();
$_AS['db_tables']=array();
while($db->next_record()){
	if (strpos($db->f('0'),'articlesystem')!==false && strpos(strstr($db->f('0'),'articlesystem'),'_')===false) {
		$tname = explode('_',$db->f('0'));
		$_AS['db_tables'][$tname[count($tname)-1]] = $tname[count($tname)-1];
	}
}

if ($_AS['settings']['action']=='install' && !empty($_AS['settings']['db'])) {

	$_AS['db_client_install_sql']=file_get_contents ($_AS['basedir'].'meta/client_install.meta');
	$_AS['db_client_install_sql']=str_replace('{client_id}',$client,$_AS['db_client_install_sql']);
	$_AS['db_client_install_sql']=str_replace('{table_prefix}',$cfg_cms['db_table_prefix'],$_AS['db_client_install_sql']);
	$_AS['db_client_install_sql']=str_replace('area_plug_articlesystem','area_plug_{db}',$_AS['db_client_install_sql']);
	$_AS['db_client_install_sql']=str_replace('nav_articlesystem','nav_{db}',$_AS['db_client_install_sql']);
	$_AS['db_client_install_sql']=str_replace('articlesystem/index.php','{db}/index.php',$_AS['db_client_install_sql']);
	
	if (!empty($_AS['settings']['db_new_backend_title']))
		$_AS['db_client_install_sql']=str_replace('\'Artikel\'','\''.$_AS['settings']['db_new_backend_title'].'\'',$_AS['db_client_install_sql']);
	
	if (!empty($_AS['settings']['db_new_backend_title']))
		$_AS['db_client_install_sql']=str_replace('/ Artikelsystem betreten/','/ Artikelsystem ('.$_AS['settings']['db_new_backend_title'].') betreten/',$_AS['db_client_install_sql']);
	else
		$_AS['db_client_install_sql']=str_replace('/ Artikelsystem betreten/','/ Artikelsystem ('.strtoupper('articlesystem'.$_AS['settings']['db']).') betreten/',$_AS['db_client_install_sql']);

	// Client install
	$sql='';
	$sql_meta = str_replace('{db}','articlesystem'.$_AS['settings']['db'],$_AS['db_client_install_sql']);
	$sql_meta_arr=explode("\n",$sql_meta);
	foreach ($sql_meta_arr as $v)
		if (substr(trim($v),0,1)!='#' && strpos($v,'_admin')===false)
			$sql.=$v;

	$sql_arr=explode(";",$sql);
	foreach ($sql_arr as $v)
		$db->query($v);

}

if ($_AS['settings']['action']=='new') {

	$_AS['db_install_sql']=file_get_contents ($_AS['basedir'].'meta/install.meta');
	$_AS['db_install_sql']=str_replace('{client_id}',$client,$_AS['db_install_sql']);
	$_AS['db_install_sql']=str_replace('{table_prefix}',$cfg_cms['db_table_prefix'],$_AS['db_install_sql']);
	$_AS['db_install_sql']=str_replace('plug_articlesystem','plug_{db}',$_AS['db_install_sql']);

	$_AS['index_php']=file_get_contents ($_AS['basedir'].'meta/multidb_index.php');

	$no=array();
	foreach($_AS['db_tables'] as $v) {
		$no[]=(int) str_replace('articlesystem','',$v);
	}

	$i=0;
	while(in_array($i,$no)) {
		$i++;
	}

	$index_php = str_replace('{db}','articlesystem'.$i,$_AS['index_php']);
	@mkdir($_AS['basedir'].'../'.'articlesystem'.$i);
		
	$handle = fopen($_AS['basedir'].'../'.'articlesystem'.$i.'/index.php', "a"); 		
	@fwrite($handle, $index_php);
		
	// Base install
	$sql='';
	$sql_meta = str_replace('{db}','articlesystem'.$i,$_AS['db_install_sql']);
	$sql_meta_arr=explode("\n",$sql_meta);
	foreach ($sql_meta_arr as $v)
		if (substr(trim($v),0,1)!='#' && strpos($v,'_admin')===false)
			$sql.=$v;

	$sql_arr=explode(";",$sql);
	foreach ($sql_arr as $v)
		$db->query($v);

}

if ($_AS['settings']['action']=='uninstall' && !empty($_AS['settings']['db'])) {
	// Client uninstall
	$_AS['db_client_uninstall_sql']=file_get_contents ($_AS['basedir'].'meta/client_uninstall.meta');
	$_AS['db_client_uninstall_sql']=str_replace('{client_id}',$client,$_AS['db_client_uninstall_sql']);
	$_AS['db_client_uninstall_sql']=str_replace('{table_prefix}',$cfg_cms['db_table_prefix'],$_AS['db_client_uninstall_sql']);
	$_AS['db_client_uninstall_sql']=str_replace('{plug_prefix}articlesystem','{plug_prefix}{db}',$_AS['db_client_uninstall_sql']);
	$_AS['db_client_uninstall_sql']=str_replace('{plug_prefix}',$cfg_cms['db_table_prefix'].'plug_',$_AS['db_client_uninstall_sql']);
	$_AS['db_client_uninstall_sql']=str_replace('area_plug_articlesystem','area_plug_{db}',$_AS['db_client_uninstall_sql']);
	$_AS['db_client_uninstall_sql']=str_replace('nav_articlesystem','nav_{db}',$_AS['db_client_uninstall_sql']);

	$sql='';
	$sql_meta = str_replace('{db}','articlesystem'.$_AS['settings']['db'],$_AS['db_client_uninstall_sql']);
	$sql_meta_arr=explode("\n",$sql_meta);
	foreach ($sql_meta_arr as $v)
		if (substr(trim($v),0,1)!='#' && strpos($v,'_admin')===false)
			$sql.=$v;

	$sql_arr=explode(";",$sql);
	foreach ($sql_arr as $v)
		$db->query($v);
}

if ($_AS['settings']['action']=='delete' && !empty($_AS['settings']['db'])) {

	// All Clients uninstall
	$_AS['db_client_uninstall_sql']=file_get_contents ($_AS['basedir'].'meta/client_uninstall.meta');
	$_AS['db_client_uninstall_sql']=str_replace('{table_prefix}',$cfg_cms['db_table_prefix'],$_AS['db_client_uninstall_sql']);
	$_AS['db_client_uninstall_sql']=str_replace('{plug_prefix}articlesystem','{plug_prefix}{db}',$_AS['db_client_uninstall_sql']);
	$_AS['db_client_uninstall_sql']=str_replace('{plug_prefix}',$cfg_cms['db_table_prefix'].'plug_',$_AS['db_client_uninstall_sql']);
	$_AS['db_client_uninstall_sql']=str_replace('area_plug_articlesystem','area_plug_{db}',$_AS['db_client_uninstall_sql']);
	$_AS['db_client_uninstall_sql']=str_replace('nav_articlesystem','nav_{db}',$_AS['db_client_uninstall_sql']);
	$_AS['db_client_uninstall_sql']=str_replace('WHERE idclient = \'{client_id}\'','',$_AS['db_client_uninstall_sql']);
	$_AS['db_client_uninstall_sql']=str_replace('AND idclient = \'{client_id}\'','',$_AS['db_client_uninstall_sql']);
 
	$sql='';
	$sql_meta = str_replace('{db}','articlesystem'.$_AS['settings']['db'],$_AS['db_client_uninstall_sql']);
	$sql_meta_arr=explode("\n",$sql_meta);
	foreach ($sql_meta_arr as $v)
		if (substr(trim($v),0,1)!='#' && strpos($v,'_admin')===false)
			$sql.=$v;

	$sql_arr=explode(";",$sql);
	foreach ($sql_arr as $v)
		$db->query($v);
			
	// Base uninstall
	@unlink($_AS['basedir'].'../'.'articlesystem'.$_AS['settings']['db'].'/index.php');
	@rmdir($_AS['basedir'].'../'.'articlesystem'.$_AS['settings']['db']);

	$_AS['db_uninstall_sql']=file_get_contents ($_AS['basedir'].'meta/uninstall.meta');
	$_AS['db_uninstall_sql']=str_replace('{plug_prefix}articlesystem','{plug_prefix}{db}',$_AS['db_uninstall_sql']);
	$_AS['db_uninstall_sql']=str_replace('{plug_prefix}',$cfg_cms['db_table_prefix'].'plug_',$_AS['db_uninstall_sql']);

	$sql='';
	$sql_meta = str_replace('{db}','articlesystem'.$_AS['settings']['db'],$_AS['db_uninstall_sql']);
	$sql_meta_arr=explode("\n",$sql_meta);
	foreach ($sql_meta_arr as $v)
		if (substr(trim($v),0,1)!='#')
			$sql.=$v;

	$sql_arr=explode(";",$sql);
	foreach ($sql_arr as $v)
		$db->query($v);

}



$sql = "SHOW TABLES";
$db->query($sql);
$db->next_record();
$_AS['db_tables']=array();
while($db->next_record()){
	if (strpos($db->f('0'),'articlesystem')!==false && strpos(strstr($db->f('0'),'articlesystem'),'_')===false) {
		$tname = explode('_',$db->f('0'));
		$_AS['db_tables'][$tname[count($tname)-1]] = $tname[count($tname)-1];
	}
}

$_AS['output']['body'] = '';
$_AS['output']['temp2']=array();

																			
//Für jeden geladenenen Eintrag durchlaufen
$i=0;
foreach($_AS['db_tables'] as $v) {

$sql = "SELECT value FROM  ".$cms_db['values']." WHERE group_name='lang' AND key1='nav_".$v."' AND idclient='$client' AND idlang='0'";
$db->query($sql);
$db->next_record();
$backend_title=$db->f('value');

if (empty($backend_title)) {
	$sql = "SELECT value FROM  ".$cms_db['values']." WHERE group_name='lang' AND key1='nav_".$v."' AND idclient='$client' AND idlang='$lang'";
	$db->query($sql);
	$db->next_record();
	$backend_title=$db->f('value');
}

if ($v!='articlesystem') {
	$_AS['output']['temp2'][190+$i] = str_replace(array('{lng_uni}',
																											'{db}',
																											'{uni1_input_value}',
																											'{uni2_input_value}',
																											'{uni3_input_value}',
																											'{lng_new_backend_title}',
																											'{delete_txt1}',
																											'{delete_txt2}',
																											'{delete2_txt1}'
																											),
																								array(strtoupper($v).
																								      (!empty($backend_title)?' <small>('.htmlentities(stripslashes($backend_title),ENT_COMPAT,'UTF-8').')</small>':''),
																								      (int) str_replace('articlesystem','',$v),
																											$_AS['article_obj']->lang->get('settings_admin_delete'),
																											$_AS['article_obj']->lang->get('settings_admin_delete2'),
																											$_AS['article_obj']->lang->get('settings_admin_new_backend'),
																											$_AS['article_obj']->lang->get('settings_admin_section_new_backend_title'),
																											$_AS['article_obj']->lang->get('settings_admin_delete_confirm1'),
																											$_AS['article_obj']->lang->get('settings_admin_delete_confirm2'),
																											$_AS['article_obj']->lang->get('settings_admin_delete2_confirm1')
																											),
																								$_AS['tpl']['db_setting_action']);
																								
	$_AS['output']['temp2'][190+$i] = str_replace('{dbstr}',
																								strtoupper($v).(!empty($backend_title)?' ('.stripslashes($backend_title).') ':''),	
																								$_AS['output']['temp2'][190+$i] );
	
	if (!empty($backend_title))
	  $_AS['output']['temp2'][190+$i] = preg_replace('#\{showhide\}(.*)\{/showhide\}#sU','',$_AS['output']['temp2'][190+$i]);
	else
	  $_AS['output']['temp2'][190+$i] = str_replace(array('{showhide}','{/showhide}'), array('',''), $_AS['output']['temp2'][190+$i]);
	
	if (empty($backend_title))
	  $_AS['output']['temp2'][190+$i] = preg_replace('#\{hideshow\}(.*)\{/hideshow\}#sU','',$_AS['output']['temp2'][190+$i]);
	else
	  $_AS['output']['temp2'][190+$i] = str_replace(array('{hideshow}','{/hideshow}'), array('',''), $_AS['output']['temp2'][190+$i]);

} else {
	$_AS['output']['temp2'][190+$i] = str_replace('{lng_uni}',
																								strtoupper($v).
																								(!empty($backend_title)?' <small>('.htmlentities(stripslashes($backend_title),ENT_COMPAT,'UTF-8').')</small>':''),
																								$_AS['tpl']['db_setting_curr']);
}
$i=$i+10;

}//Ende for



ksort($_AS['output']['temp2'],SORT_NUMERIC);
foreach ($_AS['output']['temp2'] as $v)
$_AS['output']['body'] .= $v;

$_AS['output']['settings']=str_replace(
	array(
		'{formurl}',
		'{body}',
		'{save}',
		'{foralllangs}',
		'{db_new_backend}',
		'{lng_admin_asdb}',
		'{lng_settings_admin_notice}'
	),
	array(
		$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin=articlesystem/admin/index.php&subarea=admin&action=show_db_settings'),
		$_AS['output']['body'],
		$_AS['article_obj']->lang->get('settings_admin_new'),
		$_AS['article_obj']->lang->get('foralllangs'),
		$_AS['article_obj']->lang->get('settings_backend_menu_string'),
		$_AS['article_obj']->lang->get('settings_admin_asdb'),
		$_AS['article_obj']->lang->get('settings_admin_notice')
	),
	$_AS['tpl']['settings_body']);


echo str_replace(array('{sf_skin}',
											 '{lng_settings_admin}'),
								 array($_AS['article_obj']->getSetting('skin'),
											 $_AS['article_obj']->lang->get('settings_admin') ),
								 $_AS['tpl']['be_navi']);
								 			 
echo $_AS['output']['settings'];
				
?>
