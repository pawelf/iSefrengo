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
<style type="text/css">
body {font-family:sans-serif;font-size:90%}

.shorturl {
	display:block;
}
.shorturl a{
	float:right;
	font-weight:normal;
	color:#144282;
	text-decoration:none;
}
.shorturl a:hover{
	text-decoration:underline;
}

.fullwidtherrormsg {
	font-size:12px;font-family:verdana;font-weight:bold;
	min-height:22px;
	background:#fdd;
	color:#f00;
	font-weight:bold;
	padding:5px;
	border:1px solid #f00;

	margin-bottom:10px;
}

.fullwidthmsg {
	font-size:12px;font-family:verdana;font-weight:bold;
	min-height:22px;
	background:#ddd;
	color:#666;
	font-weight:bold;
	padding:5px;
	border:1px solid #999;

	margin-bottom:10px;
}

.fullwidthsuccessmsg {
	font-size:12px;font-family:verdana;font-weight:bold;
	min-height:22px;
	background:#dfd;
	color:#090;
	font-weight:bold;
	padding:5px;
	border:1px solid #090;

	margin-bottom:10px;
}

input,submit,label,
#previewtabs {
	font-size:11px;
	font-family:verdana,sans-serif;
}

</style>

<body>

<?PHP

// get action
$_AS['TMP']['action']=$_AS['cms_wr']->getVal('action');

// frame reload+submit to get selected articles from parent window
if (strpos($_AS['TMP']['action'],'multi')!==false) {
?>

<form name="frm" method="post" action="export.php?action=<?PHP echo str_replace('multi','',$_AS['TMP']['action']); ?>mreload" style="margin:0;padding:0;display:inline;">
	<input id="selected" name="selected" type="text" value=""/>
	<input name="db" type="text" value="<?PHP echo $_AS['cms_wr']->getVal('db'); ?>"/>
</form>

<script  type="text/javascript">
	var chkbxs=window.parent.document.getElementsByName('article_sel[]');
	for ( i=0; i<chkbxs.length ;i++) {
		if (chkbxs[i].checked==true)
			document.frm.selected.value+=chkbxs[i].value+',';
	}
	document.frm.submit();
</script>

<?PHP
}
#

// get mode
if (strpos($_AS['TMP']['action'],'facebook')!==false)
	$_AS['TMP']['exportmode']='facebook';

if (strpos($_AS['TMP']['action'],'twitter')!==false)
	$_AS['TMP']['exportmode']='twitter';


// create article-to-export-array
if (strpos($_AS['TMP']['action'],'mreload')===false)
	$_AS['TMP']['ARTICLES'][]=$_AS['cms_wr']->getVal('idarticle');
else {
	$_AS['TMP']['ARTICLESTMP']=$_AS['cms_wr']->getVal('selected');
	$_AS['TMP']['ARTICLES']=explode(',',$_AS['TMP']['ARTICLESTMP']);
	$_AS['TMP']['ARTICLES']=array_filter($_AS['TMP']['ARTICLES']);
	unset($_AS['TMP']['ARTICLESTMP']);
}

// get current articlesystem-db
$_AS['db']=$_AS['cms_wr']->getVal('db');
//AdoDB initialtisieren
$adodb =& $GLOBALS['sf_factory']->getObject('DATABASE', 'Ado');

// get categories
$sql = "SELECT idcategory, name FROM ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_category WHERE idclient='".$client."' AND idlang='".$lang."' ORDER BY name,hash ASC"; // AND idlang='".$idlang."'
$rs = $adodb->Execute($sql);
$_AS['TMP']['categories']=array();
while (!$rs->EOF) {
    $_AS['TMP']['categories'][$rs->fields[0]] = $rs->fields[1];
    $rs->MoveNext();
}
$rs->Close();


// include base functions and classes
include_once $_AS['basedir'] . 'inc/fnc.articlesystem_utilities.php';
include_once $_AS['basedir'] . 'inc/fnc.articlesystem_generate.php'; 

include_once $_AS['basedir'] . 'inc/class.articlesystem.php'; //Basisklasse
include_once $_AS['basedir'] . 'inc/class.lang.php'; //Sprachobjekt

//Articlesystem init
$_AS['artsys_obj'] = new Articlesystem;

//include collections classes 
include_once $_AS['basedir'] . 'inc/class.articlecollection.php';
include_once $_AS['basedir'] . 'inc/class.elementcollection.php';


//Einige Config-Vars direkt holen

$_AS['TMP']['tpl_main'] = $_AS['artsys_obj']->getSetting('spfnc_'.$_AS['TMP']['exportmode'].'_tpl');
#$_AS['TMP']['tpl_images'] = $_AS['artsys_obj']->getSetting('spfnc_'.$_AS['TMP']['exportmode'].'_tpl_images');
#$_AS['TMP']['tpl_files'] = $_AS['artsys_obj']->getSetting('spfnc_'.$_AS['TMP']['exportmode'].'_tpl_files');
#$_AS['TMP']['tpl_links'] = $_AS['artsys_obj']->getSetting('spfnc_'.$_AS['TMP']['exportmode'].'_tpl_links');
#$_AS['TMP']['tpl_dates'] = $_AS['artsys_obj']->getSetting('spfnc_'.$_AS['TMP']['exportmode'].'_tpl_dates');

