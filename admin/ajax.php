<?php

/**
 * @author duchanh
 * @copyright 2012
 */


include("config.php");
include('ext.function.php');

class ajax {    
    
    function ajax(){
        $cmd = CInput::get('cmd','txt','');
         switch($cmd){                    
            case "delete_product_images":                        
                $this->delete_product_images();          	                       
            break;
            
         }
    }
    
    function delete_product_images(){
        $id = CInput::get('id','int',0);
        deleteProductImages($id);
        echo 'ss';
        
    }
    
}

new ajax();