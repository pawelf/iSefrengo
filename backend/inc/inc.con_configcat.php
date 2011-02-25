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
  */
if(!defined('CMS_CONFIGFILE_INCLUDED')){die('NO CONFIGFILE FOUND');}

/** Benötigte Funktionen und Klassen includieren */

include('inc/fnc.tpl.php');
include('inc/fnc.mipforms.php');
include_once('inc/fnc.mod_rewrite.php');

/** Eventuelle Actions/ Funktionen abarbeiten */

// $idcat vorhanden, prüfen, ob Recht zum bearbeiten gegeben ist
if(is_numeric($idcat))
  $perm->check(3, 'cat', $idcat);
else
  $perm->check(2, 'cat', $parent);

// rewrite check
$sf_is_rewrite_error = false;
if ($action == 'save')
{
	$have_rewrite_perm = (is_numeric($idcat)) ? $perm->have_perm(15, 'cat', $idcat) : $perm -> have_perm(15, 'area_con', 0);
	if($cfg_client['url_rewrite'] == '2' && $have_rewrite_perm)
	{
	  if($_REQUEST['rewrite_use_automatic'] != '1')
	  {
			if(!rewriteUrlIsAllowed($_REQUEST['rewrite_alias']))
			{
			  $sf_is_rewrite_error = true;
				$sf_rewrite_error_message = $cms_lang['err_rewrite_Allowed'];
				$action = 'change';
			}elseif(!rewriteUrlIsUnique('idcat', $idcat, $_REQUEST['rewrite_alias'])){
				$sf_is_rewrite_error = true;
				$sf_rewrite_error_message = $cms_lang['err_rewrite_Unique_cat'];
				$action = 'change';				
			}elseif(rewriteManualUrlMatchAutoUrl($_REQUEST['rewrite_url'])){
				$sf_is_rewrite_error = true;
				$sf_rewrite_error_message = $cms_lang['err_rewrite_AutoUrl'];
				$action = 'change';	
			}
		} 
	}
}
// Ordnerkonfiguration speichern
switch($action)
{
	case 'save':  // Template bearbeiten
		$use_redirect = isset($_REQUEST['sf_apply']) ? false: true;
		$idcat = con_config_folder_save($idcat, $idcatside, $idtpl, $view, $idtplconf, $description, $title, $rewrite_use_automatic, $rewrite_alias, $parent, $area, $idlay, $use_redirect, false);
		if(isset($_REQUEST['sf_apply']))
		{
			$sql = "SELECT idtplconf FROM " . $cms_db['cat_lang'] ." WHERE idcat = $idcat AND idlang=$lang";
			$db->query($sql);
			$db->next_record();
			$idtplconf = $db->f('idtplconf');
		}
		
		break;
  case 'change':  // Layout oder Modul wechseln
		$cconfig = tpl_change($idlay);
		break;
}

// Generate cancel url for backend or frontend?
/**
if(empty($view))
{
	$sf_cancel_url = $sess->url('main.php?area=con');
}else{
	$sf_cancel_url = $sess->url($cfg_client['htmlpath'].$cfg_client['contentfile']."?lang=$lang&idcat=$idcat&idcatside=$idcatside&view=$view");
}
*/
// getrennte Header für Backend und Frontendbearbeitung
if(empty($view))
{
  include('inc/inc.header.php');
}else{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	echo "<!DOCTYPE html>\n";
	echo "<html lang=\"de\">\n";
	echo "<head>\n";
	echo "  <meta charset=\"utf-8\">\n";
	echo "  <title>Sefrengo ".$cfg_cms['version']."</title>\n";
	echo "  <link rel=\"stylesheet\" type=\"text/css\" href=\"tpl/".$cfg_cms['skin']."/css/styles.css\">\n";
	echo "  <script src=\"tpl/".$cfg_cms['skin']."/js/standard.js\" type=\"text/javascript\"></script>\n";
	echo "  <script src=\"tpl/".$cfg_cms['skin']."/js/tabpane.js\" type=\"text/javascript\"></script>\n";
	echo "</head>\n";
	echo "<body id=\"con-edit2\" onload=\"off();return true;\">\n";
}


