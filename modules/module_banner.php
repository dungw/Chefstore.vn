<?php

/**
 * @author duchanh
 * @copyright 2012
 * @desc module list html of introduction
 */
 
class module_banner extends Module{
    
    function module_banner(){
        $this->file = 'banner.html';
        parent::module();
    }
    
    function draw(){
        global $skin;
        $xtpl = new XTemplate($this->tpl);
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        
        $miniBanner = new miniBanner();
        $heartBanner = $miniBanner->getBannerByPosition('heart');
        if(count($heartBanner)>0){
            foreach($heartBanner as $key=>$value){
                $img = base_url().$value['link'];
                $xtpl->assign('img',$img);
                $xtpl->assign('link',$value['link']);
                $xtpl->assign('name',$value['name']);
                $xtpl->parse('main.banner'); 
            }
        }
        
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}
