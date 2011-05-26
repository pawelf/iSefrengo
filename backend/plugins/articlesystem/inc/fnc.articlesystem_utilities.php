<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');
}


if(!is_object($SF_pageinfos))
	$sf_pageinfos =& $GLOBALS['sf_factory']->getObject('PAGE', 'Pageinfos');
else 
	$sf_pageinfos =& $SF_pageinfos;
	
if(!is_object($SF_cattree))
	$sf_cattree =& $GLOBALS['sf_factory']->getObject('PAGE', 'Cattree');
else 
	$sf_cattree =& $SF_cattree; 
	
if(!is_object($SF_catinfos))
	$sf_catinfos =& $GLOBALS['sf_factory']->getObject('PAGE', 'Catinfos');
else 
	$sf_catinfos =& $SF_catinfos;

#if(!class_exists('sf_page_pageinfos'))
#	$sf_pageinfos =& $GLOBALS['sf_factory']->getObject('PAGE', 'Pageinfos');
#else 
#	$sf_pageinfos =& $SF_pageinfos;
#	
#if(!class_exists('sf_page_cattree'))
#	$sf_cattree =& $GLOBALS['sf_factory']->getObject('PAGE', 'Cattree');
#else 
#	$sf_cattree =& $SF_cattree;
#	
#if(!class_exists('sf_page_catinfos'))
#	$sf_catinfos =& $GLOBALS['sf_factory']->getObject('PAGE', 'Catinfos');
#else 
#	$sf_catinfos =& $SF_catinfos;
#
	
if(! function_exists(as_get_idcatsub_by_cat)){
  /**
  * gets a sub-category of an SF-page-category by sortindex
  *
  * @param		integer $sf_cat -> idcat
  *						integer $sortindex -> sort index
  *						integer $online -> 1=online, 0=offline
  * @return		array
  * @access		public
  */
  function as_get_idcatsub_by_cat($sf_cat,$sortindex=1,$online=1){
	
		global $cfg_client,$sf_pageinfos,$sf_cattree,$sf_catinfos,$client;

		$sf_cattree->setIdclient($client);
		$sf_cattree->generate();

		$sf_catinfos->setIdlang($sf_lang);
		$sf_catinfos->generate();

		$sicats=array();
		foreach ($sf_cattree->getChilds($sf_cat) as $v) 
			$sicats[$sf_cattree->getSortIndex($v)]=$v;
		
		if ($sicats[$sortindex] && $sf_catinfos->getIsOnline($sicats[$sortindex]))
			return array($sicats[$sortindex],$sf_catinfos->data['data'][$sicats[$sortindex]]['name']);

		return '';
	
	}
}
	
if(! function_exists(as_get_idcatside_by_cat)){
	/**
	* gets the SF-page of an SF-page-category by sortindex
	*
	* @param		integer $sf_cat -> idcat
	*						integer $sortindex -> sort index
	*						integer $online -> 1=online, 0=offline
	* @return		array
	* @access		public
	*/
	function as_get_idcatside_by_cat($sf_cat,$sortindex=1,$online=1){
		
		global $cfg_client,$sf_pageinfos,$sf_cattree,$sf_catinfos;

		$sf_cattree->setIdclient($client);
		$sf_cattree->generate();
		
		$sf_catinfos->setIdlang($sf_lang);
		$sf_catinfos->generate();
		
		$sf_pageinfos->setIdlang($sf_lang);
		$sf_pageinfos->generate();

		$sides=array();
		foreach ($sf_pageinfos->data['data'] as $v) 
			if ($v['idcat']==$sf_cat && $v['sortindex']==$sortindex && $v['online']==$online)
				return array($v['idside'],$v['name']);

		return '';
		
	}
}


if(! function_exists(as_get_idcat_parent_cats)){
  /**
  * gets all parent-categories of an SF-page-category
  *
  * @param		integer $sf_cat -> idcat
  *						integer $sf_lang -> language id
  *						integer $sf_client -> client id
  * @return		array
  * @access		public
  */
	function as_get_idcat_parent_cats($sf_cat,$sf_lang,$sf_client){
	
		global $cfg_client,$sf_pageinfos,$sf_cattree,$sf_catinfos;

		$sf_cattree->setIdclient($sf_client);
		$sf_cattree->generate();
		
		$sf_catinfos->setIdlang($sf_lang);
		$sf_catinfos->generate();
		
		$sf_pageinfos->setIdlang($sf_lang);
		$sf_pageinfos->generate();

		$catlevel=$sf_cattree->getLevel($sf_cat);

		$cats=array();
		$catofpage=$sf_cat;
		$cats[]=$catofpage;
		$path=array();
		for ($i=$catlevel-1;$i>=0;$i--) {
			$lastcat=$sf_cattree->getParent($catofpage);
			$cats[]=$catofpage=$lastcat;
		}

		return $cats;
	
	}
}


