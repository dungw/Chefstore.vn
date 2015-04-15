<?php

/**
 * @author duchanh
 * @copyright 2012
 */


$column = array(
	"name"	=> array(
			"title"		=> "Tên đăng nhập",
			"type"		=> "input:text",						
			"searchable"=> true,
			"editlink"	=> true,
            "sufix_title" => "Nhập tên đăng nhập",
			"show_on_list"	=> true
	),
	"pass"	=> array(
			"title"		=> "Mật khẩu",
			"type"		=> "input:password",
            "required"	=> "Mật khẩu",
			"editable"	=> false,
            "editlink"	=> false,
			"searchable"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> false
	),
	"email"	=> array(
			"title"		=> "Email",
			"type"		=> "input:text",
            "required"	=> "Nhập email",
			"editable"	=> false,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
	"level"	=> array(
			"title"		=> "Cấp độ",
			"type"		=> "combobox",
			"data"		=> array(1=>'User',1=>'Mod',2=>'Admin',3=>'Supper Admin'),
			"editable"	=> false,
            "searchable"=> true,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
);

$bg = new FishTable("tbl_admin",$column,"id");
$bg->name = "Admin";
$bg->Cache = "CacheAdmin";
$bg->eventHander();


?>