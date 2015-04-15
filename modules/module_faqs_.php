<?php

/**
 * @author duchanh
 * @copyright 2012
 */
 
class module_faqs extends Module{
    
    function module_faqs(){
        $this->file = 'faqs.html';
        parent::module();
    }
    
    function draw(){
        global $skin;
        $xtpl = new XTemplate($this->tpl);
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        
        $faqs = getHtmlFaqs(1,5);
        $xtpl->assign('html', $faqs['html']);
        $xtpl->assign('pagging', $faqs['pagging']);
       
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}


