<?PHP
// File: $Id: class.SF_HEADER.php 01 2008-07-11 19:18:49Z htf $
// +----------------------------------------------------------------------+
// | Version: Sefrengo $Name:  $                                          
// +----------------------------------------------------------------------+
// | Copyright (c) 2010 iSefrengo          |
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
// + Autor: $Author: Torsten Hofmann $
// +----------------------------------------------------------------------+
// + Revision: $Revision: 01 $
// +----------------------------------------------------------------------+
// + Description:
// +----------------------------------------------------------------------+
// + Changes:
// +----------------------------------------------------------------------+
// + ToDo:
// +----------------------------------------------------------------------+


class SF_HEADER_Headerinfos extends SF_API_Object{
	
    private $db;
/**	    
    var $sf_doctype_array = array('0' => $cms_lang['lay_doctype_none'],
                                  'xhtml-1.0-trans' => 'XHTML 1.0 transitional',
                                  'xhtml-1.0-strict' => 'XHTML 1.0 strict',
                                  'html-5' => 'XHTML 5',
                                  'html-4.0.1-trans' => 'HTML 4.0.1 transitional');
*/
/**
  * Constructor
  */
  public function SF_HEADER_Headerinfos(){
      $this->cache =& sf_factoryGetObjectCache('UTILS', 'DbCache');
      $this->db =& sf_factoryGetObjectCache('DATABASE', 'Ado');
  }
/**
  *
  *
  * @return str
  */
  public function getName($idlay) { return $this->_getLayValFormSql($idlay,'name');}
/**
  *
  *
  * @return str
  */
  public function getDescription($idlay){return $this->_getLayValFormSql($idlay,'description');}
/**
  *
  *
  * @return str
  */
  public function getDoctype($idlay){return $this->_getLayValFormSql($idlay,'doctype');}
/**
  *
  * @return str
  */
  public function getDoctypeAutoinsert($idlay){return $this->_getLayValFormSql($idlay,'doctype_autoinsert');}
//	idclient 	name 	description 	code 	doctype 	doctype_autoinsert 	deletable 	author 	created 	lastmodified
/**
  *
  * @return str
  */
  public function getCode($idlay){return $this->_getLayValFormSql($idlay,'code');}
/**
  *
  * @return str
  */
  public function getAuthor($idlay){return $this->_getLayValFormSql($idlay,'author');}
/**
  *
  * @return str
  */
  public function getCreated($idlay){return $this->_getLayValFormSql($idlay,'created');}
/**
  *
  * @return str
  */
  public function getLastmodified($idlay){return $this->_getLayValFormSql($idlay,'lastmodified');}
/**
  *
  * @param int $idlay 
  * @return str
  */
  public function SF_Switch_Doctype($idlay){
    $idlay =(int)$idlay;
//try 
//{
    if($this->getDoctypeAutoinsert($idlay) == 1){
        $ret = '';
        switch ($this->getDoctype($idlay)){
			    case 'xhtml-1.0-trans':
				    $ret = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
				  break;
				   case 'xhtml-1.0-strict':
				    $ret = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'."\n";
				  break;
				   case 'html-5':
				    $ret = '<!DOCTYPE html>'."\n";
				  break;
			    case 'html-4.0.1-trans':
				    $ret = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">'."\n";
				  break;
		    }
          return $ret;
       } 
     // } catch (Exception $e){
     // throw $e;
      //  echo $e->getMessage();
     // }
  }
/**
  *
  * @param int $idlay 
  * @return str
  */	
  public function SF_HTML_Lang_Tag($idlay){
    	$idlay =(int)$idlay;
      $ret = '';  	
  }
/**
  *
  * @param int $idlay 
  * @return str
  */	
  public function SF_Slash_Closing_Tag($idlay){
    	$idlay =(int)$idlay;
      $ret = '';
	   switch($this->getDoctype($idlay)){
		    case 'html-4.0.1-trans':
			    $ret = '';
			break;
		    case 'xhtml-1.0-trans':
		    case 'xhtml-1.0-strict':
		    case 'html-5':
		  default:
			    $ret = ' /';
	    break;
    }
    return $ret;
  }	
/**
  *
  */    
  public function setDoctype($idlay){return $this->_set('sql', 'doctype', $idlay);} 
/**
  * Returns the sqlfield from db_lay
  * 
  * @param int $idlay 
  * @param str $sqlfield 
  * @return str
  */
  private function _getLayValFormSql($idlay,$sqlfield){
		 global $cms_db;
		 $ret = FALSE;
//echo $idlay.'vs'.$sqlfield.'<br>';
		 $idlay =(int)$idlay;
		 $sqlfield = addslashes($sqlfield);
     
     	if($sqlfield == ''){
     		return $ret;
     	}
     	$sql = "SELECT
                idlay,$sqlfield
              FROM
                ".$cms_db['lay']."
			        WHERE 
				        idlay='$idlay'";
				          
       $rs = $this->db->Execute($sql);
	    
       if($rs === false){
	       return $ret;
	     }
		  
		   if(!$rs->EOF){
			  $ret= $rs->fields[$sqlfield];
		   }
		return $ret;
  }
/**
  *
  */  
  private function _set($where, $key, $value, $cast = ''){
		
		if($where == '' || $key == ''){
			return false;
		}
		
		switch($cast){
			case 'int':
				$value = (int) $value;
				break;
			case 'float':
				$value = (float) $value;
				break;
			case 'boolean':
				$value = (boolean) $value;
				break;
		}
		
		if($where2 != ''){
			if($this->data[$where][$where2][$key] != $value){
				$this->data[$where][$where2][$key] = $value;
				$this->dirty = true;
				return true;
			}
		}else{
			if($this->data[$where][$key] != $value){
				$this->data[$where][$key] = $value;
				$this->dirty = true;
				return true;
			}
		}
		return false;
	}
	
}