<?php

/**
 * @author duchanh
 * @copyright 2012
 */ 

?>

<!------- drag and drop -------->
<script src="js/jquery/jquery-1.4.1.min.js" type="text/javascript"></script>
<script src="js/jquery/ui.core.js" type="text/javascript"></script>
<script src="js/jquery/ui.checkbox.js" type="text/javascript"></script>
<script src="js/jquery/jquery.bind.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="css/drag_drop.css" />
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js" ></script>
<script type="text/javascript" src="js/drags_drop_config.js" ></script>
<script src="js/jquery/custom_jquery.js" type="text/javascript"></script>   

<?php

function ListAllPage(){
	global $oDb,$lang;
    $miniPage   = new miniPage();
    $allPage    = $miniPage->getAll();     
    $order = CInput::get('order','txt','asc');
    $sort  = CInput::get('sort','txt','');
    $page	= CInput::get("page","int",1);
    
    
    /// begin conditions
    $con = "";
    
    $total_row = $miniPage->count($con);    
    $total_page = round($total_row/$miniPage->num_per_page);
    $pagging = getHtmlPagging($page,$total_page,curPageURL());
    /// end conditions
    
    if($order == 'desc'){
        $order = 'asc';
    }else if($order == 'asc'){
        $order = 'desc';
    }
    
    if($sort && $order){
        $page = $miniPage->getPage($con,$sort,$order,$page);            
    }else{
        $page = $miniPage->getPage($con,false, false,$page);
    }
    
    $link = 'index.php?f=module';
    
    echo '<div class="table-list">
            <table>
                <tbody>
                    <tr>
                        <th class="check-cols">&nbsp;</th>
                        <th><a href="'.$link.'&sort=name&order='.$order.'">Tên trang </a></th>
                        <th><a href="#">Module</a></th>
                    </tr>';
                         
                    foreach($page as $key=>$value){
                        $position = json_decode($value['position']);
                        $str_pos = '';
                        foreach($position as $pos=>$arrModule){
                            foreach($arrModule as $module){
                                if($module=='') continue;
                                $str_pos .= '<strong>'.$module.'</strong>, ';    
                            }
                        }
                        echo '<tr>
                                <td class="check-cols"></td>
                                <td><a href="'.$link.'&cmd=edit&id='.$value['id'].'">'.$value['name'].'</a></td>
                                <td>'.trim($str_pos,',').'</td>
                            </tr>';
                        
                    }     
                                                    
                    	
                echo '</tbody>
            </table>
        </div>';
    
    
    
 
    
}

function EditPage($id = 0){
	
	global $oDb, $lang,$skin;
    $miniPage  = new miniPage();
    $allPage     = $miniPage->getAll();    
	if($id > 0){        
        $miniPage->read($id);                
       	$name           = $miniPage->name;
        $layout         = $miniPage->layout;
        $position       = $miniPage->position;
        $parent         = $miniPage->parent;
        $meta_title         = $miniPage->meta_title;
        $meta_keyword       = $miniPage->meta_keyword;
        $meta_description   = $miniPage->meta_description;        
	}else{
        $name           = "";
        $layout         = "home.html";
        $position       = "";
        $parent         = 1;
        $meta_title         = "";
        $meta_keyword       = "";
        $meta_description   = "";
	}
    
    $listPos = getPositionLayout($layout);
    $position = json_decode($position,true);
    if(count($position)>0){
        $allPos = array_merge_recursive($listPos, $position);    
    }else{
        $allPos = $listPos;
    }    
    

        
    $html_drag_left_colum = '<div class="wrap_drag" id="list_pos">';    
    if(count($allPos)){
        foreach($allPos as $pos=>$module){
            if(count($module)>0){
                $html_drag_left_colum .= '<div class="column" id="'.$pos.'">';
                $html_drag_left_colum .= '<h1>'.$pos.'</h1>';
                if(count($module)>0 && is_array($module)){
                    foreach($module as $key=>$value){
                        if($value==''){
                            continue;
                        }
                        $html_drag_left_colum .= 
                        '<div class="dragbox" id="'.$value.'" >
                			<h2>'.$value.'</h2>
                			<div class="dragbox-content" ></div>
                		</div>';
                    }   
                }
                $html_drag_left_colum .= '</div><hr/>';
            }
        }
    }    
    $html_drag_left_colum .= '</div>';
    
    $module_dir = '../modules/';
    $list_module = getListFileInFolder($module_dir);
    
    $layout_dir = "../skin/$skin/layout/";
    $list_layout = getListFileInFolder($layout_dir);
    
    $html_drag_right_colum = '<div class="column wrap_drag" id="all_module">';
    $html_drag_right_colum .= '<h1>'.$lang['all_module'].'</h1>';
    foreach($list_module as $key=>$value){
        if(strpos($value,'.php')){
            $module_name = substr($value,0,-4);
            $html_drag_right_colum .= '
                <div class="dragbox" id="'.$module_name.'" >
        			<h2>'.$module_name.'</h2>
        			<div class="dragbox-content">abc</div>
        		</div>';
        }
    }
    $html_drag_right_colum .= '</div>';
    
    
    echo '<div class="table-list">
            <table>
                <tbody>
                    <tr>
                        <td>'.$html_drag_left_colum.$html_drag_right_colum.'</td>
                    </tr>
                </tbody>
            </table>
        </div>';
   
            
}



