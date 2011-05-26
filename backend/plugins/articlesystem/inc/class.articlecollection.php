<?php
//Wenn die Klasse Array Iterator nicht vorhanden ist, laden
if(!class_exists('AsArrayIterator')) {
    include_once str_replace ('\\', '/', dirname(__FILE__) . '/') . 'class.arrayiterator.php';
}

class ArticleCollection {
        var $_data = array();
        var $_env = array(
                'daterange_start' => '',
                'daterange_end' => '',
                'idcategory' => '',
                'hide_offline' => ' AND ART.online=1',
                'hide_archived' => ' AND ART.archived=0'
            );
        var $hide_offline = true;
        var $hide_archived = true;

		    /**
		    * collection setting: time/date range
		    *
		    * @param 		timestamp start -> from
		    *        		timestamp end -> to
		    * @return		nothing
		    * @access		public
		    */        
        function setDateRange($start='', $end='', $start_field='', $end_field='',$mode='',$sdmode=false) {

        		//echo ">=".date("Y-m-d H:i:s", $start)." <=".date("Y-m-d H:i:s", $end).'<br/>';

    	   		if (!empty($start_field) && $mode=='date')
    	  			$custom_start_sql= " OR ART.".$start_field." = '0000-00-00' OR ART.".$start_field." = '--'";
    	  		else if (!empty($start_field) && $mode=='datetime')
    	  			$custom_start_sql= " OR ART.".$start_field." = '0000-00-00 00:00' OR ART.".$start_field." = '-- 00:00'";

    	   		if (!empty($end_field) && $mode=='date')
    	  			$custom_end_sql= " OR ART.".$end_field." = '0000-00-00' OR ART.".$end_field." = '--'";
    	   		else if (!empty($end_field) && $mode=='datetime')
    	  			$custom_end_sql= " OR ART.".$end_field." = '0000-00-00 00:00' OR ART.".$end_field." = '-- 00:00'";
    	   		
        		if (empty($start_field))
        			 $start_field = 'article_startdate';
        		if (empty($end_field))
        			 $end_field = 'article_startdate';
							
	        		if (!empty($start)){
								if (empty($mode))
		            	$this->_env['daterange_start'] =  " AND ( ART.".$start_field." >= '".date("Y-m-d H:i:s", $start)."' ".$custom_end_sql." ) ";
								else if ($mode=='datetime')
		            	$this->_env['daterange_start'] =  " AND ( ART.".$start_field." >= '".date("Y-m-d H:i", $start)."' ".$custom_end_sql." ) ";
								else if ($mode=='date')
		            	$this->_env['daterange_start'] =  " AND ( ART.".$start_field." >= '".date("Y-m-d", $start)."' ".$custom_end_sql." ) ";

								if ($sdmode==true) {
									if (empty($mode))
			            	$this->_env['daterange_start'] =  " AND ( ART.".$start_field." >= '".date("Y-m-d 00:00:00", $start)."' ".$custom_end_sql." ) ";
									else if ($mode=='datetime')
			            	$this->_env['daterange_start'] =  " AND ( ART.".$start_field." >= '".date("Y-m-d 00:00", $start)."' ".$custom_end_sql." ) ";
									else if ($mode=='date')
			            	$this->_env['daterange_start'] =  " AND ( ART.".$start_field." = '".date("Y-m-d", $start)."' ".$custom_end_sql." ) ";
		
									if (empty($mode))
			            	$this->_env['daterange_start'] .=  " AND ( ART.".$start_field." <= '".date("Y-m-d 23:59:59", $start)."' ".$custom_end_sql." ) ";
									else if ($mode=='datetime')
			            	$this->_env['daterange_start'] .=  " AND ( ART.".$start_field." <= '".date("Y-m-d 23:59", $start)."' ".$custom_end_sql." ) ";
								}

	        		} else
	        			$this->_env['daterange_start'] = '';


																				
	            if (!empty($end))  {
								if (empty($mode))
		            	$this->_env['daterange_end'] = " AND ( ART.".$end_field." <= '".date("Y-m-d H:i:s", $end)."' ".$custom_start_sql.")";
								else if ($mode=='datetime')
		            	$this->_env['daterange_end'] = " AND ( ART.".$end_field." <= '".date("Y-m-d H:i", $end)."' ".$custom_start_sql.")";
								else if ($mode=='date')
		            	$this->_env['daterange_end'] = " AND ( ART.".$end_field." <= '".date("Y-m-d", $end)."' ".$custom_start_sql.")";
	        		} else
	        			$this->_env['daterange_end'] = '';
	        	

        			
        }

		    /**
		    * collection setting: end date/time
		    *
		    * @param		timestamp start date -> 
				*						timestamp end date -> 
		    * @return		nothing
		    * @access		public
		    */        
        function setLegal($date_end,$date_start='') {
           if (!empty($date_end) && empty($date_start))
            	$this->_env['legal'] = " AND ( ART.article_enddate >= '".date("Y-m-d H:i:s",$date_end)."' OR ART.article_enddate = '0000-00-00 00:00:00' ) ";
        	else if (!empty($date_end) && !empty($date_start)) {
            	$this->_env['legal'] = " AND ( ART.article_startdate <= '".date("Y-m-d H:i:s",$date_start)."' OR ART.article_startdate = '0000-00-00 00:00:00' ) ";
            	$this->_env['legal'] .= " AND ( ART.article_enddate >= '".date("Y-m-d H:i:s",$date_end)."' OR ART.article_enddate = '0000-00-00 00:00:00' ) ";
        }	else
        		$this->_env['legal'] = '';
       
        }

