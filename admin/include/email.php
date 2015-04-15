<?php

/**
 * @author duchanh
 * @copyright 2012
 */

$column = array(
    "name"	=> array(
			"title"		=> "Họ tên",
			"type"		=> "input:text",
			"editable"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true,
            "editable"	=> false,
			"editlink"	=> false
	),                
    "email"	=> array(
			"title"		=> "Email",
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

);

$bg = new FishTable("tbl_email",$column,"id");
$bg->name = "Email";
$bg->Cache = "CacheEmail";
$bg->eventHander();
?>