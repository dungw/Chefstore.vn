<?php

/**
 * @author duchanh
 * @copyright 2012
 */

class module_help extends Module{
    
    var $edit_html_skin  = true;
    
    function module_help(){
        $this->file = 'helpbuy.html';
        parent::module();
    }
    
    function draw(){
        global $skin;
        $xtpl = new XTemplate($this->tpl);
        
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}
