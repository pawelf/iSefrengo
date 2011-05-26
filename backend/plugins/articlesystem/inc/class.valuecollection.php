<?php
//Wenn die Klasse Array Iterator nicht vorhanden ist, laden
if(!class_exists('AsArrayIterator')) {
    include_once str_replace ('\\', '/', dirname(__FILE__) . '/') . 'class.arrayiterator.php';
}

class ValueCollection {
        var $_data = array();
        var $_env = array(
                'key1' => 'settings'
            );

        //Anzahl der Eintr&auml;ge einschr&auml;nken
        /* $lines = Anzahl der Zeilen
          $offset = Starte ab dieser Zeile */
        function setLimit($lines, $offset="0") {
            if(!is_numeric($offset)) {
                $this->writeError('offset <b>'.$offset.'</b> is not numeric', __FILE__, __CLASS__, __FUNCTION__);
                return false;
            } else if(!is_numeric($lines)) {
                $this->writeError('lines <b>'.$lines.'</b> is not numeric', __FILE__, __CLASS__, __FUNCTION__);
                return false;
            } else {
                $this->_env['limit'] = " LIMIT ".$offset.",".$lines;
                return true;
            }
        }
        
        
        function generate() {
            global $adodb, $client, $lang, $cfg_cms,$_AS;
            $this->_data = array();

            //zusaetzlich generieren: Kategoriename, Veranstaltername
            $sql = "SELECT
                        *
                    FROM
                        ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_values
                    WHERE
                        idclient=".$client." AND
                        idlang=".$lang." AND
                        key1='".$this->_env['key1']."'
                    ORDER BY
                        key2 ASC
                        ".$this->_env['limit'];

            //echo $sql;

            $rs = $adodb->Execute($sql);
            if ($rs === false) die("failed");

            while (!$rs->EOF) {
                $item =& new SingleValue();
                $_data = array(
                    'idvalue' => $rs->fields['idvalue'],
                    'idclient' => $rs->fields['idclient'],
                    'idlang' => $rs->fields['idlang'],
                    'key1' => $rs->fields['key1'],
                    'key2' => $rs->fields['key2'],
                    'value' => $rs->fields['value'],
                    'userid' => $rs->fields['userid'],
                    'lastedit' => $rs->fields['lastedit']
                );

                $item->loadByData($_data);
                array_push($this->_data, $item);

                $rs->MoveNext();
            }

            $rs->Close();
        }

        function &get() {
            $i =& new AsArrayIterator();
            $i->loadByRef($this->_data);
            return $i;
        }

        //alle treffer andrucken
        function count() {
            return count($this->_data);
        }

        //Gibt eine Fehlermeldung aus
        function writeError($msg, $file, $class, $function)
        {
            if($this->error_report==true) //Fehlermeldung ausgeben?
            {
                echo '<strong>Error:</strong> '.$msg.' <br /><strong>File:</strong> '.$file.'<br /><strong>Class:</strong> '.$class.'<br /><strong>Function:</strong> '.$function.'()';
            }
            return false;
        }
}




class SingleValue {
    var $_data = array(
        'idvalue' => '0',
        'idclient' =>  '0',
        'idlang' =>  '0',
        'key1' =>  '0',
        'key2' => '',
        'value' => '',
        'userid' => '',
        'lastedit' => ''
        );
    var $_is_loaded = false;
    var $_dirty = false;

    var $_extra = array();

    function SingleValue() { }

    function loadById($id) {
        global $adodb, $cfg_cms,$_AS;

        $sql = "SELECT
                    *
                FROM
                    ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_values
                WHERE
                    idvalue='".$id."';";

        $rs = $adodb->Execute($sql);
        if ($rs === false) die("failed");

        $_data = array(
                    'idvalue' => $rs->fields['idvalue'],
                    'idclient' => $rs->fields['idclient'],
                    'idlang' => $rs->fields['idlang'],
                    'key1' => $rs->fields['key1'],
                    'key2' => $rs->fields['key2'],
                    'value' => $rs->fields['value'],
                    'userid' => $rs->fields['userid'],
                    'lastedit' => $rs->fields['lastedit']
        );

        $rs->Close();

        $this->loadByData($_data);
    }


