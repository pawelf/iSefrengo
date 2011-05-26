<?php
// File: $Id$
// +----------------------------------------------------------------------+
// | Version: Sefrengo $Name$
// +----------------------------------------------------------------------+
// | Copyright (c) 2005 the sefrengo-group <sefrengo-group@sefrengo.de>   |
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
// + Autor: $Author$
// +----------------------------------------------------------------------+
// + Revision: $Revision$
// +----------------------------------------------------------------------+
// + Description: general metafile access class for dediplugins
// + how2use: set the dirname into the class name and constructor
// + sample:
// +        dirname = /myplugin
// +        root_name = myplugin
// +        filename = 'myplugin_meta.php'
// +        classname = class myplugin_meta
// +        constructor = function myplugin_meta()
// +----------------------------------------------------------------------+

include_once('inc/class.plugin_meta.php');

class articlesystem_meta extends plugin_meta{

	/*
	* public
	*/

	/*
	* vars
	*/

	// general plugin configuration!

	/*
	* enable functions for each client as a singel plugin
	* this feature supports sql-statements for each client
	*/
	var $multi_client = true;

	/*
	* enable auto load of plugin settings on Sefrengo startup
	* this feature supports cms_values with group_named settings
	* sample:
	*        dirname = /myplugin
	*        group_name = myplugin
	*        $cfg_myplugin = array()
	*
	*/
	var $auto_settings = false;

  /*
	* enable this file for auto. Updates
	*
	*/
	var $auto_update = true;
	
	/*
	 * set this true to load the langfile for the backend automaticly
	 * this feature is supported scince sefrengo 1.4
	 */
	var $auto_langfile = false;

	/*
	* simple set of the realname
	* sample:
	*        dirname = /myplugin
	*        root_name = myplugin
	*
	*/
	var $root_name = 'articlesystem';

    /*
     * constructor
     */

	function articlesystem_meta($call_files = false) {
		$this->dir_name = dirname(__FILE__);
		plugin_meta::plugin_init($call_files);
	}

	/*
   * extend functions
   */
}
?>

