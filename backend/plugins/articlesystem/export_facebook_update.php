<?php
// zeige alle Fehlermeldungen, aber keine Warnhinweise
error_reporting (E_ALL & ~E_NOTICE);

$_AS['basedir'] = str_replace ('\\', '/', dirname(__FILE__) . '/');
	
$types_to_register = array('GET','POST','SERVER');
foreach ($types_to_register as $global_type) {
	$arr = @${'HTTP_'.$global_type.'_VARS'};
	if (@count($arr) > 0)
		extract($arr, EXTR_OVERWRITE);
	else {
		$arr = @${'_'.$global_type};
		if (@count($arr) > 0) extract($arr, EXTR_OVERWRITE);
	}
}
$client = (int) $_POST['client'];
$lang = (int) $_POST['lang'];

define('SF_SKIP_HEADER', true);


require_once ($_AS['basedir'].'/../../inc/inc.init_external.php');

$perm->check('area_plug_newslettersystem');


$cfg_client['session_enabled'] = '0'; 	
	
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');	
}


//CMS Webrequest erstllen
$_AS['cms_wr'] =& $GLOBALS['sf_factory']->getObject('HTTP', 'WebRequest');

$_AS['TMP']=array();

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title></title>
</head>

<body>

<?PHP

// get action
$_AS['TMP']['action']=$_AS['cms_wr']->getVal('action');
$_AS['TMP']['idarticle']=$_AS['cms_wr']->getVal('idarticle');

// get mode
if (strpos($_AS['TMP']['action'],'facebook')!==false)
	$_AS['TMP']['exportmode']='facebook';

if (strpos($_AS['TMP']['action'],'twitter')!==false)
	$_AS['TMP']['exportmode']='twitter';

// get current articlesystem-db
$_AS['db']=$_AS['cms_wr']->getVal('db');
//AdoDB initialtisieren
$adodb =& $GLOBALS['sf_factory']->getObject('DATABASE', 'Ado');


// include base functions and classes
include_once $_AS['basedir'] . 'inc/fnc.articlesystem_utilities.php';
include_once $_AS['basedir'] . 'inc/fnc.articlesystem_generate.php'; 

include_once $_AS['basedir'] . 'inc/class.articlesystem.php'; //Basisklasse
include_once $_AS['basedir'] . 'inc/class.lang.php'; //Sprachobjekt

//Articlesystem init
$_AS['artsys_obj'] = new Articlesystem;
$_AS['article_obj'] =@ $_AS['artsys_obj'];

//include collections classes 
include_once $_AS['basedir'] . 'inc/class.articlecollection.php';
include_once $_AS['basedir'] . 'inc/class.elementcollection.php';


?>

<form name="frm" method="post" action="export_facebook_update.php?db=<?PHP echo $_AS['db']; ?>&amp;lang=<?PHP echo $lang; ?>&amp;client=<?PHP echo $client; ?>&amp;idarticle=<?PHP echo  $_AS['TMP']['idarticle']; ?>"  style="margin:0;padding:0;display:inline;">
	<input name="sentdatetime" type="hidden" value=""/>
	<input name="sentdata" type="hidden" value=""/>
	<input name="action" type="hidden" value=""/>
</form>

<?PHP
if ($_AS['TMP']['action']=='update') {
$_AS['TMP']['updatedateelement']=$_AS['artsys_obj']->getSetting('spfnc_facebook_lastsent_date_cf');
$_AS['TMP']['updatedataelement']=$_AS['artsys_obj']->getSetting('spfnc_facebook_lastsent_data_cf');
$_AS['TMP']['sentdatetime']=$_AS['cms_wr']->getVal('sentdatetime');
$_AS['TMP']['sentdata']=$_AS['cms_wr']->getVal('sentdata');

//Artikel intialisieren
$_AS['item'] = new SingleArticle;

//init article's element
$_AS['elements'] = new ArticleElements;
$_AS['item']->loadById($_AS['TMP']['idarticle']);
$_AS['item']->setData($_AS['TMP']['updatedateelement'], $_AS['TMP']['sentdatetime']);
$_AS['item']->setData($_AS['TMP']['updatedataelement'], $_AS['TMP']['sentdata']);
$_AS['item']->save();

}

?>

</body>
</html>