$tpl->loadTemplatefile('cat_config.tpl',true,true);
//echo "<div id=\"main\">\n";
//if(!$view)
//echo "    <h5>".$cms_lang['area_con_configcat']."</h5>\n";
/*
if($errno)
  echo "<p class=\"errormsg\">".$cms_lang["err_$errno"]."</p>";
if($sf_is_rewrite_error)
  echo "<p class=\"errormsg\">Bitte pr&uuml;fen Sie Ihre Formulareingaben</p>";
*/

// getrennte Formularaufrufe für Backend und Frontendbearbeitung
/**
if(empty($view))
  echo "  <form name=\"editform\" method=\"post\" action=\"".$sess->url('main.php?area=con_configcat')."\">\n";
else
  echo "  <form name=\"editform\" method=\"post\" action=\"".$sess->url('main.php?area=con_configcat&view='.$view)."\">\n"; 
  echo "    <input type=hidden name=\"action\" value=\"save\" />\n";
  echo "    <input type=hidden name=\"idtplconf\" value=\"$idtplconf\" />\n";
  echo "    <input type=hidden name=\"idcat\" value=\"$idcat\" />\n";
  echo "    <input type=hidden name=\"parent\" value=\"$parent\" />\n";
  echo "    <table class=\"config\" cellspacing=\"1\">\n";
*/ 

