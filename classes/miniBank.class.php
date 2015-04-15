<?php

/**
 * @author duchanh
 * @copyright 2012
 */ 
 
class miniBank extends Base{
    var $pk = 'id';
	var $pk_auto = true;//Primary key auto increment
	var $fields = array('name','img','stk','chinhanh','chutk','ordering','status'); //fields in table (excluding Primary Key)	
	var $table = "tbl_bank";
    var $key_prefix = "miniBank_";//cache key prefix
    var $Cache = 'CacheBank';
    var $num_per_page = 30;
  
    
    
    /**
     * @Desc function get banner 
     * @param $con: condition 
     * @param $sort: sort 
     * @param $order: 
     * @param $page:
     * @return array
     */    
    function getAll($con, $sort = false, $order = false){
        if($sort && $order){
            return $this->get("*",$con,"$sort $order");
        }else{
            return $this->get("*",$con," ordering DESC ");
        }           
        return false; 
    }
    
    
    
    /**
     * @Desc function get banner 
     * @param string $con: condition 
     * @param string $sort: sort 
     * @param string $order: 
     * @param int $page: page
     * @return array
     */
    function getBank($con = "", $sort = false, $order = false, $page = 1){
        if($page < 1){
            $page = 1;
        }
        $start = ($page-1)*($this->num_per_page);        
        
        if($sort && $order){
            return $this->get("*",$con,"$sort $order",$start,$this->num_per_page);
        }else{
            return $this->get("*",$con," ordering DESC ",$start,$this->num_per_page);
        }           
        return false; 
    }
    
    
  
    
}