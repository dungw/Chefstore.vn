<?php

/**
 * @author duchanh
 * @copyright 2012
 */
 
class module_product extends Module{
    
    
    function module_product(){
    	$cid = CInput::get('cid','int',0);
    	$miniCategory = new miniCategory();
    	$allProductCategory = $miniCategory->getCatByType(2);
    	
    	$list_cid = '';
    	$list_cid = $miniCategory->getListSubCategory($allProductCategory,$cid);
    	$list_cid = trim($list_cid, ',');
    	
    	if (strpos($list_cid, ',')) {
			$this->file = 'product_new.html';
    	} else {
    		$this->file = 'product.html';
    	}
    	
    	// Check
    	$type = CInput::get('type','txt','');
    	if ($type == 'search') {
    		$this->file = 'product.html';
    	}
        
        parent::module();
    }
    
    function draw() {
        global $skin, $title, $keywords, $description, $lang, $pathway,$arrPrice;
        
        $xtpl = new XTemplate($this->tpl);
        $miniProduct = new miniProduct();
        $miniCategory = new miniCategory();
        $allProductCategory = $miniCategory->getCatByType(2);
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        
        $con = " AND status = 1 ";
        
        // filter by category
        $cid = CInput::get('cid','int',0);
        
        $list_cid  = '';
        if ($cid) {
        	
            $list_cid = $miniCategory->getListSubCategory($allProductCategory,$cid);
            $list_cid = trim($list_cid,',');
            
            $title = $miniCategory->getCategoryInfo($allProductCategory,$cid,'name');
            $keywords = $miniCategory->getCategoryInfo($allProductCategory,$cid,'meta_keyword');
            $description = $miniCategory->getCategoryInfo($allProductCategory,$cid,'meta_description');
            
        } else {
        	
            $title = $lang['product'];
            $keywords = $lang['product'];
            $description = $lang['product'];
            
        }
        
        if (!strpos($list_cid, ',')) {
        	
        	$type = CInput::get('type','txt','');
	        if ($type=='new' || $type=='discount' || $type=='bestsell' || $type=='search' || $type=='saleoff') {
	            if ($list_cid) {
	                $con .= " AND cat_id IN($list_cid) ";
	            }
	            switch ($type){
	                case "new":
	                    $con .= " AND new = 1 ";
	                    $sort = 'ordering';
	                    $order = 'DESC'; 
	                    $type_name = 'Sản phẩm mới';  
	                    $title = $type_name;  
	                break;
	                
	                case "bestsell":
	                    $con .= " AND best_seller = 1 ";
	                    $sort = 'ordering';
	                    $order = 'DESC'; 
	                    $type_name = 'Sản phẩm bán chạy';
	                    $title = $type_name;
	                break;
	                
	                case "discount":
	                    $con .= " AND discount = 1 ";
	                    $sort = 'ordering';
	                    $order = 'DESC';
	                    $type_name = 'Sản phẩm giảm giá'; 
	                    $title = $type_name;
	                break;
	                
	                
	                case "saleoff":
	                    $con .= " AND saleoff = 1 ";
	                    $sort = 'ordering';
	                    $order = 'DESC';
	                    $type_name = 'Sản phẩm khuyến mãi'; 
	                    $title = $type_name;
	                break;
	                
	                case "search":
	                    // keyword
	                    $keyword = CInput::get("keyword","txt","");
	                    if($keyword!="" && strtolower($keyword) != "tìm kiếm trên chefstore.vn"){
	                        $con .= " AND ( `id` = '$keyword' OR `name` LIKE '%$keyword%' OR `code` LIKE '%$keyword%' OR `description` LIKE '%$keyword%' ) ";
	                    }
	                    
	                    $sort = 'ordering';
	                    $order = 'DESC'; 
	                    $type_name = 'Tìm kiếm';
	                    $title = $type_name;
	                break;
	                
	                default: 
	                    $con = "";
	                    $sort = 'ordering';
	                    $order = 'DESC'; 
	                    $type_name = 'Sản phẩm';
	                    $title = $type_name;
	                break;
	                
	            }
	            
	            $pathway = array(
	                0 => array(
	                    'type'  => '',
	                    'link'  =>'javascript:void(0)',
	                    'name'  => $title
					)
	            );
	            
	            $p = CInput::get("p","int",1);
	            $total_row = $miniProduct->count($con);
	            $total_page = ceil($total_row/$miniProduct->num_per_page);
	            $paging = pagging($p,$total_page,curPageURL());
	            $list_product = $miniProduct->getProduct($con,$sort,$order,$p);
	            
	            if (count($list_product) > 0 && $list_product) {
	                $i = 0;
	                $style_class = '';
	                
	                $html_cateogry_info = '<h1 style="text-transform: lowercase !important;" class="cate-name"><a href="javascript:void(0)">'. $type_name .'</a></h1>';
	                $html_cateogry_info .= '<ul class="grid first clearfix">';
	                
	                if ($type_name=='Tìm kiếm' && $keyword!='') {
	                    $html_cateogry_info = '<h1 class="cate-name">Có '.$total_row.' kết quả phù hợp với từ khóa <span class="yellow">"'.$keyword.'"</span> của bạn</h1>';
	                    $html_cateogry_info .= '<ul class="grid first clearfix">';
	                }
	                foreach ($list_product as $key=>$value) {
	                    if ($i%3 == 0) {
	                        $style_class = 'class="first"';
	                    } else if (($i+1)%3==0) {
	                        $style_class = 'class="last"';
	                    } else {
	                        $style_class =''; 
	                    }
	                    
	                    $product_link = createLink('product_detail',array('id'=>$value['id'],'name'=>$value['name']));
	                    $product_thumb = base_url().$value['thumb'];
	                    
	                    $product_type_html = '';
	                    if ($value['new']) {
	                        $product_type_html = '<span class="new">new</span>';    
	                    }
	                    if ($value['discount']) {
	                        $product_type_html = '<span class="sales">sales</span>';
	                    }
	                    if ($value['saleoff']) {
	                        $product_type_html = '<span class="saleoff">sales</span>';
	                    }
	                    
	                    if ($value['price']>0) {
	                        $price_html = formatPrice($value['price']).'</b> '.$arrPrice[$value['price_type']];    
	                    } else {
	                        $price_html = 'Call';
	                    }
	                    
	                    $html_cateogry_info .= 
	                    '<li align="center" '.$style_class.'>
	                        '.$product_type_html.'
	                        <a href="'.$product_link.'">
	                            <img src="'.$product_thumb.'" alt="'.$value['name'].'" />
	                            <span class="pro-name">'.$value['name'].'</span>
	                        </a>
	                        <!--
	                        <span class="price">Giá: <b>'.$price_html.'</span>
	                        -->
	                    </li>';
	                    
	                    if (($i+1)%3==0) {
	                        $html_cateogry_info .= '</ul><ul class="grid first clearfix">';
	                    }
	                    $i++;
	                    
	                }
	                $xtpl->assign('html_cateogry_info', $html_cateogry_info);
	            } else {
	                $html_cateogry_info = '';
	                if(CInput::get('keyword')!=''){
	                    $html_cateogry_info = '<h1 class="cate-name">Không có kết quả nào phù hợp với từ khóa <span class="yellow">"'.$keyword.'"</span> của bạn</h1>';    
	                }
	                
	                $xtpl->assign('html_cateogry_info', $html_cateogry_info);
	                $xtpl->assign('dpl2', 'none');
	            }
	            
	            $xtpl->assign('paging', $paging);            
	            $xtpl->parse('main.category');
	        }
	        
	        else if ((string)$list_cid == (string)$cid) { // danh muc cap thap nhat        
	            $con  .= " AND cat_id = ".$cid;
	            $miniProduct->num_per_page = 15;
	            $p	= CInput::get("p","int",1);
	            
	            $total_row = $miniProduct->count($con);    
	            $total_page = ceil($total_row/$miniProduct->num_per_page);
	            $paging = pagging($p,$total_page,curPageURL());
	            $category_name = $miniCategory->getCategoryInfo($allProductCategory,$cid,'name');
	            $category_link = createLink('product',array('cid'=>$cid,'name'=>$category_name));
	            $link_sort_abc = createLink('product',array('cid'=>$cid,'name'=>$category_name))."&sort=az";
	            $link_sort_new = createLink('product',array('cid'=>$cid,'name'=>$category_name))."&sort=newest";
	            $link_sort_priceup = createLink('product',array('cid'=>$cid,'name'=>$category_name))."&sort=price_up";
	            $link_sort_pricedown = createLink('product',array('cid'=>$cid,'name'=>$category_name))."&sort=price_down";
	            $link_sort_discount = createLink('product',array('cid'=>$cid,'name'=>$category_name))."&sort=discount";
	            $html_cateogry_info = 
	                '<!--<div class="filter clearfix">                    
	                    <div class="sortData">
	                        <b>Sắp xếp theo:</b>
	                        <a href="'.$link_sort_abc.'">A - Z</a>
	                        <a href="'.$link_sort_new.'">Mới nhất</a>
	                        <a href="'.$link_sort_priceup.'">Giá tăng dần</a>
	                        <a href="'.$link_sort_pricedown.'">Giá giảm dần</a>
	                        <a href="'.$link_sort_discount.'">Hàng giảm giá</a>
	                        <div class="result">Có <b>'.$total_row.'</b> kết quả tương ứng</div>
	                    </div>
	                </div>-->';
	             
	            //$html_cateogry_info .= 
	                    '<div class="path-navi">
	                     <a href="'.$category_link.'">Home</a>
	                     <span>&nbsp&nbsp|&nbsp&nbsp</span>
	                     <a href="">'. $category_name .'</a>
	                     </div>';
	                     
	            $html_cateogry_info .= '<h1 class="cate-name"><a href="'.$category_link.'">'.$category_name.'</a></h1>'; 
	            
	            $order = CInput::get('order','txt','DESC');
	            $sort  = CInput::get('sort','txt','ordering');
	            
	            $sort_type = CInput::get('sort','txt','');
	            switch ($sort){
	                case "az":
	                    $sort = 'name';
	                    $order = 'ASC'; 
	                break;
	                
	                case "newest":
	                    $sort = 'id';
	                    $order = 'DESC'; 
	                break;
	                
	                case "price_down":
	                    $sort = 'price';
	                    $order = 'DESC'; 
	                break;
	                
	                case "price_up":
	                    $sort = 'price';
	                    $order = 'ASC'; 
	                break;
	                
	                default: 
	                    $sort = 'ordering';
	                    $order = 'DESC'; 
	                break;
	            }
	            
	            $list_product = $miniProduct->getProduct($con,$sort,$order,$p);
	            if (count($list_product) > 0 && $list_product) {
	                
	                $i = 0;
	                $style_class = '';
	                $html_cateogry_info .= '<ul class="grid first clearfix">';
	                foreach ($list_product as $key=>$value){
	                    
	                    if ($i%3 == 0) {
	                        $style_class = 'class="first"';
	                    } else if (($i+1)%3 == 0) {
	                        $style_class = 'class="last"';
	                    } else {
	                        $style_class =''; 
	                    }
	                    
	                    $product_link = createLink('product_detail',array('id'=>$value['id'],'name'=>$value['name']));
	                    $product_thumb = base_url().$value['thumb'];
	                    
	                    $product_type_html = '';
	                    if ($value['new']) {
	                        $product_type_html = '<span class="new">new</span>';    
	                    }
	                    if ($value['discount']) {
	                        $product_type_html = '<span class="sales">sales</span>';
	                    }
	                    if ($value['saleoff']) {
	                        $product_type_html = '<span class="saleoff">sales</span>';
	                    }
	                    if ($value['price']>0) {
	                        $price_html = formatPrice($value['price']).'</b> '.$arrPrice[$value['price_type']];    
	                    } else {
	                        $price_html = 'Call';
	                    }
	                    
	                    // Check default image
	                    /*
	                    if ($product_thumb[strlen($product_thumb)-1] == '/') {
	                    	$product_thumb = '/skin/default/img/noimage.png';
	                    }
	                    
	                    // Check header image
	                    if (!strpos($_SERVER['HTTP_HOST'], 'calhost')) {
	                    	$file_headers = @get_headers($product_thumb);
							if ($file_headers[0] != 'HTTP/1.1 200 OK') {
							    $product_thumb = '/skin/default/img/noimage.png';
							}
	                    }
						*/
	                    $html_cateogry_info .= 
	                    '<li '.$style_class.'>
	                        '.$product_type_html.'
	                        <table width="200" height="200">
				            	<tr>
				            		<td align="center">
				            			<a href="'.$product_link.'">
				            				<img src="'.$product_thumb.'" alt="'.$value['name'].'" />
				           				</a>
				            		</td>
				            	</tr>
				            </table>
				            <span class="pro-name">'.$value['name'].'</span>
				            
				            <!--
	                        <a href="'.$product_link.'">
	                            <img src="'.$product_thumb.'" alt="'.$value['name'].'" />
	                            <span class="pro-name">'.$value['name'].'</span>
	                        </a>
	                        <span class="price">Giá: <b>'.$price_html.'</b></span>
	                        -->
	                        
	                    </li>';
	                    
	                    if (($i+1)%3 == 0) {
	                        $html_cateogry_info .= '</ul><ul class="grid first clearfix">';
	                    }
	                    $i++;
	                    
	                }
	            }else{
	                $html_cateogry_info = '';
	                $xtpl->assign('dpl', 'none');
	            }
	            
	            
	            $xtpl->assign('html_cateogry_info', $html_cateogry_info);
	            $xtpl->assign('paging', $paging);
	            
	            $xtpl->parse('main.category');
	            
	            
	            $parent_cat = $miniCategory->getParentCat($allProductCategory,$cid);
	            $pparent_cat = $miniCategory->getParentCat($allProductCategory,$parent_cat['id']);
	            if(count($pparent_cat)>0 && $pparent_cat){
	                $wft = array(
	                    'type'  => 'link',
	                    'link'  => createLink('product',array('cid'=>$pparent_cat['id'],'name'=>$pparent_cat['name'])),
	                    'name'  => $pparent_cat['name']
	                    );
	                $pathway[]  = $wft;
	            }
	            if(count($parent_cat)>0 && $parent_cat){
	                $wft =  array(
	                    'type'  => 'link',
	                    'link'  => createLink('product',array('cid'=>$parent_cat['id'],'name'=>$parent_cat['name'])),
	                    'name'  => $parent_cat['name']
	                    );
	                $pathway[]  = $wft;
	            }
	            $wft = array(
	                    'type'  => '',
	                    'link'  =>'javascript:void(0)',
	                    'name'  => $category_name
	                    );
	            $pathway[] = $wft ;
	            
	        }else{             
	            $subCat = $miniCategory->getSubCat($allProductCategory,$cid);
	            foreach($subCat as $key=>$value){
	                $con = ''; 
	                $category_link = createLink('product',array('cid'=>$value['id'],'name'=>$value['name']));  
	                $html_cateogry_info = 
	                    '<a href="'.$category_link.'" class="more"><span>Xem thêm</span></a>
	                     <h1 class="cate-name"><a href="'.$category_link.'">'.$value['name'].'</a></h1>'; 
	                
	                $list_sub_c = $miniCategory->getListSubCategory($allProductCategory, $value['id']);
	                $list_sub_c = trim($list_sub_c,',');
	                $con  = " AND status = 1 AND cat_id IN ($list_sub_c) ";
	                
	                
	                $miniProduct->num_per_page = 4;
	                $arrProduct = $miniProduct->getProduct($con,'ordering','desc',1);
	                $xtpl->assign('cateName', $value['name']);
	                
	                if(count($arrProduct)>0 && $arrProduct){
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
	                        
	                        // Check image default
	                        $product_thumb = base_url().$value['thumb'];
	                        /*
	                        if ($product_thumb[strlen($product_thumb)-1] == '/') {
		                    	$product_thumb = '/skin/default/img/noimage.png';
		                    }
		                    */
		                    
		                    // Check header
		                    /*
		                    if (!strpos($_SERVER['HTTP_HOST'], 'calhost')) {
			                    $file_headers = @get_headers($product_thumb);
								if ($file_headers[0] != 'HTTP/1.1 200 OK') {
								    $product_thumb = '/skin/default/img/noimage.png';
								}
		                    }
		                    */
		                    
	                        $xtpl->assign('product_thumb', $product_thumb);
	                        $xtpl->assign('product_name', $value['name']); 
	                        
	                        /** PRODUCT PRICE
	                        if($value['price_type']>0){
	                            $xtpl->assign('product_type', $arrPrice[$value['price_type']]);
	                            $xtpl->assign('product_price', formatPrice($value['price']));
	                        }else{
	                            $xtpl->assign('product_type','Call');
	                            $xtpl->assign('product_price', '');
	                        }*/
	                        
	                        $xtpl->assign('dpl', '');
	                        $xtpl->parse('main.category.product');
	                        
	                    }
	                } else {
	                	
	                    $xtpl->assign('html_cateogry_info', '');
	                    $html_cateogry_info = '';
	                    $xtpl->assign('dpl', 'none');
	                    
	                }
	                $xtpl->assign('html_cateogry_info', $html_cateogry_info);
	                $xtpl->parse('main.category');
	            }
	            
	            $category_name = $miniCategory->getCategoryInfo($allProductCategory,$cid,'name');
	            $parent_cat = $miniCategory->getParentCat($allProductCategory,$cid);
	            $pparent_cat = $miniCategory->getParentCat($allProductCategory,$parent_cat['id']);
	            
	            if (count($pparent_cat) > 0 && $pparent_cat) {
	                $wft = array(
	                    'type'  => 'link',
	                    'link'  => createLink('product',array('cid'=>$pparent_cat['id'],'name'=>$pparent_cat['name'])),
	                    'name'  => $pparent_cat['name']
	                    );
	                $pathway[]  = $wft;
	            }
	            if (count($parent_cat) > 0 && $parent_cat){
	                $wft =  array(
	                    'type'  => 'link',
	                    'link'  => createLink('product',array('cid'=>$parent_cat['id'],'name'=>$parent_cat['name'])),
	                    'name'  => $parent_cat['name']
	                    );
	                $pathway[]  = $wft;
	            }
	            $wft = array(
	                    'type'  => '',
	                    'link'  =>'javascript:void(0)',
	                    'name'  => $category_name
	                    );
	            $pathway[] = $wft ;
	        }
	        
	        $xtpl->parse('main');
	        return $xtpl->out('main');
	        
    	} else {
        	
    		// CO DANH MUC CON
    		$xtpl = new XTemplate($this->tpl);
    		
    		// Get banner
    		$miniBanner = new miniBanner();
			$banner = $miniBanner->getBannerByPosition('category');
			$xtpl->assign('href', $banner[0]['link']);
			$xtpl->assign('name', $banner[0]['name']);
			$xtpl->assign('src', base_url() . $banner[0]['img']);
    		$xtpl->parse('main.banner');
			
    		$arCate = explode(',', $list_cid);
    		
    		$htmlSubcate = '';
    		$htmlSubcate .= '<div class="list-subcate">';
    		$htmlSubcate .= '<table width="100%">';
    		$htmlSubcate .= '<tr>';
    		$i = 0;
    		
    		foreach ($allProductCategory as $item) {
    			$cateLink = createLink('product',array('cid'=>$item['id'],'name'=>$item['name']));
    			if ($item['id'] == $cid) {
    				
    				// PATHWAY
    				$htmlMainCate  = '';
    				$htmlMainCate .= 
	                    '<div class="path-navi">
	                     <a href="'. base_url() .'">Home</a>
	                     <span>&nbsp&nbsp|&nbsp&nbsp</span>
	                     <a href="'. $cateLink .'">'. $item['name'] .'</a>
	                     </div>';
    				
					$xtpl->assign('html_pathway', $htmlMainCate);
    				$xtpl->parse('main.pathway');
    			}
    			
    			if (in_array($item['id'], $arCate) && ($item['parent_id'] == $cid)) {
	    			if ($i % 4 != 0) {
	    				$htmlSubcate .= '<td>';
	    				$htmlSubcate .= '<a href="'. $cateLink .'">'. $item['name'] .'</a>';
	    				$htmlSubcate .= '</td>';
	    			} else {
	    				$htmlSubcate .= '</tr><tr><td>';
	    				$htmlSubcate .= '<a href="'. $cateLink .'">'. $item['name'] .'</a>';
	    				$htmlSubcate .= '</td>';
	    			}
	    			$i++;
    			}
    		}
    		
    		$htmlSubcate .= '</tr>';
    		$htmlSubcate .= '</table>';
    		$htmlSubcate .= '</div>';
    		$xtpl->assign('html_subcate', $htmlSubcate);
    		$xtpl->parse('main.subcate');
    		$xtpl->parse('main');
    		
	        return $xtpl->out('main');
        }
    }
}



















