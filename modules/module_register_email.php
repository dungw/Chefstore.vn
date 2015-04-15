<?php

/**
 * @author duchanh
 * @copyright 2012
 */

class module_register_email extends Module{
    
    var $edit_html_skin  = true;
    
    function module_register_email(){
        $this->file = 'register_email.html';
        parent::module();
    }
    
    function draw(){
        global $skin, $title, $keywords, $description, $pathway;
        
        $xtpl = new XTemplate($this->tpl);
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
     
        $keywords = $description = $title = "Đăng ký nhận địa chỉ qua email";
        
        $pathway = array(
            0=> array(
                'type'  => '',
                'link'  =>'javascript:void(0)',
                'name'  => 'News Letter'
                )
        );
        
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}


