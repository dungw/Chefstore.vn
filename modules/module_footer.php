<?php

/**
 * @author duchanh
 * @copyright 2012
 */

class module_footer extends Module{
    
    var $edit_html_skin  = true;
    
    function module_footer(){
        $this->file = 'footer.html';
        parent::module();
    }
    
    
    function draw(){
        global $skin;        
        $xtpl = new XTemplate($this->tpl);
        
        $xtpl->assign('link_home', base_url());
        
        
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}

