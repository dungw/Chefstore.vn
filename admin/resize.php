<?php

/**
 * @author duchanh
 * @copyright 2012
 */ 
 

include_once("../config.php");
include_once(INC_PATH."classes/CFile.class.php");
include_once(INC_PATH."classes/Imagethumb.class.php");
include_once(INC_PATH."classes/cropImages.class.php");

/* Note: This thumbnail creation script requires the GD PHP Extension.  
	If GD is not installed correctly PHP does not render this page correctly
	and SWFUpload will get "stuck" never calling uploadSuccess or uploadError
 */

// Get the session Id passed from SWFUpload. We have to do this to work-around the Flash Player Cookie Bug
if (isset($_POST["PHPSESSID"])) {
	session_id($_POST["PHPSESSID"]);
}



$base = new Base();
$base->table = 'tbl_product_images';
$arrImage = $base->get('*','AND status = 1');

foreach($arrImage as $key=>$value){
        
        $img = '..'.$value['images'];
        
        $thumb50 = getSmallImages($img,'thumb50');        
        $imageThumb = new Imagethumb($img,true);
        $imageThumb->getThumb($thumb50,80,80);
        
        $thumb300 = getSmallImages($img,'thumb300');
        $imageThumb = new Imagethumb($img,true);
        $imageThumb->getThumb($thumb300,400,400);
        
        $thumb = getSmallImages($img,'thumb');
        $imageThumb = new Imagethumb($img,true);
        $imageThumb->getThumb($thumb,300,300);
}
    
    
    
?>