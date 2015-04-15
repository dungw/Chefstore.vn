<?php

/**
 * @author duchanh
 * @copyright 2012
 */


$column = array(
	"name"	=> array(
			"title"		=> "Tên",
			"type"		=> "input:text",						
			"searchable"=> true,
			"editlink"	=> true,
            "sufix_title" => "Ví dụ: Vietcombank",
			"show_on_list"	=> true
	),
    "chutk"	=> array(
			"title"		=> "Tên chủ TK",
			"type"		=> "input:text",						
			"searchable"=> false,
			"editlink"	=> false,
            "sufix_title" => "Ví dụ: Khoa Lai Tan",
			"show_on_list"	=> true
	),
    "chinhanh"	=> array(
			"title"		=> "Chi nhánh",
			"type"		=> "input:text",						
			"searchable"=> false,
			"editlink"	=> false,
            "sufix_title" => "Ví dụ: Vietcombank Thành công",
			"show_on_list"	=> true
	),
    /*
    "type"	=> array(
			"title"		=> "Phân loại",
			"type"		=> "combobox",
            "data"      => array(1=>'Visa / master card',2=>'Ngân hàng'),
			"editable"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
    */
	"img"	=> array(
			"title"		=> "Logo ngân hàng",
			"type"		=> "input:image",
            "required"	=> "Nhập ảnh logo ngân hàng",
			"editable"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
	"stk"	=> array(
			"title"		=> "Số tài khoản",
			"type"		=> "input:text",						
			"searchable"=> true,
			"editlink"	=> true,
            "sufix_title" => "Ví du: 1300 5206 469 345",
			"show_on_list"	=> true
	),
    /*	
    "internet"	=> array(
			"title"		=> "Internet banking",
			"type"		=> "checkbox",
			"label"		=> "Có",
			"unlabel"	=> "Không",
			"editable"	=> true,
			"show_on_list" => true,
            "sufix_title" => "Tích nếu ngân hàng có hỗ trợ Internet Banking" 
	),	
    */				
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

$bg = new FishTable("tbl_bank",$column,"id");
$bg->name = "Ngân hàng";
$bg->Cache = "CacheBank";
$bg->eventHander();
?>