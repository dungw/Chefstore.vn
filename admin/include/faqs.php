<?php

/**
 * @author duchanh
 * @copyright 2012
 */

$column = array(
    "username"	=> array(
			"title"		=> "Họ tên",
			"type"		=> "input:text",
			"editable"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true,
            "editable"	=> false,
			"editlink"	=> false
	),                
    "content"	=> array(
			"title"		=> "Câu hỏi",
			"type"		=> "input:text",
			"editable"	=> false,
            "required"	=> "",
			"show_on_list"	=> true,
			"editlink"	=> false
	),
    "date"	=> array(
			"title"		=> "Ngày dang ký",
			"type"		=> "input:datetime",
			"editable"	=> false,
            "required"	=> "",
			"show_on_list"	=> true,
			"editlink"	=> false
	),
    "ip_address"	=> array(
			"title"		=> "Ip address",
			"type"		=> "input:text",
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

$bg = new FishTable(" tbl_faqs",$column,"id");
$bg->name = "Hỏi đáp";
$bg->Cache = "CacheFaqs";
$bg->eventHander();
?>