<?php

/**
 * @author duchanh
 * @copyright 2012
 * @desc module list html of introduction
 */
 
class module_check_order extends Module{
    
    function module_check_order(){
        $this->file = 'check_order.html';
        parent::module();
    }
    
    function draw(){
        global $skin,$title, $keywords, $description, $pathway;
        $xtpl = new XTemplate($this->tpl);
        
        
        $sdt = CInput::get('phone','txt','');
        $miniOrder = new miniOrder();        
        if($sdt){
            $arrProduct = array();
            $list_order = $miniOrder->getOrderByPhone($sdt);
            if(count($list_order) >0 ){
                $order_info = json_decode($list_order['list_product'],true);
                $miniProduct = new miniProduct();
                $order_info = $miniProduct->getProductCartInfo($order_info);
                $i = 1;
                foreach($order_info as $key=>$value){
                     if($list_order['status']==0){
                        $status = 'Đang xử lý';
                     }else if($list_order['status']==1){
                        $status = 'Đang chuyển';
                     }else{
                        $status = 'Hoàn thành';
                     }
                     
                     if($i==count($order_info)) break;
                     $xtpl->assign('stt', $i);                     
                     $xtpl->assign('product_link',createLink('product_detail',array('id'=>$value['id'],'name'=>$value['name'])));
                     $xtpl->assign('thumb', base_url().$value['thumb']);
                     $xtpl->assign('product_name', $value['name']);
                     $xtpl->assign('product_price', formatPrice($value['price']));
                     $xtpl->assign('num', $value['number']);
                     $xtpl->assign('total_price', formatPrice($value['cart_price']));
                     $xtpl->assign('status', $status);
                     $i++;
                     $xtpl->parse('main.row');
                }
                $xtpl->assign('all_price', formatPrice($order_info['total_cart_price']));
            }else{
                $xtpl->assign('display', 'none');
                $xtpl->assign('error', 'error');            
                $xtpl->assign('warning', '<label class="error">Không có đơn hàng nào sử dụng số điện thoại như trên</label>');
            }
            
        }else if($sdt && $list_order==0){
            $xtpl->assign('display', 'none');
            $xtpl->assign('error', 'error');            
            $xtpl->assign('warning', '<label class="error">Không có đơn hàng nào sử dụng số điện thoại như trên</label>');
        }else{
            $xtpl->assign('display', 'none');
        }
        
        $hotline = getConfig('hotline');
        $hotline = explode('|',$hotline);
        $xtpl->assign('hotline1', trim($hotline[0]));
        
        
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        $xtpl->assign('link_check_order', createLink('check_order'));
        
        $title = $keywords = $description = 'Kiểm tra đơn hàng';
        
        $pathway = array(
            0=> array(
                'type'  => '',
                'link'  =>'javascript:void(0)',
                'name'  => 'Check Order Status'
                )
        );
        
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}
