<?php

/**
 * @author duchanh
 * @copyright 2012
 */

class module_footer_asset extends Module{
    
    function module_footer_asset(){
        $this->file = 'footer_asset.html';
        parent::module();
    }
    
    function draw(){
        global $skin, $lang;
        
        $xtpl = new XTemplate($this->tpl);
        
        if (isset($_SESSION['language'])) $xtpl->assign('lang', $_SESSION['language']);
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        $xtpl->assign('link_sitemap', createLink('sitemap'));
        $xtpl->assign('link_feed', createLink('feed'));
        
        $cid = CInput::get('cid','int',0);
        if($cid){
            $url_cur = '&cid='.$cid;
        }else{
            $url_cur = '';
        }
        
        $xtpl->assign('link_giam_gia', base_url().'san-pham/san-pham-giam-gia.html'.$url_cur);
        $xtpl->assign('link_spmoi', base_url().'san-pham/san-pham-moi.html'.$url_cur);
        $xtpl->assign('link_banchay', base_url().'san-pham/san-pham-ban-chay.html'.$url_cur);
        
        $xtpl->assign('googleplus',getConfig('googleplus'));
        $xtpl->assign('facebook',getConfig('facebook'));
        $xtpl->assign('twitter',getConfig('twitter'));
        $xtpl->assign('address',getConfig('address'));
        $xtpl->assign('email',getConfig('email'));
        $xtpl->assign('fax',getConfig('fax'));
        
        $xtpl->assign('lb_aboutus', $lang['lb_aboutus']);
        $xtpl->assign('lb_introduce', $lang['lb_introduce']);
        $xtpl->assign('lb_introduce', $lang['lb_introduce']);
        $xtpl->assign('lb_category_product', $lang['lb_category_product']);
        $xtpl->assign('lb_contact', $lang['lb_contact']);
        $xtpl->assign('lb_register_email', $lang['lb_register_email']);
        $xtpl->assign('lb_enter_email', $lang['lb_enter_email']);
        $xtpl->assign('lb_address', $lang['lb_address']);
        $xtpl->assign('lb_connect_with_us', $lang['lb_connect_with_us']);
        
        $phone = trim(getConfig('phone1')) . ' | ' . trim(getConfig('phone2'));
        $xtpl->assign('phone', $phone);
        
        
        // danh muc san pham
        $miniCategory = new miniCategory();
        $category = $miniCategory->getCatByType(2);
        if(count($category)>0){
            foreach($category as $key=>$value){
                if($value['parent_id'] != 0 ) continue;
                $link = createLink('product',array('cid'=>$value['id'],'name'=>$value['name']));
                $xtpl->assign('cat_link', $link);
                $xtpl->assign('cat_name', $value['name']);   
                $xtpl->parse('main.cat');     
            }
        }
        
        // huong dan
        $cid = 38;
        $miniNews = new miniNews();
        $miniNews->num_per_page = 10;
        $con = " AND status = 1 AND cat_id = $cid ";
        $arrNews = $miniNews->getNews($con,'ordering','desc',1);
        if(count($arrNews)>0){
            foreach($arrNews as $key=>$value){
                $link = createLink('news_detail',array('id'=>$value['id'],'title'=>$value['title']));
                $xtpl->assign('guide_link', $link);
                $xtpl->assign('guide_title', $value['title']);   
                $xtpl->parse('main.guide');
            }
        }
        
        
        // chinh sach      
        $cid = 43;
        $miniNews = new miniNews();
        $miniNews->num_per_page = 10;
        $con = " AND status = 1 AND cat_id = $cid ";
        $arrNews = $miniNews->getNews($con,'ordering','desc',1);
        if(count($arrNews)>0){
            foreach($arrNews as $key=>$value){
                $link = createLink('news_detail',array('id'=>$value['id'],'title'=>$value['title']));
                $xtpl->assign('policy_link', $link);
                $xtpl->assign('policy_title', $value['title']);   
                $xtpl->parse('main.policy');
            }
        } 
        
        
        // gioi thieu
        $cid = 44;
        $miniNews = new miniNews();
        $miniNews->num_per_page = 10;
        $con = " AND status = 1 AND cat_id = $cid ";
        $arrNews = $miniNews->getNews($con,'ordering','desc',1);
        if(count($arrNews)>0){
            foreach($arrNews as $key=>$value){
                $link = createLink('news_detail',array('id'=>$value['id'],'title'=>$value['title']));
                $xtpl->assign('about_link', $link);
                $xtpl->assign('about_title', $value['title']);   
                $xtpl->parse('main.about');
            }
        }
        
        
        
        
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}


