<?php

/**
 * @author duchanh
 * @copyright 2012
 * @desc module list html of introduction
 */



class module_order_sucess extends Module{
    
    function module_order_sucess(){
        $this->file = 'order_sucess.html';
        parent::module();
    }
    
    
    function draw(){
        global $skin, $title, $keywords, $description, $pathway;        
        $xtpl = new XTemplate($this->tpl);
                
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        $xtpl->assign('link_check_order', createLink('check_order'));
        
        $title = $keywords = $description = "Giỏ hàng của bạn";
        
        $pathway = array(
            0=> array(
                'type'  => 'link',
                'link'  => createLink('cart'),
                'name'  => "Giỏ hàng"
                ),
            1=> array(
                'type'  => 'link',
                'link'  => createLink('order'),
                'name'  => "Đặt mua hàng"
                ),
            2=> array(
                'type'  => '',
                'link'  => '',
                'name'  => "Xác nhận đơn hàng"
                )
        );
        
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}

