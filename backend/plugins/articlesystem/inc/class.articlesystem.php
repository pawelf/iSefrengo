<?php
class Articlesystem {
    //lang object
    var $lang;

    //cms WebRequest object
    var $cms_wr = null;
    
    //Pfad zum Plugin
    var $basedir;
    
    //ADOdb-Objekt
    var $adodb;
    
    //CMS-Vars
    var $sess;
    var $idclient;
    var $idlang;
    
    //Einstellungen
    var $settings = array();
    var $defaultval = array();

    function Articlesystem($checksetting=true) {
        global $GLOBALS, $_AS, $auth, $adodb, $cms_db,$cfg_cms, $client, $lang, $sess;

        $this->adodb =& $adodb;
        $this->cms_wr =& $GLOBALS['sf_factory']->getObject('HTTP', 'WebRequest');

        $this->userid =& $auth->auth['uid'];
        $this->idclient =& $client;
        $this->idlang =& $lang;
        $this->sess =& $sess;
        $this->cfg_cms =& $cfg_cms;

				$this->db = $_AS['db'];

        $this->basedir =& $_AS['basedir'];

        //Default-Settings einladen
        if(file_exists($this->basedir . 'inc/cfg.defaultsettings.php')) {
            include_once $this->basedir . 'inc/cfg.defaultsettings.php';
        }

        //Objektweit verf&uuml;gbar machen
        $this->defaultval['settings'] = $defaultsettings;
        $this->defaultval['number_of_month'] = $number_of_month;
        $this->defaultval['turnus'] = $turnus;
        $this->defaultval['languages'] = $languages;
        $this->defaultval['display'] = $display;
        $this->defaultval['skins'] = $skins;

        $this->defaultval['wysiwygs'] = array("true" => "ja","false"=>"nein");

        //Wenn keine Einstellungen hinzugef&uuml;gt wurden, diese laden
        if($checksetting == true) {
            $this->checkSettings();
        }

				$sql = "SELECT value FROM  ".$cms_db['values']." WHERE group_name='lang' AND key1='nav_".$this->db."' AND idclient='$client' AND idlang='0'";
				$recordSet = $this->adodb->Execute($sql);
				$_AS['topic'] =$recordSet->fields[0];
				if (empty($_AS['topic'])) {
					$sql = "SELECT value FROM  ".$cms_db['values']." WHERE group_name='lang' AND key1='nav_".$this->db."' AND idclient='$client' AND idlang='$lang'";
					$recordSet = $this->adodb->Execute($sql);
					$_AS['topic'] =$recordSet->fields[0];
				}

        $this->lang = new Lang($this->basedir . 'lang/'.$this->getSetting('language').'.php');

    }

    /**
    * check / add new plug-settings upon start or update
    *
    * @param 		none
    * @return		bool -> true = success
    * @access		public
    */        
    function checkSettings() {

			foreach ($this->getClientLangs() as $lkey => $lval) {

        $defaultsettings = $this->defaultval['settings'];
        $sql = "SELECT * FROM ".$this->cfg_cms['db_table_prefix']."plug_".$this->db."_values WHERE idclient='".$this->idclient."' AND idlang='".$lkey."' AND key1='settings' ";
        $recordSet = $this->adodb->Execute($sql);
        if ($recordSet === false) die("failed");
        //Einstellungen in ein Array speichern
        $db_settings = $recordSet->GetArray();
        $recordSet->Close();
        
        $found = array();
        //Sind weniger Einstellungen vorhanden als vorgegeben?
        if(count($db_settings)<count($defaultsettings)) {
            //F&uuml;r jede Default-Einstellung durchlaufen
            foreach($defaultsettings as $key => $val) {
                $found[$key] = false;
                //Jede DB-Einstellung pr&uuml;fen
                for($i=0, $count = count($db_settings);$i<$count;$i++) {
                    //Gefunden und aussteigen
                    if($db_settings[$i]['key2']==$key) {
                        $found[$key] = true;
                        break;
                    }
                }
            }

            //var_dump($found);

            //F&uuml;r jedes nicht gefundene Eintragen
            foreach($found as $key => $bool) {
                if($bool == false) {
                    $record['idclient'] = $this->idclient;
                    $record['idlang'] = $lkey;
                    $record['key1'] = 'settings';
                    $record['key2'] = $key;
                    $record['value'] = $defaultsettings[$key];
                    $record['userid'] = $this->userid;
                    $record['lastedit'] = time();
                    $sql = $this->adodb->AutoExecute($this->cfg_cms['db_table_prefix']."plug_".$this->db."_values", $record, 'INSERT');

                    //Einstellungen gleich setzen
                    $this->settings[$key] = $defaultsettings[$key];
                }
            }
            if ($this->idlang == $lkey)
            	$this->loadSettings();
        
#            return true;
        }
        //Keine Eintr&auml;ge hinzugef&uuml;gt
        else {
            if ($this->idlang == $lkey)
	            $this->loadSettings();
     
#            return true;
        }
      }

    }

