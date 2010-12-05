<?php 

/*
 * Sefrengo Serfertransfer-Wizard
 *  Version 2
 *
 * Kurzanleitung: 
 *  Kopieren Sie zunächst alle Dateien vom alten Server auf das 
 *  neue System. Erzeugen Sie anschließend einen Dump der Datenbank
 *  und spielen Sie auch diese im neuen System ein. Kopieren Sie nun 
 *  dieses Rufen Sie nun diese Datei in das backend/-Verzeichnis auf
 *  dem neuen System und Rufen Sie sie in Ihrem Browser auf.
 * 
 *  Folgenden Sie nun den Schritten durch die Sie der Wizard führt.
 *
 * Bei Fragen wenden Sie sich an das Sefrengo-Forum: 
 *  http://forum.sefrengo.org/
 *
 */


@error_reporting(E_ALL & ~E_NOTICE);

define('CMS_CONFIGFILE_INCLUDED', true);
$this_dir = str_replace ('\\', '/', dirname(__FILE__) . '/');

$configfile = $this_dir.'inc/config.php';
$configfound = is_file($configfile);

if($configfound) {
	include_once $this_dir.'API/inc.apiLoader.php';
	require_once($this_dir.'tpl/standard/lang/de/lang_settings.php');
	require_once($this_dir.'tpl/standard/lang/de/lang_clients_config.php');
	
	$wq = sf_factoryGetObject('HTTP', 'WebRequest');
	$action = $wq -> getVal('action', 'welcome');
	$no_header = $wq -> getVal('no-header', 'false') == 'true';
	
	$cfg = array(
		'cms_path' => str_replace ('\\', '/', dirname(__FILE__)) . '/', 
		'cms_html_path' => 'http://'.$_SERVER['HTTP_HOST'].str_replace('servertransfer.php', '', $_SERVER['PHP_SELF'])
	);
	$cfg_client = array(
		'path', 
		'htmlpath', 
		'space', 
		'url_rewrite_basepath', 
		'upl_path', 
		'upl_htmlpath'
	);
} else {
	$action = 'noconfigfile';
}

/**********************************************************/


if(!(isset($no_header) && $no_header)) {
header('Content-Type: text/html; charset=utf-8');
echo '<?'; ?>xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Sefrengo Servertransfer-Wizard</title>
		
		<style type="text/css">
*{
margin:0;
padding:0;
}
* html #content{
height:242px;
}
body{
background-color:#EFEFEF;
color:#000000;
font:.8em Verdana,Arial,Helvetica,sans-serif;
text-align:center;
}
h3{
background:#FFFFFF;
color:#FBC900;
font-size:.9em;
font-weight:bold;
}
label{
font-size:.85em;
font-weight:bold;
cursor:pointer;
}
option{
padding:2px 15px 0 4px;
}
select{
border:1px solid #B7D9FF;
font:.8em Verdana,Arial,Helvetica,sans-serif;
margin-bottom:1px;
padding:3px;
}
.breit{
border:1px solid #144282;
width:100%;
padding:2px;
}
.button{
background:url(./tpl/standard/img/bg_button.gif) #DDDDDD repeat-x bottom;
border:1px solid #999999;
color:#000000;
cursor:pointer;
font:.8em Verdana,Arial,Helvetica,sans-serif;
padding:3px;
text-align:center;
}
.buttons{
float:right;
padding:12px 10px;
}
.copyright{
color:#144282;
font-size:.8em;
font-weight:bold;
padding:18px 10px;
}
.fehl{
font-weight:bold;
font-size:.8em;
padding:5px 18px 0 18px;
color:#B00000;
}
.floatl{
float:left;
width:49%;
}
.floatr{
float:right;
width:49%;
}
.hide{
display:none;
}
.nojs{
background:#FFF5CE;
border-bottom:1px solid #FBC900;
color:#B00000;
font-size:.8em;
font-weight:bold;
padding:5px;
text-align:center;
}
.warning{
background:#FFF5CE;
border-bottom:1px solid #FBC900;
border-top:1px solid #FBC900;
}
#content{
border-bottom:1px solid #B7D9FF;
min-height:200px;
padding:20px;
}
#content .dbx-content{
font-size:.9em;
margin:0 0 0 18px;
padding:9px;
}
#content p{
margin:6px 0;
}
#header{
background-color: #144282;
border-bottom:2px solid #FBC900;
height:auto !important;
height:60px;
min-height:60px;
}
#header h2{
background:#144282;
color:#FBC900;
font-size:.8em;
font-weight:bold;
padding:10px 6px 4px 10px;
}
#header p{
background:#144282;
color:#FFFFFF;
font-size:.8em;
line-height:120%;
padding:0px 10px 4px 10px;
}
#header p span{
color:#FF6600;
}
#navi{
background:#DFEEFF;
border-top:1px solid #FFFFFF;
height:47px;
height:auto !important;
min-height:47px;
}
#wrapper{
background:#FFFFFF;
border:2px solid #144282;
color:#000000;
margin:100px auto 0 auto;
text-align:left;
width:478px;
}
.on{
background:url(./tpl/standard/img/bg_button.gif) #DAECA4 repeat-x;
border:1px solid #AAD52C;
}
.grey{
background-color: #F0F0F0;
color: #707070;
}
code { font-size: 1.2em; }
a { color: #144282; }
.copy_proposal { float: right; }
		</style>
	</head>
	<body>
		<noscript>
			<p class="nojs">Bitte aktivieren Sie Javascript in Ihrem Browser um den Servertransfer-Wizard fortsetzen zu k&#246;nnen!</p>
		</noscript>
		<h1 class="hide">Sefrengo 01.03.01 Setup</h1>
		<div id="wrapper">

<?php
} // end if(!$no-header)

