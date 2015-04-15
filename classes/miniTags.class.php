<?php

/**
 * 
 * @author duchanh
 * @copyright 2012
 */ 
 
class miniTags extends Base{
    var $pk = 'id';
	var $pk_auto = true;//Primary key auto increment
	var $fields = array('item_id','tags','type'); //fields in table (excluding Primary Key)	
	var $table = "tbl_tags";
    var $key_prefix = "miniTags_";//cache key prefix
    var $Cache = 'CacheTags';
    var $num_per_page = 20;
    
    
    
    
    /**
     * @Desc get tags 
     * @param string $tags: tags
     * @param int $type: type of tag 1: news, 2: product, 3: images     
     * @return array
     */
    function getTags($tags, $type){
        $con = " AND `tags` = \"$tags\" AND `type` = $type ";        
        return $this->get('item_id',$con);
    }
    
    
    
    /**
     * @Desc get tags by id 
     * @param int $id_tags: id of tags     
     * @return array
     */
    function getTagsById($id_tags){
        $con = " AND `id` = $id_tags ";        
        return $this->get('item_id',$con);
    }
    
    
    /**
     * @Desc get tags by item id 
     * @param int $id_tags: id of tags  
     * @param int $type: type of tag 1: news, 2: product, 3: images       
     * @return array
     */
    function getTagsByItemId($item_id, $type){
        $con = " AND `item_id` = $item_id AND `type` = $type ";
        return $this->get('tags',$con);
    }
    
    
    
    /**
     * @Desc get tags by item id 
     * @param string $tags: tags
     * @param int $item_id: item id
     * @param int $type: type of tag 1: news, 2: product, 3: images       
     * @return array
     */
    function insertTags($tags,$item_id, $type){
        $con = " AND `tags` = \"$tags\"  AND `item_id` = $item_id AND `type` = $type ";
        $number = $this->count($con);
        if($number>0){
            return 1; 
        }
        
        $this->tags     = $tags;
        $this->item_id  = $item_id;
        $this->type     = $type;
        $id = $this->insert();
        return $id;        
    }
    
    
    
    /**
     * @Desc get tags by item id 
     * @param int $item_id: item id     
     * @param int $type: type of tag 1: news, 2: product, 3: images       
     * @return array
     */
    function deleteTags($item_id,$type){
        global $oDb;
        $sql = "DELETE FROM $this->table WHERE item_id = $item_id AND type = $type ";
        $oDb->query($sql);
        return 1;
        
    }
    
}