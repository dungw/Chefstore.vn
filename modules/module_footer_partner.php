<?php 

/**
 * @author duchanh
 * @copyright 2012
 */

class module_footer_partner extends Module{
    
    function module_footer_partner(){
        $this->file = 'footer_partner.html';
        parent::module();
    }
    
    function draw(){
        global $skin, $lang;
        $xtpl = new XTemplate($this->tpl);
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        
        $this->table = 'tbl_partner';
        $allPartner = $this->get('*',' AND status = 1 ','ordering DESC',0,30);
        foreach($allPartner as $key=>$value){
            if(!strpos($value['link'],'//')){
                $value['link'] = 'http://'.$value['link'];
            }
            
            $xtpl->assign('name', $value['name']);
            if($value['link']!=''){
                $xtpl->assign('link', $value['link']);
                $xtpl->assign('target', 'target="_blank" ');
            }else if($value['link']==''){
                $xtpl->assign('target', '');
                $xtpl->assign('link', '#');
            }
            
            $xtpl->assign('img', base_url().$value['img']);    
            $xtpl->parse('main.partner');    
        }
        
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}


