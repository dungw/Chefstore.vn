<?php

/**
 * @author duchanh
 * @copyright 2012
 */

class module_navigation extends Module{
    
    function module_navigation(){
        $this->file = 'navigation.html';
        parent::module();
    }
    
    
    function getColumn($parent_id, $subcat){
        $max = 1;
        if(count($subcat)>0){
            foreach($subcat as $key=>$value){
                if($value['parent_id'] != $parent_id) continue;
                if($value['column'] > $max) $max = $value['column'];
            }
        }
        switch($max){
            case "1":
                return 'one'; 
            break;
            
            case "2":
                return 'two'; 
            break;
            
            case "3":
                return 'three'; 
            break;
            
            case "4":
                return 'four'; 
            break;
        }
        
        
        
    }
    
    function draw(){
        global $skin;
        $xtpl = new XTemplate($this->tpl);
        
        $skin_path  = base_url().'skin/'.$skin.'/';        
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        
        $xtpl->assign('link_all', base_url().'list-all');
        
        
        $miniCategory = new miniCategory();
        $category = $miniCategory->getCatByType(2);
        if(count($category)>0){
            $i = 0;
            $cot = 0;  
            foreach($category as $key=>$value){                
                if($value['parent_id']!=0) continue; // lay danh muc cap cao nhat
                $cot++;
                
                if($i==0){
                    $xtpl->assign('class','class="first"');    
                }
                $link = createLink('product',array('cid'=>$value['id'],'name'=>$value['name']));
                $xtpl->assign('link',$link);
                $xtpl->assign('name',$value['name']);
                
                $html_sub_menu = '';
                $subCat = $miniCategory->getSubCat($category,$value['id'],1);
                $html_sub_menu = '';
                
                $cols = $this->getColumn($value['id'],$subCat);
                
                if(count($subCat)>0){
                    $html_sub_menu = '<div class="submenu '.$cols.'-columns">';
                    
                    // left
                    $html_sub_menu .= '<div class="left-column">';
                    $html_sub_menu .= '<dl>';
                    foreach($subCat as $k=>$v){
                        if($v['column']==1){
                            $html_sub_menu .= '<dt><a href="'.createLink('product',array('cid'=>$v['id'],'name'=>$v['name'])).'">'.$v['name'].'</a></dt>';
                            $subSubCat = $miniCategory->getSubCat($category,$v['id'],1);  
                            foreach($subSubCat as $sub_key=>$sub_value){
                                $html_sub_menu .= '<dd><a href="'.createLink('product',array('cid'=>$sub_value['id'],'name'=>$sub_value['name'])).'">'.$sub_value['name'].'</a></dd>';
                            }     
                        }
                    }
                    
                    $html_sub_menu .= '</dl>';
                    $html_sub_menu .= '</div>';
                    
                    
                    switch($cols){
                        case "one":
                        break;
                        
                        case "two":
                            
                            //right
                            $html_sub_menu .= '<div class="right-column">';
                            $html_sub_menu .= '<dl>';
                            foreach($subCat as $k=>$v){
                                if($v['column']==2){
                                    $html_sub_menu .= '<dt><a href="'.createLink('product',array('cid'=>$v['id'],'name'=>$v['name'])).'">'.$v['name'].'</a></dt>';
                                    $subSubCat = $miniCategory->getSubCat($category,$v['id'],1);  
                                    foreach($subSubCat as $sub_key=>$sub_value){
                                        $html_sub_menu .= '<dd><a href="'.createLink('product',array('cid'=>$sub_value['id'],'name'=>$sub_value['name'])).'">'.$sub_value['name'].'</a></dd>';
                                    }   
                                }
                            }
                            
                            $html_sub_menu .= '</dl>';
                            $html_sub_menu .= '</div>';
                            
                        break;
                        
                        case "three":
                            //middle
                            $html_sub_menu .= '<div class="middle-column">';
                            $html_sub_menu .= '<dl>';
                            foreach($subCat as $k=>$v){
                                if($v['column']==2){
                                    $html_sub_menu .= '<dt><a href="'.createLink('product',array('cid'=>$v['id'],'name'=>$v['name'])).'">'.$v['name'].'</a></dt>';
                                    $subSubCat = $miniCategory->getSubCat($category,$v['id'],1);  
                                    foreach($subSubCat as $sub_key=>$sub_value){
                                        $html_sub_menu .= '<dd><a href="'.createLink('product',array('cid'=>$sub_value['id'],'name'=>$sub_value['name'])).'">'.$sub_value['name'].'</a></dd>';
                                    }     
                                }
                                
                            }
                            
                            $html_sub_menu .= '</dl>';
                            $html_sub_menu .= '</div>';
                            
                            
                            //right
                            $html_sub_menu .= '<div class="right-column">';
                            $html_sub_menu .= '<dl>';
                            foreach($subCat as $k=>$v){
                                if($v['column']==3){
                                    $html_sub_menu .= '<dt><a href="'.createLink('product',array('cid'=>$v['id'],'name'=>$v['name'])).'">'.$v['name'].'</a></dt>';
                                    $subSubCat = $miniCategory->getSubCat($category,$v['id'],1);  
                                    foreach($subSubCat as $sub_key=>$sub_value){
                                        $html_sub_menu .= '<dd><a href="'.createLink('product',array('cid'=>$sub_value['id'],'name'=>$sub_value['name'])).'">'.$sub_value['name'].'</a></dd>';
                                    }     
                                }
                            }
                            
                            $html_sub_menu .= '</dl>';
                            $html_sub_menu .= '</div>'; 
                        break;
                        
                        case "four":
                            //middle
                            $html_sub_menu .= '<div class="middle-column">';
                            $html_sub_menu .= '<dl>';
                            foreach($subCat as $k=>$v){
                                if($v['column']==2){
                                    $html_sub_menu .= '<dt><a href="'.createLink('product',array('cid'=>$v['id'],'name'=>$v['name'])).'">'.$v['name'].'</a></dt>';
                                    $subSubCat = $miniCategory->getSubCat($category,$v['id'],1);  
                                    foreach($subSubCat as $sub_key=>$sub_value){
                                        $html_sub_menu .= '<dd><a href="'.createLink('product',array('cid'=>$sub_value['id'],'name'=>$sub_value['name'])).'">'.$sub_value['name'].'</a></dd>';
                                    }    
                                }
                            }
                            
                            $html_sub_menu .= '</dl>';
                            $html_sub_menu .= '</div>';
                            
                            
                            $html_sub_menu .= '<div class="middle-column">';
                            $html_sub_menu .= '<dl>';
                            foreach($subCat as $k=>$v){
                                if($v['column']==3){
                                    $html_sub_menu .= '<dt><a href="'.createLink('product',array('cid'=>$v['id'],'name'=>$v['name'])).'">'.$v['name'].'</a></dt>';
                                    $subSubCat = $miniCategory->getSubCat($category,$v['id'],1);  
                                    foreach($subSubCat as $sub_key=>$sub_value){
                                        $html_sub_menu .= '<dd><a href="'.createLink('product',array('cid'=>$sub_value['id'],'name'=>$sub_value['name'])).'">'.$sub_value['name'].'</a></dd>';
                                    }     
                                }
                            }
                            
                            $html_sub_menu .= '</dl>';
                            $html_sub_menu .= '</div>';
                            
                            //right
                            $html_sub_menu .= '<div class="right-column">';
                            $html_sub_menu .= '<dl>';
                            foreach($subCat as $k=>$v){
                                if($v['column']==4){
                                    $html_sub_menu .= '<dt><a href="'.createLink('product',array('cid'=>$v['id'],'name'=>$v['name'])).'">'.$v['name'].'</a></dt>';
                                    $subSubCat = $miniCategory->getSubCat($category,$v['id'],1);  
                                    foreach($subSubCat as $sub_key=>$sub_value){
                                        $html_sub_menu .= '<dd><a href="'.createLink('product',array('cid'=>$sub_value['id'],'name'=>$sub_value['name'])).'">'.$sub_value['name'].'</a></dd>';
                                    }   
                                }
                            }
                            
                            $html_sub_menu .= '</dl>';
                            $html_sub_menu .= '</div>';
                        break;
                    }
                    
                    $html_sub_menu .= '</div>';   
                    
                }else{
                    $html_sub_menu = '';
                }
                    
                $xtpl->assign('html_sub_menu',$html_sub_menu);
                $xtpl->parse('main.row');
            }
        }    
        
        $xtpl->assign('link_giam_gia', base_url().'san-pham/san-pham-giam-gia.html');
        $xtpl->assign('link_spmoi', base_url().'san-pham/san-pham-moi.html');
        $xtpl->assign('link_banchay', base_url().'san-pham/san-pham-ban-chay.html');    
        
        $miniCategory = new miniCategory();
        $allCat = $miniCategory->getCatByType(2);
        if(count($allCat)>0){
            foreach($allCat as $key=>$value){
                if($value['parent_id']!=0) continue;
                $link = createLink('product',array('cid'=>$value['id'],'name'=>$value['name']));
                $xtpl->assign('link_category_other', $link);
                $xtpl->assign('name_category_other', $value['name']);
                $xtpl->parse('main.catall');
            }
        }
        
        
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}