if(! function_exists(as_is_side_in_cat)){
  /**
  * checks SF-page-category contains a special page
  *
  * @param		integer $sf_page -> idcatside
	*					  integer $sf_cat -> idcat
  *						integer $sf_lang -> language id
  *						integer $sf_client -> client id
	*						bool $recursive
  * @return		bool 
  * @access		public
  */
	function as_is_side_in_cat($sf_page,$sf_cat,$sf_lang,$sf_client,$recursive=false){
	
		global $cfg_client,$idcat,$sf_pageinfos,$sf_cattree,$sf_catinfos;

		$sf_cattree->setIdclient($sf_client);
		$sf_cattree->generate();
		
		$sf_catinfos->setIdlang($sf_lang);
		$sf_catinfos->generate();
		
		$sf_pageinfos->setIdlang($sf_lang);
		$sf_pageinfos->generate();
		
		$catofpage=$sf_pageinfos->getIdcat($sf_page);
		
		if (($recursive==false && $catofpage==$sf_cat) || 
				($recursive==true && in_array($sf_cat,as_get_idcat_parent_cats($idcat,$lang,$client))) )
			return true;
		else
			return false;
	}

}


	

if(! function_exists(as_get_rewriteurl)){
  /**
  * creates an spoken url ("mod_rewrite 2") for an SF-page
  *
  * @param		integer $sf_page -> idcatside
  *						integer $sf_lang -> language id
  *						integer $sf_client -> client id
	*						bool $recursive
  * @return		string
  * @access		public
  */
	function as_get_rewriteurl($sf_page,$sf_lang,$sf_client){
	
		global $cfg_client,$sf_pageinfos,$sf_cattree,$sf_catinfos;


		$sf_cattree->setIdclient($sf_client);
		$sf_cattree->generate();
		
		$sf_catinfos->setIdlang($sf_lang);
		$sf_catinfos->generate();
		
		$sf_pageinfos->setIdlang($sf_lang);
		$sf_pageinfos->generate();
		
		$catofpage=$sf_pageinfos->getIdcat($sf_page);
		$catlevel=$sf_cattree->getLevel($catofpage);
		$cats=array();
		
		$cats[]=$catofpage;
		$path=array();
		for ($i=$catlevel-1;$i>=0;$i--) {
			$lastcat=$sf_cattree->getParent($catofpage);
			$cats[]=$catofpage=$lastcat;
		}
		
		for ($i=count($cats)-1;$i>=0;$i--) {
			$path[]=$sf_catinfos->getRewriteAliasRaw($cats[$i]);
		}
	
	 return $cfg_client['htmlpath'].implode('/',$path).'/'.$sf_pageinfos->getRewriteUrlRaw($sf_page).$cfg_client['url_rewrite_suffix'];
	}

}

if(! function_exists(as_get_startidside_by_cat)){
  /**
  * gets start-SF-page of an page category
  *
  * @param		integer $sf_cat -> idcat
  *						integer $sf_lang -> language id
  * @return		integer
  * @access		public
  */
	function as_get_startidside_by_cat($sf_cat,$sf_lang){
	
		global $cfg_client,$sf_pageinfos,$sf_cattree,$sf_catinfos;

		$sf_pageinfos->setIdlang($sf_lang);
		$sf_pageinfos->generate();

		$sides=array();
		foreach ($sf_pageinfos->data['data'] as $v) {
			if ($v['idcat']==$sf_cat && $v['is_start'])
			 $sf_page=$v['idside'];
			 continue;
		}

		return $sf_page;
	}

}
	
	

if(! function_exists(as_get_val)){
  /**
  * get data from SF-db "content_external"
  *
  * @param		string $value_name -> content key
  *						bool $langdependent -> depending on current SF-page-language
  * @return		string
  * @access		public
  */
  function as_get_val($value_name,$langdependent=true)
  {
   global $idcatside, $cms_db, $db, $con_side, $cms_mod;

	if ($langdependent!==false)
		$idsidelang=$con_side[$idcatside]['idsidelang'];
	else 
		$idsidelang=0;


   $sql = "SELECT
      *
     FROM
      ".$cms_db['content_external'] ."
     WHERE
      idsidelang='".$idsidelang."'
      AND container='".$cms_mod['container']['id']."'
      AND idtype='$value_name'";
   $db->query($sql);
   $db->next_record();

   return $db->f('value');
  }
}

