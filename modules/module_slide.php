<?php

/**
 * @author duchanh
 * @copyright 2012
 */

class module_slide extends Module{
    
    function module_slide(){
        $this->file = 'slide.html';
        parent::module();
    }
    
    function draw(){
        global $skin;
        $xtpl = new XTemplate($this->tpl);
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        
        $miniBanner = new miniBanner();
        $cid = CInput::get('cid','int',0);
        
        $banner = $miniBanner->getBannerByPosition('slide', $cid);             
        if(is_array( $banner ) && count($banner)>0){
            foreach($banner as $key=>$value){
                 $img = base_url().$value['img'];
                $xtpl->assign('img', $img);
                if($value['name'] && $value['desc'] && $value['link']){
                    $xtpl->assign('name', $value['name']);
                    $xtpl->assign('desc', $value['desc']);
                    $xtpl->assign('link', $value['link']);    
                }else{
                    $xtpl->assign('none', 'none');
                }
                
                $xtpl->parse('main.row'); 
            }                   
        }else{
            return '';
        }
        
     
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}


