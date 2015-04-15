<?php
/**
 * @author duchanh
 * @copyright 2012
 * @desc module list html of introduction
 */

class module_hoidap extends Module {
	
    function module_hoidap() {
        $this->file = 'hoidap.html';
        parent::module();
    }
    
    function draw() {
        global $skin;
        $xtpl = new XTemplate($this->tpl);
        
        $item_on_page = 20;
        $list_all_hoidap = getHoiDapAjax(1, $item_on_page);
        
        $skin_path = base_url().'skin/'.$skin.'/';
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        
        $xtpl->assign('paging', $list_all_hoidap['pagging']);
        $xtpl->assign('html', $list_all_hoidap['html']);
        
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}

