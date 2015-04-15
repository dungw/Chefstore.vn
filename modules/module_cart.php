<?php

/**
 * @author duchanh
 * @copyright 2012
 * @desc module list html of introduction
 */
 
class module_cart extends Module{
    
    function module_cart(){
        $this->file = 'cart.html';
        parent::module();
    }
    
    function draw(){
        global $skin, $title, $keywords, $description, $pathway, $arrPrice;
        $xtpl = new XTemplate($this->tpl);
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        
        $miniProduct = new miniProduct();
        $cart = $miniProduct->getProductCartInfo();
        if(count($cart)>1){
            $i = 1;
            foreach($cart as $key=>$value){
                if($i==count($cart)) break;
                $xtpl->assign('stt', $i);
                $xtpl->assign('id', $value['id']);
                
                $product_link = createLink('product_detail',array('id'=>$value['id'],'name'=>$value['name']));
                $xtpl->assign('product_link', $product_link);
                $xtpl->assign('product_name',$value['name']);
                $xtpl->assign('product_type',$arrPrice[$value['price_type']]);    
                
                $thumb = base_url().$value['thumb'];
                $xtpl->assign('product_thumb', $thumb);  
                $xtpl->assign('product_price', formatPrice($value['price']));  
                $xtpl->assign('product_num', $value['number']);
                $xtpl->assign('product_total_price', formatPrice($value['cart_price']));
                $i++;
                $xtpl->parse('main.cart');
            }
            
            $xtpl->assign('total_cart_price', formatPrice($cart['total_cart_price']));
        }else{
            $xtpl->assign('style', 'style="display: none;"');
            $html_none = '<h1 align="center">Hiện tại giỏ hàng của bạn không có sản phẩm nào</h1>
                    <p align="center">Bạn chọn mua hàng từ các danh mục trên hoặc quay lại <a href="'.base_url().'">trang chủ</a></p>';
            $xtpl->assign('html_none', $html_none);
        }
        
        
        $hotline = getConfig('hotline');
        $hotline = explode('|',$hotline);
        $xtpl->assign('hotline1', trim($hotline[0]));
        
        $pathway = array(
            0=> array(
                'type'  => '',
                'link'  =>'javascript:void(0)',
                'name'  => 'Giỏ hàng'
                )
        );
        
        $title = "Giỏ hàng của bạn";        
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}
