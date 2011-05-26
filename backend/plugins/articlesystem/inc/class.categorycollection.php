<?php
//Wenn die Klasse Array Iterator nicht vorhanden ist, laden
if(!class_exists('AsArrayIterator')) {
    include_once str_replace ('\\', '/', dirname(__FILE__) . '/') . 'class.arrayiterator.php';
}

class CategoryCollection {
        var $_data = array();
        var $_env = array(
                'key1' => 'settings'
            );

		    /**
		    * collection setting: limit collection items
		    *
		    * @param 		number $lines -> number of items
		    *				 		number $offset -> start item
		    * @return		nothing
		    * @Access		public
		    */ 
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

		    /**
		    * collection setting: category filter
		    *
		    * @param		string $idcategory -> category/ies (more than one must be separated by commas). 
		    * @return		nothing
		    * @access		public
		    */ 
        function setGroups($groups) {

							$groups2=array();
							
       				foreach ($groups as $v)
       					$groups2[]='\'%|'.$v.'|%\'';
							
							$sql .= ' AND ( comment=\''.implode('\' OR comment=\'',$groups).'\''.
											' OR comment like '.implode(' OR comment like ',$groups2).') ';
							
							$this->_env['groups'] = $sql;
            

        }        
		    /**
		    * generate the collection
		    *
		    * @param 		none
		    * @return		nothing
		    * @access		public
		    */        
        function generate() {
            global $adodb, $client, $lang, $cfg_cms,$_AS;
	            $this->_data = array();

            //zusaetzlich generieren: Kategoriename, Veranstaltername
            $sql = "SELECT
                        *
                    FROM
                        ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_category
                    WHERE
                        idclient=".$client." #AND
                        #idlang=".$lang." AND
                        ".$this->_env['groups']."   

                    ORDER BY
                   			idlang ASC,
                    		name ASC,
                        hash ASC
                        ".$this->_env['limit'];

#            echo $sql;

            $rs = $adodb->Execute($sql);
            if ($rs === false) die("failed");

            while (!$rs->EOF) {
                $item =& new SingleCategory();
                $_data = array(
                    'idcategory' => $rs->fields['idcategory'],
                    'idclient' => $rs->fields['idclient'],
                    'idlang' => $rs->fields['idlang'],
                    'online' => $rs->fields['online'],
                    'name' => $rs->fields['name'],
                    'comment' => $rs->fields['comment'],
                    'userid' => $rs->fields['userid'],
                    'lastedit' => $rs->fields['lastedit'],
                    'hash' => $rs->fields['hash']
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




class SingleCategory {
    var $_data = array(
        'idcategory' => '0',
        'idclient' =>  '0',
        'idlang' =>  '0',
        'online' =>  '1',
        'name' => '',
        'comment' => '',
        'userid' => '',
        'lastedit' => '',
        'hash' => ''
        );
    var $_is_loaded = false;
    var $_dirty = false;

    var $_extra = array();

    function SingleCategory() { }

    /**
    * loads a category from db
    *
    * @param number §id -> article's id
    * @return	nothing
    * @Access	public
    */
    function loadById($id) {
        global $adodb, $cfg_cms,$_AS;

        $sql = "SELECT
                    *
                FROM
                    ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_category
                WHERE
                    idvalue='".$id."';";

        $rs = $adodb->Execute($sql);
        if ($rs === false) die("failed");

        $_data = array(
                    'idcategory' => $rs->fields['idcategory'],
                    'idclient' => $rs->fields['idclient'],
                    'idlang' => $rs->fields['idlang'],
                    'online' => $rs->fields['online'],
                    'name' => $rs->fields['name'],
                    'comment' => $rs->fields['comment'],
                    'userid' => $rs->fields['userid'],
                    'lastedit' => $rs->fields['lastedit'],
                    'hash' => $rs->fields['hash']
        );

        $rs->Close();

        $this->loadByData($_data);
    }

    /**
    * loads a category from incomming post data 
    *
    * @param array §incoming_data -> form data as array
    * @return	nothing
    * @Access	public
    */
    function loadByData($incoming_data, $set_dirtyflag = false) {
        foreach($incoming_data as $key => $value)
        {
            $this->_set($key, $value, $set_dirtyflag);
        }

        $this->_is_loaded = true;
    }

    /**
    * gets category data 
    *
    * @param string §key -> field name
    *				 bool $transform -> "true" manipulates the data for utf8-web-output
    * @return	data of the article element
    * @access	public
    */
    function getDataByKey($key) {
        return $this->_data[$key];
    }


    /**
    * set category data 
    *
    * @param string §key -> field name
    *				 string §val -> value
    *				 bool $set_dirtyflag -> ???
    * @return	data of the article element
    * @access	private
    */
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

    /**
    * set category data 
    *
    * @param string §key -> field name
    *				 string §val -> value
    *				 bool $set_dirtyflag -> ???
    * @return	data of the article element
    * @access	public
    */
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
        global $client, $lang, $auth;

        $this->_set('idclient', $client, false);
        //$this->_set('idlang', $lang, false);
        $this->_set('userid', $auth->auth['uid'], false);
        $this->_set('lastedit', date("Y-m-d H:i:s"), false);
    }

    /**
    * stores category in db
    *
    * @param none
    * @return	none
    * @access	public
    */
    function save() {
        global $adodb, $cfg_cms,$_AS;

        if ($this->_dirty) {
            if ($this->_data['idcategory'] > 0) {
                $this->_setSpecial();

                $set_sql = array();
                foreach($this->_data as $key => $value)
                {
                    $set_sql[] = $key."='".$value."'";
                }

                $sql = "UPDATE
                          ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_category
                        SET
                          ".implode($set_sql, ", ")."
                        WHERE
                            idcategory='".$this->_data['idcategory']."';";
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
                            ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_category
                             (".implode($keys_sql, ', ').")
                        VALUES
                             (".implode($values_sql, ', ').")";

                //echo $sql."<br>";
                $adodb->Execute($sql);

                //Die neue ID in das Objekt speichern, falls sie sofort gebraucht wird
                $this->setData('idcategory', $adodb->Insert_ID());
            }

            $this->_dirty = false;
        }
    }

    /**
    * delete category from db
    *
    * @param integer $id -> category id
    * @return	none
    * @access	public
    */
    function delete($id=0) {
        global $adodb, $cfg_cms,$_AS;

        //Löscht alle! Kategorien eines Projektes mittels Hash
        if (!empty($this->_data['idcategory']) && $id==0) {
            $sql = "DELETE FROM
                        ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_category
                    WHERE
                        idcategory='".$this->_data['idcategory']."'";
            //echo $sql;
            $adodb->Execute($sql);
            
        } else if ($id!=0) {
        
            $sql = "DELETE FROM
                        ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_category
                    WHERE
                        idcategory='".$id."'";
            //echo $sql;
            $adodb->Execute($sql);        

        }
    }

}







?>