// Ordnername
if((!$action && $idcat) || isset($_REQUEST['sf_apply']) && ! $sf_is_rewrite_error)
{
	$sql = "SELECT
	          name, description, rewrite_use_automatic, rewrite_alias
	        FROM ".$cms_db['cat_lang']."
	        WHERE idcat='$idcat'
	        AND idlang='$lang'";
	$db->query($sql);
	$db->next_record();
	$title = $db->f('name');
	$description = $db->f('description');
	$rewrite_use_automatic = $db->f('rewrite_use_automatic');
	$rewrite_alias = $db->f('rewrite_alias');
}else{
	remove_magic_quotes_gpc($title);
	remove_magic_quotes_gpc($description);
	if(!$idcat && ! $action)
	{
// new page
		$rewrite_use_automatic = 1;
	}else{
//on change
		remove_magic_quotes_gpc($rewrite_use_automatic);
	}
	remove_magic_quotes_gpc($rewrite_alias);
}
$have_rewrite_perm = (is_numeric($idcat)) ? $perm->have_perm(15, 'cat', $idcat) : $perm -> have_perm(15, 'area_con', 0);
/**
if($cfg_client['url_rewrite'] == '2' && $have_rewrite_perm)
{
  $rows = '5';
}else{
  $rows = '1';
}
//name
echo "    <tr>\n";
echo "      <td class=\"head\" rowspan=\"$rows\" width=\"110\"><p>".$cms_lang['con_configcat_folder']."</p></td>\n";
echo "      <td>
"<input class=\"w800\" type=\"text\" name=\"name\" value=\"".htmlentities($name, ENT_COMPAT, 'UTF-8')."\" size=\"90\" maxlength=\"255\" />";
		unset($rows);
		
//rewrite start
$have_rewrite_perm = (is_numeric($idcat)) ? $perm->have_perm(15, 'cat', $idcat) : $perm -> have_perm(15, 'area_con', 0);
if($cfg_client['url_rewrite'] == '2' && $have_rewrite_perm)
{
	$rewrite_use_automatic_checked = ($rewrite_use_automatic == 1) ? 'checked="checked"':'';
	$rewrite_alias_background = $rewrite_use_automatic_checked ? '#cccccc' : '#ffffff';
	$rewrite_alias_disabled = $rewrite_use_automatic_checked ? 'disabled="disabled"' : '';
	$rewrite_breadkrumb_path = ($rewrite_alias == '') ? rewriteGetPath($idcat, $lang, true). '<em>{Dieser Ordner}</em>/': rewriteGetPath($idcat, $lang, true);
	$rewrite_error = ($sf_is_rewrite_error) ? '<p class="errormsg">'.$sf_rewrite_error_message.'</p>':'';
	
	echo '<tr><td class="headre">Ordner Alias - mod_rewrite - Einstellungen</td></tr>
	<tr><td><input type="checkbox" name="rewrite_use_automatic" value="1" id="rewrite_use_automatic" '.$rewrite_use_automatic_checked.' onclick="if(document.editform.rewrite_use_automatic.checked==true){document.editform.rewrite_alias.disabled=true;document.editform.rewrite_alias.style.backgroundColor=\'#cccccc\'}else{document.editform.rewrite_alias.disabled=false;document.editform.rewrite_alias.style.backgroundColor=\'#ffffff\'}"/>
	<input type="hidden" name="form_is_submitted" value="true" />
	<label for="rewrite_use_automatic">Alias automatisch vergeben</label></td></tr>
	<tr><td><input class="w800" type="text" name="rewrite_alias" value="'.htmlentities($rewrite_alias, ENT_COMPAT, 'UTF-8').'" size="90" maxlength="255" style="background-color:'.$rewrite_alias_background.'" '.$rewrite_alias_disabled.'>'.$rewrite_error.'</td></tr>
	<tr><td><small>URL dieses Ordners: http://<em>{domain.xyz}</em>/'.$rewrite_breadkrumb_path .' </small>';
}else{
  echo '<input type="hidden" name="rewrite_use_automatic" value="'.$rewrite_use_automatic.'" />';	
  echo '<input type="hidden" name="rewrite_alias" value="'.htmlentities($rewrite_alias, ENT_COMPAT, 'UTF-8').'" />';	
}
*/
// URL REWRITE
$have_rewrite_perm = (is_numeric($idcat)) ? $perm->have_perm(15, 'cat', $idcat) : $perm -> have_perm(15, 'area_con', 0);
if($cfg_client['url_rewrite'] == '2' && $have_rewrite_perm)
{
	$tpl->setCurrentBlock('URL_REWRITE');
	$tpl_data['REWRITE_USE_AUTOMATIC_CHECKED'] = ($rewrite_use_automatic == 1) ? 'checked="checked" ':'';
	$tpl_data['REWRITE_URL'] = $rewrite_alias;
	$tpl_data['REWRITE_URL_BACKGROUNDCOLOR'] = ($rewrite_use_automatic == 1) ? '#cccccc':'#ffffff';
	$tpl_data['REWRITE_URL_DISABLED'] = ($rewrite_use_automatic == 1) ? 'disabled="disabled" ':'';
	$tpl_data['REWRITE_ERROR'] = $rewrite_error = ($sf_is_rewrite_error) ? '<p class="errormsg">'.$sf_rewrite_error_message.'</p>':'';
  $tpl_data['CAT_REWRITE_TITEL'] = $cms_lang['con_rewrite_cattitel'];
	$tpl_data['CAT_REWRITE_AUTO'] = $cms_lang['con_rewrite_catauto'];
	$tpl_data['CAT_REWRITE_URL'] = $cms_lang['con_rewrite_caturl'];
	
	if($rewrite_use_automatic == 1)
	{
		$tpl_data['REWRITE_CURRENT_URL'] = ($rewrite_alias == '') ? rewriteGetPath($idcat, $lang). '<em>xxx</em>'. $cfg_client['url_rewrite_suffix']: rewriteGetPath($idcat, $lang).$rewrite_alias;
	}else{
		$tpl_data['REWRITE_CURRENT_URL'] = ($rewrite_alias == '') ?  '<em>{Diese Seite}</em>':$rewrite_alias;
	}
	$tpl_data['REWRITE_CURRENT_URL'] = $cfg_client['htmlpath']. $tpl_data['REWRITE_CURRENT_URL'];
	$tpl->setVariable($tpl_data);
	$tpl->parseCurrentBlock();
	unset($tpl_data);
}else{
	$tpl->setCurrentBlock('HIDDEN_FIELDS');
	$tpl_data['HIDDEN_FIELDS'] = '<input type="hidden" name="rewrite_use_automatic" value="'. $rewrite_use_automatic .'" />
	  <input type="hidden" name="rewrite_url" value="'. $rewrite_alias .'" />';
	$tpl->setVariable($tpl_data);
	$tpl->parseCurrentBlock();
	unset($tpl_data);	
}
//rewrite stop
//echo "			</td>\n";
//echo "    </tr>\n";

