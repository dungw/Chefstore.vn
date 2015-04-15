<?php

/**
 * @author duchanh
 * @copyright 2012
 * @desc module list html of introduction
 */
 
class module_contact_us extends Module{
    
    function module_contact_us(){
        $this->file = 'contact_us.html';
        parent::module();
    }
    
    function draw(){
        global $skin, $title ,$keywords, $description, $pathway, $lang;
        $xtpl = new XTemplate($this->tpl);
        
        if (isset($_SESSION['language'])) $xtpl->assign('lang', $_SESSION['language']);
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        
        $xtpl->assign('address', getConfig('address'));        
        $xtpl->assign('hotline', getConfig('hotline'));
        $xtpl->assign('email', getConfig('email'));
        
        $xtpl->assign('lb_contact', $lang['lb_contact']);
        $xtpl->assign('lb_send_us_infomation', $lang['lb_send_us_infomation']);
        $xtpl->assign('lb_ex_address', $lang['lb_ex_address']);
        $xtpl->assign('lb_necess_info', $lang['lb_necess_info']);
        $xtpl->assign('lb_message_with_us', $lang['lb_message_with_us']);
        
        $xtpl->assign('lb_fullname', $lang['lb_fullname']);
        $xtpl->assign('lb_phone', $lang['lb_phone']);
        $xtpl->assign('lb_address', $lang['lb_address']);
        
        $title = 'Thông tin liên hệ';
        $description = $keywords = "Liên hệ với chúng tôi";
        
        $pathway = array(
            0=> array(
                'type'  => '',
                'link'  =>'javascript:void(0)',
                'name'  => 'Thông tin liên  hệ'
                )
        );
        
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}
