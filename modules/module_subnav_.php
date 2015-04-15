<?php

/**
 * @author duchanh
 * @copyright 2012
 */

class module_subnav extends Module{
    
    function module_subnav(){
        $this->file = 'subnav.html';
        parent::module();
    }
    
    function draw(){
        global $skin;
        $xtpl = new XTemplate($this->tpl);
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        
        $cid = CInput::get('cid','int',0);
        if($cid){
            $url_cur = '&cid='.$cid;
        }else{
            $url_cur = '';
        }
        
        $xtpl->assign('link_giam_gia', base_url().'san-pham/san-pham-giam-gia.html'.$url_cur);
        $xtpl->assign('link_spmoi', base_url().'san-pham/san-pham-moi.html'.$url_cur);
        $xtpl->assign('link_banchay', base_url().'san-pham/san-pham-ban-chay.html'.$url_cur);
        
        
        $xtpl->assign('googleplus',getConfig('googleplus'));
        $xtpl->assign('facebook',getConfig('facebook'));
        
      
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}