$_AS['TMP']['config']['date'] = str_replace( array('{day}', '{month}', '{year}'), 
																			array('d', 'm', 'Y'),
																			$_AS['artsys_obj']->getSetting('spfnc_'.$_AS['TMP']['exportmode'].'_tpl_cfg_date'));
$_AS['TMP']['config']['time'] = str_replace( array('{hour}', '{minute}'), 
																			array('%H', '%M'), 
																			$_AS['artsys_obj']->getSetting('spfnc_'.$_AS['TMP']['exportmode'].'_tpl_cfg_time'));
$_AS['TMP']['config']['time12'] = str_replace( array('{hour}', '{minute}'),
																				array('%I', '%M'),
																				$_AS['artsys_obj']->getSetting('spfnc_'.$_AS['TMP']['exportmode'].'_tpl_cfg_time'));
$_AS['TMP']['config']['time24'] = str_replace( array('{hour}', '{minute}'),
																				array('%H', '%M'),
																				$_AS['artsys_obj']->getSetting('spfnc_'.$_AS['TMP']['exportmode'].'_tpl_cfg_time'));

$_AS['TMP']['config']['filesize_str_b'] = 'Byte';
$_AS['TMP']['config']['filesize_str_kb'] = 'KByte';
$_AS['TMP']['config']['filesize_str_mb'] = 'MByte';
$_AS['TMP']['config']['filesize_decplaces'] = 2;
$_AS['TMP']['config']['day'] = 'd';
$_AS['TMP']['config']['month'] = 'm';
$_AS['TMP']['config']['year'] =  'Y';
$_AS['TMP']['config']['day2'] 	= '%A';
$_AS['TMP']['config']['month2'] = '%B';

//single article inits
$_AS['item'] = new SingleArticle;
#$_AS['elements'] = new ArticleElements;


if ($_AS['TMP']['exportmode']=='facebook') {
	$_AS['TMP']['api_key'] = $_AS['artsys_obj']->getSetting('spfnc_facebook_app_key');
	$_AS['TMP']['jslang_facebook_manualsentconfirm'] = $_AS['artsys_obj']->lang->get('spfnc_facebook_manualsentconfirm');
?>

<div id="fb-root"></div>
<script type="text/javascript">
	var applicationid='<?PHP echo $_AS['TMP']['api_key']; ?>';
	var jslangfbsentconfirm='<?PHP echo $_AS['TMP']['jslang_facebook_manualsentconfirm']; ?>';
</script>
<script type="text/javascript" src="js/export.facebook.js"></script>

<?PHP

}

if ($_AS['TMP']['exportmode']=='twitter') {
?>
<script type="text/javascript" src="js/export.twitter.js"></script>
<?PHP
}
$_AS['TMP']['article_count']=0;

//main loop to create the export data
foreach ($_AS['TMP']['ARTICLES'] as $id) {

	$_AS['TMP']['output'] = $_AS['TMP']['tpl_main'];

	$_AS['item']->loadById($id);

	if($_AS['item']->getDataByKey('online')!=1)
		continue;

	$_AS['TMP']['article_count']++;

  //Tpl in Tmp-Var kopieren
	$_AS['TMP']['data']	=		as_element_replacement(	$_AS['item'],
																										$_AS['artsys_obj'],
																										$_AS['item_elements']['image'],
																										'',
																										'',
																										'',
																										$_AS['TMP']['tpl_main'],
																										'',
																										'',
																										'',
																										'',
																										$_AS['TMP']['categories'],
																										$_AS['TMP']['config'],
																										false);

	//fill template - element dependent if-statements
	foreach ($_AS['TMP']['data'] as $k => $v)
		$_AS['TMP']['output']=str_replace('{'.$k.'}',$v,as_element_ifstatements($_AS['TMP']['output'],$_AS['TMP']['data'],$k,$v));
	
	// global if-statements
	$_AS['TMP']['output'] = as_element_sfifstatements($_AS['TMP']['output']);

	if (strpos($_AS['TMP']['output'],'{chop}')!==false){
  	preg_match_all('#\{chop\}(.*)\{/chop\}#sU',$_AS['TMP']['output'],$_AS['TMP']['chopparts']);
  	if (!empty($_AS['TMP']['chopparts']))
    	foreach ($_AS['TMP']['chopparts'][1] as $k => $v)
    		$_AS['TMP']['output']=str_replace(	$_AS['TMP']['chopparts'][0][$k],
    																				as_str_chop($v, 
    																										$_AS['artsys_obj']->getSetting('spfnc_'.$_AS['TMP']['exportmode'].'_tpl_cfg_chopmaxlength'),
    																										false, 
    																										$_AS['artsys_obj']->getSetting('spfnc_'.$_AS['TMP']['exportmode'].'_tpl_cfg_chopend'),
    																										false),
    																				$_AS['TMP']['output']);
    else
    	$_AS['TMP']['output']=str_replace(array('{chop}','{/chop}'), array('',''), $_AS['TMP']['output']);
	}

	if (strpos($_AS['TMP']['action'],'facebook')!==false) 
		include $_AS['basedir'] . 'inc/inc.export.facebook_create.php';
	
	if (strpos($_AS['TMP']['action'],'twitter')!==false) {
		include $_AS['basedir'] . 'inc/inc.export.twitter_create.php';
	}

}

if ($_AS['TMP']['article_count']==0){
?>
<script type="text/javascript">
	window.parent.tb_remove();
</script>

<?PHP
}
?>


</body>
</html>

