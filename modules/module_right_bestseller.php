<?php
/**
 * @author duchanh
 * @copyright 2012
 */
class module_right_bestseller extends Module{
    
    function module_right_bestseller(){
        $this->file = 'right_bestseller.html';
        parent::module();
    }
    function draw(){
        global $skin, $arrPrice, $lang;
        
        $xtpl = new XTemplate($this->tpl);
        $skin_path  = base_url().'skin/'.$skin.'/';
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
    	$miniCategory = new miniCategory();
    	
		if ($_SESSION['language'] == 'vi') {
        	$allCategory = $miniCategory->getCatByType(0);
        } else if ($_SESSION['language'] == 'en') {
        	$allCategory = $miniCategory->getCatByType(0, 'ordering');
        }
    	
    	if ($_GET['cid'] > 0) $cid = $_GET['cid'];
    	
    	// Get parent
    	$parentID = 0;
    	foreach ($allCategory as $item) {
    		if ($item['id'] == $cid) {
    			$parentID = $item['parent_id'];
    		}
    	}
    	
    	if (count($allCategory) > 0) {
    		foreach ($allCategory as $key=>$value) {
    			if (intval($value['parent_id']) == 0) {
    				if (intval($cid) == $value['id'] || $value['id'] == $parentID) {
    					$xtpl->assign('active', 'active');
    				} else {
    					$xtpl->assign('active', '');
    				}
    				
    				$link = createLink('product', array('cid'=>$value['id'], 'name'=>$value['name']));
    				$xtpl->assign('link',$link);
    				$xtpl->assign('name',$value['name']);						                
    				$xtpl->parse('main.row');                					
    			}
    			
    		}					
    	}
    	
    	$xtpl->assign('lb_home', $lang['lb_home']);
    	$xtpl->assign('lb_our_product', $lang['lb_our_product']);
    	
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}


