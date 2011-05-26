<?php
//Wenn die Klasse Array Iterator nicht vorhanden ist, laden
if(!class_exists('AsArrayIterator')) {
    include_once str_replace ('\\', '/', dirname(__FILE__) . '/') . 'class.arrayiterator.php';
}


class ArticleElements {
		var $_artid=null;
    var $_data_all= array();
    var $_data = array(
        'idelement' => '0',
        'idclient' => 0,
        'idlang' => 0,
        'idarticle' => '0',
        'online' => '1',
        'type' => '',
        'sort_index' => '',
        'value_no' => '',
        'value_txt' => '',
        'value_uni' => '',
        'title' => '',
        'description' => ''
        );
    var $_is_loaded = false;
    var $_dirty = false;

    var $_extra = array();

    function SingleElement() { }

    /**
    * loads an element from db
    *
    * @param		number §id -> element's id
    * @return		nothing
    * @access		public
    */
    function loadById($id) {
        global $adodb, $_AS, $cfg_cms, $client, $lang;

        $sql = "SELECT
                    *
                FROM
                    ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_elements
                WHERE
                    idarticle='".$id."' ORDER BY type, sort_index ASC;";

        $rs = $adodb->Execute($sql);
        if ($rs === false) die("failed");
        
				$this->_data_all=array();
				$type_mem=null;

				while (!$rs->EOF) {
				
					if ($type_mem!=$rs->fields['type']){
						$this->_data_all[$rs->fields['type']]['idarticle']=$rs->fields['idarticle'];
					}
          $this->_data_all[$rs->fields['type']]['idlang']= $rs->fields['idlang'];
					$this->_data_all[$rs->fields['type']]['online']=$rs->fields['online'];
					$this->_data_all[$rs->fields['type']]['idelement'][]=$rs->fields['idelement'];
          $this->_data_all[$rs->fields['type']]['idclient'][]= $rs->fields['idclient'];
					$this->_data_all[$rs->fields['type']]['type'][]=$rs->fields['type'];
					$this->_data_all[$rs->fields['type']]['sort_index'][]=$rs->fields['sort_index'];
					$this->_data_all[$rs->fields['type']]['value_no'][]=$rs->fields['value_no'];
					$this->_data_all[$rs->fields['type']]['value_txt'][]=$rs->fields['value_txt'];	
					$this->_data_all[$rs->fields['type']]['value_uni'][]=$rs->fields['value_uni'];					
					$this->_data_all[$rs->fields['type']]['title'][]=$rs->fields['title'];		
					$this->_data_all[$rs->fields['type']]['description'][]=$rs->fields['description'];						

	        $type_mem=$rs->fields['type'];
					$rs->MoveNext();
				}
        $rs->Close();
				return $this->_data_all;
#        $this->loadByData($_data_all);
    }

    /**
    * loads an element from incomming post data 
    *
    * @param		array §incoming_data -> form data as array
    * @return		nothing
    * @access		public
    */
    function loadByData($incoming_data, $set_dirtyflag = false) {
				$this->_data_all=array();
				if (is_array($incoming_data))
        foreach($incoming_data as $v) {

	        foreach($v as $key => $value) {
	            $this->_set($key, $value, $set_dirtyflag);
	        }
	      $this->_data_all[$this->_data['type']]=$this->_data;
				}

        $this->_is_loaded = true;
    }

    /**
    * gets article element data 
    *
    * @param		string §key -> field name
    * @return		array -> element data
    * @access		public
    */
    function getDataByKey($key) {
    	
        return $this->_data[$key];
    }

    /**
    * gets all article element data by type
    *
    * @param		string §key -> type name
    * @return		array -> element data
    * @access		public
    */
    function getDataByType($key) {
    	
        return $this->_data_all[$key];
    }

    /**
    * set article element data 
    *
    * @param		string §key -> field name
    *						string §val -> value
    *						bool $set_dirtyflag -> ???
    * @return		data of the article element
    * @access		private
    */
    function _set($key, $val, $set_dirtyflag = true) {

        if (array_key_exists($key, $this->_data)) {
            $this->_data[$key] = $val;
#            if ($set_dirtyflag) {
#                $this->_dirty = true;
#            }
            return true;
        }

        return false;
    }

    /**
    * set article element data 
    *
    * @param		string §key -> field name
    *						string §val -> value
    *						bool $type -> will be set for all element items
    * @return		data of the article element
    * @access		public
    */
    function setData($key, $val, $type='global') {

    if ($key=='idarticle')
    	$this->_artid=$val;
    	
		if ($type=='global')
			foreach($this->_data_all as $k=>$v)
				 if (array_key_exists($key, $this->_data)) {
						$this->_data_all[$k][$key] = $val;
					}

    }

