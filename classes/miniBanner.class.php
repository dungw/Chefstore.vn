<?php

/**
 * @author duchanh
 * @copyright 2012
 */ 
 
class miniBanner extends Base{
    var $pk = 'id';
	var $pk_auto = true;//Primary key auto increment
	var $fields = array('cat_id','name','desc','link','img','position','ordering','begin_display','end_display','status'); //fields in table (excluding Primary Key)	
	var $table = "tbl_banner";
    var $key_prefix = "miniBanner_";//cache key prefix
    var $Cache = 'CacheBanner';
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
        global $allBanner;
        if($allBanner && count($allBanner)>0){
            return $allBanner;
        }
        
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
    function getBanner($con = "", $sort = false, $order = false, $page = 1){
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
    
    
    
    /**
     * @Desc function get banner by position
     * @param string $con: condition 
     * @param string $sort: sort 
     * @param string $order: 
     * @param int $page: page
     * @return array
     */
    function getBannerByPosition($pos, $cid = 0){
        $result = array();
        $allBanner = $this->getAll(false);
        foreach($allBanner as $key=>$value){
            if($value['position']==$pos && $value['status']==1){
                if($cid){
                    $miniCategory = new miniCategory();
                    $allCat = $miniCategory->getCatByType(2);
                    $list_sub = $miniCategory->getListSubCategory($allCat,$value['cat_id']);
                    $list_sub = trim($list_sub,',');
                    $list_sub = explode(',',$list_sub);
                    if(in_array($cid,$list_sub)){                        
                        array_push($result,$value);
                    }                    
                            
                }else{
                    array_push($result,$value);
                }
                
            } 
        }        
        return $result;
    }
    
    
}