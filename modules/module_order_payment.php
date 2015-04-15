<?php

/**
 * @author duchanh
 * @copyright 2012
 * @desc module list html of introduction
 */
 
class module_order_payment extends Module{
    
    function module_order_payment(){
        $this->file = 'order_payment.html';
        parent::module();
    }
    
    function draw(){
        global $skin,$title, $keywords, $description, $pathway, $_SESSION;
        $xtpl = new XTemplate($this->tpl);
        
        $skin_path  = base_url().'skin/'.$skin.'/';
        $xtpl->assign('link_home', base_url());    
        $xtpl->assign('skin_path', $skin_path); 
        
        
        $xtpl->assign('link_guide', createLink('news_detail',array('id'=>13,'title'=>'huong dan mua hang')));
        $xtpl->assign('link_payment_type', createLink('news_detail',array('id'=>14,'title'=>'huong dan mua hang')));
        
        
        $return_page = createLink('order_sucess');
        
        $miniProduct = new miniProduct();
        $cart = $miniProduct->getProductCartInfo();
        $total_cart_price = $cart['total_cart_price'];
        $list_name = '';
        $num = 0;        
        $ss_cart =  $_SESSION['cart'];
                
        foreach($cart as $key=>$value){
            $tpm_num = $ss_cart[$value['id']];
            $num += $tpm_num;
            if($key==count($cart)) break;
            $list_name .= $value['name'].',';
        }
        
        $list_name = trim($list_name,',');
        
        $link_nl  = 'https://www.nganluong.vn/button_payment.php?receiver=hanhcoltech@gmail.com&product_name='.$list_name.'&price='.$total_cart_price.'&return_url='.base_url().'&cancel_url='.$return_page;
        $xtpl->assign('link_nl', $link_nl); 
        $link_bk  = 'https://www.baokim.vn/payment/customize_payment/product?business=hanhcoltech@gmail.com&product_name='.$list_name.'&product_price='.$total_cart_price.'&product_quantity='.$num.'&total_amount='.$total_cart_price.'&product_description=Mua sản phẩm tại website '.base_url();
        $xtpl->assign('link_bk', $link_bk);
        
        $xtpl->assign('hotline', getConfig('hotline'));        
        $xtpl->assign('order_id', $_SESSION['order']);
                
        $miniBank = new miniBank();
        $bank = $miniBank->getBank('AND status = 1','name','ASC',1);
        
        
        foreach($bank as $key=>$value){
            $xtpl->assign('id', $value['id']);
            $xtpl->assign('name', $value['name']);
            $xtpl->assign('chutk', 'Chủ TK: '.$value['chutk']);
            $xtpl->assign('stk', 'Số TK: '.$value['stk']);
            $xtpl->assign('img', base_url().$value['img']);
            $xtpl->parse('main.bank');
        }
        
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
                'name'  => 'Phương thức thanh toán'
                )
        );
        
        
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}
