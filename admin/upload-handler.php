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

ini_set("html_errors", "0");

// Check the upload
if (!isset($_FILES["userfile"]) || !is_uploaded_file($_FILES["userfile"]["tmp_name"]) || $_FILES["userfile"]["error"] != 0) {
	echo "ERROR:invalid upload";
	exit(0);
}

// Get the image and create a thumbnail
$img = imagecreatefromjpeg($_FILES["userfile"]["tmp_name"]);
if (!$img) {
	echo "ERROR:could not create image handle ". $_FILES["userfile"]["tmp_name"];
	exit(0);
}



// config dir upload by HanhND
$cur_folder = date('Y').'/'.date('m').'/'.date('d').'/';
$type  = CInput::get('type','txt','');
$dir =  "../uploads/".$type."/".$cur_folder;

// create folder
if(!is_dir($dir)){
    mkdir($dir,0775,true);
}

if($_FILES['userfile']['name']!= 'none' && $_FILES['userfile']['name'] != '') {		
    $image_image  	= @ereg_replace("[^a-zA-Z0-9_.]", "n",$_FILES['userfile']['name']);
    $file_name  =  CFile::uploadFile($_FILES['userfile']['tmp_name'],$image_image,$dir) ;   	    
	$img		=  $dir.$file_name;
	if( $img == 'none' ) $img = "";
    
    if($type=='product'){
        global $_SESSION;
        $arrProductImage = isset($_SESSION['pimages'])?$_SESSION['pimages']:NULL;
        
        // thumb 50
        $thumb50_dir = $dir.'thumb50/';
        if(!is_dir($thumb50_dir)){
            mkdir($thumb50_dir,0775,true);
        }
        $thumb50      =  $thumb50_dir.$file_name;
        $imageThumb = new Imagethumb($img,true);
        $imageThumb->getThumb($thumb50,50,50);
        
        
        // thumb 300
        $thumb300_dir = $dir.'thumb300/';
        if(!is_dir($thumb300_dir)){
            mkdir($thumb300_dir,0775,true);
        }
        $thumb300      =  $thumb300_dir.$file_name;
        $imageThumb = new Imagethumb($img,true);
        $imageThumb->getThumb($thumb300,300,300);
        
        
        // thumb
        $thumb_dir = $dir.'thumb/';
        if(!is_dir($thumb_dir)){
            mkdir($thumb_dir,0775,true);
        }        
        $thumb      =  $thumb_dir.$file_name;
        $imageThumb = new Imagethumb($img,true);
        $imageThumb->getThumb($thumb,200,200);
        
        
        $arrProductImage[] = trim($img,'.');
        $_SESSION['pimages'] = $arrProductImage;
        
        echo trim($thumb50,'.');
        exit;
    }
    
    
    		
}else{
	$img	= "";
    $thumb  = "";
}

echo trim($img,'.');



    
    
    
?>