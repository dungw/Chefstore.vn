<?php

/**
 * @author duchanh
 * @copyright 2012
 */ 
 
class miniEmail extends Base{
    var $pk = 'id';
	var $pk_auto = true;//Primary key auto increment
	var $fields = array("name","email","date"); //fields in table (excluding Primary Key)	
	var $table = "tbl_email";
    var $key_prefix = "miniEmail_";//cache key prefix
    var $Cache = 'CacheEmail'; 
    
    var $num_per_page = 30;
    
    
    /**
     * @Desc get comment 
     * @param string $con: condition
     * @param string $sort: field want to sort
     * @param string $order: DESC or ASC
     * @return array
     */
    function getEmail($con = "", $sort = false, $order = false, $page = 1){
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