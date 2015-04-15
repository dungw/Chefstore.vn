<?php

/**
 * @author duchanh
 * @copyright 2012
 */
 
 
class miniProduct extends Base{
    var $pk = 'id';
    var $pk_auto = true;//Primary key auto increment
    var $fields = array('cat_id','name','code','price','price_promotion','price_type','vat','delivery_time','img','description','specifications','ordering','date','home','hits','in_stock','other_info','new','discount','saleoff','best_seller','status','meta_title','meta_keyword','meta_description'); //fields in table (excluding Primary Key)	
    var $table = "tbl_product";    
    var $key_prefix = "miniProduct_";//cache key prefix
    var $Cache = 'CacheProduct';

    var $num_per_page = 15;
    
    /**
     * @Desc get product 
     * @param string $con: condition
     * @param string $sort: field wanna sort
     * @param string $order: DESC or ASC
     * @param int $page: 
     * @return array
     */
    function getProduct($con = "", $sort = false, $order = false, $page = 1){
        if($page < 1){
            $page = 1;
        }
        $start = ($page-1)*($this->num_per_page);        
        $result = false;
        if($sort && $order){
            $result =  $this->get("*",$con,"$sort $order, img DESC",$start,$this->num_per_page);
        }else{
            $result = $this->get("*",$con," img DESC ",$start,$this->num_per_page);
        }
        
        $list_id = '';
        if(count($result)>0){            
            foreach($result as $key=>$value){
                $list_id .= $value['id'].',';
            }
            $list_id = trim($list_id,',');
        }
        
        if($list_id){
            $miniProdutImages = new miniProductImages();
            $list_image = $miniProdutImages->getProductImageDefault($list_id);  
			
            foreach($result as &$value){
                if(isset($list_image[$value['id']])){
                    $value['thumb'] = getSmallImages($list_image[$value['id']]['images'],'thumb');
                    $value['images'] = $list_image[$value['id']]['images'];
                    $value['thumb50'] = getSmallImages($list_image[$value['id']]['images'],'thumb50');
                    $value['thumb300'] = getSmallImages($list_image[$value['id']]['images'],'thumb300');    
                }else{
                    $value['thumb'] = null;
                    $value['images'] = null;
                    $value['thumb50'] = null;
                    $value['thumb300'] = null;
                }
                
            }            
        }
        
        return $result; 
    }
    
    
    
    /**
     * @Desc get product comment
     * @param string $list_id: list id
     * @return array
     */
    function getProductComment($list_id){
        $con = " AND id IN ($list_id) ";
        return $this->get('id, name ', $con);
    }
    
    
    /**
     * @Desc add product to cart 
     * @param int $pid: product id      
     * @return array
     */
    function addProductToCart($pid){
        global $_SESSION;
        $cart = isset($_SESSION['cart'])?$_SESSION['cart']:null;        
        $tmp = null;
        if(count($cart)>0 && isset($cart[$pid])){
            foreach($cart as $id=>$num){
                if($id==$pid){                    
                    $tmp[$id] = $num+1;                    
                }else{
                    $tmp[$pid] = $num;
                }
            }
            $_SESSION['cart'] = $tmp;
            return $tmp;
        }else{
            $cart[$pid] = 1;
            $_SESSION['cart'] = $cart;
            return $cart;
        }
    }
 
    
    /**
     * @Desc get cart info           
     * @return array
     */
    function getProductCartInfo($cart_info = false){
        global $_SESSION;
        $cart = isset($_SESSION['cart'])?$_SESSION['cart']:null;
        if($cart_info){
            $cart = $cart_info;
        }
        $list_id = '';
        $product_cart = null;
        if(isset($cart) && count($cart)>0){
            foreach($cart as $id=>$num){
                $list_id .= $id.',';
            }
            $list_id = trim($list_id,',');
            
            $con = " AND id IN ($list_id) ";
            $product_cart = $this->getProduct($con," name "," DESC " );
            $total_cart_price = 0;
            foreach($product_cart as $key=>&$value){
                $value['number'] = $cart[$value['id']];
                $value['cart_price'] = $cart[$value['id']]*$value['price'];
                $total_cart_price += $value['cart_price'];
            }
            $product_cart['total_cart_price'] =  $total_cart_price;
        }
        
        return $product_cart;
    }
    
    
    /**
     * @Desc update hit product
     * @param int $id: id of news
     * @return boolean
     */
    function hits($id){
        global $oDb;
        $sql = " UPDATE `$this->table` SET `hits` = `hits` + 1 WHERE `$this->table`.`id` = $id LIMIT 1 ";
        $oDb->query($sql);
        return true;
    }
    
    
    
