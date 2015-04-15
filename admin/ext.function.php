<?php
	
/**
 * @author duchanh
 * @copyright 2012
 */
     
function remove_sign($str) {
		$str= remove_sign_1($str);
		
		$str=str_replace(array('–','…','“','”',"~","!","@","#","$","%","^","&","*","/","\\","?","<",">","'","\"",":",";","{","}","[","]","|","(",")",",",".","`","+","=","-"),"",$str);
		$str = preg_replace("/[^_A-Za-z0-9- ]/i",'', $str);
		
	return strtolower($str);
	}
	
	function remove_sign_1($str){
		$str=str_replace(array("à","á","ạ","ả","ã","ă","ằ","ắ","ặ","ẳ","ẵ","â","ầ","ấ","ậ","ẩ","ẫ"),"a",$str);
		$str=str_replace(array("À","Á","Ạ","Ả","Ã","Ă","Ằ","Ắ","Ặ","Ẳ","Ẵ","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ"),"A",$str);
		$str=str_replace(array("è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ"),"e",$str);
		$str=str_replace(array("È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ"),"E",$str);
		$str=str_replace("đ","d",$str);
		$str=str_replace("Đ","D",$str);
		$str=str_replace(array("ỳ","ý","ỵ","ỷ","ỹ","ỹ"),"y",$str);
		$str=str_replace(array("Ỳ","Ý","Ỵ","Ỷ","Ỹ"),"Y",$str);
		$str=str_replace(array("ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ"),"u",$str);
		$str=str_replace(array("Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ"),"U",$str);
		$str=str_replace(array("ì","í","ị","ỉ","ĩ"),"i",$str);
		$str=str_replace(array("Ì","Í","Ị","Ỉ","Ĩ"),"I",$str);
		$str=str_replace(array("ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ","ờ","ớ","ợ","ở","ỡ"),"o",$str);
		$str=str_replace(array("Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ","Ờ","Ớ","Ợ","Ở","Ỡ"),"O",$str);
		return $str;
	}
	
	function getAddress(){
		$adr = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
		$adr .= isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST');
		$adr .= isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : getenv('REQUEST_URI');
	return $adr;
	}
	
	function getIP(){
		$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : getenv('REMOTE_ADDR');
	return $ip;
	}
	
    /*
	function redirect($strUrl, $intTime=0){
		//echo "<meta http-equiv='Refresh' content='".$intTime."; url=".$strUrl."'/>";
		Header("Location: ".$strUrl);
	}
    */
	
	function print_date($date){
		$input_date = explode(" ",trim($date));
		
		$in_date = explode("-",$input_date[0]);
		$in_date = $in_date[2] ."-". $in_date[1] ."-". $in_date[0];
		
		$in_time = explode(':', $input_date[1]);
		$in_hour = $in_time[0];
		$in_minute = $in_time[1];
		$in_second = $in_time[2];
		
		
		$date_now = date('d-m-Y');
		$hour_now = date('H');
		$minute_now = date('i');
		$second_now = date('s');
		
		if($date_now==$in_date){
			if($in_hour==$hour_now){
				if($in_minute==$minute_now){
					$date_output = (int)$second_now - (int)$in_second;
					$date_output = $date_output ." giây trước";
				}else{
					$date_output = (int)$minute_now - (int)$in_minute;
					$date_output = $date_output ." phút trước";
				}
			}else{
				$date_output = (int)$hour_now - (int)$in_hour;
				$date_output = $date_output ." giờ trước";
			}
		}else{
			$date_output = $in_date; //." &nbsp;". implode(":",$in_time);
		}
		
		return $date_output;
	}
	
	function post_not_found($config){
		$addr = getAddress();
		$check = $config->dbo->query("select * from #__logs where `url`='". addslashes(str_replace('-',' ',$addr)) ."'");
		if($check->num_rows == 0){
			$config->dbo->query("Insert into #__logs(`title`,`url`,`date`) values('Bài viết không tồn tại','". addslashes(str_replace('-',' ',$addr)) ."','". date('Y-m-d H:i:s') ."')");
		}
	}
	
	function clear_favorite(){
		$_SESSION['favorite-post'] = null;
	}
	
	function isfavorite_post($id){
		if(isset($_SESSION['favorite-post'][$id])){
			return true;
		}else{
			return false;
		}
	}
	
	function price($str){
		$output = preg_replace("/[^0-9]/","",$str);
		$arr = str_split($output);
		$count = 0;
		$result = "";
		for($i=sizeof($arr)-1;$i>=0;$i--){
			if($arr[$i]!=""){
			$count++;
			$result = $arr[$i] . $result;
			if(($count >= 3)&&($i>0)){
				$count = 0;
				$result = ",". $result;
			}
			}
		}
		return $result;
	}
	
	function cal_date($date,$num_day,$format = 'Y-m-d H:i:s'){
		$newdate = strtotime( $num_day .' day' , strtotime ( $date ) ) ;
		$newdate = date ( $format , $newdate );
		return $newdate;
	}
    
    
    function getCountry(){
        global $oDb;
        $arr_country	= array();
        
        $sql = "SELECT `id`, `name` FROM tbl_country WHERE 1 ORDER BY id ";
        $rs = $oDb->query($sql);
                                
		while ($rc = $oDb->fetchArray($rs)){				
			$name			            = $rc['name'];
			$id 						= $rc['id'];
			$arr_country[$id]		= $name;
		}
        return $arr_country;
    }
    
    
    function getParentCategory($parent_id = 0){
        global $oDb;
        $arr_category	= array();
        
        $sql = "SELECT `id`, `name` FROM tbl_category WHERE 1 AND `parent_id` =  $parent_id ";           
        $sql .= 'ORDER BY name ASC ';

        $rs = $oDb->query($sql);
        $arr_category[0] = 'Trang chủ';  
                               
		while ($rc = $oDb->fetchArray($rs)){				
			$name			            = $rc['name'];
			$id 						= $rc['id'];
			$arr_category[$id]		= $name;
		}
        return $arr_category;
    }
    
    function getCateByCate($cid) {
    	global $oDb;
    	
    	$sql = 'SELECT * FROM tbl_category WHERE id IN ('. $pid .') ORDER BY id';
    	$rs = $oDb->query($sql);
    	$allCat = $oDb->fetchAll($rs);
    	return $allCat;
    }
    
    function getCategory(){
        global $oDb;
        $arr_category	= array();
        $arr_category[0] = 'Trang chủ';  
        
        $sql = "SELECT `id`, `name`, `parent_id` FROM tbl_category WHERE 1 ";           
        $sql .= 'ORDER BY name ASC ';

        $rs = $oDb->query($sql);
        $allCat = $oDb->fetchAll($rs);
        foreach($allCat as $key=>$value){
            if($value['parent_id']==0){
                $name			            = $value['name'];
				$id 						= $value['id'];
				$arr_category[$id]		= $name;
                
                // sub1
                foreach($allCat as $key1=>$value1){
                    if($value1['parent_id']==$value['id']){
                        $name			            = '-----'.$value1['name'];
        				$id 						= $value1['id'];
        				$arr_category[$id]		= $name;
                        
                        // sub2
                        foreach($allCat as $key2=>$value2){
                            if($value2['parent_id']==$value1['id']){
                                $name			            = '----------'.$value2['name'];
                				$id 						= $value2['id'];
                				$arr_category[$id]		= $name;
                                
                                // sub3
                                foreach($allCat as $key3=>$value3){
                                    if($value3['parent_id']==$value2['id']){
                                        $name			            = '---------------'.$value3['name'];
                        				$id 						= $value3['id'];
                        				$arr_category[$id]		= $name;
                                    }
                                }
                            }
                        }
                    }
                }
                
            }
        }
       
        return $arr_category;
    }
    
    
    function getNewsCategory(){
        global $oDb;
        $arr_category	= array();
        $arr_category[0] = 'Trang chủ';  
        
        $sql = "SELECT `id`, `name`, `parent_id` FROM tbl_news_category WHERE 1 ";           
        $sql .= 'ORDER BY name ASC ';

        $rs = $oDb->query($sql);
        $allCat = $oDb->fetchAll($rs);
        foreach($allCat as $key=>$value){
            if($value['parent_id']==0){
                $name			            = $value['name'];
				$id 						= $value['id'];
				$arr_category[$id]		= $name;
                
                // sub1
                foreach($allCat as $key1=>$value1){
                    if($value1['parent_id']==$value['id']){
                        $name			            = '-----'.$value1['name'];
        				$id 						= $value1['id'];
        				$arr_category[$id]		= $name;
                        
                        // sub2
                        foreach($allCat as $key2=>$value2){
                            if($value2['parent_id']==$value1['id']){
                                $name			            = '----------'.$value2['name'];
                				$id 						= $value2['id'];
                				$arr_category[$id]		= $name;
                                
                                // sub3
                                foreach($allCat as $key3=>$value3){
                                    if($value3['parent_id']==$value2['id']){
                                        $name			            = '---------------'.$value3['name'];
                        				$id 						= $value3['id'];
                        				$arr_category[$id]		= $name;
                                    }
                                }
                            }
                        }
                    }
                }
                
            }
        }
       
        return $arr_category;
    }
    
    
    
    function getProduct(){
        global $oDb;
        $arr_category	= array();
        
        $sql = "SELECT `id`, `name` FROM tbl_product WHERE 1 ";           
        $sql .= 'ORDER BY name ASC ';

        $rs = $oDb->query($sql);
		while ($rc = $oDb->fetchArray($rs)){				
			$name			            = $rc['name'];
			$id 						= $rc['id'];
			$arr_category[$id]		= $name;
		}
        return $arr_category;
    }
    
    
    function getLevel(){
        global $oDb;
        $arr	= array();
        $sql = "SELECT `id`, `name` FROM tbl_level WHERE 1 ";          
        $sql .= 'ORDER BY id';

        $rs = $oDb->query($sql);
                                
		while ($rc = $oDb->fetchArray($rs)){				
			$name			            = $rc['name'];
			$id 						= $rc['id'];
			$arr[$id]		= $name;
		}
        return $arr;
    }
    
    
    function getProductImages($pid){
        global $oDb;
        $sql = "SELECT * FROM  `tbl_product_images` WHERE `product_id` = $pid ";
        $query = $oDb->query($sql);
        $ressult = $oDb->fetchAll($query);
        return $ressult;
    }
    
    
    function deleteProductImages($id){
        global $oDb;
        $sql = "SELECT * FROM  `tbl_product_images` WHERE `id` = $id ";
        $query = $oDb->query($sql);
        $ressult = $oDb->fetchAll($query);
        $product_images = $ressult[0];
        
        $image = '..'.$product_images['images'];             
        if(file_exists($image)){
            @unlink($image);
        }
        
        $thumb = '..'.getSmallImages($product_images['images'],'thumb');
        if(file_exists($thumb)){
            @unlink($thumb);
        }
        
        $small = '..'.getSmallImages($product_images['images'],'small');
        if(file_exists($small)){
            @unlink($small);
        }
        
         
        
        $sql = "DELETE FROM `tbl_product_images` WHERE `tbl_product_images`.`id` = $id LIMIT 1";
        $oDb->query($sql);
    }
    
    
    
    function order($list_id){
        $listId = json_decode($list_id);
        $base = new base();
        $base->table = 'tbl_product';
        $content = '';
        if(count($listId)<=0) return '';
        foreach($listId as $id=>$num){
            $product = $base->get('*',false,false,0,1);
            $product = $product[0];
            $content .= '<a target="_blank" href="'.createLink('product_detail',array('id'=>$id,'name'=>$product['name'])).'"> - '.$product['name'].'</a>&nbsp;(<strong>'.$num.'</strong>)<br/>';
        }
        
        return $content;
        
    }
    
    
    function product_comment($id){
        $base = new base();
        $base->table = 'tbl_product';
        $product = $base->get('*'," AND id = $id ",false,0,1);
        $product = $product[0];
        $content .= '<a target="_blank" href="'.createLink('product_detail',array('id'=>$id,'name'=>$product['name'])).'"> - '.$product['name'].'</a>';
        
        return $content;
        
    }
    
    
    
    function order_print($value){
        $link = 'print_order.php?id='.$value;
        $content = '<a href="'.$link.'" target="_blank"><img src="images/print.png" alt="In" title="In"></a>';
        return $content;
    }
	
?>