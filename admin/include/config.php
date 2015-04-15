<?php

/**
 * @author duchanh
 * @copyright 2012
 */
 
$column = array(
    "label"	=> array(
			"title"		=> "Tên",
			"type"		=> "input:readonly",
			"editable"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true,
            "editable"	=> false,
			"editlink"	=> true
	),                
    "value"	=> array(
			"title"		=> "Giá trị",
			"type"		=> "textarea:noeditor",
			"editable"	=> false,
            "sufix_title" => "Nội dung có thể thay đổi",
            "required"	=> "Nhập giá trị",
			"show_on_list"	=> true,
			"editlink"	=> false
	),
	
);

$bg = new FishTable("tbl_config",$column,"id");
$bg->name = "Cài đặt";
$bg->Cache = "CacheConfig";
//$bg->mylevel = 3;
$bg->eventHander();
?>