// rechte management
if(!empty($idcat) && ($perm->have_perm(6, 'cat', $idcat) || $perm->have_perm(14, 'cat', $idcat)))
{
	$tpl->setCurrentBlock('USER_RIGHTS');
	$tpl->setVariable('CAT_RIGHTS',$cms_lang['con_edit']);
	if($perm->have_perm(6, 'cat', $idcat))
	{
		$panel1 = $perm->get_right_panel('cat', $idcat, array( 'formname'=>'editform' ), 'Backendrechte bearbeiten', false, false, 0, 'backend_' );
		$panel1['spaces'] =  "&nbsp;&nbsp;&nbsp;&nbsp;\n";
		if(!empty($panel1))
		{
			$tpl_data['BACKENDRIGHTS'] = implode("", $panel1);
		}
	}else{
		$tpl_data['BACKENDRIGHTS'] = '';
	}
	
	
	if($perm->have_perm(14, 'cat', $idcat))
	{
		$panel2 = $perm->get_right_panel('frontendcat', $idcat, array( 'formname'=>'editform' ), 'Frontendrechte bearbeiten', false, false, 0,  'frontend_');
			if(!empty($panel2))
		{
			$tpl_data['FRONTENDRIGHTS'] = implode("", $panel2);
		}
	}else{
		$tpl_data['FRONTENDRIGHTS'] = '';
	}
	$tpl_data['LANG_RIGHTS'] = '';
	$tpl->setVariable($tpl_data);
	$tpl->parseCurrentBlock();
	unset($tpl_data);
}
//if(!empty($panel1) || !empty($panel2)){
//echo "      <tr>\n";
//echo "        <td class=\"head\">&nbsp;</td>\n"
//echo "        <td>";
//if(!empty($panel1)) echo implode("", $panel1) .'';
//if(!empty($panel2)) echo implode("", $panel2);
//echo "      </tr>\n";
//}

//Hier
/*
// Ordnerbeschreibung
echo "    <tr>\n";
echo "      <td class=\"head\">".$cms_lang['con_configcat_description']."</td>\n";
echo "      <td><textarea class=\"w800\" name=\"description\" rows=\"3\" cols=\"52\">".htmlentities($description, ENT_COMPAT, 'UTF-8')."</textarea></td>\n";
echo "    </tr>\n";
*/

// Outputbuffering für das Backend temporär beenden, um Content aus den Modulen in Variablen speichern zu können
$temp_output_for_backend = ob_get_contents();
ob_end_clean();
ob_start();
// Darf Templatekonfiguration Betreten
$have_config_tpl_perm = (is_numeric($idcat)) ? $perm->have_perm(11, 'cat', $idcat) : $perm -> have_perm(11, 'area_con', 0);
//echo "    <tr>\n";
//echo "      <td class=\"head\">".$cms_lang['con_template']."</td>\n";
	echo "<legend>".$cms_lang['con_templateconfig']."</legend>\n";
	echo "<p><label>".$cms_lang['con_template']."</label>\n";
if($have_config_tpl_perm)
{
	echo "<select name=\"idtpl\" size=\"1\" onchange=\"document.editform.action.value='changetpl';document.editform.submit();\">\n";
}else{
	echo "<select name=\"idtpl\" size=\"1\">\n";
}

// konfiguriertes Template und Layout suchen
if($idtplconf != '0' && !$idtpl && !$configtpl)
{
	$sql = "SELECT 
				B.idlay, B.idtpl 
			FROM 
				".$cms_db['tpl_conf']." A 
				LEFT JOIN ".$cms_db['tpl']." B USING(idtpl) 
			WHERE 
				idtplconf='$idtplconf'";
	$db->query($sql);
	$db->next_record();
	$idlay = $db->f('idlay');
	$idtpl = $db->f('idtpl');
	$configtpl = $idtpl;
}elseif($idtpl){
// template was changed or reloaded - get idtpl from $_REQUEST
	$sql = "SELECT idlay, idtpl FROM ".$cms_db['tpl']." WHERE idtpl='$idtpl'";
	$db->query($sql);
	$db->next_record();
	$idlay = $db->f('idlay');
}else{
// new config get starttemplate to fetch idlay
	$sql = "SELECT 
						idlay, idtpl
					FROM 
						".$cms_db['tpl']." T
					WHERE 
						is_start = 1 
						AND idclient='$client'";
	$db->query($sql);
	$db->next_record();
	$idlay = $db->f('idlay');
	$idtpl = $db->f('idtpl');
}

