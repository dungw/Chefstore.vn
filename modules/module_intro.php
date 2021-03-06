<?php

/**
 * @author duchanh
 * @copyright 2012
 * @desc module list html of introduction
 */



class module_intro extends Module{
    
    var $edit_html_skin  = true;
    
    function module_intro(){
        $this->file = 'intro.html';
        parent::module();
    }
    
    
    function draw(){
        global $skin;        
        $xtpl = new XTemplate($this->tpl);
                
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}

