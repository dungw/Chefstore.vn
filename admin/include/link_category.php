<?php

/**
 * @author duchanh
 * @copyright 2012
 */

$column = array(
	"cat_id"	=> array(
			"title"		=> "Danh mục SP",
			"type"		=> "combobox",
            "data"      => getCategory(),
            "required"	=> "Chọn danh mục",
			"editable"	=> false,
            "editlink"	=> true,
			"searchable"	=> false,
			"show_on_list"	=> true
	),
    "name"	=> array(
			"title"		=> "Tên link (text)",
			"type"		=> "input:text",
			"required"	=> "Nhập tên link (text)",
			"searchable"	=> true,
			"editlink"	=> true,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
    "link"	=> array(
			"title"		=> "Liên kết phụ",
			"type"		=> "input:text",
			"required"	=> "Nhập liên kết phụ",
			"searchable"	=> false,
			"editlink"	=> true,
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

$bg = new FishTable("tbl_link_category",$column,"id");
$bg->name = "Liên kết phụ";
$bg->Cache = "CacheLinkCategory";
$bg->eventHander();

?>