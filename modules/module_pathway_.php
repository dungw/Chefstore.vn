<?php

/**
 * @author duchanh
 * @copyright 2012
 */

class module_pathway extends Module{
    
    function module_pathway(){
        $this->file = 'pathway.html';
        parent::module();
    }
    
    function draw(){
        global $skin;
        $xtpl = new XTemplate($this->tpl);
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        
        
        $page = CInput::get('page','txt','');
        if($page=='home' || $page==''){
            return '';
        }
       
        
        
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}


