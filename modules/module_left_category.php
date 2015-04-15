<?php

/**
 * @author duchanh
 * @copyright 2012
 * @desc module list html of introduction
 */
 
class module_left_category extends Module{
    
    function module_left_category(){
        $this->file = 'left_category.html';
        parent::module();
    }
    
    
    function draw(){
        global $skin;
        $xtpl = new XTemplate($this->tpl);
        // type = 1 is news category, 
        // type = 2 is product category
        // type = 3 images category  
        $type = 2;
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        $parent_id = CInput::get('cid','int',0);
        $miniCategory = new miniCategory();
        var_dump($_SESSION['language']);die;
        if ($_SESSION['language'] == 'vi') {
        	$allCategory = $miniCategory->getCatByType($type);
        } else if ($_SESSION['language'] == 'en') {
        	$allCategory = $miniCategory->getCatByType($type, 'ordering');
        }
        
        if(count($allCategory)>0){
            foreach($allCategory as $key=>$value){
                if($value['parent_id'] != $parent_id){
                    continue;
                }
                if($type==1){
                    $link = createLink('news',array('cid'=>$value['id'],'name'=>$value['name']));    
                }else if($type==2){
                    $link = createLink('product',array('cid'=>$value['id'],'name'=>$value['name']));
                }else if($type==3){
                    $link = createLink('images',array('cid'=>$value['id'],'name'=>$value['name']));
                }
                $xtpl->assign('link',$link);
                $xtpl->assign('name',$value['name']);
                $xtpl->parse('main.category');            
            }
        }
        
        $xtpl->parse('main');
        return $xtpl->out('main');    
        
    }
    
}
