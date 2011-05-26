<?php
if (!class_exists('Lang')) {
	class Lang {
	    var $lang = array();
	
	    function Lang($file) {
	    	global $_AS;
	   
	        if(file_exists($file)) {
	            require $file;
	           
	            $this->lang =& $plug_lang;
	        }
	    }
	
	    function get($key) {
	        return $this->lang[$key];
	    }
	
	}
}
?>