    /**
    * stores article elements in db
    *
    * @param		none
    * @return		none
    * @access		public
    */
    function save() {
        global $adodb, $cfg_cms,$client, $lang, $_AS;
				$_data_all_post=$this->_data_all;
				$this->loadById($this->_artid);

				foreach ($_data_all_post as $key => $data) {

          for ($i=0;$i<count($this->_data_all[$key]['sort_index']);$i++) {
   					if (!in_array($this->_data_all[$key]['idelement'][$i],$data['idelement'])) {
							$sql = "DELETE FROM ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_elements WHERE idelement='".$this->_data_all[$key]['idelement'][$i]."'";
							//echo $sql;
							$adodb->Execute($sql);
						}
					}

          for ($i=0;$i<count($data['sort_index']);$i++) {

						// prevents in_array-warning
						if (!is_array($this->_data_all[$key]['idelement']))
							$this->_data_all[$key]['idelement']=array();
							
   					if (empty($data['idelement'][$i]) || !in_array($data['idelement'][$i],$this->_data_all[$key]['idelement'])) {     
            
              $keys_sql = array();
              $values_sql = array();	                
              $values_sql[] = "'".$data['idarticle']."'";
              $keys_sql[] = 'idarticle';
              $values_sql[] = "'".(empty($data['idclient'])?$client:$data['idclient'])."'";
              $keys_sql[] = 'idclient';
              $values_sql[] = "'".(empty($data['idlang'])?$lang:$data['idlang'])."'";
              $keys_sql[] = 'idlang';
              $values_sql[] = "'".$data['type']."'";
              $keys_sql[] = 'type';			                
              $values_sql[] = "'".$data['sort_index'][$i]."'";
              $keys_sql[] = 'sort_index';
              $values_sql[] = "'".$data['value_no'][$i]."'";
              $keys_sql[] = 'value_no';
              $values_sql[] = "'".$data['value_txt'][$i]."'";
              $keys_sql[] = 'value_txt';	   
              $values_sql[] = "'".$data['value_uni'][$i]."'";
              $keys_sql[] = 'value_uni';	   
              $values_sql[] = "'".$data['title'][$i]."'";
              $keys_sql[] = 'title';
              $values_sql[] = "'".$data['description'][$i]."'";
              $keys_sql[] = 'description';
              $values_sql[] = "'".$data['online'][$i]."'";
              $keys_sql[] = 'online';
       
              $sql = "INSERT INTO
                          ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_elements
                           (".implode($keys_sql, ', ').")
                      VALUES
                           (".implode($values_sql, ', ').") ;
                      ";
							//echo "<br/>insert:<br/>".$sql;
							$rs = $adodb->Execute($sql);
    					if ($rs === false) die("failed");
          	
					} else {

              $set_sql = array();

              $set_sql[] = 'idarticle='."'".$data['idarticle']."'";;
              $set_sql[] = 'idclient='."'".(empty($data['idclient'])?$client:$data['idclient'])."'";
              $set_sql[] = 'idlang='."'".(empty($data['idlang'])?$lang:$data['idlang'])."'";
              $set_sql[] = 'type='."'".$data['type']."'";			                
              $set_sql[] = 'sort_index='."'".$data['sort_index'][$i]."'";
              $set_sql[] = 'value_no='."'".$data['value_no'][$i]."'";
              $set_sql[] = 'value_txt='."'".$data['value_txt'][$i]."'";
              $set_sql[] = 'value_uni='."'".$data['value_uni'][$i]."'";
              $set_sql[] = 'title='."'".$data['title'][$i]."'";
              $set_sql[] = 'description='."'".$data['description'][$i]."'";
              $set_sql[] = 'online='."'".$data['online'][$i]."'";

              $sql = "UPDATE
                        ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_elements
                      SET
                        ".implode($set_sql, ", ")."
                      WHERE
                          idelement='".$data['idelement'][$i]."';";
       
							//echo "<br/>update:<br/>".$sql;
							$rs = $adodb->Execute($sql);
    					if ($rs === false) die("failed");

					}

				}

	      }
    }

    /**
    * deletes elements from db
    *
    * @param		integer/array $id -> element id or ids (ids as array)
    * @return		none
    * @access		public
    */
    function delete($id) {
        global $adodb, $cfg_cms,$_AS;

        if (!empty($id))
	        if (!is_array($id)) {
	            $sql = "DELETE FROM
	                        ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_elements
	                    WHERE
	                        idelement='".$id."'";
	            $adodb->Execute($sql);
	            
	        } else {
	        	foreach($id as $v) {
	            $sql = "DELETE FROM
	                        ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_elements
	                    WHERE
	                        idelement='".$v."'";
	            $adodb->Execute($sql);
	          }
	        } 
    }

}


?>
