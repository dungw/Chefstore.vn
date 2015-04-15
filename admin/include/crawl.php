<?php

/**
 * @author duchanh
 * @copyright 2012
 */

$act 	= $_REQUEST['act'];
switch ($act){
	
	case 'import':
		ImportData();
		break;
        
    case 'update_image':
		updateImage();
		break;
        
    case 'test':
		test();
		break;
	
    
	case 'list':
	default:
		ListData();
		break;
		
}

/**
 * Liet ke danh sach cacs quest
 *
 */
function ListData(){
	//array('id', 'name','logo','wins','loses','champions','list_players');
	echo '<div style="color:red; text-align:center;">'.$_REQUEST['msg'].'</div>';
	echo '<div class="table-list">';
	
	echo "
		<div style='text-align:right; padding-right:20px;'>
			<form action='index.php?f=crawl&act=import' method = 'POST' enctype='multipart/form-data'>
				<label><b>Chọn file dữ liệu</b></label>
				<input type='hidden' name='MAX_FILE_SIZE' value='2000000' />
				<input type='file' name='file' />
				<input type='submit' value='Upload' />
			</form>
		</div>";
	

	
}

/**
 * Import du lieu tu file excel
 *
 */
function ImportData(){
    
    include(INC_PATH."classes/DomDocument.php");
    include(INC_PATH."classes/simple_html_dom.php");
	
	global $sitePath, $oDb;
	
    $data = array();
    $arrField = array();
	if ( $_FILES['file']['tmp_name'] )
  	{    
        $content = file_get_contents($_FILES['file']['tmp_name']); 
        $dom = new simple_html_dom;
        $dom->load($content);
        $i=0;
        foreach($dom->find('tr') as $Row){
            $i++;
            if($i==1){
                foreach($Row->find('td') as $Cell){
                    $arrField[] = $Cell->innertext;
                } 
            }else{
                $tmp = array();
                $field = 0;
                foreach($Row->find('td') as $Cell){
                    $tmp[$arrField[$field]] = $Cell->innertext;
                    $field++;
                }
                if($tmp && count($tmp)>0){
                    $data[] = $tmp;
                }                    
            }
            
        }
        
        // xóa db
        $sql = 'TRUNCATE TABLE `tbl_product';
        $oDb->query($sql);
                
        foreach($data as $key=>$value){
            $miniProduct = new miniProduct();
            $id = $value['id'];            
            unset($value['id']);
            
            foreach($value as $field=>$v){
                if($field!=''){
                    $miniProduct->$field = strip_tags($v);    
                }                 
            }                
            $miniProduct->insert();    
        }
        
        // update lại anh
        updateImage();
        // xoa thumb trong duong dan anh
        test();
        echo "Up thành công";
        exit;
    
  	}
  	
  	//header("Location: $sitePath/index.php?f=crawl&msg=Hoàn thành");
}


function updateImage(){
    global $oDb;
    $sql = "SELECT id, img FROM tbl_product WHERE 1";
    $rc = $oDb->query($sql);
    $rs = $oDb->fetchAll($rc);
    
    $sql = 'TRUNCATE TABLE `tbl_product_images';
    $oDb->query($sql);
    
    foreach($rs as $key=>$value){
        $pid = $value['id'];
        $img = $value['img'];    
        
        $img = explode('|',$img);                
        foreach($img as $k=>$v){            
            if($v=='') continue;
            $miniProductImage = new miniProductImages();
            $miniProductImage->product_id = $pid;
            $miniProductImage->images = $v;
            $miniProductImage->ordering = 1;
            $miniProductImage->default = 1;
            $miniProductImage->status = 1;
            $miniProductImage->insert();
        }        
    }
}


function test(){
    global $oDb;
    $sql = "SELECT * FROM tbl_product_images where 1";    
    $rc1 = $oDb->query($sql);
    $rs1 = $oDb->fetchAll($rc1);
    
    foreach($rs1 as $key=>$value){
        $image = $value['images'];
        $image = str_replace('thumb300','',$image);
        $image = str_replace('thumb50','',$image);
        
        $miniProductImage = new miniProductImages();
        $miniProductImage->images = $image;
        $miniProductImage->update($value['id'],array('images'));
    }
    
    
    
}


?>