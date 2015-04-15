<?php

/**
 * @author duchanh
 * @copyright 2012
 */


$column = array(
    "name"	=> array(
			"title"		=> "Tên key (Click vào đó để sửa nội dung)",
			"type"		=> "input:text",
			"editable"	=> false,
            "sufix_title" => "<em style=\"color:red\">Tuyệt đối không thay đổi phần này</em>",
			"show_on_list"	=> true,
            "editable"	=> false,
			"editlink"	=> true
	),                
    "content"	=> array(
			"title"		=> "HTML footer",
			"type"		=> "textarea",
			"editable"	=> false,
            "required"	=> "Nhập HTML footer",
            "sufix_title" => "",
			"show_on_list"	=> false,
			"editlink"	=> false
	),
	
);

$bg = new FishTable("tbl_footer",$column,"id");
$bg->name = "SEO footer";
$bg->Cache = "CacheFooter";
$bg->eventHander();
?>