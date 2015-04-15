<?php

/**
 * @author duchanh
 * @copyright 2012
 */


$column = array(                
    "cat_id"	=> array(
			"title"		=> "Nhóm sản phẩm",
			"type"		=> "combobox",					
			"editable"	=> false,
            "data"      => getCategory(),
            "searchable"=> true,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
	"title"	=> array(
			"title"		=> "Tiêu đề",
			"type"		=> "input:text",
			"required"	=> "Nhập tiêu đề",
			"searchable"	=> true,
			"editlink"	=> true,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
    "img"	=> array(
			"title"		=> "Ảnh miêu tả",
			"type"		=> "input:image",
            "required"	=> "Nhập ảnh",
			"editable"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
    "brief"	=> array(
			"title"		=> "Nội dung tóm tắt",
			"type"		=> "textarea",
			"required"	=> "Nhập nội dung tóm tắt",
			"searchable"	=> false,
			"editlink"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> false
	),
	"content"	=> array(
			"title"		=> "Nội dung",
			"type"		=> "textarea",
            "required"	=> "Nhập nội dung",
			"editable"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> false
	),
    "date"	=> array(
			"title"		=> "Ngày đăng tin",
			"type"		=> "datetime:current",
			"editable"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> false
	),
    "ordering"	=> array(
			"title"		=> "Thứ tự",
			"type"		=> "input:int10",
			"editable"	=> true,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
    "meta_keyword"	=> array(
			"title"		=> "Từ khóa SEO",
			"type"		=> "input:text",
			"sufix_title" => "",
			"show_on_list"	=> false
	),
    "meta_description"	=> array(
			"title"		=> "Description SEO",
			"type"		=> "input:text",
			"sufix_title" => "",
			"show_on_list"	=> false
	), 
	"status"	=> array(
			"title"		=> "Hiển thị",
			"type"		=> "checkbox",
			"label"		=> "Có",
			"unlabel"	=> "Không",
			"editable"	=> true,
			"show_on_list" => true,
            "sufix_title" => ""                        
	)
);

$bg = new FishTable("tbl_congdung",$column,"id");
$bg->name = "Công dụng";
$bg->Cache = "CacheCongDung";
$bg->eventHander();
?>