switch($action) {
	case 'welcome':
		$prev = "";
		$next = "window.location.href='servertransfer.php?action=db';";
		
		echo '
			<div id="header">
				<h2>Wilkommen</h2>
				<p>Dieser Wizard wird Sie Schritt für Schritt durch die Änderungen führen, die für einen erfolgreichen Transfer Ihrer mit Sefrengo erstellten Webseite von einem Server auf einen anderen notwendig sind.</p>
			</div>
			<div id="content">';
		
		if(basename(__FILE__) != 'servertransfer.php') {
			echo '<p>Scheinbar haben Sie die Datei umbenannt. Die vom Sefrengo Servertransfer-Wizard vorgeschlagenen Pfade stimmen in diesem Fall u.U. nicht. Dieses Script <b>muss servertransfer.php heißen</b>.</p>';
		}
		echo '<p><b>Kopieren</b> Sie zunächst <b>alle Dateien</b> vom alten Server auf das neue System. Erzeugen Sie anschließend einen <b>Dump der Datenbank</b> und spielen Sie auch diese im neuen System ein. Rufen Sie nun diese Datei in Ihrem Browser auf.</p>';
		echo '<p>Bitte beachten Sie dass dieses Tool Ihnen die Arbeit erleichtern soll. Es gibt <strong>keine Garantie</strong> dass dieses Tool unter allen Umständen korrekt funktioniert. Erstellen Sie <strong>immer</strong> vorher eine Sicherungslopie der values-Tabelle sowie der /backend/inc/config.php, da ansonsten eine Wiederherstellung nicht möglich ist.</p>';
		break;
	case 'noconfigfile':
		echo '
			<div id="header">
				<h2>Konfigurationsdatei</h2>
				<p>Die Konfigurationsdatei wurde nicht gefunden!</p>
			</div>
			<div id="content">
				<p>Die Konfigurationsdatei <i>config.php</i> im <i>inc/</i>-Verzeichnis (<i>'.htmlspecialchars($configfile).'</i>) wurde nicht gefunden. Liegt der Sefrengo Servertransfer-Wizard evtl. nicht im <b>backend</b>-Ordner?</p>';
		break;
	case 'db':
		echo '
			<div id="header">
				<h2>Datenbankeinstellungen</h2>
				<p>Dies sind die aktuell gespeicherten Datenbank-Einstellungen. Passen Sie diese an die Einstellungen des neuen Servers an und klicken Sie anschließend auf Weiter.</p>
			</div>
			<div id="content">';
		
		$configtext = content($configfile);
		$search = '/^\s*\$cfg_cms\s*\[\s*\'{parameter}\'\s*\]\s*=\s*[\'"](.*)[\'"]\s*;\s*$/m';
		
		if(preg_match(str_replace('{parameter}', 'db_database', $search), $configtext, $match))
			$db_database_is = $match[1];
		
		if(preg_match(str_replace('{parameter}', 'db_user', $search), $configtext, $match))
			$db_user_is = $match[1];
		
		if(preg_match(str_replace('{parameter}', 'db_password', $search), $configtext, $match))
			$db_password_is = $match[1];
		
		echo '
		<form action="servertransfer.php?action=db-save" id="form" method="post">
			<input type="hidden" name="action" value="db-save" style="display: none;" />
			
			<p>
				<label for="db_database">Name der Datenbank</label><br />
				<input type="text" class="breit" id="db_database" name="db_database" value="'.$db_database_is.'" />
			</p>
			
			<p class="floatl">
				<label for="db_user">Datenbank-Username</label><br />
				<input type="text" class="breit" id="db_user" name="db_user" value="'.$db_user_is.'" />
			</p>
			
			<p class="floatr">
				<label for="db_database">Datenbank-Passwort</label><br />
				<input type="text" class="breit" id="db_password" name="db_password" value="'.$db_password_is.'" />
			</p>
		</form>';
		$prev = "window.location.href='servertransfer.php?action=welcome';";
		$next = "document.getElementById('form').submit();";
		
		break;
	
	case 'db-save':
	case 'db-download':
		$configtext = content($configfile);
		$search = '/^\s*\$cfg_cms\s*\[\s*\'{parameter}\'\s*\]\s*=\s*[\'"](.*)[\'"]\s*;\s*$/m';
		$replace = '$cfg_cms[\'{parameter}\'] = \'{value}\';';
		
		$db_database = $wq -> getVal('db_database', null);
		$db_user = $wq -> getVal('db_user', null);
		$db_password = $wq -> getVal('db_password', null);
		
		if(!is_null($db_database)) 
			$configtext = preg_replace(
				str_replace('{parameter}', 'db_database', $search), 
				str_replace(
					array('{parameter}', '{value}'), 
					array('db_database', $db_database),
					$replace), 
				$configtext);
		
		if(!is_null($db_user)) 
			$configtext = preg_replace(
				str_replace('{parameter}', 'db_user', $search), 
				str_replace(
					array('{parameter}', '{value}'), 
					array('db_user', $db_user),
					$replace), 
				$configtext);
		
		if(!is_null($db_password)) 
			$configtext = preg_replace(
				str_replace('{parameter}', 'db_password', $search), 
				str_replace(
					array('{parameter}', '{value}'), 
					array('db_password', $db_password),
					$replace), 
				$configtext);
		
		if($action == 'db-save') {
			if(is_writable($configfile)) {
				if(file_exists($configfile.'.bak')) @unlink($configfile.'.bak');
				@rename($configfile, $configfile.'.bak');
				$fp = fopen($configfile, 'w');
				fputs($fp, $configtext);
				fclose($fp);
				
				echo '
					<div id="header">
						<h2>Datenbankeinstellungen</h2>
						<p>Die Datenbank-Einstellungen wurden erfolgreich gespeichert. Es wurde ein Backup der Originaldatei angelegt.</p>
					</div>
					<div id="content">
						<p>Klicken Sie auf Weiter um fortzufahren.</p>';
			} else {
				echo '
					<div id="header">
							<h2>Datenbankeinstellungen</h2>
							<p>Die Datenbank-Einstellungen konnten nicht auf dem Server gespeichert werden.</p>
					</div>
					<div id="content">
					<p>Klicken Sie auf den folgenden Link um die neue Konfigurationsdatei herunter zu laden. Diese muss dann manuell in das /backend/inc-Verzeichnis auf dem Webserver geladen werden. Bestätigen Sie anschließend mit Weiter.</p>
					<form action="servertransfer.php?action=db-download" method="post" style="text-align: center;">
							<input type="hidden" name="no-header" value="true" />
							<input type="hidden" name="db_database" value="'.htmlspecialchars($db_database).'" />
							<input type="hidden" name="db_user" value="'.htmlspecialchars($db_user).'" />
							<input type="hidden" name="db_password" value="'.htmlspecialchars($db_password).'" />
							<input class="button" type="submit" id="download" value="Konfigurationsdatei herunterladen" accesskey="l" onfocus="this.className=\'button on\'" onmouseover="this.className=\'button on\'" onblur="this.className=\'button\'" onmouseout="this.className=\'button\'" />
					</form>';
			}
			$prev = "window.location.href='servertransfer.php?action=db';";
			$next = "window.location.href='servertransfer.php?action=path';";
		} elseif($action == 'db-download') {
			header('Content-Type: application/octet-stream; charset=utf-8');
			header('Content-Disposition: attachment; filename="config.php"');
			//header('Content-Type: text/plain; charset=utf-8');
			echo $configtext;
			exit();
		}
		break;
	
	case 'path':
		require_once($configfile);
		@$db = sf_factoryGetObject('DATABASE', 'Ado');
		if($db -> ErrorNo() != 0) {
			echo '
				<div id="header">
					<h2>Datenbankfehler</h2>
					<p>Die Datenbank-Verbindung konnte nicht hergestellt werden.</p>
				</div>
				<div id="content">
					<p>Die Datenbank meldete folgenden Fehler: <code>'.$db -> ErrorMsg().'</code></p>';
			$prev = "window.location.href='servertransfer.php?action=db';";
			$next = "";
		} else {
			echo '
				<div id="header">
					<h2>Pfade</h2>
					<p>Dies sind die aktuell gespeicherten Pfadangaben. Passen Sie die Pfade an die Anfroderungen des neuen Servers an. Sie können sich dabei an den Vorschlägen zu den Systemeinstellungen orientieren. Bestätigen Sie anschließend mit Weiter.</p>
				</div>
				<div id="content">
					<form action="servertransfer.php?action=path-save" id="form" method="post">
					<h2>Systemeinstellungen</h2>';
			foreach($cfg as $line => $proposal) {
				$sql = "SELECT value, conf_desc_langstring FROM $cms_db[values] WHERE group_name='cfg' AND key1='$line' LIMIT 1;";
				$rs = $db -> Execute($sql);
				if($rs !== false) {
					$lang = $rs -> fields['conf_desc_langstring'];
					if(isset($cms_lang[$lang])) {
						$lang = $cms_lang[$lang];
					}
					echo '<p><label for="cfg_'.$line.'">'.$lang.'</label><br />';
					echo '<input type="text" class="breit" name="cfg_'.$line.'" id="cfg_'.$line.'" value="'.$rs -> fields['value'].'" /></p>';
					echo '<p><label for="cfg_'.$line.'_proposal"><a href="" class="copy_proposal" onclick="document.getElementById(\'cfg_'.$line.'\').value = document.getElementById(\'cfg_'.$line.'_proposal\').value;return false;">[Übernehmen]</a> Vorgeschlagener neuer Wert</label>';
					echo '<input type="text" class="breit grey" name="cfg_'.$line.'_proposal" id="cfg_'.$line.'_proposal" value="'.$proposal.'" readonly="readonly" /></p>';
				}
			}
			
			$sql = "SELECT idclient, name FROM $cms_db[clients];";
			$rs = $db -> Execute($sql);
			
			$clients = array();
			if($rs !== false) {
				while(!$rs -> EOF) {
					$clients[$rs -> fields['idclient']] = $rs -> fields['name'];
					$rs -> MoveNext();
				}
			}
			
			foreach($clients as $id => $name) {
				echo '<br /><br /><br /><h2>Projekteinstellungen: '.$name.'</h2>';
				
				foreach($cfg_client as $line) {
					$sql = "SELECT value, conf_desc_langstring FROM $cms_db[values] WHERE group_name='cfg_client' AND key1='$line' AND idclient='$id' LIMIT 1;";
					$rs = $db -> Execute($sql);
					if($rs !== false) {
						while(!$rs -> EOF) {
							$lang = $rs -> fields['conf_desc_langstring'];
							if(isset($cms_lang[$lang])) {
								$lang = $cms_lang[$lang];
							}
							echo '<p><label for="cfg_client_'.$id.'_'.$line.'">'.$lang.'</label><br />';
							echo '<input type="text" class="breit" name="cfg_client_'.$id.'_'.$line.'" id="cfg_client_'.$id.'_'.$line.'" value="'.$rs -> fields['value'].'" /></p>';
							$rs -> MoveNext();
						}
					}
				}
			}
			echo '</form>';
			$prev = "window.location.href='servertransfer.php?action=db';";
			$next = "document.getElementById('form').submit();";
		}
		
		break;
	
	case 'path-save':
		require_once($configfile);
		@$db = sf_factoryGetObject('DATABASE', 'Ado');
		if($db -> ErrorNo() != 0) {
			echo '
				<div id="header">
					<h2>Datenbankfehler</h2>
					<p>Die Datenbank-Verbindung konnte nicht hergestellt werden.</p>
				</div>
				<div id="content">
					<p>Die Datenbank meldete folgenden Fehler: <code>'.$db -> ErrorMsg().'</code></p>';
			$prev = "window.location.href='servertransfer.php?action=path';";
			$next = "";
		} else {
			$updatesql = "TRUNCATE TABLE $cms_db[code];\n";
			foreach($cfg as $line => $proposal) {
				$value = $wq -> getVal('cfg_'.$line, null);
				if(!is_null($value)) 
					$updatesql .= "UPDATE $cms_db[values] SET value='$value' WHERE group_name='cfg' AND key1='$line' LIMIT 1;\n";
			}
			
			$sql = "SELECT idclient, name FROM $cms_db[clients];";
			$rs = $db -> Execute($sql);
			
			$clients = array();
			if($rs !== false) {
				while(!$rs -> EOF) {
					$clients[$rs -> fields['idclient']] = $rs -> fields['name'];
					$rs -> MoveNext();
				}
			}
			
			foreach($clients as $id => $name) {
				foreach($cfg_client as $line) {
					$value = $wq -> getVal('cfg_client_'.$id.'_'.$line, null);
					if(!is_null($value)) 
						$updatesql .= "UPDATE $cms_db[values] SET value='$value' WHERE group_name='cfg_client' AND key1='$line' AND idclient='$id' LIMIT 1;\n";
				}
			}
			$updatesql = explode("\n", $updatesql);
			foreach($updatesql as $sql) {
				if(trim($sql) == '') break;
				$db -> Execute($sql);
				if($db -> ErrorNo() != 0) {
					echo '
						<div id="header">
							<h2>Datenbankfehler</h2>
							<p>Wärend des Updates ist ein Fehler aufgetreten.</p>
						</div>
						<div id="content">
							<p>Diese Fehlermeldung wurde ausgegeben: <code>'.$db -> ErrorMsg().'</code>.</p>
							<p>Folgendes SQL-Query sollte ausgeführt werden: <code>'.$sql.'</code>.</p>
							<p>Bitte melden Sie diesen Fehler im <a href="http://forum.sefrengo.org">Sefrengo-Forum</a>.</p>';
					$prev = "window.location.href='servertransfer.php?action=path';";
					$next = "";
					break;
				}
			}
			if($db -> ErrorNo() == 0) {
				echo '
					<div id="header">
						<h2>Pfade</h2>
						<p>Die neuen Pfade wurden erfolgreich gespeichert.</p>
					</div>
					<div id="content">
						<p>Klicken Sie auf Weiter um fortzufahren.</p>';
			}
			$prev = "window.location.href='servertransfer.php?action=path';";
			$next = "window.location.href='servertransfer.php?action=bye';";
		}
		break;
	
	case 'bye':
		echo '
			<div id="header">
				<h2>Fertig</h2>
				<p>Alle Änderungen welche für den Betrieb Ihrer Webseite notwendig sind wurden erfolgreich gespeichert.</p>
			</div>
			<div id="content">
				<p>Wenn die von Ihnen eingegebenen Werte korrekt waren, sollte die Seite nun einwandfrei Funktionieren. Heben Sie jedoch dennoch Ihre Backups noch einige Tage auf, um sicherzustellen dass alles ohne Probleme funktioniert. <strong>Löschen Sie nun unbedingt dieses Script!</strong></p>
				<p>Klicke Sie nun auf <a href="main.php">Weiter</a> um sich anzumelden.</p>
				<p>Wenn Sie Verbesserungsvorschläge oder einen Fehler entdeckt haben, können Sie uns <a href="http://forum.sefrengo.org">Sefrengo-Forum</a> darüber informieren.</p>';
		$prev = "";
		$next = "window.location.href='main.php';";
		break;
}