// Templates Auflisten
$sql = "SELECT idtpl, name, is_start FROM $cms_db[tpl] WHERE idclient='$client' ORDER BY name";
$db->query($sql);
if($db->affected_rows() == 0)
{
	 echo "        <option value=\"0\" selected>".$cms_lang['form_nothing']."</option>";
}
while ($db->next_record())
{
	if($db->f('idtpl') == $idtpl)
	{
		echo "<option value=\"".$db->f('idtpl')."\" selected=\"selected\">".$db->f('name')."</option>";
	}elseif($perm -> have_perm(1, 'tpl', $db->f('idtpl'))) {
		echo "<option value=\"".$db->f('idtpl')."\">".$db->f('name')."</option>";
	}
}
echo "      </select></p>\n";
echo "    <input type=hidden name=\"configtpl\" value=\"$configtpl\" />";

//buttons  
/**  
echo "      <tr>\n";
echo "        <td class='content7' colspan='3' style='text-align:right'>\n";
echo "        <input type='submit' name='sf_save' title='".$cms_lang['gen_save_titletext']."' value='".$cms_lang['gen_save']."' class=\"sf_buttonAction\" onmouseover=\"this.className='sf_buttonActionOver'\" onmouseout=\"this.className='sf_buttonAction'\" />\n";
echo "        <input type='submit' name='sf_apply' title='".$cms_lang['gen_apply_titletext']."' value='".$cms_lang['gen_apply']."' class=\"sf_buttonAction\" onmouseover=\"this.className='sf_buttonActionOver'\" onmouseout=\"this.className='sf_buttonAction'\" />\n";
echo "        <input type='button' name='sf_cancel' title='".$cms_lang['gen_cancel_titletext']."' value='".$cms_lang['gen_cancel']."' class=\"sf_buttonAction\" onclick=\"window.location='".$sf_cancel_url."'\" onmouseover=\"this.className='sf_buttonActionCancelOver'\" onmouseout=\"this.className='sf_buttonAction'\" />\n";
echo "        </td>\n";
echo "      </tr>\n";
*/
if($have_config_tpl_perm && $idtpl)
{
	echo "    <input type=hidden name=\"idlay\" value=\"$idlay\" />\n";
// Module auflisten
	$list = browse_layout_for_containers($idlay);
// Einstellungen suchen
	if($configtpl == $idtpl)
	{
    $sql = "SELECT
              A.config, A.view, A.edit, B.container, C.name,
              C.input, C.idmod, C.version, C.verbose, C.cat,
              C.source_id, C.idmod
            FROM $cms_db[container_conf] A 
            LEFT JOIN $cms_db[container] B USING(idcontainer) 
            LEFT JOIN $cms_db[mod] C USING(idmod) 
            WHERE A.idtplconf='$idtplconf'";
	}else{
    $sql = "SELECT
              A.config, A.view, A.edit, B.container, C.name, C.input,
              C.idmod, C.version, C.verbose, C.cat, C.source_id,
              C.idmod
            FROM $cms_db[container_conf] A 
            LEFT JOIN $cms_db[container] B USING(idcontainer) 
            LEFT JOIN $cms_db[mod] C USING(idmod) 
            WHERE A.idtplconf='0' AND B.idtpl='$idtpl'";
  }
	$db->query($sql);
	while($db->next_record())
	{
    $container[$db->f('container')] = array ( $db->f('config'),      // value 0
		                                          $db->f('view'),        // value 1
		                                          $db->f('edit'),        // value 2
		                                          htmlentities($db->f('name'), ENT_COMPAT, 'UTF-8'),        // value 3
		                                          $db->f('input'),       // value 4
		                                          htmlentities($db->f('idmod'), ENT_COMPAT, 'UTF-8'),       // value 5
		                                          htmlentities($db->f('version'), ENT_COMPAT, 'UTF-8'),     // value 6 
                                                          htmlentities($db->f('verbose'), ENT_COMPAT, 'UTF-8'),     // value 7
                                                          htmlentities($db->f('cat'), ENT_COMPAT, 'UTF-8'),         // value 8
                                                          htmlentities($db->f('source_id'), ENT_COMPAT, 'UTF-8'),   // value 9
                                                          htmlentities($db->f('idmod'), ENT_COMPAT, 'UTF-8'));      // value 10
  }
	if(is_array($container))
	{
		ksort($container);
		foreach($container as $key => $value)
		{
			if(is_array($list['id']))
			{
				if(in_array($key, $list['id']))
				{
					$input = $value['4'];
// Containername
					$modname  = ((($value['7'] != '') ? $value['7'] : $value['3']) . ((empty($value['6'])) ? '' : ' (' . $value['6'] . ')') );
					$modtitel = ( ' ++ ' .$cms_lang['gen_description'] . ' ++ &#10;' . (($value['8'] != '') ? $cms_lang['gen_cat'] . ': ' . $value['8'] . ' &#10;' : '') .
                                                    (($value['7'] != '') ? $cms_lang['gen_verbosename'] . ': ' . $value['7'] . ' &#10;' : '') .
                                                    (empty($value['9']) ? $cms_lang['gen_name'] : $cms_lang['gen_original']) . ': ' . $value['3'] . ' &#10;' .
                                                    (($value['6'] != '') ? $cms_lang['gen_version'] . ': ' . $value['6'] . ' &#10;' : '') . 'IdMod: ' . $value['10'] );
					$modcursor = 'pointer';

					echo "\n";
     
          printf ("        <p class=\"moduldesc\">%s\n", (!empty($list[$key]['title'])) ? $list[$key]['title']:"$key. ".$cms_lang['tpl_container']."");
					echo "<input type=\"hidden\" name=\"c$key\" value=\"".$value['5']."\" />\n";
					echo "          <div class=\"forms\">";
					echo "        <select name=\"cview$key\" size=\"1\">\n";
					printf ("          <option value=\"0\"%s>". $cms_lang['gen_mod_active'] ."</option>\n", ($value['1'] == '0' || !$value['1']) ? ' selected':'');
					printf ("          <option value=\"-1\"%s>". $cms_lang['gen_mod_deactive'] ."</option>\n", ($value['1'] == '-1') ? ' selected':'');
					echo "        </select>";
					echo "        <select name=\"cedit$key\" size=\"1\">\n";
					printf ("          <option value=\"0\"%s>". $cms_lang['gen_mod_edit_allow'] ."</option>\n", ($value['2'] == '0' || !$value['2']) ? ' selected':'');
					printf ("          <option value=\"-1\"%s>". $cms_lang['gen_mod_edit_disallow'] ."</option>\n", ($value['2'] == '-1') ? ' selected':'');
					echo "        </select>\n";
					echo "        </div>";
					echo "        <h4 title=\"". $modtitel . "\"> ".$modname."</h4>";
          echo "        </p>";
					echo "        <p class=\"modulconfig\">";

					// Developer-Modul
					if (strpos($value['6'], 'dev') != false && $value['6'] != '') $input = '<p class="errormsg">'.$cms_lang['tpl_devmessage']."</p>\n".$input;

					// Modulkonfiguration einlesen
					if($cconfig)
                                          $tmp1 = preg_split("/&/", $cconfig[$key]);
					else
                                          $tmp1 = preg_split("/&/", $value['0']);
					$varstring = array();
					foreach($tmp1 as $key1=>$value1)
					{
						$tmp2 = explode('=', $value1);
						foreach($tmp2 as $key2=>$value2)
						  $varstring["$tmp2[0]"]=$tmp2[1];
					}
					foreach($varstring as $key3=>$value3)
					{
						$cms_mod['value'][$key3] = cms_stripslashes(urldecode($value3));
					}
					foreach($value as $key4=>$value4)
					  $cms_mod['info'][$key4] = cms_stripslashes(urldecode($value4));
					  $input = str_replace("MOD_VAR", "C".$key."MOD_VAR" , $input);
					  eval(' ?>'.$input);
					  unset($cms_mod['value'], $cms_mod['info']);
				}
		echo "        </p>";
			}
		}
	}
}//end id have perm tpl config

