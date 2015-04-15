<?php

/**
 * @author duchanh
 * @copyright 2012
 */

class module_footer_ads extends Module{
    
    function module_footer_ads(){
        $this->file = 'footer_ads.html';
        parent::module();
    }
    
    function draw(){
        global $skin;
        $xtpl = new XTemplate($this->tpl);
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        
        $miniBanner = new miniBanner();
        $banner = $miniBanner->getBannerByPosition('footer');
        if(is_array( $banner ) && count($banner)>0){
            $value = $banner[0];
        }else{
            return '';
        }
        
        $img = base_url().$value['img'];
        $xtpl->assign('img', $img);
        $xtpl->assign('name', $value['name']);
     
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}


