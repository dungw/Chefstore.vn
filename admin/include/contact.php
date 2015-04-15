<?php

/**
 * @author duchanh
 * @copyright 2012
 */


$column = array(
	"fullname"	=> array(
			"title"		=> "Họ tên",
			"type"		=> "input:text",
			"required"	=> "Nhập họ tên",
			"searchable"	=> true,
			"editlink"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
	"email"	=> array(
			"title"		=> "Email ",
			"type"		=> "input:text",
			"required"	=> "Nhập email",
			"searchable"	=> true,
			"editlink"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
	"phone"	=> array(
			"title"		=> "Số điện thoại",
			"type"		=> "input:text",
			"required"	=> "Nhập số điện thoại",
			"searchable"	=> true,
			"editlink"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
	"content"	=> array(
			"title"		=> "Nội dung",
			"type"		=> "input:text",
			"required"	=> "Nhập nội dung",
			"searchable"	=> true,
			"editlink"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
    "product_id"	=> array(
			"title"		=> "Sản phẩm",
			"type"		=> "combobox",
            "data"      => getProduct(),
			"required"	=> "Nhập tên sản phẩm",
			"searchable"	=> true,
			"editlink"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
    "product_number"	=> array(
			"title"		=> "Số lượng",
			"type"		=> "input:int10",
			"required"	=> "Số lượng",
			"searchable"	=> true,
			"editlink"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true
	)
    /*,    
    "status"	=> array(
			"title"		=> "Hiển thị",
			"type"		=> "checkbox",
			"label"		=> "Có",
			"unlabel"	=> "Không",
			"editable"	=> true,
			"show_on_list" => true,
            "sufix_title" => ""                        
	)
    */
);

$bg = new FishTable("tbl_contact",$column,"id");
$bg->name = "Liên hệ";
$bg->Cache = "CacheContact";
$bg->mylevel = 0;
$bg->eventHander();

?>