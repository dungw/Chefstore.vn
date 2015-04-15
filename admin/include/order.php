<?php

/**
 * @author duchanh
 * @copyright 2012
 */


$column = array(      
    "list_product"	=> array(
			"title"		=> "Danh sách sp",
			"type"		=> "function",
			"function"	=> 'order',
			"editable"	=> false,
            "searchable"=> false,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
    
	"fullname"	=> array(
			"title"		=> "Tên KH",
			"type"		=> "input:text",
			"searchable"=> true,
			"editlink"	=> true,
            "sufix_title" => "Nhâp tên khách hàng",
			"show_on_list"	=> true
	),
    "company"	=> array(
			"title"		=> "Cơ quan",
			"type"		=> "input:text",
			"searchable"=> false,
			"editlink"	=> false,
            "sufix_title" => "Nhâp tên cơ quan",
			"show_on_list"	=> true
	),   
    "tax_code"	=> array(
			"title"		=> "Mã số thuế",
			"type"		=> "input:text",
			"searchable"=> true,
			"editlink"	=> false,
            "sufix_title" => "Nhâp mã số thuế",
			"show_on_list"	=> true
	),    
	"phone"	=> array(
			"title"		=> "Điện thoại",
			"type"		=> "input:text",
            "required"	=> "Nhập số điện thoại",
			"editable"	=> false,
            "searchable"=> true,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
    "email"	=> array(
			"title"		=> "Email",
			"type"		=> "input:text",
            "required"	=> "Nhập email",
			"editable"	=> false,
            "sufix_title" => "",
            "searchable"=> true,
			"show_on_list"	=> true
	),
    "address"	=> array(
			"title"		=> "Địa chỉ",
			"type"		=> "input:text",
            "required"	=> "Nhập địa chỉ",
			"editable"	=> false,
            "sufix_title" => "",
            "searchable"=> true,
			"show_on_list"	=> true
	),
    "notes"	=> array(
			"title"		=> "Ghi chú",
			"type"		=> "input:text",
            "required"	=> "Nhập ghi chú",
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
    "date"	=> array(
			"title"		=> "Ngày tháng",
			"type"		=> "input:text",
            "required"	=> "Nhập ngày tháng",
			"editable"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
    "status"	=> array(
			"title"		=> "Tình trạng",
			"type"		=> "combobox",
            "data"      => array(0=>'Đang xử lý',1=>'Đang chuyển',2=>'Hoàn thành'),
			"editable"	=> true,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
    "action"	=> array(
			"title"		=> "In",
			"type"		=> "function",
            "function"	=> "order_print",
			"editable"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true
	)
);

$bg = new FishTable("tbl_order",$column,"id");
$bg->name = "Đặt hàng";
$bg->Cache = "CacheCart";
$bg->mylevel = 0;
$bg->eventHander();

?>