    /**
    * load plug-settings
    *
    * @param 		none
    * @return		bool -> true = success
    * @access		public
    */        
    function loadSettings() {

        $sql = "SELECT * FROM ".$this->cfg_cms['db_table_prefix']."plug_".$this->db."_values WHERE idclient='".$this->idclient."' AND idlang='".$this->idlang."' AND key1='settings'";

        $recordSet = $this->adodb->Execute($sql);
        if ($recordSet === false) die("failed");
        //Einstellungen in ein Array speichern
        $db_settings = $recordSet->GetArray();
        $recordSet->Close();
        
        //Jede DB-Einstellung pr&uuml;fen
        for($i=0, $count = count($db_settings);$i<$count;$i++) {
            $this->settings[$db_settings[$i]['key2']] = $db_settings[$i]['value'];
        }

        if($i>0) return true;
        else return false;
    }

    /**
    * update plug's single setting
    *
    * @param 		string $set -> settings key(2)
    *						string $val -> value
    * @return		nothing
    * @access		public
    */        
    function updateSingleSetting($set='',$val='') {
    		if (empty($set) || empty($val))
    			return;
    		
        $sql = "UPDATE
                  ".$this->cfg_cms['db_table_prefix']."plug_".$this->db."_values 
                SET
                  value='".$val."'
                WHERE
                    idclient='".$this->idclient."' AND idlang='".$this->idlang."' AND key1='settings' AND key2='".$set."';";
        //echo $sql;
        $recordSet = $this->adodb->Execute($sql);
        if ($recordSet === false) die("failed");
        //Einstellungen in ein Array speichern
        $recordSet->Close();
     }

    /**
    * get plug's single setting
    *
    * @param 		string $key -> settings key
    *						bool $transform -> "true" manipulates the data for utf8-web-output
    * @return		nothing
    * @access		public
    */        
    function getSetting($key,$transform=false) {
   
        if(isset($this->settings[$key])) {
        		if ($transform)
    					return htmlentities($this->settings[$key],ENT_COMPAT,'UTF-8');
						else
							return $this->settings[$key];
        } else {
            return false;
        }
    }
    
    /**
    * get client langs
    *
    * @param 		none
    * @return		nothing
    * @access		public
    */        
    function getClientLangs() {
        $sql = "SELECT
                    A.idlang, A.name
                FROM
                    ".$this->cfg_cms['db_table_prefix']."lang A
                LEFT JOIN
                    ".$this->cfg_cms['db_table_prefix']."clients_lang B USING(idlang)
                WHERE
                    B.idclient='".$this->idclient."'
                ORDER BY
                    idlang";
        $recordSet = $this->adodb->Execute($sql);

        $return_arr = array();
        while (!$recordSet->EOF) {
            $return_arr[$recordSet->fields[0]] = $recordSet->fields[1];
            $recordSet->MoveNext();
        }
        $recordSet->Close();
        
        return $return_arr;
    }
    
    
#    function getOrganizer() {
#        $sql = "SELECT
#                    idorganizer, name
#                FROM
#                    ".$this->cfg_cms['db_table_prefix']."plug_".$this->db."_organizer
#                WHERE
#                    idclient='".$this->idclient."' AND idlang='".$this->idlang."'
#                ORDER BY
#                    name ASC";
#        $recordSet = $this->adodb->Execute($sql);
#
#        $return_arr = array();
#        while (!$recordSet->EOF) {
#            $return_arr[$recordSet->fields[0]] = $recordSet->fields[1];
#            $recordSet->MoveNext();
#        }
#        $recordSet->Close();
#
#        return $return_arr;
#    }