    function sendMailCart($to, $buyer_info, $code = '2011'){
        $xtpl = new XTemplate('html_sendmail_cart.html');
        
        $xtpl->assign('fullname', $buyer_info['fullname']);
        $xtpl->assign('company', $buyer_info['company']);
        $xtpl->assign('email', $buyer_info['email']);
        $xtpl->assign('phone', $buyer_info['phone']);
        $xtpl->assign('date_create', date('d/m/Y',time()));
        $xtpl->assign('code', $code);
        
        $pcart = $this->getProductCartInfo();
        if(count($pcart)>0){
            foreach($pcart as $key=>$value){
                $link_product = createLink('product_detail',array('id'=>$value['id'],'name'=>$value['name']));
                $xtpl->assign('link_product',$link_product);
                $xtpl->assign('name_product',$value['name']);
                $xtpl->assign('number',$value['number']);
                $xtpl->assign('price',$value['cart_price']);                
                $xtpl->parse('main.row');            
            }
        }
        
        $xtpl->assign('total_price',$pcart['total_cart_price']);
        $xtpl->assign('vanchuyen','Miễn phí nội thành');
        $xtpl->assign('final_price',$pcart['total_cart_price']);
        $xtpl->assign('website',$_SERVER['SERVER_NAME']);
        $xtpl->assign('link_website',$_SERVER['SERVER_NAME']);
        
        $xtpl->parse('main');        
        $content =  $xtpl->out('main');
        
        $from_email = trim(str_replace('www','',$_SERVER['SERVER_NAME']),'.');        
        $from['email']  =   'admin@'.$from_email;
        $from['name']   =   'Admin';        
        $subject = "Đơn hàng tại ".$_SERVER['SERVER_NAME'];
        
        sendMail($from,$to,false, $subject, $content);
    }
    
    
    
    
    function searchAutoComplete($q,$limit){
        $con = " AND LIKE '%".$q."% ";
        
        $result =  $this->get("id,name",$con,"$sort $order",0,$limit);
        
        $list_id = '';
        if(count($result)>0){            
            foreach($result as $key=>$value){
                $list_id .= $value['id'].',';
            }
            $list_id = trim($list_id,',');
        }
        
        if($list_id){
            $miniProdutImages = new miniProductImages();
            $list_image = $miniProdutImages->getProductImageDefault($list_id);
            foreach($result as &$value){
                $value['thumb'] = $list_image[$value['id']]['thumb'];
                $value['images'] = $list_image[$value['id']]['images'];
            }            
        }
        
        return $result; 
    }
    
    
    function countProduct(){
        global $oDb;
        $arr = array();
        $sql = "SELECT  cat_id,  count(*) as tt FROM `$this->table` GROUP BY cat_id ";
        $rc = $oDb->query($sql);
        $result = $oDb->fetchAll($rc);
        foreach($result as $key=>$value){
            $arr[$value['cat_id']] = $value['tt'];
        }
        return $arr;
        
    }
    
   
    
    function getFilterPrice($arr){
        // nho hon 1 tr
        $arr1 = array(
            0   => array('value'=>'0-500','text'=>'0 tới 500 ngàn'),
            1   => array('value'=>'500-1000','text'=>'500 ngàn tới 1 triệu'),
        ); 
        
        // nho hon 2tr
        $arr2 = array(
            0   => array('value'=>'0-500','text'=>'0 tới 500 ngàn'),
            1   => array('value'=>'500-1000','text'=>'500 ngàn tới 1 triệu'),
            2   => array('value'=>'1000-1500','text'=>'1 triệu tới 1.5 triệu'),
            3   => array('value'=>'1500-2000','text'=>'1 triệu rưỡi tới 2 triệu')
        );
        
        // nho hon 5tr
        $arr3 = array(
            0   => array('value'=>'0-500','text'=>'0 tới 500 ngàn'),
            1   => array('value'=>'1000-2000','text'=>'1 triệu tới 2 triệu'),
            2   => array('value'=>'2000-3000','text'=>'2 triệu tới 3 triệu'),
            3   => array('value'=>'3000-5000','text'=>'3 triệu tới 5 triệu'),
        );
        
        if($arr['max']<1000000){
            return $arr1;
        } 
        
        if($arr['max']<2000000){
            return $arr2;
        }
        
        if($arr['max']<5000000){
            return $arr3;
        }
    }
        
}
