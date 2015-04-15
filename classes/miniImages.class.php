<?php

/**
 * @author duchanh
 * @copyright 2012
 */ 
 
class miniImages extends Base{
    var $pk = 'id';
	var $pk_auto = true;//Primary key auto increment
	var $fields = array("cat_id","name","thumb","img","desc","ordering","status"); //fields in table (excluding Primary Key)	
	var $table = "tbl_images";
    var $key_prefix = "miniImages_";//cache key prefix
    var $Cache = 'CacheImages';    
    var $info = false;
    
    var $resize_width  = 400;
    var $resize_height = 400; 
    
    var $num_per_page = 20;
    
    
    function getImages($con = "", $sort = false, $order = false, $page = 1){
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