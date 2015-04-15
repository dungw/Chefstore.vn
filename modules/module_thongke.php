<?php

/**
 * @author duchanh
 * @copyright 2012
 */

class module_thongke extends Module{
    
    var $edit_html_skin  = true;
    
    function module_thongke(){
        $this->file = 'thong_ke.html';        
        parent::module();
    }
    
    function draw(){
        global $skin;        
        $xtpl = new XTemplate($this->tpl);
        
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        
        $counter = counter();        
        $xtpl->assign('total', $counter['total']);
        $xtpl->assign('online', $counter['online']);
               
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}

