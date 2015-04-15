<?php

/**
 * @author duchanh
 * @copyright 2012
 */


class module_top_menu extends Module{
    
    function module_top_menu(){
        $this->file = 'top_menu.html';
        parent::module();
    }
    
    function draw(){
        global $skin;
        $xtpl = new XTemplate($this->tpl);
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        
        
        $xtpl->assign('link_aboutus',createLink('aboutus'));
        $xtpl->assign('link_product',createLink('product'));
        $xtpl->assign('link_news',createLink('news'));
        $xtpl->assign('link_help',createLink('help'));
        $xtpl->assign('link_contact',createLink('contact'));
        
        
        
        $page = CInput::get('page','txt','home');                
        
        if($page=='home'){
            $xtpl->assign('active_home','active');    
        }
        $xtpl->assign('product',createLink('product'));
        if($page=='product'){
            $xtpl->assign('active_product','active');    
        }
        $xtpl->assign('aboutus',createLink('aboutus'));
        if($page=='aboutus'){
            $xtpl->assign('active_aboutus','active');    
        }
        $xtpl->assign('news',createLink('news'));
        if($page=='news' || $page=='news_detail'){
            $xtpl->assign('active_news','active');    
        }
        $xtpl->assign('map',createLink('map'));
        if($page=='map'){
            $xtpl->assign('active_map','active');    
        }
        $xtpl->assign('help',createLink('guide'));
        if($page=='help'){
            $xtpl->assign('active_help','active');    
        }
        $xtpl->assign('contact',createLink('contact'));
        if($page=='contact'){
            $xtpl->assign('active_contact','active');    
        }
        $xtpl->assign('detail',createLink('detail'));
        if($page=='detail'){
            $xtpl->assign('active_detail','active');    
        }
        $xtpl->assign('faq',createLink('faq'));
        if($page=='faq'){
            $xtpl->assign('active_faq','active');    
        }
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}


