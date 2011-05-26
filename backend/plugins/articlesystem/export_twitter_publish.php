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
body {font-family:verdana,sans-serif;
			padding:5px 0;
			margin:0;}
form {
	margin:0;
	padding:0;
	display:inline;
}

#charcount {
	font-size:10px;
}

textarea {
	line-height:140%;
	font-size:12px;
	font-family:verdana,sans-serif;
	width:90%;
	height:65px;
	padding:3px;
}

</style>
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

$_AS['TMP']['sentdatetime']=$_AS['cms_wr']->getVal('sentdatetime');
$_AS['TMP']['data']=$_AS['cms_wr']->getVal('data');

?>

<form name="frm" method="post" action="export_twitter_publish.php?db=<?PHP echo $_AS['db']; ?>&amp;lang=<?PHP echo $lang; ?>&amp;client=<?PHP echo $client; ?>&amp;idarticle=<?PHP echo  $_AS['TMP']['idarticle']; ?>">
	<input name="sentdatetime" type="hidden" value="<?PHP echo $_AS['TMP']['sentdatetime']; ?>"/>
	<textarea name="data" onkeyup="if (this.value.length>140) this.value=this.value.substring(0,140);document.getElementById('charcount').innerHTML=this.value.length;"><?PHP echo htmlentities(urldecode(stripslashes($_AS['TMP']['data'])),ENT_COMPAT,'UTF-8'); ?></textarea>
	<div id="charcount" style="padding:3px;"></div>
	<input name="action" type="hidden" value=""/>
</form>

<?PHP
if (empty($_AS['TMP']['action'])) {
?>

<script type="text/javascript">
	document.frm.data.value=window.parent.data<?PHP echo  $_AS['TMP']['idarticle']; ?>;
	document.getElementById('charcount').innerHTML=document.frm.data.value.length;
	</script>

<?PHP
}

if ($_AS['TMP']['action']=='publish') {

#	include_once $_AS['basedir'] . 'inc/class.twitter.php';
	require_once($_AS['basedir'] . 'inc/twitteroauth/twitteroauth.php');
	$_AS['TMP']['sentdatetime']=$_AS['cms_wr']->getVal('sentdatetime');
	$_AS['TMP']['data']=$_AS['cms_wr']->getVal('data');
	$_AS['TMP']['data']=stripslashes($_AS['TMP']['data']);
	$_AS['TMP']['data']=html_entity_decode($_AS['TMP']['data'],ENT_COMPAT,'UTF-8');

	//Artikel intialisieren
	$_AS['TMP']['twitter_ckey']=$_AS['artsys_obj']->getSetting('spfnc_twitter_ckey');
	$_AS['TMP']['twitter_csecret']=$_AS['artsys_obj']->getSetting('spfnc_twitter_csecret');
	$_AS['twitter_oauth'] = new TwitterOAuth($_AS['TMP']['twitter_ckey'],
																					 $_AS['TMP']['twitter_csecret'],
																					 @file_get_contents($_AS['basedir'].'twitter_access_token'),
																					 @file_get_contents($_AS['basedir'].'twitter_access_token_secret'));

	$_AS['TMP']['twitter_response']=$_AS['twitter_oauth']->post('statuses/update', array('status' => $_AS['TMP']['data']));
	
	if (empty($_AS['TMP']['twitter_response']->error))	{
	?>
			<script type="text/javascript">
			  window.parent.document.getElementById('post<?PHP echo  $_AS['TMP']['idarticle']; ?>').className='fullwidthsuccessmsg';
			  document.frm.action.value='update';
			  document.frm.submit();
			</script>
	<?PHP
	} else {
	?>
			<script type="text/javascript">
			  window.parent.document.getElementById('post<?PHP echo  $_AS['TMP']['idarticle']; ?>').className='fullwidtherrormsg';
				document.getElementById('charcount').innerHTML='Error: <?PHP echo $_AS['TMP']['twitter_response']->error; ?>';
			</script>
	<?PHP
	}

}


if ($_AS['TMP']['action']=='update') {
	$_AS['TMP']['updatedateelement']=$_AS['artsys_obj']->getSetting('spfnc_twitter_lastsent_date_cf');
	$_AS['TMP']['updatedataelement']=$_AS['artsys_obj']->getSetting('spfnc_twitter_lastsent_data_cf');
	$_AS['TMP']['sentdatetime']=$_AS['cms_wr']->getVal('sentdatetime');
	$_AS['TMP']['data']=$_AS['cms_wr']->getVal('data');
	$_AS['TMP']['data']=stripslashes($_AS['TMP']['data']);
	
	//Artikel intialisieren
	$_AS['item'] = new SingleArticle;
	
	//init article's element
	$_AS['elements'] = new ArticleElements;
	$_AS['item']->loadById($_AS['TMP']['idarticle']);
	$_AS['item']->setData($_AS['TMP']['updatedateelement'], $_AS['TMP']['sentdatetime']);
	$_AS['item']->setData($_AS['TMP']['updatedataelement'], $_AS['TMP']['data']);
	$_AS['item']->save();

}

?>

</body>
</html>

