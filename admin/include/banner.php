<?php

/**
 * @author duchanh
 * @copyright 2012
 */


$column = array(
	"name"	=> array(
			"title"		=> "Tên banner",
			"type"		=> "input:text",						
			"searchable"=> true,
			"editlink"	=> true,
            "sufix_title" => "Ví dụ: Sản phẩm mới",
			"show_on_list"	=> true
	),
    "desc"	=> array(
			"title"		=> "Miêu tả",
			"type"		=> "textarea:noeditor",						
			"searchable"=> true,
			"editlink"	=> true,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
	"link"	=> array(
			"title"		=> "Liên kết",
			"type"		=> "input:text",
            "required"	=> "Nhập đường dẫn liên kết",
			"editable"	=> false,
            "editlink"	=> true,
			"searchable"	=> true,
            "sufix_title" => "Vú dụ: http://google.com",
			"show_on_list"	=> true
	),
	"img"	=> array(
			"title"		=> "Ảnh",
			"type"		=> "input:image",
            "required"	=> "Nhập ảnh",
			"editable"	=> false,
            "sufix_title" => "Kích thước 600x360 nếu là popup",
			"show_on_list"	=> true
	),
	"position"	=> array(
			"title"		=> "Vị trí",
			"type"		=> "combobox",
			"data"		=> array('top'=>'top','slide'=>'slide','popup'=>'popup','right'=>'right','content'=>'content','footer'=>'footer'),
			"editable"	=> false,
            "searchable"=> true,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
	"ordering"	=> array(
			"title"		=> "Thứ tự",
			"type"		=> "input:int10",
			"editable"	=> true,
            "sufix_title" => "",
			"show_on_list"	=> true
	),				
	"status"	=> array(
			"title"		=> "Hiển thị",
			"type"		=> "checkbox",
			"label"		=> "Có",
			"unlabel"	=> "Không",
			"editable"	=> true,
			"show_on_list" => true,
            "sufix_title" => "" 
	),
);

$bg = new FishTable("tbl_banner",$column,"id");
$bg->name = "Banner";
$bg->Cache = "CacheBanner";
$bg->eventHander();

?>