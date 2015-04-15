<?php

/**
 * @author duchanh
 * @copyright 2011
 */


class cropImage{
    var $imgSrc;
    var $myImage;
    var $cropHeight;
    var $cropWidth;
    var $x;
    var $y;
    var $thumb;
    var $cWidth;
    var $cHeight;
    var $type;
    var $desc;
    
    
    function __construct($image) {
        $this->imgSrc = $image;
        
        $imageInfo = getimagesize($this->imgSrc);
        $this->type = $imageInfo['mime'];
        
        //Your Image
        
        
        //getting the image dimensions
        list($width, $height) = getimagesize($this->imgSrc);
            
        if($width > $height){
            $biggestSide = $width; //find biggest length
            $cropPercent = $height/$width;
        }
        else{
            $biggestSide = $height;
            $cropPercent = $width/$height;
        }
        
        $this->cropWidth   = $biggestSide*$cropPercent; 
        $this->cropHeight  = $biggestSide*$cropPercent; 
                         
                         
        //getting the top left coordinate
        $this->x = ($width-$this->cropWidth)/2;
        $this->y = ($height-$this->cropHeight)/2;
      
    }
  
    
    
    function cropImages($desc,$cWidth, $cHeight) {
        $this->cWidth = $cWidth;
        $this->cHeight = $cHeight;
        $this->desc = $desc;
        
        switch($this->type) {
            case 'image/jpg':
            case 'image/jpeg':
            case 'image/pjpeg':
              $this->createJpeg();
            break;
            
            case 'image/png':
            case 'image/x-png':
              $this->createPng();
            break;
            
            case 'image/gif':
              $this->createGif();
            break;
            
            case 'image/bmp':
            case 'image/wbmp':
              $this->createBmp();
            break;
        }
        
    }
    
    
    function createJpeg()
    {
        $this->myImage = imagecreatefromjpeg($this->imgSrc) or die("Error: Cannot find image!");        
        $this->thumb = imagecreatetruecolor($this->cWidth, $this->cHeight);    
        imagecopyresampled($this->thumb, $this->myImage, 0, 0,$this->x, $this->y, $this->cWidth, $this->cHeight, $this->cropWidth, $this->cropHeight);
        imagejpeg($this->thumb,$this->desc);
    }

    function createPng()
    {
        $this->myImage = imagecreatefrompng($this->imgSrc) or die("Error: Cannot find image!");        
        $this->thumb = imagecreatetruecolor($this->cWidth, $this->cHeight);    
        imagecopyresampled($this->thumb, $this->myImage, 0, 0,$this->x, $this->y, $this->cWidth, $this->cHeight, $this->cropWidth, $this->cropHeight);
        imagepng($this->thumb,$this->desc);
    }

    function createGif()
    {
        $this->myImage = imagecreatefromgif($this->imgSrc) or die("Error: Cannot find image!");        
        $this->thumb = imagecreatetruecolor($this->cWidth, $this->cHeight);    
        imagecopyresampled($this->thumb, $this->myImage, 0, 0,$this->x, $this->y, $this->cWidth, $this->cHeight, $this->cropWidth, $this->cropHeight);
        imagegif($this->thumb,$this->desc);
    }

    function createBmp()
    {
        $this->myImage = imagecreatefromwbmp($this->imgSrc) or die("Error: Cannot find image!");        
        $this->thumb = imagecreatetruecolor($this->cWidth, $this->cHeight);    
        imagecopyresampled($this->thumb, $this->myImage, 0, 0,$this->x, $this->y, $this->cWidth, $this->cHeight, $this->cropWidth, $this->cropHeight);
        imagewbmp($this->thumb,$this->desc);
    }
    
    
    
    
         
}  

?>