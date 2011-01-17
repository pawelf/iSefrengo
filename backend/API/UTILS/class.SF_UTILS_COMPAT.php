<?PHP
/**
  *
  * Copyright (c) 2011 iSefrengo
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
class SF_UTILS_COMPAT extends SF_API_Object
{
/**
  *
  *
  */
  public function __construct()
  {
    require_once('PHP/Compat.php');
    //if(!class_exists('PHP_Compat')) throw new SF_UTILS_COMPATException('Fehler PHP_Compat existiert nicht');
   }
/**
  *
  *
  */    
  public function SF_Compat_loadFunction($function)
  {
    return PHP_Compat::loadFunction($function);
  }
/**
  *
  *
  */
  public function SF_Compat_loadConstant($constant)
  {
    return PHP_Compat::loadConstant($constant);  
  }
/**
  *
  *
  */
  public function SF_Compat_loadEnvironment($environment, $setting)
  {
    return PHP_Compat::loadFunctionEnvironment($environment, $setting);
  }
/**
  *
  *
  */
  public function SF_Compat_loadVersion($version=null)
  {
   return PHP_Compat::loadVersion($version);  
  }
}
/**
 * @package
 *
 * @author
 * @since
 */
//class SF_UTILS_COMPATException extends iSFException{}
?>