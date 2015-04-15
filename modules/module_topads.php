<?php

/**
 * @author duchanh
 * @copyright 2012
 */

class module_topads extends Module{
    
    function module_topads(){
        $this->file = 'topads.html';
        parent::module();
    }
    
    function draw(){
        global $skin;
        $xtpl = new XTemplate($this->tpl);
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        $page = CInput::get('page','txt','');
        
        $miniBanner = new miniBanner();
        $topBanner = $miniBanner->getBannerByPosition('top');
        
        if(is_array( $topBanner ) && count($topBanner)>0 && ($page=='' || $page=='home')){
            $value = $topBanner[0];
            $img = base_url().$value['img'];
            $xtpl->assign('img', $img);
            $xtpl->assign('name', $value['name']);
        }else{
            return '';
        }
        
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}