echo '</div>';

echo '<div id="navi"><p class="buttons">';
if(isset($prev) && $prev != '') echo '<input class="button" type="button" id="prev" value="&laquo; Zurück" accesskey="z" onclick="'.$prev.'" onfocus="this.className=\'button on\'" onmouseover="this.className=\'button on\'"  onblur="this.className=\'button\'" onmouseout="this.className=\'button\'" /> ';
if(isset($next) && $next != '') echo '<input class="button" type="button" id="next" value="Weiter &raquo;" accesskey="w" onclick="'.$next.'" onfocus="this.className=\'button on\'" onmouseover="this.className=\'button on\'"  onblur="this.className=\'button\'" onmouseout="this.className=\'button\'" /> ';
echo '</p><p class="copyright">Sefrengo Servertransfer-Wizard | &copy; <a href="http://www.sefrengo.org">www.sefrengo.org</a></p></div>';

function content($_) {
	$buffer = '';
	$fp = fopen($_, 'r');
	if($fp) {
		while(!feof($fp)) {
			$buffer .= fgets($fp, 2048);
		}
		fclose($fp);
	}
	return $buffer;
}

?>
		</div>
	</body>
</html>
<!-- 
  Sefrengo Servertransfer-Script
    Version 2
  
  Design & Layout by LIVINGPIXEL for Sefrengo.org
  Programming by Peter Körner <peter@3easysteps.de>
-->
