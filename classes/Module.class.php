<?php

/**
 * @author duchanh
 * @copyright 2012
 */
  
class Module extends Base{
    
    var $file = '';
    var $tpl  = '';    
    var $cache_html = false;
    
    function module(){
        global $skin;
        $this->tpl = "skin/$skin/module/".$this->file;
    }
    
    
}