    /**
    * get article categories
    *
    * @param 		none
    * @return		array -> "category id" => "category name"
    * @access		public
    */        
    function getCategory() {
        $sql = "SELECT
                    idcategory, name
                FROM
                    ".$this->cfg_cms['db_table_prefix']."plug_".$this->db."_category
                WHERE
                    idclient='".$this->idclient."' AND idlang='".$this->idlang."'
                ORDER BY
                    name ASC";
        $recordSet = $this->adodb->Execute($sql);

        $return_arr = array();
        while (!$recordSet->EOF) {
            $return_arr[$recordSet->fields[0]] = $recordSet->fields[1];
            $recordSet->MoveNext();
        }
        $recordSet->Close();

        return $return_arr;
    }

    /**
    * plug's backend menü, navigation & function
    *
    * @param 		none
    * @return		html
    * @access		public
    */        
    function getNavigation() {
        global $perm;

        $area = $this->cms_wr -> getVal('area');
        $subarea = $this->cms_wr -> getVal('subarea');
        $action = $this->cms_wr -> getVal('action');

        //Tpl einladen
				if ($subarea!='admin')
	        include_once $this->basedir . 'tpl/'.$this->cfg_cms['skin'].'/tpl.be_navi.php';

        switch($subarea) {
#            case 'organizer':
#                switch($action) {
#                    case 'new_organizer':
#                        $action = 'new_organizer';
#                      break;
#                    case 'edit_organizer':
#                    case 'save_organizer':
#                        $action = 'edit_organizer';
#                      break;
#                    case 'switch_online':
#                    case 'switch_offline':
#                    case 'delete_organizer':
#                    default:
#                        $action = 'show_organizer';
#                }
#                $subarea = 'organizer';
#            break;
            case 'category':
                switch($action) {
                    case 'save_category':
                    default:
                        $action = 'show_category';
                }
                $subarea = 'category';
            break;

            case 'settings':
                switch($action) {
                    case 'save_settings':
                    default:
                        $action = 'show_settings';
                }
                $subarea = 'settings';
            break;

            case 'archive':
                switch($action) {
                    case 'dupl_article':
                    case 'edit_article':
                    case 'save_article':
                        $action = 'edit_article';
                      break;
                    case 'switch_online':
                    case 'switch_offline':
                    case 'delete_article':
                    default:
                    $action = 'show_article';
                }
                $subarea = 'archive';
            break;

            case 'article':
            default:
                switch($action) {
                    case 'new_article':
                        $action = 'new_article';
                      break;
                    case 'dupl_article':
                    case 'edit_article':
                    case 'save_article':
                        $action = 'edit_article';
                      break;
                    case 'switch_online':
                    case 'switch_offline':
                    case 'delete_article':
                    default:
                    $action = 'show_article';
                }
                $subarea = 'article';
            break;
        }

        $_url['article'] = $this->sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$this->db.'/index.php&subarea=article&action=show_article');
        $_url['archive'] = $this->sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$this->db.'/index.php&subarea=archive&action=show_article');
