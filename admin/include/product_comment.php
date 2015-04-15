<?php

/**
 * @author duchanh
 * @copyright 2012
 */

$column = array(             
    "item_id"	=> array(
			"title"		=> "Sản phẩm",
			"type"		=> "function",
			"function"	=> 'product_comment',
			"editable"	=> false,
            "required"	=> "",
			"show_on_list"	=> true,
			"editlink"	=> false
	),
    "username"	=> array(
			"title"		=> "Họ tên",
			"type"		=> "input:text",
			"editable"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true,
            "editable"	=> false,
			"editlink"	=> false
	),
     "user_ip"	=> array(
			"title"		=> "Địa chỉ IP",
			"type"		=> "input:text",
			"editable"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true,
            "editable"	=> false,
			"editlink"	=> false
	),
    "content"	=> array(
			"title"		=> "Nội dung",
			"type"		=> "input:text",
			"editable"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true,
            "editable"	=> false,
			"editlink"	=> false
	),
    "date"	=> array(
			"title"		=> "Ngày",
			"type"		=> "input:datetime",
			"editable"	=> false,
            "required"	=> "",
			"show_on_list"	=> true,
			"editlink"	=> false
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

$bg = new FishTable("tbl_comment",$column,"id");
$bg->name = "Bình luận";
$bg->Cache = "CacheComment";
$bg->showAddButton = false;
$bg->eventHander();
?>