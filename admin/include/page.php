<?php

/**
 * @author duchanh
 * @copyright 2012
 */

$column = array(
    "name"	=> array(
			"title"		=> "Tên trang",
			"type"		=> "input:text",
			"editable"	=> false,
            "required"	=> "Nhập tên trang",
            "sufix_title" => "<em style=\"color:red\">Tuyệt đối không thay đổi phần này</em>",
			"show_on_list"	=> true,
            "editable"	=> false,
			"editlink"	=> true
	),                
    "meta_title"	=> array(
			"title"		=> "Title <meta tags>",
			"type"		=> "input:text",
			"editable"	=> true,
            "required"	=> "Title",
			"show_on_list"	=> true,
			"editlink"	=> false
	),
    "meta_keyword"	=> array(
			"title"		=> "Nhập keywords <meta tags>",
			"type"		=> "input:text",
			"editable"	=> true,
            "required"	=> "Nhập số điện thoại đại lý",
			"show_on_list"	=> true,
			"editlink"	=> false
	),
    "meta_description"	=> array(
			"title"		=> "Nhập description <meta tags>" ,
			"type"		=> "input:text",
            "editable"	=> true,
			"editable"	=> true,
            "sufix_title" => "",
			"show_on_list"	=> true
	)
);

$bg = new FishTable("tbl_page",$column,"id");
$bg->name = "SEO page";
$bg->Cache = "CachePage";
//$bg->mylevel = 0;
$bg->eventHander();
?>