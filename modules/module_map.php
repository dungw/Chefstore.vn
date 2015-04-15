<?php

/**
 * @author duchanh
 * @copyright 2012
 * @desc module list html of introduction
 */
 
class module_map extends Module{
    
    var $edit_html_skin  = true;
    
    function module_map(){
        $this->file = 'map.html';
        parent::module();
    }
    
    
    function draw(){
        global $skin,$title,$keywords,$description, $lang;        
        $xtpl = new XTemplate($this->tpl);
        
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        
        $title = $lang['map'];
        $keywords = $lang['map'];
        $description = $lang['map'];
        
        $xtpl->parse('main');
        return $xtpl->out('main');  
                
    }
    
}