//        $_url['organizer'] = $this->sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$this->db.'/index.php&subarea=organizer&action=show_organizer');
	      $_url['category'] = $this->sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$this->db.'/index.php&subarea=category&action=show_category');
        $_url['settings'] =  $this->sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$this->db.'/index.php&subarea=settings&action=show_settings');

        $_css['article'] = ($subarea == 'article') ? ' style="font-weight:bold;background-image:url(tpl/'.$this->cfg_cms['skin'].'/img/bg_header_active_sub.gif);"' : '';
        $_css['archive'] = ($subarea == 'archive') ? ' style="font-weight:bold;background-image:url(tpl/'.$this->cfg_cms['skin'].'/img/bg_header_active_sub.gif);"' : '';
        //$_css['organizer'] = ($subarea == 'organizer') ? ' style="font-weight:bold;background-image:url(tpl/'.$this->cfg_cms['skin'].'/img/bg_header_active_sub.gif);"' : '';
        $_css['category'] = ($subarea == 'category') ? ' style="font-weight:bold;background-image:url(tpl/'.$this->cfg_cms['skin'].'/img/bg_header_active_sub.gif);"' : '';
        $_css['settings'] = ($subarea == 'settings') ? ' style="font-weight:bold;background-image:url(tpl/'.$this->cfg_cms['skin'].'/img/bg_header_active_sub.gif);"' : '';
        

        $_tpl['article'] = str_replace(array(
								'{area}',
								'{url}',
								'{css}'
								),
							array(
								$this->lang->get('area_article'),
								$_url['article'],
								$_css['article']
              ),
							$_AS['tpl']['navi_link']);
				if($this->getSetting('use_archive') == 1)
	        $_tpl['archive'] = str_replace(array(
									'{area}',
									'{url}',
									'{css}'
									),
								array(
									$this->lang->get('area_archive'),
									$_url['archive'],
									$_css['archive']
	              ),
								$_AS['tpl']['navi_link']);

        if($this->getSetting('set_category') == 1 && $perm->have_perm(1, 'area_plug_'.$this->db ,0) == true) {
            $_tpl['category'] = str_replace(array(
								'{area}',
								'{url}',
								'{css}'
								),
							array(
								$this->lang->get('area_category'),
								$_url['category'],
								$_css['category']
              ),
							$_AS['tpl']['navi_link']);
        }
        
        if($perm->have_perm(2, 'area_plug_'.$this->db ,0) == true) {
            $_tpl['settings'] = str_replace(array(
								'{area}',
								'{url}',
								'{css}'
								),
							array(
								$this->lang->get('area_settings'),
								$_url['settings'],
								$_css['settings']
              ),
							$_AS['tpl']['navi_link']);
				}
				
        $_tpl['links'] = implode("", $_tpl);				

        $_tpl_out = str_replace(array(
								'{area}',
								'{subarea}',
								'{action}',
								'{links}',
								'{sf_skin}'

								),
							array(
								$this->lang->get('area'),
								$this->lang->get('area_article'),
								' - '.(($subarea=='archive')?$this->lang->get('action_show_'.$subarea):$this->lang->get('action_'.$action)),
				        $_tpl['links'],
				        $this->cfg_cms['skin']
								),
							$_AS['tpl']['be_navi']);

        echo $_tpl_out;

    }
    
    /**
    * month selectbox
    *
    * @param 		string $fieldname -> form field name-attr-val
    * 			 		integer $selected_month -> currently selected month
    * 			 		string $style -> form field space for style-attr
    * 			 		string $onclick -> form field space for js-attr
    * 			 		bool $option_showrange -> something with the selectbox labels (?!)
    * @return		html
    * @access		public
    */        
    function getSelectMonthBack($fieldname='', $selected_month=-1, $style=' style="font-weight:bold;"', $onclick='', $option_showrange=false) {
        $months = $this->defaultval['number_of_month'];
        
        $output = '<select name="'.$fieldname.'" size="1"'.$onclick.'>';
        if($option_showrange == true) {
            $output .= '<option value="" selected="selected">'.$this->lang->get('showrange').'</option>';
        }
		
        foreach($months as $number ) {
            if($number == -1) {
              $lng = $this->lang->get('all');
            } else if($number < 12) {
              $lng = ($number == 1) ? $number." ".$this->lang->get('month') : $number." ".$this->lang->get('month_plural');
            } else {
              $lng = ($number == 12) ? ($number/12)." ".$this->lang->get('year') : ($number/12)." ".$this->lang->get('year_plural');
            }

            $selected = ($selected_month == $number) ? $style : '';
            $output .= '
            <option value="'.$number.'"'.$selected.'>'.$lng.'</option>';
        }
        $output .= '
        </select>';
        
        return $output;
    }