if(! function_exists(as_set_val)){
	/**
	* stores data to SF-db "content_external"
	*
	* @param		string $value_name -> content key
	*						string $value -> data
	*						bool $langdependent -> depending on current SF-page-language
	* @return		string
	* @access		public
	*/
  function as_set_val($value_name, $value,$langdependent=true)
  {
   global $idcatside, $cms_db, $db, $con_side, $cms_mod;

	if ($langdependent!==false)
		$idsidelang=$con_side[$idcatside]['idsidelang'];
	else 
		$idsidelang=0;

   //Schauen, ob es den Wert schon gibt
   $sql = "SELECT
      *
     FROM
      ".$cms_db['content_external'] ."
     WHERE
      idsidelang='".$idsidelang."'
      AND container='".$cms_mod['container']['id']."'
      AND idtype='$value_name'";
   $db->query($sql);

   //Es gibt den Wert schon -> wert aktuallisieren
   if ($db->next_record()){
    $sql = "UPDATE
       ". $cms_db['content_external'] ."
      SET
       value='$value'
      WHERE
       idsidelang='".$idsidelang."'
       AND container='".$cms_mod['container']['id']."'
       AND idtype='$value_name'";
   }
   //Es gibt den Wert noch nicht, neu in tabelle einfügen
   else{
    $sql = "INSERT INTO
       ". $cms_db['content_external'] ."
       (idsidelang, container, idtype, value)
      VALUES
       ('".$idsidelang."',
        '".$cms_mod['container']['id']."',
        '$value_name', '$value')";
   }

   $db->query($sql);

  //Letzte Ünderung Datum ändern!
  $sql = "UPDATE ". $cms_db['side_lang']. " SET lastmodified='".time()."' WHERE idsidelang='".$con_side[$idcatside]['idsidelang']."' ";
                  $db->query($sql);

   //Cache löschen
   //Seite fürs frontend neu generieren, da sich ein Wert geändert hat
   change_code_status($idcatside, 1, 'idcatside');

  }
}

if(! function_exists(as_backendmode)){
  function as_backendmode($vw='preview')
  {	
  	global $sess,$view;
  	return ($sess->name == 'sefrengo' && $view != $vw);
  }
}
				

if(! function_exists(as_cleanstring)){

	function as_cleanstring($string)
	{
		//Leerzeichen raus
		$string = trim($string);

		//Sonderzeichen raus
		$string = str_replace("ä","ae", $string);
		$string = str_replace("Ä","Ae", $string);
		$string = str_replace("ü","ue", $string);
		$string = str_replace("Ü","Ue", $string);
		$string = str_replace("ö","oe", $string);
		$string = str_replace("Ö","Oe", $string);
		$string = str_replace("ß","ss", $string);
		$string = str_replace("+","-", $string);
		$string = str_replace(":","_", $string);
		$string = str_replace("!","_", $string);
		$string = str_replace("&","_", $string);
		$string = str_replace("®","_", $string);
		$string = str_replace("©","_", $string);	
		$string = str_replace('"','', $string);		
		$string = str_replace("'","", $string);	
		$string = str_replace(" ","_", $string);	
		
		//Weiteres...
		$string = str_replace(",","", $string);

		return $string;
	}
}

//
//
//

if(! function_exists(as_url_creator)){
	/**
	* creates article's url
	*
	* @param		....
	* @return		string
	* @access		public
	*/	
	function as_url_creator($doc,$vars=array())
	{
		global $_AS,$cfg_client,$sess,$view,$mvars;
		$doc=str_replace('&amp;','&',$doc);
		$url=str_replace('&','&amp;',$doc);
		
		if ($cfg_client['url_rewrite']==0 || ($sess->name == 'sefrengo' && ($view == 'edit' || $view == 'preview' )))
			$bw='&amp;';
		else
			$bw='?';
		foreach ($vars as $k => $v) {
			if (!empty($v) || $v==='0' || $v===0)
				if (strpos($k,'cal_')!==false) { 
					if ($mvars[74]=='calendar')
						$url.=$bw.$_AS['modkey'].$k.'='.$v;
				} else {
						$url.=$bw.$_AS['modkey'].$k.'='.$v;
				}
				
			$bw='&amp;';
		}
		return $url;	
	}
}


//
//
//
if(! function_exists(as_natksort)){
	function as_natksort($array)
	{
	    $original_keys_arr = array();
	    $original_values_arr = array();
	    $clean_keys_arr = array();
	    $i = 0;
	    foreach ($array AS $key => $value)
	    {
	        $original_keys_arr[$i] = $key;
	        $original_values_arr[$i] = $value;
	       
	      
	        $clean_keys_arr[$i] = str_replace(explode(',','Ä,Ö,Ü,ä,ö,ü,É,È,À,ë,é,è,à,ç'), 
	        																	explode(',','A,O,U,a,o,u,E,E,A,e,e,e,a,c'),
	        																	html_entity_decode($key));
	        																	
	        $i++;
	    }

	    natcasesort($clean_keys_arr);
	
	    $result_arr = array();
	
	    foreach ($clean_keys_arr AS $key => $value)
	    {
	        $original_key = $original_keys_arr[$key];
	        $original_value = $original_values_arr[$key];
	        $result_arr[$original_key] = $original_value;
	    }
	
	    return $result_arr;
	} 
}

// function array_join
// merges 2 arrays preserving the keys,
// even if they are numeric (unlike array_merge)
// if 2 keys are identical, the last one overwites
// the existing one, just like array_merge
// merges up to 10 arrays, minimum 2.
function as_array_merge($a1, $a2, $a3=null, $a4=null, $a5=null, $a6=null, $a7=null, $a8=null, $a9=null, $a10=null) {
    $a=array();
    foreach($a1 as $key=>$value) $a[$key]=$value;
    foreach($a2 as $key=>$value) $a[$key]=$value;
    if (is_array($a3)) $a=array_join($a,$a3,$a4,$a5,$a6,$a7,$a8,$a9,$a10);
    return $a;
}


?>
