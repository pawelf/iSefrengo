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
class SF_PAGE_Pageinfos extends SF_API_Object
{
/**
  *
  */
  protected $data = array( 'data' => array());
/**
  *
  */					
  protected $config = array( 'idlang' => 0, 
						  'check_frontend_prems' => false,
						  'check_backend_prems' => false,    						
    					'link_sessionstring' => '', 	
    					'link_use_idlang' => true,
    					'link_extra_urlstring' => '',
    					'is_generated' => false
    					);
/**
  *
  */
  protected $cache;
/**
  *
  */
  protected $db;
/**
  * Constructor
  */
  public function __construct()
  {
    $this->cache =& sf_factoryGetObjectCache('UTILS', 'DbCache');
    $this->db =& sf_factoryGetObjectCache('DATABASE', 'Ado');
  }
/**
  *
  */
  public function setIdlang($idlang)
  {
    $this->config['idlang'] = (int) $idlang;
  }
/**
  *
  */
  public function setCheckFrontendperms($boolean)
  {
    $this->config['check_frontend_prems'] = (boolean) $boolean;
  }
/**
  *
  */
  public function setCheckBackendperms($boolean)
  {
    $this->config['check_backend_prems'] = (boolean) $boolean;
  }
/**
  *
  */    
  public function setLinkSessionstring($sessionstring)
  {
    $this->config['link_sessionstring'] = $sessionstring;
  }
/**
  *
  */  
  public function setLinkUseIdlang($boolean)
  {
    $this->config['link_use_idlang'] = (boolean) $boolean;
  }
/**
  *
  */  
  public function setLinkExtraUrlstring($urlstring)
  {
    $this->config['link_extra_urlstring'] = $urlstring;
  }
/**
  *
  */
  public function generate()
  {
    global $cfg_client, $sess, $perm, $cms_db, $db, $auth;
//check dependencies 
    if($this->config['idlang'] < 1 || $this->config['is_generated'])
    {
      return false;
    }		
		
		if(sf_factoryObjectExistsInCache('PAGE', 'Catinfos'))
		{
			$this->catinfos =& sf_factoryGetObjectCache('PAGE', 'Catinfos');
		}else{
			$this->catinfos =& sf_factoryGetObject('PAGE', 'Catinfos');
			$this->catinfos->setIdlang($this->config['idlang']);
			$this->catinfos->generate();
		}
		$catinfos =& $this->catinfos->getCatinfoDataArrayByRef();
		
//url parameter with lang
		$querylang = ($this->config['link_use_idlang']) ? 'lang='.$this->config['idlang'].'&amp;' : '';
			
//check perm: user have perm to see pages with the protected flag
//$sql_hide_protected_pages = ( $perm->have_perm(2, 'area_frontend', 0) || $this->config['check_frontend_prems']) ? '': 'AND (F.online & 0x04) = 0x00';
		$sql_hide_protected_pages = '';
    if(($auth->auth['uid'] == 'nobody'))
    {
		  $sql_hide_protected_pages = 'AND (F.online & 0x04) = 0x00';
		} 
		
//check perms for user with advanced frontend perms
		$check_frontendperms_in_page = ($auth->auth['uid'] != 'nobody' && $this->config['check_frontend_perms']);		
		$check_backendperms_in_page = $this->config['check_backend_perms'];
		$sess_string = ($this->config['link_sessionstring'] != '') ? '_SF_SESSION_STRING' : '';
	
		$sql = "SELECT
					D.idcatside, D.idcat, D.sortindex, D.is_start,
					E.idside,
					IF ((F.online & 0x03) = 0x01 OR ((F.online & 0x02) = 0x02 AND (UNIX_TIMESTAMP(NOW()) BETWEEN F.start AND F.end)) ,'1' ,'0') AS online,
					IF ( ((F.online & 0x04) = 0x04) ,'1' ,'0') AS protected,
					F.title, F.start, F.rewrite_use_automatic, F.rewrite_url, F.end, F.idsidelang, F.created, F.lastmodified,
					F.idtplconf
				FROM
					".$cms_db['cat_side']." D LEFT JOIN
					".$cms_db['side']." E USING(idside) LEFT JOIN
					".$cms_db['side_lang']." F USING(idside)
				WHERE 
					D.idcat IN (". implode(',', array_keys($catinfos)). ")
					AND  F.idlang   = '".$this->config['idlang']."'
					$sql_hide_protected_pages
					ORDER BY D.idcatside";
		
//try cache - on success jump out with return true
		$cache_key = $sql 
						.'|'.$this->config['link_extra_urlstring'] 
						.'|'.$sess_string
						.'|'.implode(',', $perm->get_group())
                        .'|'.$this->config['check_frontend_prems']
                        .'|'.$this->config['check_backend_prems'];
						
		if($data = $this->cache->getCacheEntry($cache_key))
		{
			$this->data =& $data;
			
//insert session if get mode
			if($this->config['link_sessionstring'] != '')
			{
				foreach($this->data['data'] AS $k=>$v)
				{
					$this->data['data'][$k]['link'] = str_replace('_SF_SESSION_STRING', $this->config['link_sessionstring'], $this->data['data'][$k]['link']);
				}
			}
			return true;
		}					

	    $rs = $this->db->Execute($sql);
	    
	    if($rs === false)
	    {
	       return true;
	    }
		
		  while(! $rs->EOF )
		  {
			  $idcatside_loop = $rs->fields['idcatside'];
			  $idcat_loop = $rs->fields['idcat'];
			  if($check_frontendperms_in_page)
			  {
				  if($rs->fields['protected'] == 1 && ! $perm->have_perm(18, 'frontendpage', $idcatside_loop, $idcat_loop))
				  {
				    $rs->MoveNext();
					  continue;
				  }
			  }
			
			  if($check_backendperms_in_page)
			  {
				  if(!$perm->have_perm(17, 'side', $idcatside_loop, $idcat_loop))
				  {
				    $rs->MoveNext();
					  continue;
				  }
			  }
			
			  $link_loop = $cfg_client['contentfile'] . '?'. $querylang .'idcatside='. $idcatside_loop . 
							       $sess_string . $this->config['link_extra_urlstring'];
							
			  $this->data['data'][$idcatside_loop] = array( 'link'               =>$link_loop,
															'idcat'              =>$idcat_loop,
															'sortindex'          =>$rs->fields['sortindex'],
															'idside'             =>$rs->fields['idside'],
															'name'               =>$rs->fields['title'],
															'created'            =>$rs->fields['created'],
															'lastmodified'       =>$rs->fields['lastmodified'],
															'online'             =>$rs->fields['online'],
															'idsidelang'         =>$rs->fields['idsidelang'],
															'is_start'           =>$rs->fields['is_start'],
															'idtplconf'          =>$rs->fields['idtplconf'],
															'rewrite_use_automatic' =>$rs->fields['rewrite_use_automatic'],
															'rewrite_url'          =>$rs->fields['rewrite_url'],
															'user_protected'     =>$rs->fields['user_protected']
														);
			$rs->MoveNext();
		}
		
		//insert cache
		$this->cache->insertCacheEntry($cache_key, $this->data, 'frontend', 'tree');
		
		//replace placeholder '_SF_SESSION_STRING' with real session
		if($this->config['link_sessionstring'] != '')
		{
			foreach($this->data['data'] AS $k=>$v)
			{
				$this->data['data'][$k]['link'] = str_replace('_SF_SESSION_STRING', $this->config['link_sessionstring'], $this->data['data'][$k]['link']); 
			}
		}	
	  return true;
  }
/**
  * Returns the IdSideLang of a given idcatside
  * 
  * @param int $idcatside
  * @return 
  */
  public function getIdSideLang($idcatside){return $this->data['data'][$idcatside]['idsidelang'];}
/**
  * Returns the Link of a given idcatside
  * 
  * @param int $idcatside
  * @return 
  */
  public function getLink($idcatside){return $this->data['data'][$idcatside]['link'];}
/**
  * Returns the Idcat of a given idcatside
  * 
  * @param int $idcatside
  * @return
  */
  public function getIdcat($idcatside){return $this->data['data'][$idcatside]['idcat'];}
/**
  * Returns the Idside of a given idcatside
  * 
  * @param int $idcatside
  * @return int 
  */
  public function getIdside($idcatside){return $this->data['data'][$idcatside]['idside'];}
/**
  * Returns the RewriteUseAutomatic of a given idcatside
  * 
  * @param int $idcatside
  * @return bool
  */
  public function getRewriteUseAutomatic($idcatside){return $this->data['data'][$idcatside]['rewrite_use_automatic'];}
/**
  * Returns the RewriteUrlRaw of a given idcatside
  * 
  * @param int $idcatside
  * @return
  */  
  public function getRewriteUrlRaw($idcatside){return $this->data['data'][$idcatside]['rewrite_url'];}
/**
  * Returns the Sortindex of a given idcatside
  * 
  * @param int $idcatside
  * @return 
  */
  public function getSortindex($idcatside){return $this->data['data'][$idcatside]['sortindex'];}
/**
  * Returns the CreatedTimestamp of a given idcatside
  * 
  * @param int $idcatside
  * @return str 
  */
  public function getCreatedTimestamp($idcatside){return $this->data['data'][$idcatside]['created'];}
/**
  * Returns the LastmodifiedTimestamp of a given idcatside
  * 
  * @param int $idcatside
  * @return str 
  */
  public function getLastmodifiedTimestamp($idcatside){return $this->data['data'][$idcatside]['lastmodified'];}
/**
  * Returns the Parent of a given idcatside
  * 
  * @param int $idcatside
  * @return str 
  */
  public function getParent($idcatside){return $this->getIdcat($idcatside);}
/**
  * Returns the IsOnline of a given idcatside
  * 
  * @param int $idcatside
  * @return str 
  */
  public function getIsOnline($idcatside){return $this->data['data'][$idcatside]['online'];}
/**
  * Returns the IsProtected of a given idcatside
  * 
  * @param int $idcatside
  * @return str 
  */
  public function getIsProtected($idcatside){return $this->data['data'][$idcatside]['user_protected'];}
/**
  * Returns the Idtplconf of a given idcatside
  * 
  * @param int $idcatside
  * @return str 
  */  
  public function getIdtplconf($idcatside){return $this->data['data'][$idcatside]['idtplconf'];}
/**
  * Returns the Title of a given idcatside
  * 
  * @param int $idcatside
  * @return str 
  */
  public function getTitle($idcatside){return $this->data['data'][$idcatside]['name'];}
/**
  * Returns the IsStart of a given idcatside
  * 
  * @param int $idcatside
  * @return 
  */
  public function getIsStart($idcatside){return $this->data['data'][$idcatside]['is_start'];}
/**
  * Returns the summary of a given idcatside
  * 
  * @param int $idcatside
  * @return str
  */
	public function getSummary($idcatside){return $this->_getMetaValFormSql($idcatside, 'summary');}  
/**
  * Returns the metadescription of a given idcatside
  * 
  * @param int $idcatside
  * @return str
  */
  public function getMetaDescription($idcatside){return $this->_getMetaValFormSql($idcatside, 'meta_description');}	
/**
  * Returns the MetaKeywords of a given idcatside
  * 
  * @param int $idcatside
  * @return  str
  */
  public function getMetaKeywords($idcatside){return $this->_getMetaValFormSql($idcatside, 'meta_keywords');}
/**
  * Returns the MetaAuthor of a given idcatside
  * 
  * @param int $idcatside
  * @return str 
  */
  public function getMetaAuthor($idcatside){return $this->_getMetaValFormSql($idcatside, 'meta_author');}
/**
  * Returns the MetaRobots of a given idcatside
  * 
  * @param int $idcatside
  * @return str 
  */
  public function getMetaRobots($idcatside){return $this->_getMetaValFormSql($idcatside, 'meta_robots');}
/**
  * Returns the Author of a given idcatside
  * 
  * @param int $idcatside
  * @return str 
  */
  public function getAuthor($idcatside){return $this->_getMetaValFormSql($idcatside, 'author');}
/**
  * Returns the MetaRedirect of a given idcatside
  * 
  * @param int $idcatside
  * @return str 
  */
  public function getMetaRedirect($idcatside){return $this->_getMetaValFormSql($idcatside, 'meta_redirect');}
/**
  * Returns the MetaRedirectUrl of a given idcatside
  * 
  * @param int $idcatside
  * @return str 
  */
  public function getMetaRedirectUrl($idcatside){return $this->_getMetaValFormSql($idcatside, 'meta_redirect_url');}
/**
  * Returns the Idlang of a given idcatside
  * 
  * @param int $idcatside
  * @return
  */  
  public function getIdlang($idcatside){return $this->_getMetaValFormSql($idcatside, 'idlang');}
/**
  * Returns the Start of a given idcatside
  * 
  * @param int $idcatside
  * @return
  */   
  public function getStart($idcatside){return $this->_getMetaValFormSql($idcatside, 'start');}
/**
  * Returns the End of a given idcatside
  * 
  * @param int $idcatside
  * @return
  */ 
  public function getEnd($idcatside){return $this->_getMetaValFormSql($idcatside, 'end');}
/**
  * Returns the MetaRobotsTime of a given idcatside
  * 
  * @param int $idcatside
  * @return
  */   
  public function getMetaRobotsTime($idcatside){return $this->_getMetaValFormSql($idcatside, 'meta_redirect_time');}
/**
  * Returns all idcatsides of one cat as an array in a given order.
  * 
  * Possible Options:
  * $options['order'] - Set the order. Possible values are idcatside, sortindex, is_start, 
  * name, created, lastmodified, start, end, idside. Default is sortindex.
  * $options['order_dir'] - Orderdir is ASC or DESC. Default is ASC.
  * $options['show_startpage'] - (bool) true or false. Default is true
  * $options['hide_online'] - (bool) true or false. Default is false
  * $options['hide_offline'] - (bool) true or false. Default is true
  * 
  * @param int $idcat
  * @param arr $options 
  * @return arr 
  */
  public function getIdcatsidesByIdcat($idcat, $options = array())
  {
    global $cms_db;    	
//cast
    $idcat = (int) $idcat;
    $ret = array();
//handle options
    $options['order'] = (isset($options['order'])) ? $options['order'] : 'sortindex';
    $options['order'] = (in_array($options['order'], array('sortindex', 'is_start', 'name', 'created', 'lastmodified', 'start', 'end', 'idside'))) ? $options['order'] : 'sortindex';
    $options['show_startpage'] = (isset($options['show_startpage'])) ? (bool) $options['show_startpage'] : true;
    $options['order_dir'] = (isset($options['order_dir'])) ?  strtoupper($options['order_dir']) : 'ASC';
    $options['order_dir'] = ($options['order_dir'] == 'DESC') ?  'DESC' : 'ASC';
    $options['hide_online'] = (isset($options['hide_online'])) ?  (bool) $options['hide_online'] : false;
    $options['hide_offline'] = (isset($options['hide_offline'])) ?  (bool) $options['hide_offline'] : true;
    	
    $sql_order = 'D.sortindex';
    switch($options['order'])
    {
      case 'idcatside':
    	case 'sortindex':
    	case 'is_start':
    	  $sql_order = 'D.'.$options['order'];
    	  break;
    	case 'name':
    	  $sql_order = 'F.title';
    		break;
    	case 'created':
    	case 'lastmodified':
    	case 'start':
    	case 'end':
    	  $sql_order = 'F.'.$options['order'];
    		break;
    	case 'idside':
    	  $sql_order = 'E.'.$options['order'];
    		break;
    }
    	
    $sql_order_dir = ($options['order_dir'] == 'ASC') ? 'ASC' : 'DESC';
    	
//get sql
    $sql = "SELECT
					D.idcatside
				FROM
					".$cms_db['cat_side']." D LEFT JOIN
					".$cms_db['side']." E USING(idside) LEFT JOIN
					".$cms_db['side_lang']." F USING(idside)
				WHERE 
					D.idcat = $idcat
					AND  F.idlang   = '".$this->config['idlang']."'
				ORDER BY 
					$sql_order $sql_order_dir";				

	    $rs = $this->db->Execute($sql);
	    
    if($rs === false)
	  {
	    return $ret;
	  }
		
		while(!$rs->EOF)
		{
		  if(!$options['show_startpage'] && $this->getIsStart($rs->fields['idcatside']) == 1)
			{
			  $rs->MoveNext();
				continue;
			}
			
			if($options['hide_online'] && $this->getIsOnline($rs->fields['idcatside']) == 1)
			{
				$rs->MoveNext();
				continue;
			}
			
			if($options['hide_offline'] && $this->getIsOnline($rs->fields['idcatside']) == 0)
			{
			  $rs->MoveNext();
		    continue;
      }
			
      if($this->getIdcat($rs->fields['idcatside']) > 0)
      {
        array_push($ret, $rs->fields['idcatside']);
		  }
							
			$rs->MoveNext();
		}
    return $ret;
  }
/**
	* Checks recursive if the given idcatside is a child of the givent $idcat
	*
	* @param int $idcatside pageid to check
	* @param int $idcat_parent needed parent folder-id
	*
	* @return bool
	*/
  public function isChildOf($idcatside, $idcat_parent)
  {
		if($this->getIdcat($idcatside) == $idcat_parent ||
			$this->catinfos->getParent($this->getIdcat($idcatside)) == $idcat_parent ||
			$this->catinfos->getRootparent($this->getIdcat($idcatside)) == $idcat_parent)
    {
			return true;
		}elseif( $this->getIdcat($idcatside) == $this->catinfos->getRootparent($this->getIdcat($idcatside)) ||
	    $this->catinfos->getRootparent($this->getIdcat($idcatside)) != 0 ){
			return false;
		}
		return $this->catinfos->isChildOf($this->catinfos->getIdcat(), $idcat_parent);
	}
/**
  *
  */    
  public function &getPageinfoDataArrayByRef()
  {
    return $this->data['data'];
  }  
/**
  * Returns the sqlfield of the given idcatside
  * 
  * @param int $idcatside
  * @param str $sqlfield Must be a value of the side_lang
  * @return str
  */
	private function _getMetaValFormSql($idcatside, $sqlfield)
	{
		global $cms_db;
		
		$ret = FALSE; 	
//cast
    $idcatside = (int) $idcatside;
    $sqlfield = addslashes($sqlfield);
    if($idcatside < 1 || $sqlfield == '')
    {
      return $ret;
    }
     	
//run sql
      $sql = "SELECT
					D.idcatside, F.$sqlfield
				FROM
					".$cms_db['cat_side']." D LEFT JOIN
					".$cms_db['side']." E USING(idside) LEFT JOIN
					".$cms_db['side_lang']." F USING(idside)
				WHERE 
					D.idcatside = $idcatside
					AND  F.idlang   = '".$this->config['idlang']."' ";				

	    $rs = $this->db->Execute($sql);
	    
	  if($rs === false)
	  {
	    return $ret;
	  }
		
		if(!$rs->EOF)
	  {
	    $ret= $rs->fields[$sqlfield];
		}
		return $ret;
  }
} 
?>
