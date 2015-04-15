<?php

/**
 * @author duchanh
 * @copyright 2012
 */ 
 
class miniOrder extends Base{
    var $pk = 'id';
	var $pk_auto = true;//Primary key auto increment
	var $fields = array("billing","payment_type","fullname","company","tax_code","address","phone","mobile","email","notes","list_product","status","date"); //fields in table (excluding Primary Key)	
	var $table = "tbl_order";
    var $key_prefix = "miniOrder_";//cache key prefix
    var $Cache = 'CacheOrder';    
    var $info = false;
    
    var $num_per_page = 20;
    
    
    
    function getOrderByPhone($phone){
        $con = " AND `phone` LIKE '%$phone%' OR `mobile` LIKE '%$phone%' ORDER BY id DESC LIMIT 0,1 ";
        $result =   $this->get('id, list_product, status ',$con); 
        if(count($result)>0){
            return $result[0];
        }
        return null; 
    }
    
    
     function getOrder($con = "", $sort = false, $order = false, $page = 1){
        if($page < 1){
            $page = 1;
        }
        $start = ($page-1)*($this->num_per_page);        
        
        if($sort && $order){
            return $this->get("*",$con,"$sort $order",$start,$this->num_per_page);
        }else{
            return $this->get("*",$con," id DESC ",$start,$this->num_per_page);
        }           
        return false; 
    }
  
   
}