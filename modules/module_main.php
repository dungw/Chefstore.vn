<?php

/**
 * @author duchanh
 * @copyright 2012
 */

class module_main extends Module{
    
    function module_main(){
        $this->file = 'main.html';
        parent::module();
    }
    
    function draw(){
        global $skin,$lang;
        
        $xtpl = new XTemplate($this->tpl);
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        $xtpl->assign('link_search', createLink('product'));
        $keyword = CInput::get('keyword','txt','Enter Search text');
        $xtpl->assign('keyword',$keyword);
        $xtpl->assign('lb_search', $lang['lb_search']);
        
        // LANGUAGE
        if ($_SESSION['language'] == 'vi') {
        	$xtpl->assign('lang_active_vi', 'active');
        	$xtpl->assign('lang_active_en', '');
        } else if ($_SESSION['language'] == 'en') {
        	$xtpl->assign('lang_active_vi', '');
        	$xtpl->assign('lang_active_en', 'active');
        }
        
        $xtpl->assign('lang_en', $lang['lang_en']);
        $xtpl->assign('lang_vi', $lang['lang_vi']);
        
        global $_SESSION;
        $number_product = 0;
        if(isset($_SESSION['cart'])){            
            $number_product = count($_SESSION['cart']);
        }
        
        $xtpl->assign('number_product', $number_product);        
        $xtpl->assign('link_cart', createLink('cart'));
        $xtpl->assign('link_check_order', createLink('check_order'));
     
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}


