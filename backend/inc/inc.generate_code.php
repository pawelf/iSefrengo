<?PHP
/**
  *
  * Copyright (c) 2005 - 2007 sefrengo.org <info@sefrengo.org> 
  * Copyright (c) 2010 - 2011 iSefrengo
  *
  * This program is free software; you can redistribute it and/or modify
  * it under the terms of the GNU General Public License
  *
  * This program is subject to the GPL license, that is bundled with
  * this package in the file LICENSE.TXT.
  * If you did not receive a copy of the GNU General Public License
  * along with this program write to the Free Software Foundation, Inc.,
  * 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA
  *
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.
  *
  *
  * @author
  *
  */
if(!defined('CMS_CONFIGFILE_INCLUDED')){die('NO CONFIGFILE FOUND');}

include($cms_path.'inc/fnc.type.php');

// Template suchen
$sql = "SELECT A.idtplconf, B.idtpl 
        FROM $cms_db[side_lang] A LEFT JOIN $cms_db[tpl_conf] B USING(idtplconf)
        WHERE A.idside='$idside' AND A.idlang='$lang' AND A.idtplconf!='0'";
$db->query($sql);
if(!$db->affected_rows())
{
	$sql = "SELECT A.idtplconf, B.idtpl
	        FROM $cms_db[cat_lang] A LEFT JOIN $cms_db[tpl_conf] B USING(idtplconf)
	        WHERE A.idcat='$idcat' AND A.idlang='$lang' AND A.idtplconf!='0'";
	$db->query($sql);
}
if($db->next_record())
{
// Templatekonfiguration suchen
	$idtpl = $db->f('idtpl');
	$sql = "SELECT A.config, A.view, A.edit, B.container, C.name, C.output, C.idmod, C.verbose
	        FROM $cms_db[container_conf] A LEFT JOIN $cms_db[container] B USING(idcontainer)
	        LEFT JOIN $cms_db[mod] AS C USING(idmod)
	        WHERE A.idtplconf='".$db->f('idtplconf')."'";
	$db->query($sql);
	while($db->next_record())
	  $container[$db->f('container')] = array ($db->f('config'), $db->f('view'), $db->f('edit'), $db->f('name'), $db->f('output'), $db->f('idmod'), $db->f('verbose'));

// Content-Array erstellen
	$sql = "SELECT A.idcontent, container, number, idtype, typenumber, value
	        FROM $cms_db[content] A LEFT JOIN $cms_db[side_lang] B USING(idsidelang)
	        WHERE B.idside='$idside' AND B.idlang='$lang' ORDER BY number";
	$db->query($sql);
	while($db->next_record())
	  $content[$db->f('container')][$db->f('number')][$db->f('idtype')][$db->f('typenumber')] = array($db->f('idcontent'), $db->f('value'));

// Layout suchen
  $sql = "SELECT idlay
			    FROM ".$cms_db['tpl']." 
			    WHERE idtpl='$idtpl'";
	$db->query($sql);
	$db->next_record();
	$idlay = $db->f('idlay');
//Header API	
	$SF_layout =& sf_factoryGetObjectCache('HEADER', 'Headerinfos');
	$layout = $SF_layout->getCode($idlay);
	$layout = str_replace('<CMSPHP:CACHE>', '<?PHP ', $layout);
	$layout = str_replace('</CMSPHP:CACHE>', ' ?>', $layout);
	$layout = $SF_layout->SF_Switch_Doctype($idlay).$layout;

// Container generieren
	$list = extract_cms_tags($layout);
	if(is_array($list))
	{
		foreach($list as $cms_mod['container'])
		{
// Head-Container?
			if($cms_mod['container']['type'] == 'head')
			{
// Head Meta-Tags generieren Infos Header API
				$code ='';
				$code .= '<CMSPHP> if($cfg_client[\'url_rewrite\'] == \'2\') echo \'<base href="\'.htmlspecialchars(str_replace(\'{%http_host}\',  $_SERVER[\'HTTP_HOST\'], $cfg_client[\'url_rewrite_basepath\']), ENT_COMPAT, \'utf-8\').\'"'.$SF_layout->SF_Slash_Closing_Tag($idlay).'>\'."\n"; </CMSPHP>';
				$code .= "<meta name=\"generator\" content=\"Sefrengo / www.sefrengo.org\" ".$SF_layout->SF_Slash_Closing_Tag($idlay).">\n";
				$code .= '<?PHP if($SF_pageinfos->getMetaAuthor($idcatside)!= \'\') echo \'<meta name="author" content="\'.htmlspecialchars($SF_pageinfos->getMetaAuthor($idcatside), ENT_COMPAT, \'utf-8\').\'"'.$SF_layout->SF_Slash_Closing_Tag($idlay).'>\'."\n"; ?>';
				$code .= '<?PHP if($SF_pageinfos->getMetaDescription($idcatside) != \'\') echo \'<meta name="description" content="\'.htmlspecialchars($SF_pageinfos->getMetaDescription($idcatside), ENT_COMPAT, \'utf-8\').\'"'.$SF_layout->SF_Slash_Closing_Tag($idlay).'>\'."\n"; ?>';
				$code .= '<?PHP if($SF_pageinfos->getMetaKeywords($idcatside) != \'\') echo \'<meta name="keywords" content="\'.htmlspecialchars($SF_pageinfos->getMetaKeywords($idcatside), ENT_COMPAT, \'utf-8\').\'"'.$SF_layout->SF_Slash_Closing_Tag($idlay).'>\'."\n"; ?>';
				$code .= '<?PHP if($SF_pageinfos->getMetaRobots($idcatside) != \'\') echo \'<meta name="robots" content="\'.htmlspecialchars($SF_pageinfos->getMetaRobots($idcatside), ENT_COMPAT, \'utf-8\').\'"'.$SF_layout->SF_Slash_Closing_Tag($idlay).'>\'."\n"; ?>';
        if($SF_layout->getDoctype($idlay)!='html-5')
        {
				  $code .= '<meta http-equiv="content-type" content="text/html; charset='.$lang_charset.'"'.$SF_layout->SF_Slash_Closing_Tag($idlay).'>'."\n";
        }else{
          $code .= '<meta charset="'.$lang_charset.'"'.$SF_layout->SF_Slash_Closing_Tag($idlay).'>'."\n";
        }
//JS and CSS file include
				$sql = "SELECT C.filetype, D.dirname, B.filename
						    FROM ". $cms_db['lay_upl'] ." A
							  LEFT JOIN ". $cms_db['upl'] ." B USING(idupl)
							  LEFT JOIN ". $cms_db['filetype'] ." C USING(idfiletype)
							  LEFT JOIN ". $cms_db['directory'] ." D on B.iddirectory=D.iddirectory
						    WHERE idlay='$idlay'";
				$db->query($sql);
				while($db->next_record())
				{
					if($db->f('filetype') == 'js')  $code .= "<script src=\"".$db->f('dirname').$db->f('filename')."\" type=\"text/javascript\"></script>\n";
					if($db->f('filetype') == 'css') $code .= "<link rel=\"StyleSheet\" href=\"".$db->f('dirname').$db->f('filename')."\" type=\"text/css\" ".$SF_layout->SF_Slash_Closing_Tag($idlay).">\n";
				}
				$search[]  = $cms_mod['container']['full_tag'];
				$replace[] = $code;
// Seitenkonfigurationslayer?
			}elseif($cms_mod['container']['type'] == 'config'){
				$search[]  = $cms_mod['container']['full_tag'];
				$replace[] = '<CMSPHP> if ($cms_side[\'view\']) echo $con_side[$idcatside][\'config\'];</CMSPHP>';
			}else{
				unset($code);
				unset($config);
				unset($output);
// darf Modul gesehen werden?
				if($container[$cms_mod['container']['id']]['1'] == '0' || $container[$cms_mod['container']['id']]['1'] == $auth->auth['uid']) {
// Container konfigurieren
					$code   = $container[$cms_mod['container']['id']]['4'];
					$config = preg_split('/&/', $container[$cms_mod['container']['id']]['0']);
					foreach($config as $key1 => $value1)
					{
						$tmp2 = explode('=', $value1);
						if($tmp2['1'] != '')
						{
// $mod_value Array schreiben
							$cms_mod['value'][$tmp2['0']] = cms_stripslashes(urldecode($tmp2['1']));
// MOD_VALUE[x] ersetzen
							$code = str_replace('MOD_VALUE['.$tmp2['0'].']', str_replace("\'","'", urldecode($tmp2['1'])), $code);
						}
						unset($tmp2);
					}
// nicht benutzte Variablen strippen
					$code = preg_replace('/MOD_VALUE\[\d*\]/', '', $code);
					$code = str_replace('<CMSPHP:CACHE>', '<?PHP ', $code);
	        $code = str_replace('</CMSPHP:CACHE>', ' ?>', $code);
					if(stristr($code, '<cms:mod constant="tagmode" />'))
					{
						$code = str_replace('<cms:mod constant="tagmode" />', '', $code);
						$code = cms_stripslashes($code);
					}
// Das Modul existiert noch nicht in der Datenbank
					if(!is_array($content[$cms_mod['container']['id']])) $content[$cms_mod['container']['id']]['1'] = 'neu';
// Alle MOD_TAGS[] im Container ersetzen
					$used_type = extract_cms_tags($code);
// alle Module in einem Container generieren
					if(is_array($content[$cms_mod['container']['id']]))
					{
					  foreach($content[$cms_mod['container']['id']] as $key3 => $value3)
					  {
// letztes Modul in diesem Container?
							if (!$content[$cms_mod['container']['id']][$key3+1]) {
								$cms_mod['modul']['lastentry'] = 'true';
								$pre_container_code = '<CMSPHP> $cms_mod[\'modul\'][\'lastentry\']=\'true\'; </CMSPHP>';
							} else {
								unset($cms_mod['modul']['lastentry']);
								$pre_container_code = '<CMSPHP> unset($cms_mod[\'modul\'][\'lastentry\']); </CMSPHP>';
							}
	
							// erstes Modul generieren?
							if ($key3 == '1') {
								$container_code = $code;
								if (is_array($used_type)) {
									// CMS-TAG in Funktionsaufruf umwandeln
									foreach ($used_type as $value4) {
										// CMS-TAG Konfiguration auslesen
										$cms_type_config = '\'';
										foreach ($value4 as $key5=>$value5) {
											if ($key5 != 'type' && $key5 != 'id' && $key5 != 'full_tag') $cms_type_config .= '\''.$key5.'\'=>\''.str_replace('\"','"', cms_addslashes($value5)).'\',';
										}
	
										// letztes Komma entfernen
										$cms_type_config = substr ($cms_type_config,  1, -1);
										if (!$value4['id']) $value4['id'] = '0';
										if ($value4['addslashes'] == 'true') $container_code = str_replace($value4['full_tag'], 'type_output_'.strtolower($value4['type']).'('.$cms_mod['container']['id'].', $cms_mod[\'modul\'][\'id\'], '.$value4['id'].', array('.$cms_type_config.'))', $container_code);
										else $container_code = str_replace($value4['full_tag'], '<?PHP echo type_output_'.strtolower($value4['type']).'('.$cms_mod['container']['id'].', $cms_mod[\'modul\'][\'id\'], '.$value4['id'].', array('.$cms_type_config.')); ?>', $container_code);
									}
								}
	
								// Modul cachen
								eval('$cms_mod[\'modul\'][\'id\'] = $key3;$cms_mod[\'key\'] = \'mod\'.$cms_mod[\'container\'][\'id\'].\'_\'.$key3.\'_\'; ?>'.$pre_container_code.$container_code);
								$container_code_final = ob_get_contents ();
								ob_end_clean ();
								ob_start();
								$output = '<CMSPHP> $cms_mod[\'modul\'][\'id\']=\''.$key3.'\';$cms_mod[\'key\'] = \'mod\'.$cms_mod[\'container\'][\'id\'].\'_'.$key3.'_\'; </CMSPHP>'.$container_code_final;
	
							// alle weiteren Module dranhängen
							} else {
								// Modul cachen
								eval('$cms_mod[\'modul\'][\'id\'] = $key3;$cms_mod[\'key\'] = \'mod\'.$cms_mod[\'container\'][\'id\'].\'_\'.$key3.\'_\'; ?>'.$pre_container_code.$container_code);
								$container_code_final = ob_get_contents ();
								ob_end_clean ();
								ob_start();
								$output .= '<CMSPHP> $cms_mod[\'modul\'][\'id\']=\''.$key3.'\';$cms_mod[\'key\'] = \'mod\'.$cms_mod[\'container\'][\'id\'].\'_'.$key3.'_\'; </CMSPHP>'.$container_code_final;
							}
						}
					}

					// Container in Array schreiben
					$search[] = $cms_mod['container']['full_tag'];

					// ist Modul sichtbar?
					if ($container[$cms_mod['container']['id']]['1'] == '0') {
						$replace[] = '<!--START '.$cms_mod['container']['id'].'//--><CMSPHP> $cms_mod[\'container\'][\'id\']=\''.$cms_mod['container']['id'].'\'; </CMSPHP>'.$output.'<!--END '.$cms_mod['container']['id'].'//-->';
					}	else {
						$replace[] = '<!--START '.$cms_mod['container']['id'].'//--><CMSPHP> $cms_mod[\'container\'][\'id\']=\''.$cms_mod['container']['id'].'\'; if(\''.$container[$cms_mod['container']['id']]['1'].'\'==$auth->auth[\'uid\']) { </CMSPHP>'.$output.'<CMSPHP> } </CMSPHP><!--END '.$cms_mod['container']['id'].'//-->';
					}
					unset($output);
					unset($used_type, $cms_mod['value']);
				} else {
					// Modul ist nicht sichtbar
					$search[] = $cms_mod['container']['full_tag'];
					$replace[] = '';
				}
			}
		}

		// Seite erstellen
		$code = $layout;
		foreach ($search as $key=>$value) {
			$code = str_replace($value, $replace[$key], $code);
		}
	} else $code = $layout;
} else $code = $cms_lang['con_notemplate'];

// Dynamisches PHP beibehalten
eval(' ?>'.$code);
$code = ob_get_contents ();
ob_end_clean ();
ob_start();
$code = str_replace('<CMSPHP>', '<?PHP ', $code);
$code = str_replace('</CMSPHP>', ' ?>', $code);
// Dateilinks ersetzen
// Dateilinks suchen...
preg_match_all("!cms://idfile=(\d+)!", $code, $internlinks);
$sql_links = implode(',', $internlinks[1]);
if ($sql_links != '') {
	$sql = "SELECT
				A.idupl id, A.filename filename,B.dirname dirname
			FROM
				".$cms_db['upl']." as A
				LEFT JOIN ". $cms_db['directory'] ." as B USING(iddirectory)
			WHERE
				A.idclient=$client
				AND A.idupl IN ($sql_links)";
	$db->query($sql);
	while($db->next_record()){
		$cms_file[$db->f('id')] = $cfg_client['upl_htmlpath'].$db->f('dirname').$db->f('filename');
	}
}
//...und ersetzen
$in ="'cms://idfile=(\d+)'e";
$out = '\$cms_file[\\1]';
$code = preg_replace($in, $out, $code);
?>
