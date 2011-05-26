<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');
}

$_AS['db']='{db}';

include_once str_replace ('\\', '/', dirname(__FILE__) . '/').'../articlesystem/index.php'; //Basisklasse

?>


