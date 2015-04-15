<?php

/**
 * @author duchanh
 * @copyright 2012
 */


$column = array(
    "name"	=> array(
			"title"		=> "Tên đại lý ",
			"type"		=> "input:text",
			"editable"	=> false,
            "required"	=> "Nhập tên đại lý",
			"show_on_list"	=> true,
            "editable"	=> false,
			"editlink"	=> true
	),                
    "address"	=> array(
			"title"		=> "Địa chỉ",
			"type"		=> "input:text",
			"editable"	=> false,
            "required"	=> "Nhập địa chỉ",
			"show_on_list"	=> true,
			"editlink"	=> false
	),
    "phone"	=> array(
			"title"		=> "Số điện thoại",
			"type"		=> "input:text",
			"editable"	=> false,
            "required"	=> "Nhập số điện thoại đại lý",
			"show_on_list"	=> true,
			"editlink"	=> false
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
	)
	
);

$bg = new FishTable("tbl_dealer",$column,"id");
$bg->name = "Đại lý";
$bg->Cache = "CacheDealer";
$bg->eventHander();
?>