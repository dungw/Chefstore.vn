<?php
/**
 * @author duchanh
 * @copyright 2012
 */

class module_right_comment extends Module{
    
    function module_right_comment(){
        $this->file = 'right_comment.html';
        parent::module();
    }
    
    function draw(){
        global $skin, $lang;
        $xtpl = new XTemplate($this->tpl);
        
        // GET ABOUT US
        $this->table = 'tbl_aboutus';
		$allAbout = $this->get('*',false,' id  ASC');
    	foreach($allAbout as $key=>$value) {
			$xtpl->assign('active', 'class="active"');
			$xtpl->assign('link', createLink('aboutus', array('id' => $value['id'], 'name' => $value['name'])));
			$xtpl->assign('name', $value['name']);
			$xtpl->parse('main.about');
		}
        $skin_path = base_url().'skin/'. $skin .'/';
		
        // Category new
        $cnid = CInput::get('cnid','int',0);
        $this->table = 'tbl_news_category';
    	$allCateNew = $this->get('*',' AND parent_id = 46',' id  ASC');
    	foreach($allCateNew as $key=>$value) {
    		$xtpl->assign('active', '');
			if ($value['id'] == $cnid) $xtpl->assign('active', 'active');
			$xtpl->assign('link', createLink('cate_new', array('id' => $value['id'], 'name' => $value['name'])));
			$xtpl->assign('name', $value['name']);
			$xtpl->parse('main.cate_new');
		}
        
        $xtpl->assign('lb_introduce', $lang['lb_introduce']);
        $xtpl->assign('lb_new', $lang['lb_new']);
        $xtpl->assign('lb_contact', $lang['lb_contact']);
        
        $xtpl->assign('link_home', base_url());		
        $xtpl->assign('link_contact', createLink('contact'));		
        $xtpl->assign('link_new', createLink('news'));
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}


