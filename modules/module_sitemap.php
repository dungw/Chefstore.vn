<?php

/**
 * @author duchanh
 * @copyright 2012
 */

include(INC_PATH."classes/SimpleXMLExtended.class.php");
class module_sitemap extends Module{
    
    function module_sitemap(){
        $this->file = 'sitemap.html';        
        parent::module();
    }
    
    function draw(){
        global $skin, $title, $keywords, $description, $pathway;        
        $xtpl = new XTemplate($this->tpl);
        
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        
        $miniCategory = new miniCategory();
        $allCat = $miniCategory->getCatByType(2);
        
        $miniProduct = new miniProduct();
        $arrNumberProduct  = $miniProduct->countProduct();
        
        $html = '';
        if(count($allCat)>0){
            $html = '<div class="row">';
            $i = 1;
            $class =  '';
            foreach($allCat as $key=>$value){
                if($value['parent_id']!=0) continue;
                if($i==1){
                    $class = 'first';
                }                
                if($i==5){
                    $class = 'last';
                }else{
                    $class = ''; 
                }
                
                $link = createLink('product',array('cid'=>$value['id'],'name'=>$value['name']));
                $html .= '<ul class="list-row '.$class.'">'; 
                $html .= '<li><h3><a href="'.$link.'">'.$value['name'].'</a></h3></li>';
                
                $subCat = $miniCategory->getSubCat($allCat,$value['id']);
                if(count($subCat)>0){
                    foreach($subCat as $key=>$value){
                        $number_product = isset($arrNumberProduct[$value['id']])? $arrNumberProduct[$value['id']] : 0;
                        $link_sub = createLink('product',array('cid'=>$value['id'],'name'=>$value['name']));
                        $html .= '<li><a href="'.$link_sub.'">'.$value['name'].'</a><em>('.$number_product.')</em></li>';
                    }
                }
                
                if($i%5==0){
                    $html .= '</div><div class="row">';
                }
                $html .= '</ul>';
                $i++;
                
            }
        }
        
        $sitemap = CInput::get('sitemap','int',0);
        $html_other = '';
        if($sitemap==0){
            
            $html_other .= '<hr><p>&nbsp;</p>';
            $html_other.= '<div class="row">';
                                      
            // huong dan
            $cid = 38;            
            $html_other.= '<ul class="list-row first">';
            $html_other .= '<li><h3>Hướng dẫn</h3></li>';      
            $miniNews = new miniNews();
            $miniNews->num_per_page = 10;
            $con = " AND status = 1 AND cat_id = $cid ";
            $arrNews = $miniNews->getNews($con,'ordering','desc',1);
            if(count($arrNews)>0){
                foreach($arrNews as $key=>$value){
                    $link = createLink('news_detail',array('id'=>$value['id'],'title'=>$value['title']));
                    $html_other .= '<li><a href="'.$link.'">'.$value['title'].'</a></li>';
                }
            }        
            $html_other .= '</ul>';
            
            
            // huong dan
            $cid = 44;            
            $html_other.= '<ul class="list-row first">';
            $html_other .= '<li><h3>Giới thiệu</h3></li>';      
            $miniNews = new miniNews();
            $miniNews->num_per_page = 10;
            $con = " AND status = 1 AND cat_id = $cid ";
            $arrNews = $miniNews->getNews($con,'ordering','desc',1);
            if(count($arrNews)>0){
                foreach($arrNews as $key=>$value){
                    $link = createLink('news_detail',array('id'=>$value['id'],'title'=>$value['title']));
                    $html_other .= '<li><a href="'.$link.'">'.$value['title'].'</a></li>';
                }
            }        
            $html_other .= '</ul>';
            
            
            // huong dan
            $cid = 43;            
            $html_other.= '<ul class="list-row first">';
            $html_other .= '<li><h3>Chính sách</h3></li>';      
            $miniNews = new miniNews();
            $miniNews->num_per_page = 10;
            $con = " AND status = 1 AND cat_id = $cid ";
            $arrNews = $miniNews->getNews($con,'ordering','desc',1);
            if(count($arrNews)>0){
                foreach($arrNews as $key=>$value){
                    $link = createLink('news_detail',array('id'=>$value['id'],'title'=>$value['title']));
                    $html_other .= '<li><a href="'.$link.'">'.$value['title'].'</a></li>';
                }
            }        
            $html_other .= '</ul>';
            
            $html_other .= '</div>';
                    
             
        }
        
        $xtpl->assign('html', $html);
        $xtpl->assign('other', $html_other);
        
        $title = 'Sitemap';
        $keywords = $description = 'Sitemap';
        
        $pathway = array(
            0=> array(
                'type'  => '',
                'link'  =>'javascript:void(0)',
                'name'  => 'Danh mục sản phẩm'
                )
        );
        
        $xtpl->parse('main');
        
        // create sitemap
        $this->createSiteMap('index');
        $this->createSiteMap('product');
        $this->createSiteMap('news');
        $this->createSiteMap('help');
        $this->createSiteMap('categories');
        
        return $xtpl->out('main');        
    }
    
    
    function createSiteMap($map){
        switch($map){                    
            case "index": 
                                     
                $html = '<?xml version="1.0" encoding="UTF-8"?>';
                $html = '<?xml-stylesheet type="text/xsl" href="'.base_url().'xml-sitemap.xsl"?>';
                $html .= '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
                
                
                $miniCategory = new miniCategory();
                $allCat = $miniCategory->getCatByType(1);
                
                $miniNews = new miniNews();
                $miniNews->num_per_page = 100;
                
                $con = ' AND status = 1';        
                if(1){
                    $list_subcat = $miniCategory->getListSubCategory($allCat,0);
                    $list_subcat = trim($list_subcat,',');
                    $con .= " AND cat_id IN ($list_subcat) ";            
                }
                $listNews = $miniNews->getNews($con,'ordering',' DESC ',1);
                if(count($listNews)>0){
                    foreach($listNews as $key=>$value){
                        if($key==0){
                            $type = "daily";
                            $priority = 1;
                        }else{
                            $type = "weekly";
                            $priority = 0.5;
                        }
                        $html .= '
                        <url>
                    		<loc>'.createLink('news_detail',array('id'=>$value['id'],'title'=>$value['title'])).'</loc>
                    		<lastmod>'.date('Y-m-d H:i:s+00:00',$value['date']).'</lastmod>
                    		<changefreq>'.$type.'</changefreq>
                    		<priority>'.$priority.'</priority>
                    	</url>';
                    }
                }        
                
                $html .= '</urlset>';
                
                $open1 = fopen('sitemap_index.xml', "w");
                fwrite($open1,$html);
                fclose($open1);          	                       
            break;
            
            case "product":                        
                $html = '<?xml version="1.0" encoding="UTF-8"?>';
                $html = '<?xml-stylesheet type="text/xsl" href="'.base_url().'xml-sitemap.xsl"?>';
                $html .= '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
                
                
                $miniCategory = new miniCategory();
                $allCat = $miniCategory->getCatByType(2);
                
                $miniProduct = new miniProduct();
                $miniProduct->num_per_page = 100;
                
                $con = ' AND status = 1';        
                if(1){
                    $list_subcat = $miniCategory->getListSubCategory($allCat,0);
                    $list_subcat = trim($list_subcat,',');
                    $con .= " AND cat_id IN ($list_subcat) ";            
                }
                $listProduct = $miniProduct->getProduct($con,'ordering',' DESC ',1);
                if(count($listProduct)>0){
                    foreach($listProduct as $key=>$value){
                        if($key==0){
                            $type = "daily";
                            $priority = 1;
                        }else{
                            $type = "weekly";
                            $priority = 0.5;
                        }
                        $html .= '
                        <url>
                    		<loc>'.createLink('product_detail',array('id'=>$value['id'],'name'=>$value['name'])).'</loc>
                    		<lastmod>'.date('Y-m-d H:i:s+00:00',$value['date']).'</lastmod>
                    		<changefreq>'.$type.'</changefreq>
                    		<priority>'.$priority.'</priority>
                    	</url>';
                    }
                }        
                
                $html .= '</urlset>';
                
                $open1 = fopen('sitemap_products.xml', "w");
                fwrite($open1,$html);
                fclose($open1);    	                       
            break;
            
            case "news":                        
                $html = '<?xml version="1.0" encoding="UTF-8"?>';
                $html = '<?xml-stylesheet type="text/xsl" href="'.base_url().'xml-sitemap.xsl"?>';
                $html .= '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
                
            
                $miniNews = new miniNews();
                $miniNews->num_per_page = 100;
                
                $con = ' AND status = 1 AND cat_id = 46 ';       
              
                $listNews = $miniNews->getNews($con,'ordering',' DESC ',1);
                if(count($listNews)>0){
                    foreach($listNews as $key=>$value){
                        if($key==0){
                            $type = "daily";
                            $priority = 1;
                        }else{
                            $type = "weekly";
                            $priority = 0.5;
                        }
                        $html .= '
                        <url>
                    		<loc>'.createLink('news_detail',array('id'=>$value['id'],'title'=>$value['title'])).'</loc>
                    		<lastmod>'.date('Y-m-d H:i:s+00:00',$value['date']).'</lastmod>
                    		<changefreq>'.$type.'</changefreq>
                    		<priority>'.$priority.'</priority>
                    	</url>';
                    }
                }        
                
                $html .= '</urlset>';
                
                $open1 = fopen('sitemap.xml', "w");
                fwrite($open1,$html);
                fclose($open1);      	                       
            break;
            
            
            case "help":                        
                $html = '<?xml version="1.0" encoding="UTF-8"?>';
                $html = '<?xml-stylesheet type="text/xsl" href="'.base_url().'xml-sitemap.xsl"?>';
                $html .= '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
                $miniNews = new miniNews();
                $miniNews->num_per_page = 100;
                $con = ' AND status = 1 AND cat_id = 45 ';        
              
                $listNews = $miniNews->getNews($con,'ordering',' DESC ',1);
                if(count($listNews)>0){
                    foreach($listNews as $key=>$value){
                        if($key==0){
                            $type = "daily";
                            $priority = 1;
                        }else{
                            $type = "weekly";
                            $priority = 0.5;
                        }
                        $html .= '
                        <url>
                    		<loc>'.createLink('news_detail',array('id'=>$value['id'],'title'=>$value['title'])).'</loc>
                    		<lastmod>'.date('Y-m-d H:i:s+00:00',$value['date']).'</lastmod>
                    		<changefreq>'.$type.'</changefreq>
                    		<priority>'.$priority.'</priority>
                    	</url>';
                    }
                }        
                
                $html .= '</urlset>';
                
                $open1 = fopen('sitemap_help.xml', "w");
                fwrite($open1,$html);
                fclose($open1);      	                       
            break;
            
            case "categories":                        
                $html = '<?xml version="1.0" encoding="UTF-8"?>';
                $html = '<?xml-stylesheet type="text/xsl" href="'.base_url().'xml-sitemap.xsl"?>';
                $html .= '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
                
                
                $miniCategory = new miniCategory();
                $allCat = $miniCategory->getCatByType(2);
                if(count($allCat)>0){
                    foreach($allCat as $key=>$value){
                        if($key==0){
                            $type = "daily";
                            $priority = 1;
                        }else{
                            $type = "weekly";
                            $priority = 0.5;
                        }
                        $html .= '
                        <url>
                    		<loc>'.createLink('product',array('cid'=>$value['id'],'name'=>$value['name'])).'</loc>
                    		<lastmod>'.date('Y-m-d H:i:s+00:00',time()).'</lastmod>
                    		<changefreq>'.$type.'</changefreq>
                    		<priority>'.$priority.'</priority>
                    	</url>';
                    }
                }        
                
                $html .= '</urlset>';
                
                $open1 = fopen('sitemap_categories.xml', "w");
                fwrite($open1,$html);
                fclose($open1);      	                       
            break;
        }
        
    }
}

