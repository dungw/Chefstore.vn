<?php

/**
 * @author duchanh
 * @copyright 2012
 */ 
 
class miniComment extends Base{
    var $pk = 'id';
	var $pk_auto = true;//Primary key auto increment
	var $fields = array("item_id","type","user_id","username","user_ip","title","content","date","status"); //fields in table (excluding Primary Key)	
	var $table = "tbl_comment";
    var $key_prefix = "miniComment_";//cache key prefix
    var $Cache = 'CacheComment';
    
    var $num_perpage = 20;
    
    
    /**
     * @Desc get comment 
     * @param int $item_id: item id
     * @param int $type: type of comment, 1: news, 2: product
     * @param string $sort: f
     * @return array
     */
    function getComment($item_id, $type, $sort = "date", $order = "ASC", $page = 1){        
        if($page < 1){
            $page = 1;
        }        
        $con = " AND status = 1 AND `item_id` = $item_id AND `type` = $type ";        
        $start = ($page-1)*($this->num_perpage);                
        return $this->get("*",$con,"$sort $order",$start,$this->num_perpage);         
         
    }
    
    
    /**
     * @Desc get list comment 
     * @param int $item_id: item id
     * @param int $type: type of comment, 1: news, 2: product
     * @param string $sort: f
     * @return array
     */
    function getListComment($con, $sort = 'id', $order = ' DESC ', $page = 1){
        $start = ($page-1)*$this->num_perpage;        
        return $this->get('*',$con," $sort $order ",$start,$this->num_perpage);
    }
    
    
    
    /**
     * @Desc delete comment 
     * @param string $list_item_id: list of item id example: 33,3,4,2 
     * @return boolean
     */
    function deleteComment($list_item_id, $type){
        global $oDb;
        $sql = " DELETE FROM `$this->table` WHERE `item_id` IN ($list_item_id) AND `type` = $type ";
        return $oDb->query($sql);
        
    }
    
    
}