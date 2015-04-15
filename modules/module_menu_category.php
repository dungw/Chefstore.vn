<?php

/**
 * @author duchanh
 * @copyright 2012
 */

class module_menu_category extends Module{    
    
    
    function module_menu_category(){
        $this->file = 'menu_category.html';
        parent::module();
    }
    
    function draw(){
        global $skin;  
        $cur_catid = CInput::get('cat','int',0);      
        $xtpl = new XTemplate($this->tpl);
        
        $miniCategory = new miniCategory();
        $arrCat = $miniCategory->getCatByType(2);
        if(is_array($arrCat) && count($arrCat)>0){            
            $class_active =  '';
            foreach($arrCat as $key=>$value){               
                if($value['parent_id']==0){
                    $link = createLink('product',array('cat'=>$value['id']));
                    $xtpl->assign('link',$link);
                    $xtpl->assign('name',$value['name']);
                    foreach($arrCat as $k=>$sub){
                        if($sub['parent_id'] == $value['id']){
                            $link = createLink('product',array('cat'=>$value['id']));
                            $xtpl->assign('link',$link);
                            $xtpl->assign('name',$value['name']);
                            $xtpl->parse('main.menu.submenu');     
                        }
                    }
                    $xtpl->parse('main.menu');     
                }
            }
        }
             
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
    

    
}
