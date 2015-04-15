<?php

/**
 * @author duchanh
 * @copyright 2012
 */ 
 
class miniProductImages extends Base{
    var $pk = 'id';
    var $pk_auto = true;//Primary key auto increment
    var $fields = array('product_id','images','ordering','default','status'); //fields in table (excluding Primary Key)	
    var $table = "tbl_product_images";    
    var $key_prefix = "miniProductImages_";//cache key prefix
    var $Cache = 'CacheProductImages';
    var $thumb_w = 200;
    var $thumb_h = 200;
    
    var $thumb50_w = 60;
    var $thumb50_h = 60;
    
    var $thumb300_w = 300;
    var $thumb300_h = 300;
    
    var $thumb_ratio = true;
        
    var $num_per_page = 30;
    
    
    /**
     * @Desc get product images
     * @param string $product_id: list product_id example "1,2,3,4";
     * @return array
     */
    function getProductImage($list_pid){
        if($list_pid != ""){
            $result = array();
            $arrayId = explode(',',$list_pid);            
            foreach($arrayId as $pid){
                $result[$pid] = array();
            }
                       
            $listProductImages = $this->get("*"," AND product_id IN ($list_pid) "," `default` DESC, ID DESC ");            
            if(count($listProductImages)>0){
                foreach($listProductImages as $key=>$value){    
                    $product_id = $value['product_id'];
                    array_push($result[$product_id],$listProductImages[$key]);
                }
            }
            return $result;
        }
        return NULL;
         
    }
    
    
    /**
     * @Desc get product images default
     * @param string $list_id: list product_id example "1,2,3,4";
     * @return array
     */
    function getProductImageDefault($list_id){
        $image = array();
        $result =  $this->get("product_id,images"," AND product_id IN ($list_id) "," ID ASC ");
        if(count($result)>0){
            foreach($result as $key=>$value){
                $image[$value['product_id']] = array('images'=>$value['images']);
            }
        }
        
        return $image;
    }
    
    
    /**
     * @Desc delete product that have product_id <= 0     
     * @return array
     */
    function deleteImageUndendity(){    
        global $oDb;
        $this->deleteProductImage(-1);
        //$sql = "DELETE FROM `$this->table` WHERE `product_id` <= 0 ";
        //$oDb->query($sql);     
    }
    
    
    
    /**
     * @Desc set product images that have product_id = -1;
     * @param int $pid: product id 
     * @return array
     */
    function setProductId($pid){
        global $oDb;
        $sql = "UPDATE `$this->table` SET `product_id` = $pid WHERE `product_id` = -1 ";
        $oDb->query($sql);
    }
    
    
    
    /**
     * @Desc set product images that have product_id = -1;
     * @param int $pid: product id 
     * @return array
     */
    function deleteProductImage($pid){
        $list_image = $this->get(" id "," AND `product_id` = $pid ");
        if(is_array($list_image) && count($list_image)>0){
            foreach($list_image as $key=>$value){
                $this->deleteImage($value['id']);
            }
        }
        
        
    }
    
    
    
    /**
     * @Desc delete product images
     * @param int $id: id
     * @return boolean
     */
    function deleteImage($id){
        $this->read($id);
        $thumb_path = '..'.$this->thumb_path;            
        if(file_exists($thumb_path)){
            @unlink($thumb_path);
        }
        
        $thumb50_path = '..'.$this->thumb50_path;            
        if(file_exists($thumb50_path)){
            @unlink($thumb50_path);
        }
        
        $thumb300_path = '..'.$this->thumb300_path;            
        if(file_exists($thumb300_path)){
            @unlink($thumb300_path);
        }
        
        $images_path = '..'.$this->images_path;
        if(file_exists($images_path)){
            @unlink($images_path);
        }            
        return $this->remove($id);
    }
    
        
}