<?PHP
// File: $Id: main.php
// +----------------------------------------------------------------------+
// | Version: Sefrengo $Name:  $                                          
// +----------------------------------------------------------------------+
// | Copyright (c) 2005 - 2010 sefrengo.org <info@sefrengo.org>           |
// +----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify |
// | it under the terms of the GNU General Public License                 |
// |                                                                      |
// | This program is subject to the GPL license, that is bundled with     |
// | this package in the file LICENSE.TXT.                                |
// | If you did not receive a copy of the GNU General Public License      |
// | along with this program write to the Free Software Foundation, Inc., |
// | 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA               |
// |                                                                      |
// | This program is distributed in the hope that it will be useful,      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the        |
// | GNU General Public License for more details.                         |
// |                                                                      |
// +----------------------------------------------------------------------+
// + Autor: $Author:
// +----------------------------------------------------------------------+
// + Revision: $Revision:
// +----------------------------------------------------------------------+
// + Description:
// +----------------------------------------------------------------------+
// + Changes: 
// +----------------------------------------------------------------------+
// + ToDo:
// +----------------------------------------------------------------------+

// Output buffering starten
ob_start();

if (function_exists('set_magic_quotes_runtime')) {
    @set_magic_quotes_runtime (0);
}

// zeige alle Fehlermeldungen, aber keine Warnhinweise und Deprecated-Meldungen
if (defined('E_DEPRECATED'))
{
	error_reporting (E_ALL & ~E_NOTICE & ~E_DEPRECATED);
}
else
{
	error_reporting (E_ALL & ~E_NOTICE);
}
// error_reporting (E_ALL);
// Flag f�r Windows-Systeme, um auf Windows nicht existierende Befehle zu blocken
$is_win =  strtoupper(substr(PHP_OS, 0, 3) == 'WIN');

// alle GET, POST und COOKIE wegen Globals_off parsen
// $types_to_register = array('GET','COOKIE','POST','SERVER','FILES','ENV','SESSION','REQUEST');
$types_to_register = array('GET','POST','SERVER');
foreach ($types_to_register as $global_type) {
        $arr = @${'HTTP_'.$global_type.'_VARS'};
        if (@count($arr) > 0) extract($arr, EXTR_OVERWRITE);
        else {
		$arr = @${'_'.$global_type};
                if (@count($arr) > 0) extract($arr, EXTR_OVERWRITE);
        }
}
$cfg_cms = '';$cfg_client ='';

$sefrengo = ( empty($sefrengo) ) ? $_COOKIE['sefrengo']: $sefrengo;

// notwendige Dateien includen
$this_dir = str_replace ('\\', '/', dirname(__FILE__) . '/');

if (! is_file($this_dir.'inc/config.php')) {
	die('NO CONFIGFILE FOUND');
}
require_once ($this_dir.'inc/config.php');
//Load API
require_once ($this_dir.'API/inc.apiLoader.php');

require_once ($this_dir.'inc/class.cms_debug.php');
include_once ('HTML/Template/IT.php');
include_once ($this_dir.'external/phplib/prepend.php');
include_once ($this_dir.'inc/class.user_perms.php');
include_once ($this_dir.'inc/class.values_ct.php');
require_once ($this_dir.'inc/fnc.general.php');
require_once ($this_dir.'inc/fnc.libary.php');
include_once ($this_dir.'inc/class.querybuilder_factory.php');
include_once ($this_dir.'inc/class.repository.php');



// Klassen initialisieren
$deb      = new cms_debug;
$db       = new DB_cms;
$db_query = new querybuilder_factory();
$db_query = $db_query -> get_db($db, 'cms_db', $this_dir.'inc/');
$val_ct   = new values_ct();

// Konfigurationsparameter einlesen
$cfg_cms_temp = $val_ct -> get_cfg();
$cfg_cms = array_merge($cfg_cms, $cfg_cms_temp);
unset($cfg_cms_temp);

// dB Optimice
if ( $cfg_cms['db_optimice_tables']['enable'] && (time() > ($cfg_cms['db_optimice_tables']['last_run'] + $cfg_cms['db_optimice_tables']['time']))) {
    lib_optimice_tables();
    $val_ct->set_value(array('group' => 'cfg', 'client' => 0, 'key' => 'db_optimice_tables', 'key2' => 'last_run', 'value' => time()));
}

