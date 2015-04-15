<?php

/**
 * @author duchanh
 * @copyright 2012
 */


$column = array(
    "avatar"	=> array(
			"title"		=> "Ảnh avatar",
			"type"		=> "input:image",
			"editable"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
    "fullname"	=> array(
			"title"		=> "Họ và tên",
			"type"		=> "input:text",						
			"searchable"=> true,
			"editlink"	=> true,
            "sufix_title" => "Nhập họ và tên",
			"show_on_list"	=> true
	),
    "address"	=> array(
			"title"		=> "Địa chỉ",
			"type"		=> "input:text",						
			"searchable"=> true,
			"editlink"	=> true,
            "sufix_title" => "Nhập địa chỉ",
			"show_on_list"	=> true
	),
    "gender"	=> array(
			"title"		=> "Giới tính",
			"type"		=> "combobox",	
            "data"      => array(0=>'Nữ',1=>'Nam'),					
			"searchable"=> true,
			"editlink"	=> true,
            "sufix_title" => "Nhập giới tính",
			"show_on_list"	=> true
	),
	"username"	=> array(
			"title"		=> "Tên đăng nhập",
			"type"		=> "input:text",						
			"searchable"=> true,
			"editlink"	=> true,
            "sufix_title" => "Nhập tên đăng nhập",
			"show_on_list"	=> true
	),
	"email"	=> array(
			"title"		=> "Email",
			"type"		=> "input:text",
            "required"	=> "Nhập email",
			"editable"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
    "phone"	=> array(
			"title"		=> "Điện thoại",
			"type"		=> "input:text",						
			"searchable"=> true,
			"editlink"	=> true,
            "sufix_title" => "Nhập số điện thoại",
			"show_on_list"	=> false
	),
    "birthday"	=> array(
			"title"		=> "Ngày sinh",
			"type"		=> "datetime:current",						
			"searchable"=> false,
			"editlink"	=> false,
            "sufix_title" => "Nhập ngày sinh",
			"show_on_list"	=> false
	),
    "website"	=> array(
			"title"		=> "Website",
			"type"		=> "input:text",						
			"searchable"=> false,
			"editlink"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
    "status"	=> array(
			"title"		=> "Trạng thái",
			"type"		=> "checkbox",
			"label"		=> "Có",
			"unlabel"	=> "Không",
			"editable"	=> true,
			"show_on_list" => true,
            "sufix_title" => ""                        
	)
);

$bg = new FishTable("tbl_user",$column,"id");
$bg->name = "User";
$bg->Cache = "CacheUser";
$bg->eventHander();


?>