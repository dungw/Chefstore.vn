<?php 
//if(!defined('ALLOW_ACCESS')) exit('No direct script access allowed');

/**
 * @author duchanh
 * @copyright 2012
 */


class module_aboutus extends Module{
    
    function module_aboutus(){
        $this->file = 'aboutus.html';
        parent::module();
    }
    
    function draw(){
    	
        global $skin, $lang;
        $xtpl = new XTemplate($this->tpl);
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        
        $id = CInput::get('id','int',0);
        if ($id) {
            $this->table = 'tbl_aboutus';
            $data = $this->get('name, content',' AND id = '.$id);
            $value = $data[0];
            $xtpl->assign('name', $value['name']);
            $xtpl->assign('content',stripslashes($value['content']));
        }
        
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}