// Outputbuffering wieder aufnehmen
$temp_tpl_conf = ob_get_contents();
ob_end_clean();
ob_start();
echo $temp_output_for_backend;
unset($temp_output_for_backend);
$tpl->setCurrentBlock('__global__');
$tpl_data['SKIN'] = $cfg_cms['skin'];

if(empty($view))
{
	$tpl_data['FORM_ACTION'] = $sess->url('main.php?area=con_configcat');
	$tpl_data['ABORT']       = $sess->url('main.php?area=con');
	$tpl_data['AREA_TITLE']  = $cms_lang['area_con_configcat'];
}else{
	$tpl_data['FORM_ACTION'] =  $sess->url('main.php?area=con_configcat&view='.$view);
	$tpl_data['ABORT']       = $sess->url($cfg_client['htmlpath'].$cfg_client['contentfile']."?lang=$lang&idcat=$idcat&idcatside=$idcatside&view=$view"); 
	$tpl_data['AREA_TITLE']  = '';
}

//buttons    
$buttons .= "<p class='buttonwrap'>\n";  
$buttons .= "        <input type='submit' name='sf_save' title='".$cms_lang['gen_save_titletext']."' value='".$cms_lang['gen_save']."' class=\"sf_buttonAction\" />\n";
$buttons .= "        <input type='submit' name='sf_apply' title='".$cms_lang['gen_apply_titletext']."' value='".$cms_lang['gen_apply']."' class=\"sf_buttonAction\"/>\n";
$buttons .= "        <input type='button' name='sf_cancel' title='".$cms_lang['gen_cancel_titletext']."' value='".$cms_lang['gen_cancel']."' class=\"sf_buttonAction\" onclick=\"window.location='". $tpl_data['ABORT'] ."'\" />\n";
$buttons .= "</p>\n";  
$tpl_data['BUTTONS_ORDNERANGABEN'] = $tpl_data['BUTTONS_MODULANGABEN'] = $buttons;

