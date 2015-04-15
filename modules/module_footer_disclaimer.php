<?php

/**
 * @author duchanh
 * @copyright 2012
 */

class module_footer_disclaimer extends Module{
    
    var $edit_html_skin  = true;
    
    function module_footer_disclaimer(){
        $this->file = 'footer_disclaimer.html';
        parent::module();
    }
    
    function draw(){
        global $skin;
        $xtpl = new XTemplate($this->tpl);
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        
        $xtpl->assign('hotline', getConfig('hotline'));
        $xtpl->assign('address', getConfig('address'));
        
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}


