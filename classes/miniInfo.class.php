<?php

/**
 * @author duchanh
 * @copyright 2012
 */ 
 
class miniInfo extends Base{
    var $pk = 'name';
	var $pk_auto = false;//Primary key auto increment
	var $fields = array("values"); //fields in table (excluding Primary Key)	
	var $table = "tbl_info";
    var $key_prefix = "miniInfo_";//cache key prefix
    var $Cache = 'CacheInfo';    
    var $info = false;
    
    
    
    /**
     * @Desc get all tbl_info     
     * @return array
     */
    function getAllInfo(){
        if($this->info){
            return $this->info;
        }else{
            $this->info = $this->get();
            return $this->info;
        }
    }
   
}