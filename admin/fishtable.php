<?php

/**
 * @author duchanh
 * @copyright 2012
 */

/*	
	
	Type:
		- input:text
        - input:readonly
		- input:image
        - input:pimage  //edit by HanhND
		- input:int10
		- input:price
		- input:password
		- textarea
        - textarea:noeditor     // edit by HanhND
		- checkbox
		- combobox:relate:int
		- checkbox:relate:int
		- datetime:current
        - function          // edit by HanhND
	Attribute
		- title
		- required
		- editlink
		- searchable
		- label
		- unlabel
		- relate
		- editable
		- show_on_list
		- separator
		- sufix_title
		- rows
        - data
        - function
	
*/
    date_default_timezone_set('Asia/Saigon');
    
	class FishTable extends Base{
		public $name = "bản ghi";
		public $column = array();
		public $idField = null;
		public $action = array();
		public $showAddButton = true;
		public $rop = 50;
		public $totalPage = 0;
		public $totalRow = 0;
		public $mylevel = 1;
		public $info = "";
        public $showfooter = true;
        public $hasParrent = false;
		
		public $headBackground = "#009bdc";
		
		public function __construct($table,$column,$idField){
			global $oDb;
			$this->mylevel = (int)$_SESSION['admin']['level'];
			$this->pk = $idField;
			$this->fields = array();
			$this->key_prefix = $table .'_';
			
			
			$this->fields[] = $idField;
			foreach($column as $k => $v){
				$this->fields[] = $k;
				$this->$k = '';
			}
			
			$this->table = $table;
			$this->column = $column;
			$this->idField = $idField;
		}
		
		public function showList(){
				global $oDb;
				$strQuery = "select * from ". $this->table;
				
				if(isset($_POST['search-input'])&& $_POST['search-input']!=""){
					$keyword = htmlspecialchars(addslashes($_POST['search-input']));
					$_SESSION['search-input'] = $keyword;
					if($_POST['search-column']!=""){
                        $column_att = NULL;
					    foreach($this->column as $column_name=>$att){
					       if($column_name == $_POST['search-column'])
                           $column_att = $att;
					    }
                        if($column_att!= NULL && isset($column_att['data'])){
                            foreach($column_att['data'] as $key=>$value){
                                if($keyword == $value){
                                    $where = " where `". $_POST['search-column'] ."` like '%". $key ."%' ";        
                                }else{
                                    $where = " where `". $_POST['search-column'] ."` like '%". $keyword ."%' ";    
                                }
                            }   
                        }else{
                            $where = " where `". $_POST['search-column'] ."` like '%". $keyword ."%' ";    
                        }
						
					}else{
						$where = " where `". $this->idField ."`='%". (int)$keyword ."%' ";
					}
					
					$strQuery .= $where;
				}
				
				if(isset($_POST['orderby']) && $_POST['orderby']!=""){
					$order = $_POST['orderby'];
					$_SESSION[$this->table ."-page"]['order'] = $order;
					if($_POST['orderby_dir']=="DESC"){
						$order_dir .= " DESC";
						$_SESSION[$this->table ."-page"]['order_dir'] = "DESC";
					}else{
						$order_dir .= " ASC";
						$_SESSION[$this->table ."-page"]['order_dir'] = "ASC";
					}
				}else if($this->hasParrent == true){
				    $order = $_SESSION[$this->table ."-page"]['order'];
				    $order = $this->hasParrent;
				    $_SESSION[$this->table ."-page"]['order'] = $order;
				} else{
					$order = $_SESSION[$this->table ."-page"]['order'];
					if($order==""){
						$order = $this->idField;
						$_SESSION[$this->table ."-page"]['order'] = $order;
					}
					$order_dir = $_SESSION[$this->table ."-page"]['order_dir'];
					if($order_dir==""){
						$order_dir = "DESC";
						$_SESSION[$this->table ."-page"]['order_dir'] = "DESC";
					}
				}
				
				$strQuery .= " order by `". trim($order) ."` ". $order_dir;
				//tinh so trang
				$page = isset($_POST['current_page']) ? intval($_POST['current_page']) : 0;
				if($page==0){
					$page = $_SESSION[$this->table ."-page"]['page'];
					if($page==0){
						$page=1;
					}
				}
				$_SESSION[$this->table ."-page"]['page'] = $page;
				
				$limit = ($page-1) * $this->rop;
				
				$data = $oDb->query($strQuery . " limit ". (int)$limit .",". $this->rop);
				$data_total = $oDb->query($strQuery);
				
				
				$totalRow = $oDb->numRows($data_total);
				
				$totalPage = (int)($totalRow/$this->rop);
				if($totalRow % $this->rop >0){
					$totalPage++;
				}
				$this->totalPage = $totalPage;
				$this->totalRow = $totalRow;
				
				$this->printHead();
				$this->printRow($data);
                
                if($this->showfooter){
                    $this->printFooter();    
                }
		}
		
		public function printHead(){
			echo '<h2 class="broad-title">'. $this->name .'</h2>
					<span>'. $this->info .'</span>
					<div class="table-stat">
						Số bản ghi: <h1>'. $this->totalRow .'</h1> <br>
						Trang <b>'. $_SESSION[$this->table ."-page"]['page'] .'</b> trên tổng '. $this->totalPage .' trang
					</div>';
			echo "<form name='frm' id='frm' action='index.php?f=". htmlspecialchars($_GET['f']) ."' method='post'>";
			echo "<input type='hidden' name='listID' id='listID' value='0' />";
			echo "<input type='hidden' name='listName' id='listName' value='". $this->name ."' />";
			echo "<input type='hidden' name='action' id='action' value='view' />";
            
            // header
            echo '<div class="bottom_bar">';
			if($this->mylevel>1){
				echo '<input type="checkbox" id="checkAll" class="checkAll"> 
                      <input type="button" id="btnDelete" class="btnDelete" value="Xóa" />';                
                if($this->showAddButton){
					echo '<button id="btnNew" class="btnNew">Thêm</button>';
				}
				      
			}
			echo "<div class='pagination-right'>". $this->getPagination($this->totalPage) ."</div>";
			echo "</div>";
            
			echo "<div class='top_bar'><input type='text' size='30' name='search-input' value='". htmlspecialchars(isset($_REQUEST['search-input'])? $_REQUEST['search-input']:"") ."' /><select name='search-column'>";
			foreach($this->column as $key => $value){
			     $selected = '';
                 if(isset($_REQUEST['search-column']) && $_REQUEST['search-column']==$key){
                       $selected = 'selected=""';
                 }
                
				 if(isset($value['searchable']) && $value['searchable']==true){
					echo "<option value='". $key ."' ".$selected.">". strip_tags($value['title']) ."</option>";
				 }
			}
			echo "</select><input type='submit' value='  Tìm kiếm  '>";
			
			echo "<div class='show_by'>Số ". $this->name ." trên 1 trang: <select name='rop' id='rop' onchange='set_rop();'>";
			
			if($this->rop==10){
				echo "<option value='10' selected>10</option>";
			}else{
				echo "<option value='10'>10</option>";
			}
			if($this->rop==25){
				echo "<option value='25' selected>25</option>";
			}else{
				echo "<option value='25'>25</option>";
			}
			if($this->rop==50){
				echo "<option value='50' selected>50</option>";
			}else{
				echo "<option value='50'>50</option>";
			}
			if($this->rop==100){
				echo "<option value='100' selected>100</option>";
			}else{
				echo "<option value='100'>100</option>";
			}
			if($this->rop==250){
				echo "<option value='250' selected>250</option>";
			}else{
				echo "<option value='250'>250</option>";
			}
			if($this->rop==500){
				echo "<option value='500' selected>500</option>";
			}else{
				echo "<option value='500'>500</option>";
			}
			echo "</select></div>";
			echo "</div>";
			
			// table
			echo '<div class="table-list">';
			
			echo "<table><tr id=\"navigation\"><th class='check-cols'>&nbsp;</th>";
			///////////////////////////////////////echo "<th width='10'><input type='checkbox' id='checkAll' /></th>";
			if(($_SESSION[$this->table ."-page"]['order']==$this->idField)&&($_SESSION[$this->table ."-page"]['order_dir']=="ASC")){
						$dir = "DESC";
						$image = "<img align='absmiddle' src='images/arrow-up.gif' />";
					}else{
						if($_SESSION[$this->table ."-page"]['order']==$this->idField){
							$image = "<img align='absmiddle' src='images/arrow-down.gif' />";
						}
						$dir = "ASC";
					}
			echo "<th width='30' nowrap><b><a href='javascript:order(\"". $this->idField ."\",\"". $dir ."\");'>ID ". $image ."</a></b></th>";
			
			// print action
		//	if(count($this->action)>0){
			//	echo "<td style='color:#FFF; background-color:". $this->headBackground .";' colspan='". count($this->action) ."' nowrap align='center'><b>Action</b></td>";
		//	}
			
			
			foreach($this->column as $key => $value){
				$image = "";
				if(isset($value['show_on_list']) && $value['show_on_list']==true){
					if(($_SESSION[$this->table ."-page"]['order']==$key)&&($_SESSION[$this->table ."-page"]['order_dir']=="ASC")){
						$dir = "DESC";
						$image = "<img align='absmiddle' src='images/arrow-up.gif' />";
					}else{
						if($_SESSION[$this->table ."-page"]['order']==$key){
							$image = "<img align='absmiddle' src='images/arrow-down.gif' />";
							$dir = "ASC";
						}else{
							$dir = "DESC";
						}
						
					}
					if(isset($value['editable']) && ($value['editable']==true)&&($value['type']!="checkbox")&&($this->mylevel>1)){
						$save_icon = '&nbsp; &nbsp;<a href="javascript:save(\''. $key .'\');"><img title="Cập nhật '. $value['title'] .'" src="images/save_icon.gif" align="absmiddle" />';
					}else{
						$save_icon = "";
					}
					echo "<th><a href='javascript:order(\"". $key ."\",\"". $dir ."\");'>". $value['title'] ."</b> ". $image ."</a>". $save_icon ."</th>";
				}
			}
			
			
			echo "</tr>";
            
		}
		
		public function printFooter(){
			echo "</table></div>";
			echo "<input type='hidden' name='field' id='field' value=''>";
			echo "<input type='hidden' name='singleval' id='singleval' value=''>";
			echo "<input type='hidden' name='singleid' id='singleid' value=''>";
			echo "<input type='hidden' name='orderby' id='orderby' value='". htmlspecialchars(isset($_POST['orderby'])?$_POST['orderby']:"") ."'>";
			echo "<input type='hidden' name='orderby_dir' id='orderby_dir' value='". htmlspecialchars(isset($_POST['orderby_dir'])?$_POST['orderby_dir']:"") ."'>";
			echo "<input type='hidden' name='current_page' id='current_page' value='".(isset($_POST['current_page']) ? $_POST['current_page']:1) ."'>";
			echo '<div class="bottom_bar">';
			if($this->mylevel>1){
				echo '<input type="checkbox" id="checkAll" class="checkAll"> <input type="button" id="btnDelete" class="btnDelete" value="Xóa" />';
				if($this->showAddButton){
					echo ' <button id="btnNew" class="btnNew">Thêm</button>';
				}
			}
			echo "<div class='pagination-right'>". $this->getPagination($this->totalPage) ."</div>";
			echo "</div>";
			echo "</form>";
		}
		
		public function getPagination($totalPage){
			$output = "";
			if($totalPage>0){
			$output = "Trang <select name='pagination' id='pagination' onchange='change_page();'>";
				for($i=1;$i<=$totalPage;$i++){
					if((int)$_SESSION[$this->table ."-page"]['page']==$i){
						$select = "selected";
					}else{
						$select = "";
					}
					$output .= "<option value='". $i ."' ". $select .">". $i ."</option>";
				}
			$output .= "</select> / ". (int)$totalPage;
			}
			return $output;
		}
		
		public function printRow($data){		  
			global $oDb;
			if(@$oDb->numRows($data)>0){
				$count = 0;
				while($item = $oDb->fetchArray($data)){
					$count++;
					if($count % 2 == 0){
						echo "<tr>";
					}else{
						echo "<tr>";
					}
					if($this->mylevel>1){
						echo "<td class='check-cols'><input type='checkbox' name='idItem' class='idItem' value='". $item[$this->idField] ."' /></td>";
					}else{
						echo "<td class='check-cols'></td>";
					}
					echo "<td>". $item[$this->idField] ."</td>";
					
					foreach($this->column as $key => $value){					   
						if(isset($value['show_on_list']) && $value['show_on_list']==true){
							if(isset($value['relate']) && $value['relate']!=""){
								$relate = explode(".", $value['relate']);
								$relateTable = $relate[0];
								$relateTitle = $relate[1];
								$relateField = $relate[2];
								$relate_rs = $oDb->query("select * from ". $relateTable ." where ". $relateField ."=". $item[$key]);
								if($oDb->numRows($relate_rs)==0){
									$title = "<font color=red>...</font>";
								}else{
									$relate = $oDb->fetchArray($relate_rs);
									if(($value['editlink']==true)&&($this->mylevel>2)){
										$title = '<a href="javascript:edit('. $item[$this->idField] .');">'. htmlspecialchars(stripslashes($relate[$relateTitle])) ."</a>";
									}else{
										$title = htmlspecialchars(stripslashes($relate[$relateTitle]));
									}
									
								}
							}else{
								switch($value['type']){
									case "checkbox":
										if((int)$item[$key]==1){
											if(($value['editable']==true)&&($this->mylevel>1)){
												$title = "<a href='javascript:switchval(\"". $key ."\",\"". $item[$this->idField] ."\",0);' class='active-link'><img src='images/check.gif' title='". htmlspecialchars($value['label']) ."'></a>";
											}else{
												$title = '<img src="images/check.gif" title="'. htmlspecialchars($value['label']) .'">';
											}
										}else{
											if(($value['editable']==true)&&($this->mylevel>1)){
												$title = "<a href='javascript:switchval(\"". $key ."\",\"". $item[$this->idField] ."\",1);' class='unactive-link'><img src='images/delete_icon.png' title='". htmlspecialchars($value['unlabel']) ."'></a>";
											}else{
												$title = '<img src="images/delete_icon.png" title="'. htmlspecialchars($value['unlabel']) .'">';
											}
										}
									break;
									
									
									case "combobox":
										$title = '---';
										foreach($value['data'] as $k => $v){
											if($item[$key] == $k){
												$tmp = $v;
											}
										}
                                        if(isset($value['editlink']) && ($value['editlink']==true)&&($this->mylevel>1)){
											$title = '<a href="javascript:edit('. $item[$this->idField] .');">'. stripslashes(strip_tags($tmp)) ."</a>";
										}else{
											$title = stripslashes(strip_tags($tmp));
										}
									break;
                                    
                                    case "function":
                                        $function = $value['function'];
                                        if(isset($item[$key]) && $item[$key]!=''){
                                            $title = $function($item[$key]);    
                                        }else{
                                            $title = $function($item['id']);
                                        }
                                        
									break;
									
									case "input:image":
										if($item[$key]==""){
											$url = "admin/images/noimage.jpg";
										}else{
											$url = $item[$key];
										}
										$title = "<img src=".base_url().$url ." class='image_review' width='100' />";
									break;
                                    
                                    case "input:pimage":
                                        $title = '';
                                        $pid = $item['id'];
                                        $arrImage = getProductImages($pid);
										if(count($arrImage)==0){
											$url = "admin/images/noimage.jpg";
										}else{
                                            foreach($arrImage as $k=>$v){
                                                $url = $v['images'];
                                                $small = getSmallImages($url,'thumb50');
                                                $img_delete = '<img src="images/close.gif" class="images_close" onclick="deleteProductImages('.$v['id'].')">';
                                                if($small){$title .= "<div class='wrap_pimages' id='pimg_".$v['id']."' ><img src=".base_url().$small ." width='50' />".$img_delete."</div>";}                                                        
                                            }  											
										}
										
									break;
									
									case "input:price":
										$title = price($item[$key]);
									break;
									
									default:
										if(isset($value['editable']) && ($value['editable']==true)&&($this->mylevel>1)){
											if($value['type']=="input:int10"){
												$size = 10;
												$width = "width:80px;";
												$class= "input-number";
											}else{
												$class = "";
												$size = 255;
												$width = "width:200px;";
											}
											$title = '<input type="text" name="'. $key .'[]" class="'. $key .' '. $class .'" style="'. $width .'" maxlength="'. $size .'" value="'. stripslashes(htmlspecialchars(trim($item[$key]))) .'" />';
										}else{
											if(isset($value['editlink']) && ($value['editlink']==true)&&($this->mylevel>1)){
												$title = '<a href="javascript:edit('. $item[$this->idField] .');">'. stripslashes(strip_tags($item[$key])) ."</a>";
											}else{
												$title = stripslashes(strip_tags($item[$key]));
											}
										}
									break;
								}
								
							}
							echo "<td>". $title ."</td>";
						}
					}
					
					echo "</tr>";
				}
			}else{
				echo "<tr><td colspan='100' align='center'><p>Chưa có ". $this->name ." nào!</p></td></tr>";
			}
		}
		
		public function getRow($id){
			global $oDb;
			$strSql = "select * from ". $this->table ." where ". $this->idField ." IN(". $id .")";
			$rs = $oDb->query($strSql) or die("Lỗi MySql: ". $strSql);                                            
			foreach($this->fields as $f){
				//$this->$f = $rs->row[$f];
			}
			return $rs;
		}
		
		public function eventHander(){
			global $oDb;
			$action = isset($_POST['action'])?$_POST['action']:'';
			switch($action){
				case "del":
					$strSql = "delete from ". $this->table ." where ". $this->idField ." in (". $_POST['listID'] .")";
					$oDb->query($strSql) or die("Lỗi MySql: ". $strSql);
					//echo "delete from ". $this->table ." where ". $this->idField ." in (". $_POST['listID'] .")";
					echo "<script>window.location.href='index.php?f=". htmlspecialchars($_GET['f']) ."';</script>";
				break;
				case "new":
					$this->viewAddForm();
				break;
				case "cnew":
					$this->doAdd();
				break;
				
				case "edit":
					$this->viewEditForm();
				break;
				
				case "cedit":
					$this->doEdit();
				break;
				
				case "save":
					$this->saveField();
				break;	
				
				case "switchval":
					$this->switchval();
				break;
				
				case "set_rop":
					$_SESSION[$this->table ."-page"]['page'] = 1;
					$this->view();
				break;
				
				case "order":
					$_SESSION[$this->table ."-page"]['page'] = 1;
					$this->view();
				break;
				
				default:
					$this->view();
				break;
			}
		}
		
		function view(){		      
			if(isset($_POST['rop']) && (int)$_POST['rop']>0){
				$_SESSION[$this->table]['rop'] = (int)$_POST['rop'];
			}
			if(isset($_SESSION[$this->table]) && $_SESSION[$this->table]['rop']>0){
				$this->rop = isset($_SESSION[$this->table]) ? $_SESSION[$this->table]['rop'] : 0;
			}else{
				$this->rop = 100;
			}
			$this->showList();
		}
		
		public function viewAddForm($msg = null){
			global $oDb;
			echo '<h2 class="broad-title">'. $this->name .'</h2>';
			if($msg!=null){
				echo $msg;
			}
			echo '<span>'. $this->info .'</span>';
			echo '<div class="add-bar"><span>Thêm '. $this->name .'</span></div>';
			echo "<form name='frm' id='frm' action='index.php?f=". htmlspecialchars($_GET['f']) ."' method='post'>";
			echo "<input type='hidden' name='action' value='cnew' />";
			echo "<div class='table-list table-form'><table>";
			foreach($this->column as $key => $value){
			
				if($value['separator']!=""){
					echo "<tr><td colspan=2><div class='add-bar'><span>". $value['separator'] ."</span></div></td></tr>";
				}
				
				echo "<tr>";
				echo "<td width='25%'>". $value['title'] ."</td>";
				
				//validate
				if($value['required']!=""){
					$class = "{required:true,messages:{required:'". addslashes($value['required']) ."'}}";
				}else{
					$class= "";
				}
				
					$default_val = htmlspecialchars($value['value']);
					switch($value['type']){
						case "input:text":
							$input = '<input type="text" name="'. $key .'" class="'. $class .'" value="'. $default_val .'" />';
						break;
                        
                        case "function":
							$input = '<input type="text" name="'. $key .'" class="'. $class .'" value="'. $default_val .'" />';
						break;
                        
                        case "input:readonly":
							$input = '<input readonly="" style="background-color: silver;" type="text" name="'. $key .'" class="'. $class .'" value="'. $default_val .'" />';
						break;	
						case "input:password":
							$input = '<input type="password" name="'. $key .'" class="'. $class .'" />';
						break;	
						case "input:image":
							$input = '<input type="text" name="'. $key .'" class="'. $class .' input-image" /> [<a href="#" class="'. $key .'" id="btnUpload'. $key .'">Chọn ảnh</a>] <span id="lblUpload'. $key .'"></span><br><img class="image_review" src="images/noimage.jpg" width="100" />';
						break;
						
						case "input:multipleimage":
							$input = '<input type="hidden" name="'. $key .'" id="'. $key .'" /><a href="javascript:void(0);" class="multiple_image_link" rel="'. $key .'" dir="'. $value['img_dir'] .'" mw="'. $value['img_mw'] .'" lbl="'. $value['img_text'] .'">Chọn ảnh</a>';
						break;
                        
                        case "input:pimage":
							$input = '<input type="text" name="'. $key .'" class="'. $class .' input-image-product" /> [<a href="#" class="'. $key .'" id="btnUpload'. $key .'">Chọn ảnh</a>] <span id="lblUpload'. $key .'"></span><br><div id="wrap_pdoruct_images"></div>';
						break;
						
						case "input:price":
							$input = '<input type="hidden" id="'. $key .'" name="'. $key .'"  value="'. $default_val .'" ><input type="text" name="'. $key .'_view" valto="'. $key .'" style="width:150px;" class="'. $class .' price-input" value="0" /> VNĐ';
						break;
						
						case "input:int10":
							$input = '<input type="text" name="'. $key .'" style="width:100px;"  value="'. $default_val .'" class="'. $class .' input-number" maxlength="10" />';
						break;
						
						case "textarea":
							if((int)$value['rows']==0){
								$rows = 10;
							}else{
								$rows = (int)$value['rows'];
							}
							$input = '<textarea name="'. $key .'" id="'. $key .'" rows="'. $rows .'" class="'. $class .' txa" cols="60">'. $default_val .'</textarea>';
                            $input .= '
                            <script type="text/javascript">
                                //<![CDATA[
                            	var editor = CKEDITOR.replace("'.$key.'");
                                 CKFinder.SetupCKEditor( editor, { 
                                        BasePath : "editor/ckfinder/", 
                                        RememberLastFolder : false
                                 }) ;
                                //]]>                                
                            </script>';
						break;
                        
                        case "textarea:noeditor":
							if((int)$value['rows']==0){
								$rows = 10;
							}else{
								$rows = (int)$value['rows'];
							}
							$input = '<textarea name="'. $key .'" id="'. $key .'" rows="'. $rows .'" class="'. $class .' txa" cols="60">'. $default_val .'</textarea>';
						break;
                        
                        
						
						case "checkbox":
							$input = '<input type="checkbox" name="'. $key .'" value="1" class="'. $class .'" '. $value['checked'] .' /> '. strip_tags($value['label']);
						break;
						
						case "combobox:relate:int":
							if($value['required']!=""){
								$class = "{min:1,messages:{min:'". addslashes($value['required']) ."'}}";
							}else{
								$class= "";
							}
							$input = '<select name="'. $key .'" class="'. $class .'" >';
							$input .= $value['add_option'];
								$relate = explode(".", $value['relate']);
								$relateTable = $relate[0];
								$relateTitle = $relate[1];
								$relateField = $relate[2];
								$strSql = "select * from ". $relateTable ." ". $value['sufix_query'];
								$relate_rs = $oDb->query($strSql) or die("Lỗi MySql: ". $strSql);
								while($relate = $oDb->fetchArray($relate_rs)){
									$input .= '<option value="'. $relate[$relateField] .'">'. htmlspecialchars(stripslashes($relate[$relateTitle])) .'</option>';
								}
							$input .= "</select>";
						break;
						
						case "combobox":
							if($value['required']!=""){
								$class = "{min:1,messages:{min:'". addslashes($value['required']) ."'}}";
							}else{
								$class= "";
							}
							$input = '<select name="'. $key .'" class="'. $class .'" >';
								foreach($value['data'] as $k => $v){
									$input .= '<option value="'. $k .'">'. htmlspecialchars(stripslashes($v)) .'</option>';
								}
							$input .= "</select>";
						break;
						
						case "checkbox:relate:int":	
								$input = "";
								$relate = explode(".", $value['relate']);
								$relateTable = $relate[0];
								$relateTitle = $relate[1];
								$relateField = $relate[2];
								$strSql = "select * from ". $relateTable ." ". $value['sufix_query'];
								$relate_rs = $oDb->query($strSql) or die("Lỗi MySql: ". $strSql);
								while($relate = $oDb->fetchArray($relate_rs)){
									$input .= '<input type="checkbox" name="'. $key .'[]" value="'. $relate[$relateField] .'" />'. htmlspecialchars(stripslashes($relate[$relateTitle])) .'<br>';
								}
						break;
						
						case "datetime:current":
							$input = '<input type="text" name="'. $key .'" value="'. date('Y-m-d H:i:s',time()) .'" class="'. $class .' inputdate" />';
						break;
						
						case "map":
							$input = '<input type="hidden" name="'. $key .'" id="'. $key .'" /><a href="javascript:void(0);" class="maplink" rel="'. $key .'" x="'. $value['x'] .'" y="'. $value['y'] .'">Đánh dấu trên bản đồ</a>';
						break;
						
						default:
							$input = '<input type="text" name="'. $key .'"  value="'. $default_val .'" class="'. $class .'" />';
						break;
					}
				echo '<td width="75%">'. $input .' '. $value['sufix_title'] .'<span class="error"></span></td>';
				echo "</tr>";
			}
			echo "<tr><td>&nbsp;</td><td><input type='submit' value='Hoàn thành' id='btnAddSubmit' /></td></tr>";
			echo "</table></form></div>";
		}
		public function viewEditForm($id = null,$msg = null){
			global $oDb;
			if($id!=null){
				$editID = $id;
			}else{
				$editID = $_POST['listID'];
			}
			$row = $oDb->fetchArray($this->getRow($editID));
			echo '<h2 class="broad-title">'. $this->name .'</h2>';
			if($msg != null){
				echo $msg;
			}
			echo '<span>'. $this->info .'</span>';
			echo '<div class="add-bar"><span>Sửa '. $this->name .'</span></div>';
			echo "<form name='frm' id='frm' action='index.php?f=". htmlspecialchars($_GET['f']) ."' method='post'>";
			echo "<input type='hidden' name='action' value='cedit' />";
			echo "<input type='hidden' name='listID' value='". $row[$this->idField] ."' />";
			echo "<div class='table-list table-form'><table>";
			foreach($this->column as $key => $value){
				//validate
				if(isset($value['required']) && $value['required']!=""){
					$class = "{required:true,messages:{required:'". addslashes($value['required']) ."'}}";
				}else{
					$class= "";
				}
				
				if(isset($value['separator']) && $value['separator']!=""){
					echo "<tr><td colspan=2><div class='add-bar'><span>". $value['separator'] ."</span></div></td></tr>";
				}
				
				echo "<tr>";
				echo "<td width='25%'>". $value['title'] ."</td>";
					switch($value['type']){
						case "input:text":
							$input = '<input type="text" name="'. $key .'" class="'. $class .'" value="'. htmlspecialchars(stripslashes($row[$key])) .'"/>';
						break;
                        
                        case "function":
							$input = '<input type="text" name="'. $key .'" class="'. $class .'" value="'. htmlspecialchars(stripslashes($row[$key])) .'"/>';
						break;
                        
                        case "input:readonly":
							$input = '<input readonly="" style="background-color: silver;" type="text" name="'. $key .'" class="'. $class .'" value="'. htmlspecialchars(stripslashes($row[$key])) .'"/>';
						break;
                        
						case "input:password":
							$input = '<input type="password" name="'. $key .'" class="'. $class .'" value="'. htmlspecialchars(stripslashes($row[$key])) .'"/>';
						break;
						
						case "input:image":
								if($row[$key]==""){
									$url = "admin/images/noimage.jpg";
								}else{
									$url = $row[$key];
								}
							$input = '<input type="text" class="'. $class .' input-image"  name="'. $key .'" value="'. htmlspecialchars(stripslashes($row[$key])) .'" /> [<a href="#" class="'. $key .'" id="btnUpload'. $key .'">Chọn ảnh</a>] <span id="lblUpload'. $key .'"></span><br><img class="image_review" src="'.base_url(). $url .'" width="100" />';
						break;
                        
                        case "input:pimage":
                                $html_img = '';
                                $pid = $row['id'];
                                $arrImage = getProductImages($pid);
								if(count($arrImage)==0){
									$url = "admin/images/noimage.jpg";
								}else{
								    $row[$key] = '';
                                    foreach($arrImage as $k=>$v){
                                        $url = $v['images'];
                                        $row[$key] .= $url.'|';
                                        $small = getSmallImages($url,'thumb50');
                                        $img_delete = '<img src="images/close.gif" class="images_close" onclick="deleteProductImages('.$v['id'].')">';
                                        if($small){$html_img .= "<div class='wrap_pimages' id='pimg_".$v['id']."' ><img src=".base_url().$small ." width='50' />".$img_delete."</div>";}                                                        
                                    }  											
								}
							    $input = '<input type="text" class="'. $class .' input-image-product"  name="'. $key .'" value="'. htmlspecialchars(stripslashes(trim($row[$key],'|'))) .'" /> [<a href="#" class="'. $key .'" id="btnUpload'. $key .'">Chọn ảnh</a>] <span id="lblUpload'. $key .'"></span><div id="wrap_pdoruct_images">'.$html_img.'</div>';
						break;
						
						case "input:multipleimage":
							$count_img = explode(',',$row[$key]);
							$num_image = sizeof($count_img) -1;
							$input = '<input type="hidden" name="'. $key .'" id="'. $key .'" value="'. stripslashes($row[$key]) .'" /><a href="javascript:void(0);" class="multiple_image_link" rel="'. $key .'" dir="'. $value['img_dir'] .'" mw="'. $value['img_mw'] .'" lbl="'. $value['img_text'] .'">Đã chọn ảnh ('. $num_image .' ảnh)</a>';
						break;
						
						case "input:price":
							$input = '<input type="hidden" id="'. $key .'" name="'. $key .'" value="'. htmlspecialchars(stripslashes($row[$key])) .'"><input type="text" name="'. $key .'_view" valto="'. $key .'" style="width:150px;" class="'. $class .' price-input" value="'. htmlspecialchars(stripslashes(price($row[$key]))) .'" /> VNĐ';
						break;
						
						case "input:int10":
							$input = '<input type="text" name="'. $key .'" style="width:100px;" class="'. $class .' input-number" maxlength="10" value="'. (int)$row[$key] .'" />';
						break;
						
						case "textarea":
							if((int)$value['rows']==0){
								$rows = 10;
							}else{
								$rows = (int)$value['rows'];
							}
							$input = '<textarea name="'. $key .'" class="'. $class .' txa" rows="'. $rows .'" cols="60">'. htmlspecialchars(stripslashes(stripslashes(stripslashes(stripslashes($row[$key]))))) .'</textarea>';
                            $input .= '
                            <script type="text/javascript">
                                //<![CDATA[
                            	var editor = CKEDITOR.replace("'.$key.'");
                                 CKFinder.SetupCKEditor( editor, { 
                                        BasePath : "editor/ckfinder/", 
                                        RememberLastFolder : false
                                 }) ;
                                //]]>                                
                            </script>';
						break;
                        
                        case "textarea:noeditor":
							if((int)$value['rows']==0){
								$rows = 10;
							}else{
								$rows = (int)$value['rows'];
							}
							$input = '<textarea name="'. $key .'" class="'. $class .' txa" rows="'. $rows .'" cols="60">'. htmlspecialchars(stripslashes($row[$key])) .'</textarea>';
						break;
						
						case "checkbox":
							if((int)$row[$key]==1){
								$check = "checked";
							}else{
								$check = "";
							}
							$input = '<input type="checkbox" class="'. $class .'" name="'. $key .'" value="1" '. $check .'/> '. strip_tags($value['label']);
						break;
						
						case "combobox:relate:int":
							if($value['required']!=""){
								$class = "{min:1,messages:{min:'". addslashes($value['required']) ."'}}";
							}else{
								$class= "";
							}
							$input = '<select name="'. $key .'" class="'. $class .'" >';
							$input .= $value['add_option'];
								$relate = explode(".", $value['relate']);
								$relateTable = $relate[0];
								$relateTitle = $relate[1];
								$relateField = $relate[2];
								$strSql = "select * from ". $relateTable ." ". $value['sufix_query'];
								$relate_rs = $oDb->query($strSql) or die("Lỗi MySql: ". $strSql);
								while($relate = $oDb->fetchArray($relate_rs)){
									if($relate[$relateField]== $row[$key]){
										$check = "selected class='optSelected'";
									}else{
										$check = "";
									}
									$input .= '<option value="'. $relate[$relateField] .'" '. $check .' >'. htmlspecialchars(stripslashes($relate[$relateTitle])) .'</option>';
								}
							$input .= "</select>";
						break;
						
						case "combobox":
							if(isset($value['required']) && $value['required']!=""){
								$class = "{min:1,messages:{min:'". addslashes($value['required']) ."'}}";
							}else{
								$class= "";
							}
							$input = '<select name="'. $key .'" class="'. $class .'" >';
								foreach($value['data'] as $k => $v){
									if($row[$key] == $k){
										$check = "selected class='optSelected'";
									}else{
										$check = "";
									}
									$input .= '<option value="'. $k .'" '. $check .'>'. htmlspecialchars(stripslashes($v)) .'</option>';
								}
							$input .= "</select>";
						break;
						
						case "checkbox:relate:int":	
								$input = "";
								$relate = explode(".", $value['relate']);
								$relateTable = $relate[0];
								$relateTitle = $relate[1];
								$relateField = $relate[2];
								$strSql = "select * from ". $relateTable ." ". $value['sufix_query'];
								$relate_rs = $oDb->query($strSql) or die("Lỗi MySql: ". $strSql);
								while($relate = $oDb->fetchArray($relate_rs)){
									$hasKey = explode(":". $relate[$relateField] .":",$row[$key]);
									if(count($hasKey)>1){
										$check = "checked";
									}else{
										$check = "";
									}
									$input .= '<input type="checkbox" name="'. $key .'[]" value="'. $relate[$relateField] .'" '. $check .' />'. htmlspecialchars(stripslashes($relate[$relateTitle])) .'<br>';
								}
						break;
					
						case "datetime:current":
							$input = '<input type="text" class="'. $class .' inputdate" name="'. $key .'" value="'. $row[$key] .'" />';
						break;
						
						case "map":
							$map_pos = explode(":",$row[$key]);
							$x = $map_pos[0];
							$y = $map_pos[1];
							if(($x == "")||($y=="")){
								$x = $value['x'];
								$y = $value['y'];
								if(($x == "")||($y=="")){
									$x = 21.03191538070277;
									$y = 105.81503391265869;
								}
							}
							$input = '<input type="hidden" name="'. $key .'" id="'. $key .'" value="'. $row[$key] .'" /><a href="javascript:void(0);" class="maplink" rel="'. $key .'" x="'. $x .'" y="'. $y .'">Đã đánh dấu <span style="color: #777;">('. $x .','. $y .')</span></a>';
						break;
						
						default:
							$input = '<input type="text" name="'. $key .'" class="'. $class .'" value="'. htmlspecialchars(stripslashes($row['key'])) .'" />';
						break;
					}
                $txt_sufixtitle = isset($value['sufix_title'])?$value['sufix_title']:"";    
				echo "<td>". $input ." ".$txt_sufixtitle."<span class='error'></span></td>";
				echo "</tr>";
			}
			echo "<tr><td>&nbsp;</td><td><input type='submit' id='btnAddSubmit' value='Hoàn thành' /> <input type='reset' value='Nạp lại giá trị cũ' /></td></tr>";
			echo "</table></form>";
		}
		
		function doAdd(){
			global $oDb;
			$column = "";
			$data = "";
			$count = 0;
			foreach($this->column as $key => $value){
				if($value['unique']==true){
					$checkuni_rs = $oDb->query("select * from ". $this->table ." where ". $key ."='". addslashes($_POST[$key]) ."'");
					$label = $value['title'];
				}
				$arr_data = $_POST[$key];
				$data_item = "";
				if($value['type']=="checkbox:relate:int"){
					foreach($arr_data as $item){
							$data_item .= ":". $item .":";
					}
				}else if($value['type']=="input:password"){
					$data_item = md5(md5(md5($_POST[$key])));
				}else{
					$data_item = $_POST[$key];
				}
				
				$this->$key = $data_item;
				$count++;
			}
			if($oDb->numRows($checkuni_rs)>0){
				$this->viewAddForm("<div class='red'>". $label ." đã tồn tại, xin chọn ". $label ." khác!</div>");
			}else{
				$chk = $this->insert();
                
                ////////// BEGIN edit by HanhND /////////////
                $arrProductImage = $_SESSION['pimages'];
                if(count($arrProductImage)>0){
                    foreach($arrProductImage as $img){
                        $sql = "INSERT INTO `tbl_product_images` (`id`, `product_id`, `images`, `ordering`, `default`) VALUES (NULL, '$chk', '$img', '0', '0')";
                        $oDb->query($sql);
                    }
                }
                unset($_SESSION['pimages']);
                ////////// END edit by HanhND ///////////////
                
                
				echo "<script>window.location.href='index.php?f=". htmlspecialchars($_GET['f']) ."';</script>";
			}
		}
		
		function doEdit(){
			global $oDb,$_SESSION;
			$column = "";
			$data = "";
			$count = 0;
			$id = $_POST['listID'];
			foreach($this->column as $key => $value){
				if(isset($value['unique']) && $value['unique']==true){
					$checkuni_rs = $oDb->query("select * from ". $this->table ." where ". $key ."='". addslashes($_POST[$key]) ."' and ". $this->idField ."<>'". $id ."'");
					$label = $value['title'];
				}
				$arr_data = $_POST[$key];
				$data_item = "";
				if($value['type']=="checkbox:relate:int"){
					foreach($arr_data as $item){
						$data_item .= ":". $item .":";
					}
				}else if($value['type']=="input:password"){
					$check_rs = $oDb->query("select * from ". $this->table ." where ". $this->idField ."='". $id ."'");
					$check = $oDb->fetchArray($check_rs);
					$newval = md5(md5(md5($_POST[$key])));
					if($check[$key]!=$_POST[$key]){
						$data_item = $newval;
					}else{
						$data_item = $check[$key];
					}
				}else{
					$data_item = $_POST[$key];
				}
                
				$this->$key = $data_item;
				$count++;
			}
			if(isset($checkuni_rs) && (int)$oDb->numRows($checkuni_rs)>0){
				$this->viewEditForm($id,"<div class='red'>". $label ." đã tồn tại, xin chọn ". $label ." khác!</div>");
			}else{
				$chk = $this->update($id,$this->fields);
                
                ////////// BEGIN edit by HanhND /////////////
                $arrProductImage = $_SESSION['pimages'];
                if(count($arrProductImage)>0){
                    foreach($arrProductImage as $img){
                        $sql = "INSERT INTO `tbl_product_images` (`id`, `product_id`, `images`, `ordering`, `default`) VALUES (NULL, '$id', '$img', '0', '0')";
                        $oDb->query($sql);
                    }
                }
                unset($_SESSION['pimages']);
                ////////// END edit by HanhND /////////////
                
                
				echo "<script>window.location.href='index.php?f=". htmlspecialchars($_GET['f']) ."';</script>";
			}
		}
		
		function saveField(){
			global $oDb;
			$listID = explode(',',$_POST['listID']);
			$listVal = $_POST[$_POST['field']];            
			for($i=1;$i<count($listID);$i++){
				$this->$_POST['field'] = $listVal[$i-1];                
				$this->update($listID[$i],array($_POST['field']));
			}
			echo "<script>window.location.href='index.php?f=". htmlspecialchars($_GET['f']) ."';</script>";
		}
		
		function switchval(){
			global $oDb;
			$this->$_POST['field'] = (int)$_POST['singleval'];
			$this->update((int)$_POST['singleid'],array($_POST['field']));            
			echo "<script>window.location.href='index.php?f=". htmlspecialchars($_GET['f']) ."&search-input=".$_REQUEST['search-input']."&search-column=".$_REQUEST['search-column']."';</script>";
		}
	}
?>	