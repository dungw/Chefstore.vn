<?php

/**
 * @author duchanh
 * @copyright 2012
 */


$column = array(                
    "cat_id"	=> array(
			"title"		=> "Danh mục",
			"type"		=> "function",
			"function"  => "abc",
			"editable"	=> false,
            "searchable"=> true,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
	"name"	=> array(
			"title"		=> "Tên sản phẩm",
			"type"		=> "input:text",
			"required"	=> "Nhập tên sản phẩm",
			"searchable"=> true,
			"editlink"	=> true,
            "sufix_title" => "Nhâp tên sản phẩm",
			"show_on_list"	=> true
	),
	"price"	=> array(
			"title"		=> "Giá",
			"type"		=> "input:int10",
            "required"	=> "Nhập giá sản phẩm",
			"editable"	=> true,
			"show_on_list"	=> true
	),
    "price_promotion"	=> array(
			"title"		=> "Giá KM",
			"type"		=> "input:int10",
            "required"	=> "Nhập giá khuyến mãi",
			"editable"	=> true,
			"show_on_list"	=> true
	),    
    "img"	=> array(
			"title"		=> "Ảnh sản phẩm",
			"type"		=> "input:pimage",            
			"editable"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
    "other_info"	=> array(
			"title"		=> "Thông tin khác",
			"type"		=> "textarea:noeditor",
			"sufix_title" => "",
			"show_on_list"	=> false
	),
    "specifications"	=> array(
			"title"		=> "Thông số kỹ thuật",
			"type"		=> "textarea:noeditor",
			"sufix_title" => "Nhập theo định dạng Xuất xứ: trung quốc, Chất liệu: kim loại",
			"show_on_list"	=> false
	),     
    "description"	=> array(
			"title"		=> "Miêu tả SP",
			"type"		=> "textarea",
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
    "ordering"	=> array(
			"title"		=> "Thứ tự",
			"type"		=> "input:int10",
			"editable"	=> true,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
    "in_stock"	=> array(
			"title"		=> "Còn hàng",
			"type"		=> "checkbox",
			"label"		=> "Có",
			"unlabel"	=> "Không",
			"editable"	=> true,
			"show_on_list" => true,
            "searchable"=> true,
            "sufix_title" => "" 
	),
    "home"	=> array(
			"title"		=> "Trang chủ",
			"type"		=> "checkbox",
			"label"		=> "Có",
			"unlabel"	=> "Không",
			"editable"	=> true,
			"show_on_list" => true,
            "searchable"=> true,
            "sufix_title" => "" 
	),  
    "new"	=> array(
			"title"		=> "SM Mới",
			"type"		=> "checkbox",
			"label"		=> "Có",
			"unlabel"	=> "Không",
			"editable"	=> true,
			"show_on_list" => true,
            "searchable"=> true,
            "sufix_title" => "" 
	),  
    "discount"	=> array(
			"title"		=> "Giảm giá",
			"type"		=> "checkbox",
			"label"		=> "Có",
			"unlabel"	=> "Không",
			"editable"	=> true,
			"show_on_list" => true,
            "searchable"=> true,
            "sufix_title" => "" 
	),      
    "saleoff"	=> array(
			"title"		=> "KM",
			"type"		=> "checkbox",
			"label"		=> "Có",
			"unlabel"	=> "Không",
			"editable"	=> true,
			"show_on_list" => true,
            "searchable"=> true,
            "sufix_title" => "" 
	),
    "best_seller"	=> array(
			"title"		=> "Bán chạy",
			"type"		=> "checkbox",
			"label"		=> "Có",
			"unlabel"	=> "Không",
			"editable"	=> true,
			"show_on_list" => true,
            "searchable"=> true,
            "sufix_title" => "" 
	),
    "date"	=> array(
			"title"		=> "Ngày đăng",
			"type"		=> "datetime:current",
			"editable"	=> false,
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
            "searchable"=> true,
            "sufix_title" => "" 
	),
);

$bg = new FishTable("tbl_product",$column,"id");
$bg->name = "Sản phẩm";
$bg->Cache = "CacheProduct";
$bg->eventHander();

?>