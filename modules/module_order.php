<?php

/**
 * @author duchanh
 * @copyright 2012
 * @desc module list html of introduction
 */
 
class module_order extends Module{
    
    function module_order(){
        $this->file = 'order.html';
        parent::module();
    }
    
    function draw(){
        global $skin,$title, $keywords, $description, $pathway;
        $xtpl = new XTemplate($this->tpl);
        
        $skin_path  = base_url().'skin/'.$skin.'/';
        $xtpl->assign('link_home', base_url());    
        $xtpl->assign('skin_path', $skin_path); 
        
        
        $xtpl->assign('link_guide', createLink('news_detail',array('id'=>13,'title'=>'huong dan mua hang')));
        $xtpl->assign('link_payment_type', createLink('news_detail',array('id'=>14,'title'=>'huong dan mua hang')));
        
        
        $miniProduct = new miniProduct();
        $cart = $miniProduct->getProductCartInfo();
        $total_cart_price = $cart['total_cart_price']; 
        $list_name = '';
        $cur_page = curPageURL();
        foreach($cart as $key=>$value){
            if($key==count($cart)-1) break;
            $list_name .= $value['name'].', ';
        }
        $list_name = trim(trim($list_name),',');
        
        
        
        $link_nl  = 'https://www.nganluong.vn/button_payment.php?receiver=namvt.iba@gmail.com&product_name='.$list_name.'&price='.$total_cart_price.'&return_url='.base_url().'&cancel_url='.$cur_page;
        $xtpl->assign('link_nl', $link_nl); 
        $link_bk  = 'https://www.baokim.vn/payment/customize_payment/product?business=namvt.iba@gmail.com&product_name='.$list_name.'&product_price='.$total_cart_price.'&product_quantity=1&total_amount='.$total_cart_price.'&product_description=Mua sản phẩm tại website '.base_url();
        $xtpl->assign('link_bk', $link_bk);
        
        $title = $keywords = $description = 'Giỏ hàng của bạn';
        
        $pathway = array(
            0=> array(
                'type'  => 'link',
                'link'  => createLink('cart'),
                'name'  => 'Giỏ hàng'
                ),
            1 => array(
                'type'  => '',
                'link'  =>'javascript:void(0)',
                'name'  => 'Đăt mua hàng'
                )
        );
        
        $hotline = getConfig('hotline');
        $hotline = explode('|',$hotline);
        $xtpl->assign('hotline1', trim($hotline[0]));
        
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}
