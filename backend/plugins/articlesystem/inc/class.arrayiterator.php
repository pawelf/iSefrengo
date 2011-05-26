<?php
class AsArrayIterator {
    var $arr = array();
    var $pos_current = 0;
    var $pos_max = 0;
    var $keys = array();

    function ArrayIterator() {    }

    function loadByRef(&$arr) {
        $this->arr =& $arr;
        $this->keys = array_keys($this->arr);
        $this->pos_max = count($this->keys);
    }

    function load($arr) {
        $this->arr =& $arr;
        $this->keys = array_keys($this->arr);
        $this->pos_max = count($this->keys);
    }

     /**
    * setzt den Iterator zurueck auf das erste Element
    */
    function rewind(){
        $this->pos_current = 0;
    }

    /**
    * validieren, dass es das aktuelle Element gibt
    */
    function valid(){
        return array_key_exists($this->pos_current, $this->keys);
    }

    /**
    * zum naechsten Element springen
    */
    function next(){
        ++$this->pos_current;
    }

    /**
    * gibt den Wert des aktuellen Elements zurueck
    */
    function current(){
        return $this->arr[ $this->keys[$this->pos_current] ];
    }

    /**
    * gibt den Schluessel des aktuellen Elements zurueck
    */
    function key(){
        return $this->keys[$this->pos_current];
    }
}
?>
