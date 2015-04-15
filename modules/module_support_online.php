<?php

/**
 * @author duchanh
 * @copyright 2012
 */


class module_support_online extends Module{
    
    function module_support_online(){
        $this->file = 'support_online.html';
        parent::module();
    }
    
    function draw(){
        global $skin;
        $xtpl = new XTemplate($this->tpl);
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
     
        // link
        $xtpl->assign('link_1', createLink('news_detail',array('id'=>12,'title'=>'Trung tâm dịch vụ khách hàng')));
        $xtpl->assign('link_2', createLink('news_detail',array('id'=>13,'title'=>'Hướng dẫn mua hàng')));
        $xtpl->assign('link_3', createLink('news_detail',array('id'=>14,'title'=>'Hình thức thanh toán')));
        $xtpl->assign('link_4', createLink('news_detail',array('id'=>15,'title'=>'Vận chuyển hàng hoá')));
        $xtpl->assign('link_5', createLink('news_detail',array('id'=>16,'title'=>'Câu hỏi thường gặp')));
        
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}


