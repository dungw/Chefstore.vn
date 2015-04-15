<?php
/**
 * @author duchanh
 * @copyright 2012
 */
class module_right_ads extends Module{
    
    function module_right_ads(){
        $this->file = 'right_ads.html';
        parent::module();
    }
    
    function draw(){
        global $skin;
        $xtpl = new XTemplate($this->tpl);
        
        $skin_path  = base_url().'skin/'.$skin.'/';
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        
        $miniBanner = new miniBanner();
        $Banner = $miniBanner->getBannerByPosition('right');
        if(is_array( $Banner ) && count($Banner)>0){
            foreach($Banner as $key=>$value){
                $img = base_url().$value['img'];
                $xtpl->assign('img', $img);
                $xtpl->assign('name', $value['name']);
                $xtpl->assign('link', $value['link']);
                $xtpl->parse('main.banner');
            }
        }else{
            return '';
        }
		
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}


