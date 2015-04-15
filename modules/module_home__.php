<?php

/**
 * @author duchanh
 * @copyright 2012
 * @desc module list html of introduction
 */
 
class module_home extends Module{
    
    function module_home(){
        $this->file = 'home.html';
        parent::module();
    }
    
    
    
    function draw(){
        global $skin, $title, $keywords, $description, $arrPrice;        
        $xtpl = new XTemplate($this->tpl);
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        
        
        
        $miniCategory = new miniCategory();
        $productCategory = $miniCategory->getCatByType(2);
        
        
        $miniProduct = new miniProduct();
        $miniProduct->num_per_page = 3;
        $con = " AND `status` = 1 AND `home` = 1 ";
        //$productPromotion = $miniProduct->getProduct($con);
        $productPromotion  = null;
        if(count($productPromotion)>0){
            $i = 1;
            foreach($productPromotion as $key=>$value){
                if($i==1){
                    $class = 'class="first"';
                }else if($i==3){
                    $class = 'class="last"';
                }else{
                    $class = '';
                }
                $link_promo = createLink('product_detail',array('id'=>$value['id'],'name'=>$value['name']));
                $img_promo  = base_url().$value['thumb300'];
                $xtpl->assign('link_promo', $link_promo);
                $xtpl->assign('name_promo', $value['name']);
                $xtpl->assign('img_promo', $img_promo);
                $xtpl->assign('class', $class);
                if($value['price']>0){
                    $xtpl->assign('price_promo', formatPrice($value['price']));
                    $xtpl->assign('price_type', $arrPrice[$value['price_type']]);    
                }else{
                    $xtpl->assign('price_promo', "Call");
                    $xtpl->assign('price_type', '');
                }
                
                $xtpl->parse('main.promo');
                $i++;
            }
        }
        
        if(count($productCategory)>0){            
            foreach($productCategory as $key=>$value){
                $con = " AND status = 1 AND home = 1 ";
                if($value['parent_id']!=0) continue;                
                
                $link_category = createLink('product',array('cid'=>$value['id'],'name'=>$value['name']));
                $xtpl->assign('link_category', $link_category);
                $xtpl->assign('name_category', $value['name']);
                            
                $lis_subcat = $miniCategory->getListSubCategory($productCategory,$value['id']);
                $lis_subcat = trim($lis_subcat,',');
                $con .= " AND  cat_id IN ($lis_subcat)";
                $con_count = " AND  cat_id IN ($lis_subcat)";
                $miniProduct = new miniProduct();
                $miniProduct->num_per_page = 4;
                $arrProduct = $miniProduct->getProduct($con,'ordering','desc',1);
                $num =    $miniProduct->count($con_count);                          
                $xtpl->assign('num', $num);
                if(count($arrProduct)>0){
                    $i = 0;
                    $style_class = '';
                    foreach($arrProduct as $key=>$value){
                        if($i==0){
                            $style_class = 'class="first"'; 
                        }else if($i==3){
                            $style_class = 'class="last"';
                        }
                        $i++;
                        
                        $xtpl->assign('style_class', $style_class);
                        
                        $product_type_html = '';
                        if($value['new']){
                            $product_type_html = '<span class="new">new</span>';    
                        }
                        if($value['discount']){
                            $product_type_html = '<span class="sales">sales</span>';
                        }
                        if($value['saleoff']){
                            $product_type_html = '<span class="saleoff">sales</span>';
                        }
                        
                        $xtpl->assign('product_type_html', $product_type_html);
                        
                        
                        $product_link = createLink('product_detail',array('id'=>$value['id'],'name'=>$value['name']));
                        $xtpl->assign('product_link', $product_link);
                        
                        $product_thumb = base_url().$value['thumb'];
                        $xtpl->assign('product_thumb', $product_thumb);
                        
                        $xtpl->assign('product_name', $value['name']);
                        
                        if($value['price']>0){
                            $xtpl->assign('price_type', $arrPrice[$value['price_type']]);                        
                            $xtpl->assign('product_price', formatPrice($value['price']));    
                        }else{
                            $xtpl->assign('price_type', 'Call');                        
                            $xtpl->assign('product_price', '');
                        }
                                                
                        $xtpl->parse('main.category.product');
                        
                        $xtpl->assign('none','');
                    }
                }else{
                    $xtpl->assign('none','<center><em>Sản phẩm đang được cập nhật...</em></center>');
                    //$xtpl->assign('dpl','none');                    
                }
                
                $xtpl->parse('main.category');
            }
        }
        
        $miniBanner = new miniBanner();
        $banner = $miniBanner->getBannerByPosition('content');
        foreach($banner as $key=>$value){
            $xtpl->assign('img', base_url().$value['img']);
            $xtpl->assign('name', $value['name']);
            $xtpl->parse('main.banner');
        }
        
        
        //$title = 'Trang chủ';
        //$keywords = 'Trang chủ';
        //$keywords = 'Trang chủ';
        $xtpl->parse('main');
        return $xtpl->out('main');
    }
    
    
}