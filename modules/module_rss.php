<?php

/**
 * @author duchanh
 * @copyright 2012
 */

class module_rss extends Module{
    
    function module_rss(){
        //$this->file = 'rss.html';
        parent::module();
    }
    
    
    function draw(){
        include(INC_PATH."classes/SimpleXMLExtended.class.php");        
        header('Content-Type: application/xml; charset=utf-8');
     
        $miniProduct = new miniProduct();
        $miniProduct->num_per_page = 50;
        
       
        $xmlstr = "<rss version='2.0'></rss>";
        $rss 	= new SimpleXMLExtended($xmlstr);
        $rss->addChild("channel");
        $rss->addChild('title','RSS - vattunhanh.com');
        $rss->addChild('description','website vattunhanh.com');
        $rss->addChild('link',base_url());
        $rss->addChild('copyright','nguyenduchanh.com');
        $rss->addChild('generator',curPageURL());
        $rss->addChild('pubDate',date('D, d M Y H:i:s',time()).' GMT');
        $rss->addChild('lastBuildDate',date('D, d M Y H:i:s',time()).' GMT');
                    
        
        $listProduct = $miniProduct->getProduct(' AND status = 1 ','ordering',' DESC ',1);
        //var_dump($listProduct);
        if(count($listProduct)>0){        
            foreach($listProduct as $key=>$value){
                $item = $rss->addChild('item');
                $item_title = $item->addChild('title');
                $item_title->addCData($value['name']);
                
                $link = createLink('product_detail',array('id'=>$value['id'],'name'=>$value['name']));
                $img = '';
                if($value['thumb']){
                    $img = '<a href="'.$link.'"><img alt="'.$value['name'].'" src="'.base_url().$value['thumb'].'" /></a>';    
                }                
                $item_desc = $item->addChild('description');
                $item_desc->addCData($img.$value['description']);
                
                $item->addChild('link',$link);
                $item->addChild('pubDate',date('D, d M Y H:i:s',time()).' GMT');            
            }
        }
        
        $txt = $rss->asXML();
        
        echo $txt;
                
    }
}

