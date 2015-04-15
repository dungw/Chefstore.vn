<?php 
//if(!defined('ALLOW_ACCESS')) exit('No direct script access allowed');

/**
 * @author duchanh
 * @copyright 2012
 */
 

$column = array(
    "name"	=> array(
			"title"		=> "Tiêu đề",
			"type"		=> "input:text",
			"editable"	=> false,
            "sufix_title" => "Tiêu đề",
			"show_on_list"	=> true,
            "editable"	=> false,
			"editlink"	=> true
	),                
    "content"	=> array(
			"title"		=> "Nội dung",
			"type"		=> "textarea",
			"editable"	=> false,
            "required"	=> "Nội dung",
            "sufix_title" => "",
			"show_on_list"	=> false,
			"editlink"	=> false
	),	
);

$bg = new FishTable("tbl_aboutus",$column,"id");
$bg->name = "Giới thiệu";
$bg->Cache = "CacheAboutus";
$bg->eventHander();

?>