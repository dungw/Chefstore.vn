<?php

/**
 * @author duchanh
 * @copyright 2012
 */


$column = array( 
    "parent_id"	=> array(
			"title"		=> "Danh mục cha",
			"type"		=> "combobox",
			"data"		=>  getCategory(),
			"editable"	=> false,
            "searchable"=> false,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
    
	"name"	=> array(
			"title"		=> "Tên danh mục",
			"type"		=> "input:text",
			"required"	=> "Nhập tên danh mục",
			"searchable"=> true,
			"editlink"	=> true,
            "sufix_title" => "Nhâp tên danh mục",
			"show_on_list"	=> true
	),
    /*
	"img"	=> array(
			"title"		=> "Ảnh",
			"type"		=> "input:image",
			"editable"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
    */
    "description"	=> array(
			"title"		=> "Miêu tả",
			"type"		=> "textarea:noeditor",
			"sufix_title" => "",
			"show_on_list"	=> false
	),
    "meta_title"	=> array(
			"title"		=> "Meta title SEO",
			"type"		=> "input:text",
			"sufix_title" => "",
			"show_on_list"	=> false
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
    "column"	=> array(
			"title"		=> "Cột",
			"type"		=> "input:int10",
			"editable"	=> true,
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

$bg = new FishTable("tbl_category",$column,"id");
$bg->name = "Danh mục";
$bg->Cache = "CacheCategory";
$bg->hasParrent = 'parent_id';
$bg->eventHander();

?>