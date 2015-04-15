<?php

/**
 * @author duchanh
 * @copyright 2012
 */


$column = array(    
    /*            
    "list_product"	=> array(
			"title"		=> "Danh sách sp",
			"type"		=> "json",
			"data"		=>  getCategory(),
			"editable"	=> false,
            "searchable"=> true,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
    */
	"fullname"	=> array(
			"title"		=> "Tên KH",
			"type"		=> "input:text",
			"searchable"=> true,
			"editlink"	=> false,
            "sufix_title" => "Nhâp tên khách hàng",
			"show_on_list"	=> true
	),
	"phone"	=> array(
			"title"		=> "Điện thoại",
			"type"		=> "input:text",
            "required"	=> "Nhập số điện thoại",
			"editable"	=> false,
            "sufix_title" => "",
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
    "address"	=> array(
			"title"		=> "Địa chỉ",
			"type"		=> "input:text",
            "required"	=> "Nhập địa chỉ",
			"editable"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
    "content"	=> array(
			"title"		=> "Địa chỉ",
			"type"		=> "input:text",
            "required"	=> "Nhập địa chỉ",
			"editable"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
    "payment_type"	=> array(
			"title"		=> "Kiểu thanh toán",
			"type"		=> "input:text",
            "required"	=> "Nhập kiểu thanh toán",
			"editable"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
    "bank"	=> array(
			"title"		=> "Ngân hàng",
			"type"		=> "input:text",
            "required"	=> "Nhập ngân hàng",
			"editable"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
    "user_bank"	=> array(
			"title"		=> "TK khách",
			"type"		=> "input:text",
            "required"	=> "Nhập tài khoản khách",
			"editable"	=> false,
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

$bg = new FishTable("tbl_cart",$column,"id");
$bg->name = "Đặt hàng";
$bg->Cache = "CacheCart";
$bg->eventHander();

?>