		    /**
		    * collection setting: show/hide offline article
		    *
		    * @param		bool $b -> true = articles must be online 
		    * @return		nothing
		    * @access		public
		    */ 
        function setHideOffline($b) {
            if($b == true) $this->_env['hide_offline'] = ' AND ART.online=1';
            else $this->_env['hide_offline'] = ' AND (ART.online=0 OR ART.online= 1)';
        }

		    /**
		    * collection setting: show/hide archived article
		    *
		    * @param		bool $b -> true = never show archived / false = show archived only
		    * @return		nothing
		    * @access		public
		    */ 
        function setHideArchived($b=true) {
            if($b == true) $this->_env['hide_archived'] = ' AND ART.archived=0';
            else $this->_env['hide_archived'] = ' AND ART.archived=1';
        }

		    /**
		    * collection setting: search filter
		    *
		    * @param		string $string -> search phrase 
		    						array $fields -> articlesystem-main-table columns
		    						bool $exact -> searches the phrase within the contents (false) or 
		    				                exact as contents (true) without leading or trailing stuff
		    * @return		nothing
		    * @access		public
		    */ 
        function setSearchString($string='',$fields=array('title','text','teaser'),$exact=false) {

						$string=str_replace("\n",'||NL||',$string);
						$this->_env['search']='';
						$string2=trim($string);
						// find all exact marked string parts and keep in mind -> "exact string"
						preg_match_all('#\"(.*)\"#sU',stripslashes($string),$exactstrings);
						// earease all exact marked string parts within the seach string
        		foreach ($exactstrings[0] as $v)
        			$string2=str_replace($v,'',$string2);
						// split all space separated parts
        		$searchstringsarray=array();
        		if (!empty($string2))
        			$searchstringsarray=explode(' ',$string2);   
						//merge exact strings and single words
        		$searchstringsarray=array_merge($searchstringsarray,$exactstrings[1]);	

						if (!empty($searchstringsarray)) {
							$sqlparts=array();
							$this->_env['search']=' AND (';
							foreach($searchstringsarray as $v1)
		        		foreach ($fields as $v2)
		        			if (!empty($v1)){
		        				$v1=str_replace('||NL||',"\r"."\n",$v1);
										if(!$exact) {
			        				$sqlparts[]= ' ART.'.$v2.' LIKE \'%'.$v1.'%\' ';
			        				if (htmlentities($v1,ENT_COMPAT,'UTF-8')!=$v1)
			        					$sqlparts[]= ' ART.'.$v2.' LIKE \'%'.htmlentities($v1,ENT_COMPAT,'UTF-8').'%\' ';
			        			} else {			        			
		        					$sqlparts[]= ' ART.'.$v2.' LIKE \''.$v1.'\' ';
		        				 	if (htmlentities($v1,ENT_COMPAT,'UTF-8')!=$v1)
		        				 		$sqlparts[]= ' ART.'.$v2.' LIKE \''.htmlentities($v1,ENT_COMPAT,'UTF-8').'\' ';
										}
	        			}
								// replace plus for AND-search
								$this->_env['search'].=implode('OR',str_replace('+',' ',$sqlparts));
							$this->_env['search'].=')';
						}
						
#						echo $this->_env['search'];

	      }

		    /**
		    * collection setting: additional custom-search filter
		    *
		    * @param		array $filters -> 'custom field' => 'value'
		    * @return		nothing
		    * @access		public
		    */ 
        function setCustomFilters($filters='') {

        		if (empty($filters)) {
							$this->_env['customfilters']='';
        			return;
        		}
						$sqlparts=array();
						$this->_env['customfilters']=' AND ';
	      		foreach ($filters as $k => $v) {
							$sqlparts_sub=array();
							foreach(array_filter(explode('###',$v)) as $vv) {
		      			if (!empty($vv)){
		      				 $sqlparts_sub[]= ' ART.'.$k.' LIKE \''.$vv.'\' ';
		      			}
		      		}
							$sqlparts[]='('.implode('OR',$sqlparts_sub).')';
	      		}
						// replace plus for AND-search
					
					$this->_env['customfilters'].=implode('AND',$sqlparts);
					//echo $this->_env['customfilters'];

	      }

		    /**
		    * collection setting: adds addition where clause stuff
		    *
		    * @param		string $csql -> ... AND ( <where stuff> ) ... 
		    * @return		nothing
		    * @access		public
		    */ 
        function setCustomWhere($csql) {
        	$csql=stripslashes(trim($csql));
        	if (empty($csql))
        		$this->_env['custom_where']='';
        	else
        		$this->_env['custom_where'] = ' AND ('.$csql.')';
        }
	      

		    /**
		    * collection setting: order setting
		    *
		    * NO LONGER IN USE?!
		    */ 
        function setOrder($order) {
            switch ($order) {
                case 'created':
                case 'lastmodified':
                    $this->_env['order'] = 'SL.'.$order;
                    break;
                default:
                    $this->_env['order'] = 'SL.title';
            }
        }

		    /**
		    * collection setting: category filter
		    *
		    * @param		string $idcategory -> category/ies (more than one must be separated by commas). 
		    * @return		nothing
		    * @access		public
		    */ 
        function setIdcategory($idcategory='') {

					if (empty($idcategory)) {
						$this->_env['idcategory']='';
						return;
					}


				//for backward compatibility i kept the old comparisions
        		if (strpos($idcategory,',')!==false) { 
        			unset($sql);
       				$idcategories=explode(',',$idcategory);
							
							$idcategories2=array();
							
       				foreach ($idcategories as $v)
       					$idcategories2[]='\'%|'.$v.'|%\'';
							
							$sql .= ' AND ( ART.idcategory=\''.implode('\' OR ART.idcategory=\'',$idcategories).'\''.
											' OR ART.idcategory like '.implode(' OR ART.idcategory like ',$idcategories2).') ';
							
							$this->_env['idcategory'] = $sql;
            } else {
               $this->_env['idcategory'] = ' AND ( ART.idcategory=\''.$idcategory.'\' OR ART.idcategory like '. '\'%|'.$idcategory.'|%\' )';
						}

        }