#
#
#    function getSelectTurnus($fieldname, $selected_turnus='', $onchange='', $with_all=true, $option_turnus_filter=false) {
#        $turnus = $this->defaultval['turnus'];
#
#        $output = '<select id="turnus_type" name="'.$fieldname.'" '.$onchange.'>';
#		
#		if($option_turnus_filter == true) {
#			$output .= '<option value="" selected="selected">'.$this->lang->get('turnus_filter').'</option>';
#		}
#		
#        foreach($turnus as $number ) {
#            if($option_turnus_filter == false) {
#				$selected = ($selected_turnus == $number) ? ' selected="selected"' : '';
#			} else {
#				$selected = '';
#			}
#            //"Alle Eintr&auml;ge" mit anzeigen?
#            if(($number == 0 && $with_all == true) || $number > 0) {
#                $output .= '
#                <option value="'.$number.'"'.$selected.'>'.$this->lang->get('turnus_'.$number).'</option>';
#            }
#        }
#        $output .= '
#        </select>';
#        return $output;
#    }
    
    /**
    * language selectbox
    *
    * @param 		string $fieldname -> form field name-attr-val
    * 			 		string $selected_language -> currently selected language
    * @return		html
    * @access		public
    */        
    function getSelectLanguage($fieldname, $selected_language='') {
        $languages = $this->defaultval['languages'];

        $output = '<select name="'.$fieldname.'" size="1">';
        foreach($languages as $language ) {
            $selected = ($selected_language == $language) ? ' selected="selected"' : '';
            $output .= '
            <option value="'.$language.'"'.$selected.'>'.$language.'</option>';
        }
        $output .= '
        </select>';

        return $output;
    }

    /**
    * skin selectbox
    *
    * @param 		string $fieldname -> form field name-attr-val
    * 			 		string $selected_skin -> currently selected skin
    * @return		html
    * @access		public
    */        
    function getSelectSkin($fieldname, $selected_skin='') {
        $skins = $this->defaultval['skins'];

        $output = '<select name="'.$fieldname.'" size="1">';
        foreach($skins as $skin ) {
            $selected = ($selected_skin == $skin) ? ' selected="selected"' : '';
            $output .= '
            <option value="'.$skin.'"'.$selected.'>'.$skin.'</option>';
        }
        $output .= '
        </select>';

        return $output;
    }


    /**
    * universal selectbox form field
    *
    * @param 		string $fieldname -> form field name-attr-val
    * 			 		integer/string $selected_uni -> currently selected item
    * 			 		array $unis -> "item-value" => "item-title"
    * 			 		string $fieldid -> form field id-attr-val
    * 			 		string $fieldonchange -> form field space for js-attrs
    * 			 		string $fieldatrcustom -> form field space for other-attrs
    * @return		html
    * @access		public
    */        
    function getSelectUni($fieldname, $selected_uni,$unis=array(),$fieldid="",$fieldonchange="",$fieldatrcustom="size=\"1\"") {

        $output = '<select '.
        					((!empty($fieldid))?'id="'.$fieldid.'"':'').
        					' name="'.$fieldname.'" '.
        					((!empty($fieldatrcustom))?$fieldatrcustom:'').
        					((!empty($fieldonchange))?' onchange="'.$fieldonchange.'"':'').'>';
				if (is_array($unis))
	        foreach($unis as $uni => $v) {
		        if (is_array($selected_uni))
								$selected = (in_array($uni,$selected_uni)) ? ' selected="selected"' : '';
						else
		            $selected = ($selected_uni == $uni && (!empty($selected_uni) || $selected_uni=='0')) ? ' selected="selected"' : '';
		         
		         $output .= '
		            <option value="'.$uni.'"'.$selected.'>'.$v.'</option>';
	        }
        $output .= '
        </select>';

        return $output;
    }

    /**
    * get checkbox or radio form field
    *
    * @param 		string $fieldname -> form field name-attr-val
    * 			 		integer/string $checked_uni -> currently selected item
    * 			 		array $unis -> "item-value" => "item-title"
    * 			 		string $fieldid -> form field id-attr-val
    * 			 		string $fieldonchange -> form field space for js-attrs
    * 			 		string $type -> form field type-attr
    * @return		html
    * @access		public
    */        
    function getCheckRadio($fieldname, $checked_uni,$unis=array(),$fieldid="",$fieldonchange="",$type='checkbox') {

				if (is_array($checked_uni)) {
					$checked_uni2=array();
					foreach ($checked_uni as $key => $value)
						$checked_uni2[trim($key)]=trim($value);
				} else 
					$checked_uni2=trim($checked_uni);
					
			  $output='';
			  $i=0;
				if (is_array($unis))
	        foreach($unis as $uni => $v) {
	        	$i++;
		        if (is_array($checked_uni2)) {
								$checked = (in_array(trim($uni),$checked_uni2)) ? ' checked="checked"' : '';
						} else
		            $checked = ($checked_uni2 == $uni && (!empty($checked_uni2) || $checked_uni2=='0')) ? ' checked="checked"' : '';


		         $output .= '
		            <input value="'.$uni.'" type="'.$type.'" name="'.$fieldname.'" id="'.$fieldname.'['.$i.']" '.$checked.' onchange="'.$fieldonchange.'"/>&nbsp;<label for="'.$fieldname.'['.$i.']">'.$v.'</label><br/>';
	        }


        return $output;
    }    
    
}




?>