// Template initialisieren
$tpl = new HTML_Template_IT($this_dir.'tpl/'.$cfg_cms['skin'].'/',true,true);

// Session starten
page_open(array('sess' => 'cms_Backend_Session','auth' => 'cms_Backend_Auth'));

// Sessionvariablen initialisieren
$sess->register('sid_client');
$sess->register('sid_lang');
$sess->register('sid_lang_charset');
$sess->register('sid_area');
$sess->register('sid_sniffer');
$client       = (empty($client))       ? $sid_client       : $client;
$lang         = (empty($lang))         ? $sid_lang         : $lang;
$lang_charset = (empty($lang_charset)) ? $sid_lang_charset : $lang_charset;

$perm         = &new cms_perms($client, $lang);
$client       = $perm -> get_client();
$lang         = $perm -> get_lang();
$lang_charset = $perm -> get_lang_charset();

// Projekt initialisieren
$sid_client   = $client;

// Sprache initialisieren
$sid_lang         = $lang;
$sid_lang_charset = $lang_charset;

// Multilanguage initialisieren
$val_ct->values_ct();

// Area initialisieren
if (isset($area)) $sid_area = $area;
else $area = $sid_area;

// Wenn area nicht erlaubt ist, redirecten auf erlaubte area, wenn m�glich
$pos = strpos($area, '_');
$allowed_area = (!$pos) ? $area: substr( $area, 0, $pos );
if( !$perm->have_perm('area_'. $allowed_area) && $area != 'logout' && $area != 'plugin'){
	$new_area = $perm->get_first_allowed_area();
	if(! empty($new_area)){
		$area = $new_area;
		unset($new_area);
	}
}

// Sprachdatei einlesen
$lang_dir = $this_dir.'tpl/'.$cfg_cms['skin'].'/lang/'.$cfg_cms['backend_lang'].'/';
$lang_defdir = $this_dir.'tpl/standard/lang/deutsch/';
require_once( ( file_exists($lang_dir.'lang_general.php') ? $lang_dir: $lang_defdir ) .'lang_general.php');
// Sprachdatei f�r Area einlesen
if (file_exists ($lang_dir."lang_$area.php")) {
	include_once($lang_dir."lang_$area.php");
} else {
	$deb -> collect('Fehlt: Sprachdatei f�r Area: ' . $area);
	if (file_exists ($lang_defdir."lang_$area.php")) {
		include_once($lang_defdir."lang_$area.php");
	}
}


// Rechte �berpr�fen
$cfg_client = $val_ct -> get_by_group('cfg_client', $client);
$deb -> collect('Projekt Id: ' . $client);
$deb -> collect('Lang Id: '    . $lang);
$deb -> collect('User Id: '    . $perm -> user_id);
$deb -> collect('Group Id: '   . $perm -> idgroup);
$deb -> collect('File:' .__FILE__.' Line:' .__LINE__, 'mem');

// Repository laden
$rep        = &new repository;
// Run init Plugins
if ( $cfg_rep['repository_init_plugins'] ) $rep->init_plugins();

// Area w�hlen
include("inc/inc.$area.php");

// Template ausspucken
$tpl->show();

// Output buffering beenden
if ($area != 'logout') page_close();
$output = ob_get_contents();
ob_end_clean();
$output .= $deb -> show();

//eventuelle autostarts ausf�hren:
if (is_array($cfg_cms['autostart']['backend'])) {
	foreach($cfg_cms['autostart']['backend'] as $value) include_once $cfg_cms['cms_path'] .'plugins/'. $value;
}

// Seite komprimieren und ausgeben
$ACCEPT_ENCODING = getenv("HTTP_ACCEPT_ENCODING");
if (($cfg_cms['gzip'] == '1') && ereg("gzip",$ACCEPT_ENCODING) && (false == headers_sent())) {
     @ob_start('ob_gzhandler');
     eval($cfg_cms['manipulate_output']);
     @ob_end_flush();
} else eval($cfg_cms['manipulate_output']);
// phpinfo();
?>