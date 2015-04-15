<?php

/**
 * @author duchanh
 * @copyright 2012
 */ 

class miniNews extends Base{
    var $pk = 'id';
	var $pk_auto = true;//Primary key auto increment
	var $fields = array('cat_id','title','brief','content','author','date','date_edit','img','hits','home','status','ordering','meta_keyword','meta_description','type'); //fields in table (excluding Primary Key)	
	var $table = "tbl_news";
    var $key_prefix = "miniNews_";//cache key prefix
    var $Cache = 'CacheNews';
    var $num_per_page = 20;
    
    var $resize_width = 200;
    var $resize_height = 200;
    
    
    
    /**
     * @Desc function get news
     * @param int $cat_id: category id
     * @param int $status: status
     * @param int $start: start of record
     * @param int $num: number want to get     
     * @return array
     */
    function getNewsByCat($cat_id,$status = false,$start = false, $num = false){
        $con = " AND cat_id = $cat_id ";    
        if($status){
            $con .= " AND status = $status ";
        }    
        if($start>=0 && $num>0){
            $result = $this->get("*",$con," ordering DESC ",$start,$num);    
        }else{
            $result = $this->get("*",$con," ordering DESC ");
        }        
        
        if($result){
            return $result;
        }else{
            return NULL;
        }
    }

    
    
    
    /**
     * @Desc function get news
     * @param string $con: condition
     * @param string $sort: field want to sort
     * @param string $order: ASC or DESC 
     * @param int $page: number of page
     * @return array
     */
    function getNews($con = "", $sort = false, $order = false, $page = 1){
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
    
    
    
    /**
     * @Desc function get news by tags
     * @param string $tags: tags
     * @param string $sort: field want to sort
     * @param string $order: ASC or DESC 
     * @param int $page: number of page
     * @return array
     */
    function getNewsByTag($tags,$sort = false, $order = false, $page = 1){
        $miniTags = new miniTags();
        $allTags = $miniTags->getTags($tags,1);
        if(count($allTags)>0){
            $list_item = '';
            foreach($allTags as $key=>$value){
                $list_item .= $value['item_id'].',';
            }
            $list_item = trim($list_item,',');
            $con = "AND id IN (".$list_item.")";            
            return $this->getNews($con,$sort = false, $order = false, $page = 1);
        }
        
        return null;
        
    }
 
    
    
    /**
     * @Desc update hit news
     * @param int $id: id of news
     * @return boolean
     */
    function hits($id){
        global $oDb;
        $sql = " UPDATE `$this->table` SET `hits` = `hits` + 1 WHERE `$this->table`.`id` = $id LIMIT 1 ";
        $oDb->query($sql);
        return true;
    }
    
    
    
    /**
     * @Desc get other news
     * @param int $cat_id: category id
     * @param int $cur_id: curent id
     * @param int $number: number want to get     
     * @return array
     */
    function getOtherNews($cat_id, $cur_id, $number = 5){
        $miniCategory = new miniCategory();
        $allNewsCategory = $miniCategory->getCatByType(1);
        $list_id = $miniCategory->getListSubCategory($allNewsCategory,$cat_id);
        $con = " AND cat_id IN ($list_id) AND id != $cur_id";
        return $this->get('*',$con,'ordering DESC',0,$number);        
        
    }
    
    
    
    /**
     * @Desc get news comment
     * @param string $list_id: list id
     * @return array
     */
    function getNewsComment($list_id){
        $con = " AND id IN ($list_id) ";
        return $this->get('id, title ', $con);
    }
    
    
}