    function loadByData($incoming_data, $set_dirtyflag = false) {
        foreach($incoming_data as $key => $value)
        {
            $this->_set($key, $value, $set_dirtyflag);
        }

        $this->_is_loaded = true;
    }


    function getDataByKey($key,$transform=false) {
    		if ($transform)
    			return htmlentities($this->_data[$key],ENT_COMPAT,'UTF-8');
        return $this->_data[$key];
    }


    function _set($key, $val, $set_dirtyflag = true) {
        if (array_key_exists($key, $this->_data)) {
            $this->_data[$key] = $val;
            if ($set_dirtyflag) {
                $this->_dirty = true;
            }
            return true;
        }

        return false;
    }

    function setData($key, $val, $set_dirtyflag = true) {
        if (array_key_exists($key, $this->_data)) {
            $this->_data[$key] = $val;
            if ($set_dirtyflag) {
                $this->_dirty = true;
            }
            return true;
        }

        return false;
    }
    
    function _setSpecial() {
        global $client, $lang, $auth,$_AS;

        $this->_set('idclient', $client, false);
        $this->_set('idlang', $lang, false);
        $this->_set('userid', $auth->auth['uid'], false);
        $this->_set('lastedit', date("Y-m-d H:i:s"), false);
    }

    function save() {
        global $adodb, $cfg_cms,$_AS;

 				$globalsettings=$_POST['settings_global'];

        if ($this->_dirty) {
            if ($this->_data['idvalue'] > 0) {
                $this->_setSpecial();

                $set_sql = array();
                foreach($this->_data as $key => $value)
                {
                	if ($globalsettings=="true" && ($key=='idlang' || $key=='idvalue'))
                		continue;

                  $set_sql[] = $key."='".$value."'";
                }

								if ($globalsettings==true)
                	$sql = "UPDATE
                          ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_values
                        SET
                          ".implode($set_sql, ", ")."
                        WHERE
                            key2='".$this->_data['key2']."';";
                else
                	$sql = "UPDATE
                          ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_values
                        SET
                          ".implode($set_sql, ", ")."
                        WHERE
                            idvalue='".$this->_data['idvalue']."';";
                            
               //echo $sql;
               $adodb->Execute($sql);
                
            } else {
                $this->_setSpecial();

                $keys_sql = array();
                $values_sql = array();
                foreach($this->_data as $key => $value)
                {
                    $values_sql[] = "'".$value."'";
                    $keys_sql[] = $key;
                }
                
                $sql = "INSERT INTO
                            ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_values
                             (".implode($keys_sql, ', ').")
                        VALUES
                             (".implode($values_sql, ', ').")";

                //echo $sql;
                $adodb->Execute($sql);

                //Die neue ID in das Objekt speichern, falls sie sofort gebraucht wird
                $this->setData('idvalue', $adodb->Insert_ID());
            }

            $this->_dirty = false;
        }
    }

    function delete() {
        global $adodb, $cfg_cms,$_AS;

        if ($this->_data['idvalue'] > 0) {
            $sql = "DELETE FROM
                        ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_values
                    WHERE
                        idvalue='".$this->_data['idvalue']."'";
            $adodb->Execute($sql);
            
        }
    }
    
    function setBaseSettingFT($key1,$key2,$value) {
  		global $client;  
  		
  		if (empty($key1) || empty($key2))
  			return false;
  		
				$this->_data['key1']=$key1;
				$this->_data['key2']=$key2;
				$this->_data['idclient']=$client;
				$this->_data['idlang']=0;
				$this->_data['value']=$value;
				$this->_dirty=true;
    
    }
    
    

}







?>
