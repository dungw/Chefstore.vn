<?php

/**
 * @author duchanh
 * @copyright 2012
 */


class module_topbar extends Module{
    
    var $edit_html_skin  = true;
    
    function module_topbar(){
        $this->file = 'topbar.html';
        parent::module();
    }
    
    function draw(){
        global $skin, $lang;
        $xtpl = new XTemplate($this->tpl);
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        
        $xtpl->assign('link_guide', createLink('news_detail',array('id'=>12,'title'=>'huong dan')));
        $xtpl->assign('link_contact', createLink('contact'));
        $xtpl->assign('link_sitemap', createLink('sitemap'));
        $xtpl->assign('link_no_http', str_replace('http://','',base_url()));
     	
        $xtpl->assign('support', $lang['lb_support']);
        
        $xtpl->assign('link_dichvu', base_url().'huong-dan');
        $xtpl->assign('link_huongdan', createLink('news_detail',array('id'=>13,'title'=>'huong dan mua hang')));
        $xtpl->assign('link_thanhtoan', createLink('news_detail',array('id'=>14,'title'=>'hinh thuc thanh toan')));
        $xtpl->assign('link_vanchuyen', createLink('news_detail',array('id'=>15,'title'=>'van chuyen hang hoa')));
        $xtpl->assign('link_faqs', createLink('news_detail',array('id'=>16,'title'=>'cau hoi thuong gap')));
        
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
        
        
        $xtpl->assign('hotline', getConfig('hotline'));
     
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}