		    /**
		    * collection setting: limit collection items
		    *
		    * @param		integer $lines -> number of items
		    						integer $offset -> start item
		    * @return		nothing
		    * @access		public
		    */ 
        function setLimit($lines='', $offset="0") {
        		if (empty($lines)) {
                $this->_env['limit'] = "";
                return true;
            }
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
		    * collection setting: sorting
		    *
		    * @param		array $sortarray -> "sorting field" => "sorting direction"
		    * @return		nothing
		    * @access		public
		    */ 
        function setSorting($sortarray='') {
        
        	if (is_array($sortarray))
        		$sortarray=array_filter($sortarray);
        	if (empty($sortarray))
						$sortarray=array(
							'article_startdate' => 'DESC',
              'article_starttime' => 'DESC', 
              'article_enddate' => 'DESC',
              'article_endtime' => 'DESC',
              'created' => 'DESC',
              'title' => 'ASC'
              );
					foreach($sortarray as $key => $value)
						if (!is_numeric($key))
							$sortarray_temp[]='ART.'.$key.' '.$value;
						else
							$sortarray_temp[]=$value;
							
					$this->_env['sort'] = implode(', ',$sortarray_temp);
					
					//echo $this->_env['sort'];
					unset($sortarray,$sortarray_temp);
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
            // no sort defined set the default
						if (empty($this->_env['sort']))
							$this->setSorting();
            //zusaetzlich generieren: Kategoriename, Veranstaltername
            $sql = "SELECT
                        ART.*
                    FROM
                        ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']." AS ART
                    WHERE
                        ART.idclient=".$client." AND
                        ART.idlang=".$lang
                        .$this->_env['idcategory']
                        .$this->_env['hide_offline']
                        .$this->_env['hide_archived']
                        .$this->_env['search']
                        .$this->_env['customfilters']
                        .$this->_env['daterange_end']
                        .$this->_env['daterange_start']
                        .$this->_env['legal']
                        .$this->_env['custom_where']."
                    ORDER BY
												".$this->_env['sort']
                        .$this->_env['limit'];

#          	echo "<pre>".$sql."</pre>";
            $rs = $adodb->Execute($sql);
            if ($rs === false) die("Articlesystem SQL-Error");

            while (!$rs->EOF) {
                /*if ($this->_env['hide_offline'] && $rs->fields['online') == 1 ) {
                    continue;
                } */

                $item =& new SingleArticle();
                $_data = array(
                    'idarticle' => $rs->fields['idarticle'],
                    'idclient' => $rs->fields['idclient'],
                    'idlang' => $rs->fields['idlang'],
                    'online' => $rs->fields['online'],
                    'archived' => $rs->fields['archived'],
                    'protected' => $rs->fields['protected'],
                    'article_startdate' => $rs->fields['article_startdate'],
                    'article_startdate_yn' => $rs->fields['article_startdate_yn'],
                    'article_starttime' => $rs->fields['article_starttime'],
                    'article_starttime_yn' => $rs->fields['article_starttime_yn'],
                    'article_enddate' => $rs->fields['article_enddate'],
                    'article_enddate_yn' => $rs->fields['article_enddate_yn'],
                    'article_endtime' => $rs->fields['article_endtime'],
                    'article_endtime_yn' => $rs->fields['article_endtime_yn'],
                    'title' => $rs->fields['title'],
                    'teaser' => $rs->fields['teaser'],
                    'text' => $rs->fields['text'],
                    'custom1' => $rs->fields['custom1'],
                    'custom2' => $rs->fields['custom2'],
                    'custom3' => $rs->fields['custom3'],
                    'custom4' => $rs->fields['custom4'],
                    'custom5' => $rs->fields['custom5'],
                    'custom6' => $rs->fields['custom6'],
                    'custom7' => $rs->fields['custom7'],
                    'custom8' => $rs->fields['custom8'],
                    'custom9' => $rs->fields['custom9'],
                    'custom10' => $rs->fields['custom10'],
                    'custom11' => $rs->fields['custom11'],
                    'custom12' => $rs->fields['custom12'],
                    'custom13' => $rs->fields['custom13'],
                    'custom14' => $rs->fields['custom14'],
                    'custom15' => $rs->fields['custom15'],
                    'custom16' => $rs->fields['custom16'],
                    'custom17' => $rs->fields['custom17'],
                    'custom18' => $rs->fields['custom18'],
                    'custom19' => $rs->fields['custom19'],
                    'custom20' => $rs->fields['custom20'],
                    'custom21' => $rs->fields['custom21'],
                    'custom22' => $rs->fields['custom22'],
                    'custom23' => $rs->fields['custom23'],
                    'custom24' => $rs->fields['custom24'],
                    'custom25' => $rs->fields['custom25'],
                    'custom26' => $rs->fields['custom26'],
                    'custom27' => $rs->fields['custom27'],
                    'custom28' => $rs->fields['custom28'],
                    'custom29' => $rs->fields['custom29'],
                    'custom30' => $rs->fields['custom30'],
                    'custom31' => $rs->fields['custom31'],
                    'custom32' => $rs->fields['custom32'],
                    'custom33' => $rs->fields['custom33'],
                    'custom34' => $rs->fields['custom34'],
                    'custom35' => $rs->fields['custom35'],
                    'idcategory' => $rs->fields['idcategory'],
                    'userid' => $rs->fields['userid'],
                    'created' => $rs->fields['created'],
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

		    /**
		    * count collection items (old methode)
		    *
		    * @param		none
		    * @return		number of items
		    * @access		public
		    */
        function count() {
            return count($this->_data);
        }

		    /**
		    * count collection items
		    *
		    * @param		none
		    * @return		number of items
		    * @access		public
		    */
	       function countitems() {
	
	            global $adodb, $client, $lang, $cfg_cms,$_AS;
	
	            // no sort defined set the default
							if (empty($this->_env['sort']))
								$this->setSorting();
	            //zusaetzlich generieren: Kategoriename, Veranstaltername
	            $sql = "SELECT
	                        count(*) as number
	                    FROM
	                        ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']." AS ART
	                    WHERE
	                        ART.idclient=".$client." AND
	                        ART.idlang=".$lang
	                        .$this->_env['idcategory']
	                        .$this->_env['hide_offline']
	                        .$this->_env['hide_archived']
	                        .$this->_env['search']
	                        .$this->_env['customfilters']
	                        .$this->_env['daterange_end']
	                        .$this->_env['daterange_start']
	                        .$this->_env['legal']
                        	.$this->_env['custom_where'];
	
#	          	echo "<pre>".$sql."</pre>";
	            $rs = $adodb->Execute($sql);
	            if ($rs === false) die("failed");
							return $rs->fields['number'];
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




class SingleArticle {
    var $_data = array(
            'idarticle' => '0',
            'idclient' => '0',
            'idlang' => '0',
            'online' => '0',
            'archived' => '0',
            'protected' => '0',
            'article_startdate' => '',
            'article_startdate_yn' => '0',
            'article_starttime' => '',
            'article_starttime_yn' => '0',
            'article_enddate' => '',
            'article_enddate_yn' => '0',
            'article_endtime' => '',
            'article_endtime_yn' => '0',
            'title' => '',
            'teaser' => '',
            'text' => '',
            'custom1' => '',
            'custom2' => '',
            'custom3' => '',
            'custom4' => '',
            'custom5' => '',
            'custom6' => '',
            'custom7' => '',
            'custom8' => '',
            'custom9' => '',
            'custom10' => '',
            'custom11' => '',
            'custom12' => '',
            'custom13' => '',
            'custom14' => '',
            'custom15' => '',
            'custom16' => '',
            'custom17' => '',
            'custom18' => '',
            'custom19' => '',
            'custom20' => '',
            'custom21' => '',
            'custom22' => '',
            'custom23' => '',
            'custom24' => '',
            'custom25' => '',
            'custom26' => '',
            'custom27' => '',
            'custom28' => '',
            'custom29' => '',
            'custom30' => '',
            'custom31' => '',
            'custom32' => '',
            'custom33' => '',
            'custom34' => '',
            'custom35' => '',
            'idcategory' => '',
            'userid' => '',
            'created' => '',                    
            'lastedit' => '',
            'hash' => ''
        );
    var $_is_loaded = false;
    var $_dirty = false;
		var $_new_ids = array();
		var $_new_langs = array();
    var $_extra = array();
    var $_dontsave = array();

    function SingleArticle() { }

    /**
    * loads an article from db
    *
    * @param		number §id -> article's id
    * @return		nothing
    * @access		public
    */
    function loadById($id) {
        global $adodb, $cfg_cms,$_AS, $auth;

				if (!empty($id) && ($_AS['valid']!='false' || $_POST['action']!='save_article')) {
	
	        $sql = "SELECT
	                    ART.*
	                FROM
	                    ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']." AS ART
	                WHERE
	                    ART.idarticle='".$id."';";
					//echo $sql;
	        $rs = $adodb->Execute($sql);
	        if ($rs === false) die("failed");
			
					
					if( $_GET['action']!='dupl_article'){	
					
	        $_data = array(
	                    'idarticle' => $rs->fields['idarticle'],
	                    'idclient' => $rs->fields['idclient'],
	                    'idlang' => $rs->fields['idlang'],
	                    'online' => $rs->fields['online'],
	                    'archived' => $rs->fields['archived'],
	                    'protected' => $rs->fields['protected'],
	                    'article_startdate' => $rs->fields['article_startdate'],
	                    'article_startdate_yn' => $rs->fields['article_startdate_yn'],
	                    'article_starttime' => $rs->fields['article_starttime'],
	                    'article_starttime_yn' => $rs->fields['article_starttime_yn'],
	                    'article_enddate' => $rs->fields['article_enddate'],
	                    'article_enddate_yn' => $rs->fields['article_enddate_yn'],
	                    'article_endtime' => $rs->fields['article_endtime'],
	                    'article_endtime_yn' => $rs->fields['article_endtime_yn'],
	                    'title' => $rs->fields['title'],
	                    'teaser' => $rs->fields['teaser'],
	                    'text' => $rs->fields['text'],
	                    'custom1' => $rs->fields['custom1'],
	                    'custom2' => $rs->fields['custom2'],
	                    'custom3' => $rs->fields['custom3'],
	                    'custom4' => $rs->fields['custom4'],
	                    'custom5' => $rs->fields['custom5'],
	                    'custom6' => $rs->fields['custom6'],
	                    'custom7' => $rs->fields['custom7'],
	                    'custom8' => $rs->fields['custom8'],
	                    'custom9' => $rs->fields['custom9'],
	                    'custom10' => $rs->fields['custom10'],
	                    'custom11' => $rs->fields['custom11'],
	                    'custom12' => $rs->fields['custom12'],
	                    'custom13' => $rs->fields['custom13'],
	                    'custom14' => $rs->fields['custom14'],
	                    'custom15' => $rs->fields['custom15'],
	                    'custom16' => $rs->fields['custom16'],
	                    'custom17' => $rs->fields['custom17'],
	                    'custom18' => $rs->fields['custom18'],
	                    'custom19' => $rs->fields['custom19'],
	                    'custom20' => $rs->fields['custom20'],
	                    'custom21' => $rs->fields['custom21'],
	                    'custom22' => $rs->fields['custom22'],
	                    'custom23' => $rs->fields['custom23'],
	                    'custom24' => $rs->fields['custom24'],
	                    'custom25' => $rs->fields['custom25'],
	                    'custom26' => $rs->fields['custom26'],
	                    'custom27' => $rs->fields['custom27'],
	                    'custom28' => $rs->fields['custom28'],
	                    'custom29' => $rs->fields['custom29'],
	                    'custom30' => $rs->fields['custom30'],
	                    'custom31' => $rs->fields['custom31'],
	                    'custom32' => $rs->fields['custom32'],
	                    'custom33' => $rs->fields['custom33'],
	                    'custom34' => $rs->fields['custom34'],
	                    'custom35' => $rs->fields['custom35'],
	                    'idcategory' => $rs->fields['idcategory'],
	                    'userid' => $rs->fields['userid'],
	                    'created' => $rs->fields['created'],
	                    'lastedit' => $rs->fields['lastedit'],
	                    'hash' => $rs->fields['hash']
	        					);
	        } else {

	        $_data = array(
	                    'idarticle' => '',
	                    'idclient' => $rs->fields['idclient'],
	                    'idlang' => $rs->fields['idlang'],
	                    'online' => '',
	                    'archived' => '',
	                    'protected' => '',
	                    'article_startdate' => '',
	                    'article_startdate_yn' => '',
	                    'article_starttime' => '',
	                    'article_starttime_yn' => '',
	                    'article_enddate' => '',
	                    'article_enddate_yn' => '',
	                    'article_endtime' => '',
	                    'article_endtime_yn' => '',
	                    'title' => $rs->fields['title'],
	                    'teaser' => $rs->fields['teaser'],
	                    'text' => $rs->fields['text'],
	                    'custom1' => $rs->fields['custom1'],
	                    'custom2' => $rs->fields['custom2'],
	                    'custom3' => $rs->fields['custom3'],
	                    'custom4' => $rs->fields['custom4'],
	                    'custom5' => $rs->fields['custom5'],
	                    'custom6' => $rs->fields['custom6'],
	                    'custom7' => $rs->fields['custom7'],
	                    'custom8' => $rs->fields['custom8'],
	                    'custom9' => $rs->fields['custom9'],
	                    'custom10' => $rs->fields['custom10'],
	                    'custom11' => $rs->fields['custom11'],
	                    'custom12' => $rs->fields['custom12'],
	                    'custom13' => $rs->fields['custom13'],
	                    'custom14' => $rs->fields['custom14'],
	                    'custom15' => $rs->fields['custom15'],
	                    'custom16' => $rs->fields['custom16'],
	                    'custom17' => $rs->fields['custom17'],
	                    'custom18' => $rs->fields['custom18'],
	                    'custom19' => $rs->fields['custom19'],
	                    'custom20' => $rs->fields['custom20'],
	                    'custom21' => $rs->fields['custom21'],
	                    'custom22' => $rs->fields['custom22'],
	                    'custom23' => $rs->fields['custom23'],
	                    'custom24' => $rs->fields['custom24'],
	                    'custom25' => $rs->fields['custom25'],
	                    'custom26' => $rs->fields['custom26'],
	                    'custom27' => $rs->fields['custom27'],
	                    'custom28' => $rs->fields['custom28'],
	                    'custom29' => $rs->fields['custom29'],
	                    'custom30' => $rs->fields['custom30'],
	                    'custom31' => $rs->fields['custom31'],
	                    'custom32' => $rs->fields['custom32'],
	                    'custom33' => $rs->fields['custom33'],
	                    'custom34' => $rs->fields['custom34'],
	                    'custom35' => $rs->fields['custom35'],
	                    'idcategory' => $rs->fields['idcategory'],
	                    'userid' =>  $auth->auth['uid'],
	                    'created' => date("Y-m-d H:i:s"),
	                    'lastedit' => date("Y-m-d H:i:s"),
	                    'hash' => ''
	        					);	        
		        
	        }

	        $rs->Close();
				} else {

	        $_data = array(
	                    'idarticle' => $_POST['idarticle'],
	                    'idclient' => $_POST['article']['idclient'],
	                    'idlang' => $_POST['article']['idlang'],
	                    'online' => $_POST['article']['online'],
	                    'archived' => $_POST['article']['archived'],
	                    'protected' => $_POST['article']['protected'],
	                    'article_startdate' => $_POST['article']['article_startdate'],
	                    'article_startdate_yn' => $_POST['article']['article_startdate_yn'],
	                    'article_starttime' => $_POST['article']['article_starttime'],
	                    'article_starttime_yn' => $_POST['article']['article_starttime_yn'],
	                    'article_enddate' => $_POST['article']['article_enddate'],
	                    'article_enddate_yn' => $_POST['article']['article_enddate_yn'],
	                    'article_endtime' => $_POST['article']['article_endtime'],
	                    'article_endtime_yn' => $_POST['article']['article_endtime_yn'],
	                    'title' => $_POST['article']['title'],
	                    'teaser' => $_POST['article']['teaser'],
	                    'text' => $_POST['article']['text'],
	                    'custom1' => $rs->fields['custom1'],
	                    'custom2' => $rs->fields['custom2'],
	                    'custom3' => $rs->fields['custom3'],
	                    'custom4' => $rs->fields['custom4'],
	                    'custom5' => $rs->fields['custom5'],
	                    'custom6' => $rs->fields['custom6'],
	                    'custom7' => $rs->fields['custom7'],
	                    'custom8' => $rs->fields['custom8'],
	                    'custom9' => $rs->fields['custom9'],
	                    'custom10' => $rs->fields['custom10'],
	                    'custom11' => $rs->fields['custom11'],
	                    'custom12' => $rs->fields['custom12'],
	                    'custom13' => $rs->fields['custom13'],
	                    'custom14' => $rs->fields['custom14'],
	                    'custom15' => $rs->fields['custom15'],
	                    'custom16' => $rs->fields['custom16'],
	                    'custom17' => $rs->fields['custom17'],
	                    'custom18' => $rs->fields['custom18'],
	                    'custom19' => $rs->fields['custom19'],
	                    'custom20' => $rs->fields['custom20'],
	                    'custom21' => $rs->fields['custom21'],
	                    'custom22' => $rs->fields['custom22'],
	                    'custom23' => $rs->fields['custom23'],
	                    'custom24' => $rs->fields['custom24'],
	                    'custom25' => $rs->fields['custom25'],
	                    'custom26' => $rs->fields['custom26'],
	                    'custom27' => $rs->fields['custom27'],
	                    'custom28' => $rs->fields['custom28'],
	                    'custom29' => $rs->fields['custom29'],
	                    'custom30' => $rs->fields['custom30'],
	                    'custom31' => $rs->fields['custom31'],
	                    'custom32' => $rs->fields['custom32'],
	                    'custom33' => $rs->fields['custom33'],
	                    'custom34' => $rs->fields['custom34'],
	                    'custom35' => $rs->fields['custom35'],
	                    'idcategory' => $_POST['article']['idcategory'],
#	                    'userid' => $_POST['article']['userid'],
#	                    'created' => $_POST['article']['created'],
#	                    'lastedit' => $_POST['article']['lastedit'],
	                    'hash' => $_POST['hash']		
	        );		
		
				}
				
        $this->loadByData($_data);
    }


    /**
    * loads an article from incomming form data 
    *
    * @param		array §incoming_data -> form data as array
    * @return		nothing
    * @access		public
    */
    function loadByData($incoming_data) {
			if (is_array($incoming_data))
        foreach($incoming_data as $key => $value)
        {
            if ($key=='idcategory' && is_array($value)){
            	$value2=array();
            	$value2='|'.implode('|',$value).'|';
            	$this->_set($key, $value2, false);
            } else
            	$this->_set($key, $value, false);
        }

        $this->_is_loaded = true;
    }

    /**
    * gets article data 
    *
    * @param		string §key -> field name
    *						bool $transform -> "true" manipulates the data for utf8-web-output
    * @return		data of the article 
    * @access		public
    */
    function getDataByKey($key,$transform=false) {
 
    		if ($transform)
    			return htmlentities(stripslashes($this->_data[$key]),ENT_COMPAT,'UTF-8');
    
        return stripslashes($this->_data[$key]);
    }

    /**
    * set article data 
    *
    * @param		string §key -> field name
    *						string §val -> value
    *						bool $set_dirtyflag -> ???
    * @return		bool -> true = success 
    * @access		private
    */
    function _set($key, $val, $set_dirtyflag = true) {
        if (array_key_exists($key, $this->_data)) {
            $val = stripslashes($val);
            $this->_data[$key] = addslashes($val);
            if ($set_dirtyflag) {
                $this->_dirty = true;
            }
            return true;
        }

        return false;
    }

    /**
    * set article data 
    *
    * @param		string §key -> field name
    *						string §val -> value
    *						bool $set_dirtyflag -> ???
    * @return		bool -> true = success 
    * @access		public
    */
    function setData($key, $val, $set_dirtyflag = true) {
#        if (array_key_exists($key, $this->_data)) {
#            $val = stripslashes($val);
#            $this->_data[$key] = addslashes($val);
#            if ($set_dirtyflag) {
#                $this->_dirty = true;
#            }
            return $this->_set($key, $val, $set_dirtyflag);
#        }
#
#        return false;
    }

    /**
    * special article data will be temporary / will be lost on article save
    *
    * @param		string §key -> field name
    * @return		bool -> true = success
    * @access		public
    */
    function setDontSave($key) {
        if (array_key_exists($key, $this->_data)) {
            $val = stripslashes($val);
            $this->_dontsave[] = addslashes($val);
            return true;
        }

        return false;
    }

    /**
    * clear all special data marked as temporary
    *
    * @param		none
    * @return		bool -> true
    * @access		public
    */
    function clearDontSave() {
        $this->_dontsave = array();
        return true;
    }


    function _setSpecial() {
        global $client, $lang, $auth;

        $this->_set('idclient', $client, false);
        $this->_set('idlang', $lang, false);
        //$this->_set('online', 1, false);
        $this->_set('userid', $auth->auth['uid'], false);
        $this->_set('lastedit', date("Y-m-d H:i:s"), false);
        $this->_set('created', date("Y-m-d H:i:s"), false);
    }

    /**
    * stores an article in db
    *
    * @param		none
    * @return		none
    * @access		public
    */
    function save() {
        global $adodb, $cfg_cms, $_AS, $lang;

        if (is_array($this->_data['idcategory'])){
        	$this->_data['idcategory']=array_filter($this->_data['idcategory']);
        	natsort($this->_data['idcategory']);
        	$idcatstr='|'.implode('|',$this->_data['idcategory']).'|';
        	$this->_data['idcategory']=null;
        	$this->_data['idcategory']=$idcatstr;
        }
        
				$this->_new_ids=array();
				$this->_new_langs=array();
				
        if ($this->_dirty) {
        
            if ($this->_data['idarticle'] > 0) {
                $this->_setSpecial();

                $this->_dontsave[] = 'idarticle';
                $this->_dontsave[] = 'idclient';
                $this->_dontsave[] = 'idlang';
                $this->_dontsave[] = 'created';

                $set_sql = array();
                foreach($this->_data as $key => $value)
                {
                    if(!in_array($key, $this->_dontsave)) {
                        $set_sql[] = $key."='".$value."'";
                    }
                }

                $sql = "UPDATE
                          ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."
                        SET
                          ".implode($set_sql, ", ")."
                        WHERE
                           idlang=".$lang." AND idarticle='".$this->_data['idarticle']."';";
								//echo $sql."<br><br>";
                $adodb->Execute($sql);

            } else {

                $langcopy=$_AS['article_obj']->getSetting('new_articles_lang_copy');
								$langs=array();
								if ($langcopy=='true')
               		$langs=$_AS['article_obj']->getClientLangs();	

								if (count($langs)>1) { 
										$cats_test=array_filter(explode('|',$this->_data['idcategory']));
										// get category hash
										if (!empty($cats_test)) {
							        $sql = "SELECT
							                    hash
							                FROM
							                    ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_category
							                WHERE ";
											$sql .= ' ( idcategory='.implode(' OR idcategory=',array_filter(explode('|',$this->_data['idcategory']))).') ';        
					            // echo $sql;  
											$rs = $adodb->Execute($sql);
											if ($rs === false) die("failed");
		
											$cathash=array();
											while (!$rs->EOF) {
            						$cathash[] = $rs->fields['hash']; 
            						$rs->MoveNext();
        							}
											
										}
										$idcats=array();		
										
										unset($idarticle_current_lang);		
										$cats_test=array_filter(explode('|',$this->_data['idcategory']));
										
			              foreach ($langs as $lkey => $lvalue) {

											// get category for the language
														if (!empty($cats_test)) {
										        $sql = "SELECT
										                    idcategory
										                FROM
										                    ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_category
										                WHERE ";
										                
														$sql .= ' ( hash=\''.implode('\' OR hash=\'',$cathash).'\') AND idlang=\''.$lkey.'\'';               

														$rs = $adodb->Execute($sql);
														if ($rs === false) die("failed");
														$idcats[$lkey]=array();
														while (!$rs->EOF) {
			            						$idcats[$lkey][] = $rs->fields['idcategory']; 
			            						$rs->MoveNext();
			        							}										
			        							natsort($idcats[$lkey]);
			        							$this->_set('idcategory',$idcatstr='|'.implode('|',$idcats[$lkey]).'|', false);
													}

				              	$this->_setSpecial();
				              	$this->_set('idlang', $lkey, false);

				              	if ($lkey!=$lang)
													$this->_dontsave[] = 'online';
												else
													$this->_dontsave =array();
													
				                $keys_sql = array();
				                $values_sql = array();
				          
				                foreach($this->_data as $key => $value)
				                {
				                    if(!in_array($key, $this->_dontsave)) {
				                        $values_sql[] = "'".$value."'";
				                        $keys_sql[] = $key;
				                    }
				                }
				                
				                $this->_data['idarticle'] = '';
				
				                $sql = "INSERT INTO
				                            ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."
				                             (".implode($keys_sql, ', ').")
				                        VALUES
				                             (".implode($values_sql, ', ').")";
				                             
						           	//	echo $sql."<br><br>";
											$adodb->Execute($sql);

											$this->_new_ids[]=$adodb->Insert_ID();
											$this->_new_langs[]=$lkey;
											
											if ($lkey==$lang)
												$idarticle_current_lang=$adodb->Insert_ID();
										}
									

								} else {
								
			              	$this->_setSpecial();
			
			                $keys_sql = array();
			                $values_sql = array();

			                foreach($this->_data as $key => $value)
			                {
			                    if(!in_array($key, $this->_dontsave)) {
			                        $values_sql[] = "'".$value."'";
			                        $keys_sql[] = $key;
			                    }
			                }
			                $this->_data['idarticle'] = '';
			
			                $sql = "INSERT INTO
			                            ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."
			                             (".implode($keys_sql, ', ').")
			                        VALUES
			                             (".implode($values_sql, ', ').")";
			                             
			          	//echo $sql."<br><br>";
									$adodb->Execute($sql);
									
			            $this->_new_ids[]=$adodb->Insert_ID();    							
									$this->_new_langs[]=$lang;
								}

                //Die neue ID in das Objekt speichern, falls sie sofort gebraucht wird
                if (empty($idarticle_current_lang))
                	$this->setData('idarticle', $adodb->Insert_ID());
          			else
          				$this->setData('idarticle', $idarticle_current_lang);

            }

            $this->_dirty = false;
        }

        //Letzte &Auml;nderung Datum &auml;ndern!
        //$sql = "UPDATE ". $cms_db['side_lang']. " SET lastmodified='".time()."' WHERE idsidelang='".$con_side[$idcatside]['idsidelang']."' ";
        //            $adodb->Execute($sql);

    }

    /**
    * deletes an article from db
    *
    * @param		none
    * @return		none
    * @access		public
    */
    function delete() {
        global $adodb, $cfg_cms, $_AS;

        if ($this->_data['idarticle'] > 0) {

        $langcopy=$_AS['article_obj']->getSetting('new_articles_lang_copy');
				$langs=array();
				if ($langcopy=='true')
       		$langs=$_AS['article_obj']->getClientLangs();	
                      
					if ($_AS['article_obj']->getSetting('del_all_lang_copies')=='true' || count($langs)<2) {
	
		        $sql = "SELECT
		                    *
		                FROM
		                    ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."
		                WHERE
		                    hash='".$this->_data['hash']."'";
	
		        $rs = $adodb->Execute($sql);
						$articleids=array();
		
						while (!$rs->EOF) {
							$articleids[]=$rs->fields['idarticle'];
							$rs->MoveNext();
						}
	
		        $rs->Close();
	
	          $sql = "DELETE FROM
	                      ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."
	                  WHERE
	                      hash='".$this->_data['hash']."'";
						$adodb->Execute($sql);
						
						foreach ($articleids as $v) {
		          $sql = "DELETE FROM
						              ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_elements
						          WHERE
						              idarticle='".$v."'";                        
							// echo $sql."<br><br>";
							$adodb->Execute($sql);
						}
	
						// echo $sql."<br><br>";
						$adodb->Execute($sql);
					} else {
	          $sql = "DELETE FROM
					              ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."
					          WHERE
					              idarticle='".$this->_data['idarticle']."'";                        
						// echo $sql."<br><br>";
						$adodb->Execute($sql);
						
	          $sql = "DELETE FROM
					              ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_elements
					          WHERE
					              idarticle='".$this->_data['idarticle']."'";                        
						// echo $sql."<br><br>";
						$adodb->Execute($sql);
					}
        }
    }

    /**
    * get articles language equivalents by hash
    *
    * @param		string $hash -> article hash
    *						integer $langexclude -> language (id) that will be excluded in the result
    * @return		array -> "article's id" => "article's language id"
    * @access		public
    */
    function getIdAndLangFromHash($hash,$langexclude=0) {
        global $adodb, $cfg_cms,$_AS;

        $sql = "SELECT idarticle, idlang
                FROM
                    ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."
                WHERE
                    hash='".$hash."' ".((!empty($langexclude))?"AND idlang!='".$langexclude."'" :"").";";

        $adodb->Execute($sql); $array = array();
        $rs = $adodb->Execute($sql);
        if ($rs === false) die("failed");
        while (!$rs->EOF) {
            $array[$rs->fields['idarticle']] = $rs->fields['idlang'];
            
            $rs->MoveNext();
        }
        
        $rs->Close();
        
        return $array;
    }


    /**
    * set article's online state
    *
    * @param		integer $state -> 0 = offline, 1 = online
    * @return		nothing
    * @access		public
    */
    function update_online($state) {
        global $adodb, $cfg_cms,$_AS;

        if ($this->_data['idarticle'] > 0) {
            $sql = "UPDATE
                     ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."
                    SET
                     online = '".$state."'
                    WHERE
                      idarticle='".$this->_data['idarticle']."';";
            $adodb->Execute($sql);
        }
    }

    /**
    * set article's archived state
    *
    * @param		integer $state -> 0 = not archived, 1 = archived
    * @return		nothing
    * @access		public
    */
    function update_archived($state) {
        global $adodb, $cfg_cms,$_AS;

        if ($this->_data['idarticle'] > 0) {
            $sql = "UPDATE
                     ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."
                    SET
                     archived = '".$state."'
                    WHERE
                      idarticle='".$this->_data['idarticle']."';";
            $adodb->Execute($sql);
        }
    }
    
    
    /**
    * converts db-time/date-string to timestamp
    *
    * @param		string $date -> db-date/time-string
    *						string $key -> article data (fieldname)
    * @return		timestamp
    * @access		public
    */
    function convDate2Timestamp($date, $key='')
    {
        //Wenn ein Key &uuml;bergeben wurde, diesen nehmen
        if(!empty($key)) {
            $date = $this->getDataByKey($key);
        }
        	
        
        /*$regex = "/\A(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})\z/";

        $day = preg_replace($regex, "\$3", $date);
        $month = preg_replace($regex, "\$2", $date);
        $year = preg_replace($regex, "\$1", $date);

        $hour = preg_replace($regex, "\$4", $date);
        $minute = preg_replace($regex, "\$5", $date);
        $second = preg_replace($regex, "\$6", $date);

        //echo $day.".".$month.".".$year." - ".$hour.":".$minute."<br>";
        return mktime($hour, $minute, $second, $month, $day, $year);*/
				
        return strtotime($date);
    }

    
    /**
    * converts timestamp to db-time/date-string
    *
    * @param		timestamp $timestamp -> timestamp
    * @return		db-time/date-string
    * @access		public
    */
    function convTimestamp2Date($timestamp)
    {
        return date("Y-m-d H:i:s",$timestamp);
    }


    /**
    * additional availability check for articles
    *
    * @param		none
    * @return		bool -> false = not available
    * @access		public
    */
    function available()
    {

      $bool = array();
      $checked = false;
      $current_dz=mktime(0,0,0,date('m'),date('d'),date('Y'));
      $current_d=mktime(23,59,59,date('m'),date('d'),date('Y'));
      $current_dt=mktime(date('H'),date('i'),0,date('m'),date('d'),date('Y'));
      $article_startdate = $this->convDate2Timestamp('', 'article_startdate');
      $article_starttime_yn = $this->_data['article_starttime_yn'];
      $article_starttime = $this->convDate2Timestamp('', 'article_starttime');
      $article_enddate_yn = $this->_data['article_enddate_yn'];
      $article_enddate = $this->convDate2Timestamp('', 'article_enddate');
      $article_endtime_yn = $this->_data['article_endtime_yn'];
      $article_endtime = $this->convDate2Timestamp('', 'article_endtime');

			if ($article_startdate>$current_d)
				return false;
				
			if (!empty($article_starttime_yn) &&  $article_starttime>$current_dt)
				return false;
				
#			if (!empty($article_enddate_yn) &&  $article_enddate<$current_dt)
#				return false;

			if (!empty($article_endtime_yn) && !empty($article_enddate_yn) &&  $article_enddate<$current_dt)
				return false;

			if (!empty($article_enddate_yn) &&  $article_enddate<$current_dz)
				return false;
								
			if (!empty($article_endtime_yn) &&  $article_endtime<$current_dt)
				return false;
					
			return true;
    }
    
}


?>