function SavePage(){
		
	global $oDb;
    $submenu		= CInput::get("submenu","txt","");    
   
	$miniPage = new miniPage();
    
    $id             = CInput::get("id","int",0); 
    $name           = CInput::get("name","txt","");   
    $layout         = CInput::get("layout","txt","");
    $position       = CInput::get("position","con","");   
    $parent         = CInput::get("parent","int",1);
    $meta_title     = CInput::get("meta_title","txt","");
    $meta_keyword   = CInput::get("meta_keyword","txt","");
    $meta_description         = CInput::get("meta_description","txt","");
    
        
    $miniPage->name             =   $name;
    $miniPage->layout           =   $layout;    
    $miniPage->parent           =   $parent;
    $miniPage->meta_title       =   $meta_title;
    $miniPage->meta_keyword     =   $meta_keyword;
    $miniPage->meta_description =   $meta_description;
    
	if($id == 0 ){	
		$id = $miniPage->insert();
	}else {	   
        $miniPage->update($id, array("name","layout","parent","meta_title","meta_keyword","meta_description"));
       
	}
	
	redirect("index.php?submenu=$submenu");
}


function DeletePage(){
	
	global $oDb;
	
	$submenu		= CInput::get("submenu","txt","");
	$id		= CInput::get("cid","int",0);
	
	if($id >0)
	{
		$sql	= "DELETE FROM tbl_Page WHERE id = $id";
		$oDb->query($sql);
	}
    
	redirect("index.php?submenu=$submenu");
}



$cmd	= CInput::get("cmd","txt","");

switch ($cmd){
	
	case "add":
		EditPage(0);
		break;
	
	
	case "edit":
		$id 	= CInput::get("id","int",0);
		EditPage($id);
		break;
		
	case "save":
		SavePage();
		break;
		
	case "delete":
		DeletePage();
		break;
        
	case "list":
	default:
		ListAllPage();
		break;
	
}



function getNameOfParrentPage($allPage, $pid){
    foreach($allPage as $key=>$value){
        if($value['id']==$pid){
            return $value['name'];
        }
    }
}


function getNameLayout($name_seleccted){
    global $skin;
    $layout_dir = "../skin/$skin/layout";
    $list_layout = scandir($layout_dir);
    unset($list_module[0],$list_module[1]);
    if(count($list_layout)>0){
        foreach($list_layout as $key=>$layout){
            
        }
    }    
}

function getListFileInFolder($dir){    
    $list_file = scandir($dir);
    unset($list_file[0],$list_file[1]);
    return $list_file;
}


function getPositionLayout($layout){
    global $skin;
    $layout_path = "../skin/$skin/layout/$layout";
    if(file_exists($layout_path)){
        $lo = file_get_contents($layout_path);    
    }else{
        $layout = substr($layout,0,-1);
        $layout_path = "../skin/$skin/layout/$layout";
        $lo = file_get_contents($layout_path);  
    }        
        
    preg_match_all('/<!--pos_(.*?)-->/',$lo,$arrPos);
    $arrPos = $arrPos[1];    
    $listPos = array();
    if(count($arrPos)>0){        
        foreach($arrPos as $key=>$pos){
            $listPos['pos_'.$pos] = '';
        }
    }
    return $listPos;
}


function getHtmlOptionLayout($allLayout, $cur_layout = ''){
    $html = '';  
    if (is_array($allLayout) && count($allLayout) > 0) {        
        foreach ($allLayout as $key => $value) {
            $selected = '';
            if ($value == $cur_layout) {
                $selected = 'selected=""';                
            }
            $html .= '<option value="' . $value . '" ' . $selected . '>' .$value .'</option>';
        }
    }
    return $html;
}

?>