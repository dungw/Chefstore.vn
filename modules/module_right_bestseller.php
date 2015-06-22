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
        	$allCategory = $miniCategory->getCatByType(2);
        } else if ($_SESSION['language'] == 'en') {
        	$allCategory = $miniCategory->getCatByType(2, 'ordering');
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

                    $xtpl->assign('parent_name', $value['name']);
                    $xtpl->assign('parent_id', $value['id']);

                    // generate sub menu
                    $children = $this->getByParent($allCategory, $value['id']);
                    if (!empty($children)) {
                        $countChild = 1;
                        $xtpl->assign('is_parent', 'parent');
                        foreach ($children as $child) {

                            //check count >= 2
                            if ($countChild > 1 && $countChild % 2 == 1) {
                                $xtpl->assign('divide', '</tr><tr>');
                            } else {
                                $xtpl->assign('divide', '');
                            }

                            $item['link'] = createLink('product', array('cid'=>$child['id'], 'name'=>$child['name']));
                            $item['name'] = $child['name'];
                            $item['active'] = ($cid == $child['id']) ? 'active' : '';

                            // get children of child
                            $units = $this->getByParent($allCategory, $child['id']);
                            if (!empty($units)) {
                                foreach ($units as $unit) {

                                    if ($cid == $unit['id']) {
                                        $xtpl->assign('active', 'active');
                                    }
                                    $u['active'] = ($cid == $unit['id']) ? 'active' : '';
                                    $u['link'] = createLink('product', array('cid'=>$unit['id'], 'name'=>$unit['name']));
                                    $u['name'] = $unit['name'];

                                    //get child
                                    $smallest = $this->getByParent($allCategory, $unit['id']);

                                    if (!empty($smallest)) {
                                        foreach ($smallest as $sm) {

                                            if ($cid == $sm['id']) {
                                                $xtpl->assign('active', 'active');
                                            }
                                            $s['active'] = ($cid == $sm['id']) ? 'active' : '';
                                            $s['link'] = createLink('product', array('cid'=>$sm['id'], 'name'=>$sm['name']));
                                            $s['name'] = $sm['name'];

                                            $xtpl->insert_loop('main.row.sub.unit.smallest', array('smallest' => $s));
                                        }
                                    }

                                    $xtpl->insert_loop('main.row.sub.unit', array('unit' => $u));
                                }
                            }
                            $countChild++;

                            $xtpl->insert_loop('main.row.sub', array('sub' => $item));
                        }
                    }

    				$xtpl->parse('main.row');                					
    			}

    		}					
    	}
    	
    	$xtpl->assign('lb_home', $lang['lb_home']);
    	$xtpl->assign('lb_our_product', $lang['lb_our_product']);
    	
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }

    /**
     * Get children from parent ID
     * @param $all
     * @param $parentID
     * @return array
     */
    public function getByParent($all, $parentID)
    {
        $children = array();
        if (!empty($all)) {
            foreach ($all as $item) {
                if ($item['parent_id'] == $parentID) {
                    $children[] = $item;
                }
            }
        }
        return $children;
    }
}


