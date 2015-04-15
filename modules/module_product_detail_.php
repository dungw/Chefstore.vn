<?php

/**
 * @author duchanh
 * @copyright 2012
 */
 
class module_product_detail extends Module{
    
    function module_product_detail(){
        $this->file = 'product_detail.html';
        parent::module();
    }
    
    function draw(){
        global $skin, $title, $keywords, $description, $lang, $pathway, $arrPrice;
        
        $xtpl = new XTemplate($this->tpl);
        $miniCategory = new miniCategory();
        $miniProduct = new miniProduct();
        $miniProductImages = new miniProductImages();
        
        $skin_path  = base_url().'skin/'.$skin.'/';
        $xtpl->assign('link_home', base_url());        
        $xtpl->assign('skin_path', $skin_path);
        
        $id = CInput::get('id','int',0);
        if($id){        
            
        	if (isset($_SESSION['language'])) $xtpl->assign('lang', $_SESSION['language']);
        	
            $xtpl->assign('link_help_dathang', createLink('news_detail',array('id'=>88,'title'=>"tro giup dat hang")));
            $xtpl->assign('link_help_thanhtoan', createLink('news_detail',array('id'=>89,'title'=>"tro giup thanh toan")));
            $xtpl->assign('cur_link',curPageURL());
            
            $xtpl->assign('hotline', getConfig('hotline'));
            
            $xtpl->assign('phone1', getConfig('phone1'));
            $xtpl->assign('phone2', getConfig('phone2'));
            $xtpl->assign('phone3', getConfig('phone3'));
            
            $xtpl->assign('lb_product_code', $lang['lb_product_code']);
            $xtpl->assign('lb_price', $lang['lb_price']);
            $xtpl->assign('lb_discount_price', $lang['lb_discount_price']);
            $xtpl->assign('lb_buy_support', $lang['lb_buy_support']);
            $xtpl->assign('lb_buy_contact', $lang['lb_buy_contact']);
            $xtpl->assign('lb_share_info', $lang['lb_share_info']);
            $xtpl->assign('lb_description', $lang['lb_description']);
            $xtpl->assign('lb_technical_info', $lang['lb_technical_info']);
            $xtpl->assign('lb_same_category', $lang['lb_same_category']);
            
            $yahoo1 = getConfig('yahoo1');
            $yahoo1 = explode(':',$yahoo1);
            $xtpl->assign('yahoo1', $yahoo1[1]);
            $xtpl->assign('name_yahoo1', $yahoo1[0]);
            
            $yahoo2 = getConfig('yahoo2');
            $yahoo2 = explode(':',$yahoo2);
            $xtpl->assign('yahoo2', $yahoo2[1]);
            $xtpl->assign('name_yahoo2', $yahoo1[0]);
            
            $yahoo3 = getConfig('yahoo3');
            $yahoo3 = explode(':',$yahoo3);
            $xtpl->assign('yahoo3', $yahoo3[1]);
            $xtpl->assign('name_yahoo3', $yahoo3[0]);
            
            $skype1 = getConfig('skype1');
            $skype1 = explode(':',$skype1);
            $xtpl->assign('skype1', $skype1[1]);
            $xtpl->assign('name_skype1', $skype1[0]);
            
            $skype2 = getConfig('skype2');
            $skype2 = explode(':',$skype2);
            $xtpl->assign('skype2', $skype2[1]);
            $xtpl->assign('name_skype2', $skype2[0]);
            
            $skype3 = getConfig('skype3');
            $skype3 = explode(':',$skype3);
            $xtpl->assign('skype3', $skype3[1]);
            $xtpl->assign('name_skype3', $skype3[0]);
        
            $xtpl->assign('cur_page', curPageURL());
            
            $allCat = $miniCategory->getCatByType(2);
            $miniProduct->read($id);
            $miniProduct->hits($id);
            $cat_id = $miniProduct->cat_id;
            
            $category_name = $miniCategory->getCategoryInfo($allCat,$cat_id,'name');
            $xtpl->assign('category_name',$category_name);
            $xtpl->assign('name',$miniProduct->name);
            
            if($miniProduct->code != ''){
                $xtpl->assign('product_code',$miniProduct->code);    
            }else{
                $xtpl->assign('dpl_product_code','none');
            }
            
            
            $xtpl->assign('id', $id);
            
            $price = formatPrice($miniProduct->price);
            $xtpl->assign('price', $price);
            $price_promotion = $miniProduct->price_promotion;
            if($price_promotion>0){
                $xtpl->assign('class_price', 'old-price');
                $price_promotion = formatPrice($price_promotion);
                $xtpl->assign('price_promotion', $price_promotion);    
            }else{
                $xtpl->assign('dpl_km', 'none');    
                $xtpl->assign('class_price', 'price');
            }
            
            
            $persent_off = round(($price - $price_promotion)*100/$price);
            $xtpl->assign('persent_off', $persent_off);    
            
            $in_stock  = ($miniProduct->in_stock==1)?'Còn hàng' : 'Hết hàng';
            $xtpl->assign('in_stock', $in_stock);
            $miniProduct->description = ucfirst(stripslashes($miniProduct->description));
            $xtpl->assign('description', $miniProduct->description);  
           
            $specifications = explode(';',trim(stripslashes($miniProduct->specifications)));
            
            $html_specifications = '';
            if($specifications && count($specifications>0)){
                foreach($specifications as $row){
                    if($row!=''){
                        $row = explode(':',$row);
                        $html_specifications .= '<tr><td class="col1">'.$row['0'].'</td>';
                        $html_specifications .= '<td class="col2">'.$row['1'].'</td></tr>';    
                    }                    
                }                
            }
            
            $xtpl->assign('specifications', $html_specifications);  
            
            if($miniProduct->other_info){
                $other_info = '<li><h3>Thông tin thêm</h3></li><li>'.$miniProduct->other_info.'.</li>';
                $xtpl->assign('other_info', $other_info);
            }
            
            $xtpl->assign('hits', $miniProduct->hits);
            $xtpl->assign('date', date('d/m/Y',strtotime($miniProduct->date)));
            $xtpl->assign('product_id', $miniProduct->id);
            $xtpl->assign('product_type', $arrPrice[$miniProduct->price_type]);
            
            $xtpl->assign('link_add_cart', createLink('cart',array('pid'=>$miniProduct->id,'number'=>1)));
            
            // share  social net word           
            $xtpl->assign('link_share_facebook','https://www.facebook.com/share.php?src=bm&u='.curPageURL());
            $xtpl->assign('link_share_twitter','http://twitter.com/home/?status='.curPageURL().'<--'.$miniProduct->name);
            $xtpl->assign('link_share_google','http://www.google.com/bookmarks/mark?op=edit&bkmk='.curPageURL().'&title='.$miniProduct->name);
            
            $listProductImages = $miniProductImages->getProductImage($id);
            $listProductImages = $listProductImages[$id];
            if(count($listProductImages)>0){ 
                $i = 0;
                $img300 = base_url().getSmallImages($listProductImages[0]['images'],'thumb300');
                $img    = base_url().$listProductImages[0]['images'];
                
				// Check image default
				if ($img[strlen($img)-1] == '/') {
					$img = '/skin/default/img/noimage.png';
				}
	                    
				// Check header
				if (!strpos($_SERVER['HTTP_HOST'], 'calhost')) {
					$file_headers = @get_headers($img);
					if ($file_headers[0] != 'HTTP/1.1 200 OK') {
						$img = '/skin/default/img/noimage.png';
					}
				}
                
                $xtpl->assign('img300',$img300);
                $xtpl->assign('images',$img);

                if(count($listProductImages)>1){
                    foreach($listProductImages as $key=>$value){
                        if($i==0){
                            $xtpl->assign('class','class="first"');
                            $xtpl->assign('active','active');
                        }else{
                            $xtpl->assign('class','');
                            $xtpl->assign('active','');
                        }
                        
                        $xtpl->assign('thumb',base_url().getSmallImages($value['images'],'thumb'));
                        $xtpl->assign('thumb50',base_url().getSmallImages($value['images'],'thumb50'));
                        $xtpl->assign('img_full',base_url().$value['images']);
                        $xtpl->parse('main.images');
                        $i++;
                    }
                }
                
            }
            
            
            // other product
            $cid = $miniProduct->cat_id;
            $con = " AND status = 1 AND cat_id = $cid AND id != $id ";
            $miniProduct->num_per_page = 5;
            $otherProduct = $miniProduct->getProduct($con,'ordering','desc',1);
            if(count($otherProduct)>0){
            	$i = 0;
                foreach($otherProduct as $key=>$value){
                	
                	// class
                	$i++;
                	if ($i <= 3) {
	                	$class = '';
	                	if (($i/3 == 1)) {
	                		$class = 'last';
	                	}
	                	$xtpl->assign('class', $class);
	                	
	                    $link_other = createLink('product_detail',array('id'=>$value['id'],'name'=>$value['name']));
	                    $xtpl->assign('link_other',$link_other);
	                    $xtpl->assign('name_other',$value['name']);
	                    
	                    $thumb_other    = base_url().$value['thumb'];
	                    $xtpl->assign('thumb_other',$thumb_other);
	                    
	                    $price_other    = formatPrice($value['price']);
	                    $xtpl->assign('price_other',$price_other);
	                    $xtpl->assign('product_type',$arrPrice[$value['price_type']]);
	                    $xtpl->parse('main.other_product');
                	}
                    
                }
                $xtpl->assign('link_more',createLink('product',array('cid'=>$cid,'name'=>'san pham khac')));
            }
            
            
            // product commment
            $miniComment = new miniComment();
            $miniComment->num_perpage = 10;
            $listComment = $miniComment->getComment($id,2,'id');
            if(count($listComment)>0){
                foreach($listComment as $key=>$value){                    
                    $xtpl->assign('title',$value['title']);
                    $xtpl->assign('username',$value['username']);
                    $xtpl->assign('date',date('H:i d/m/Y',strtotime($value['date'])));                    
                    $xtpl->assign('content',$value['content']);                    
                    $xtpl->parse('main.comment');  
                }
            }else{
                $xtpl->assign('none_comment','<p style="color:red"><em>Hãy là người đầu tiên nhận xét về sản phẩm này...</em></p>');
            }
            
            
            $list_news = $miniProduct->listnews;
            
            $list_news = trim($list_news);
            if($list_news){                
                $miniNew = new miniNews();
                $miniNew->num_per_page = 5;
                $news_lienquan = $miniNew->getNews("AND status = 1 AND id IN ($list_news) ", 'ordering ', 'desc',1);
                if($news_lienquan && count($news_lienquan)>0){
                    foreach($news_lienquan as $k=>$v){
                        $xtpl->assign('title_lienquan',$v['title']);
                        $xtpl->assign('link_detail_lienquan',createLink('news_detail',array('id'=>$v['id'],'title'=>$v['title'])));
                        $xtpl->parse('main.news');  
                    }
                }else{
                    $xtpl->assign('none_newlienquan','none');  
                }
            }else{
                $xtpl->assign('none_newlienquan','none');
            }
            
            
            
                
            $title = ($miniProduct->meta_title!='')?$miniProduct->meta_title:$miniProduct->name;
            $keywords = $miniProduct->meta_keyword;
            $description = $miniProduct->meta_description;
        }
        
        
        
        $allCat = $miniCategory->getCatByType(2);
        $cid = $miniProduct->cat_id;        
        $category_name = $miniCategory->getCategoryInfo($allCat,$cid,'name');
        $parent_cat = $miniCategory->getParentCat($allCat,$cid);
        $pparent_cat = $miniCategory->getParentCat($allCat,$parent_cat['id']);
        $ppparent_cat = $miniCategory->getParentCat($allCat,$pparent_cat['id']);
        
        if(count($ppparent_cat)>0 && $ppparent_cat){
            $wft = array(
                'type'  => 'link',
                'link'  => createLink('product',array('cid'=>$ppparent_cat['id'],'name'=>$ppparent_cat['name'])),
                'name'  => $ppparent_cat['name']
                );
            $pathway[]  = $wft;
        }
        if(count($pparent_cat)>0 && $pparent_cat){
            $wft = array(
                'type'  => 'link',
                'link'  => createLink('product',array('cid'=>$pparent_cat['id'],'name'=>$pparent_cat['name'])),
                'name'  => $pparent_cat['name']
                );
            $pathway[]  = $wft;
        }
        if(count($parent_cat)>0 && $parent_cat){
            $wft = array(
                'type'  => 'link',
                'link'  => createLink('product',array('cid'=>$parent_cat['id'],'name'=>$parent_cat['name'])),
                'name'  => $parent_cat['name']
                );
            $pathway[]  = $wft;
        }
        
                
        $wft =  array(
            'type'  => 'link',
            'link'  => createLink('product',array('cid'=>$cid,'name'=>$category_name)),
            'name'  => $category_name
            );
        $pathway[]  = $wft;
        
        $wft = array(
                'type'  => '',
                'link'  =>'javascript:void(0)',
                'name'  => $miniProduct->name
                );
        $pathway[] = $wft ;
     
        $xtpl->parse('main');
        return $xtpl->out('main'); 
    }
    
 
}
    