//BRAUCH man das dann noch ???
if(!$have_config_tpl_perm && !$have_enter_tpl_perm && ! $have_meta_perm)
{
	$tpl_data['BUTTONS_MODULANGABEN'] = '';
}
$tpl_data['IDTPLCONF'] = $idtplconf;
$tpl_data['IDCAT'] = $idcat;
$tpl_data['PARENT'] = $parent;
$tpl_data['CON_TITLE_DESC'] = $cms_lang['con_configcat_folder'];
$tpl_data['CON_CONCONFIG'] = $cms_lang['con_catconfig'];
$tpl_data['TPL_CONF'] = $temp_tpl_conf;
$tpl_data['SIDE_TITLE'] = empty($title) ? '' : $title;
$tpl_data['CON_CATCONFIG_LANG'] = $cms_lang['con_configcat_description'];
$tpl_data['CON_CATCONFIG_DESC'] = $description;
$tpl_data['FOOTER_LICENSE'] = $cms_lang['login_licence'];
$tpl->setVariable($tpl_data);
unset($tpl_data);

/** Fehlermeldung */
if(!empty($errno) || $sf_is_rewrite_error)
{
	$tpl->setCurrentBlock('ERRORMESSAGE');
	if($sf_is_rewrite_error)
	{
		$tpl_error['ERRORMESSAGE'] = $cms_lang['con_err_formular'];
	}else{
		$tpl_error['ERRORMESSAGE'] = $cms_lang['err_' . $errno];
	}
	$tpl->setVariable($tpl_error);
	$tpl->parseCurrentBlock('ERRORMESSAGE');
	unset($tpl_data);
}
?>
