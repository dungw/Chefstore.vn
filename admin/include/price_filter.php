<?php

/**
 * @author duchanh
 * @copyright 2012
 */


$column = array( 
    "cat_id"	=> array(
			"title"		=> "Danh mục",
			"type"		=> "combobox",
			"data"		=>  getCategory(),
            "searchable"	=> true,
			"editlink"	=> true,
            "sufix_title" => "",
			"show_on_list"	=> true
	),
    "min"	=> array(
			"title"		=> "Giá bắt đầu",
			"type"		=> "input:int10",
			"required"	=> "Nhập giá bắt đầu",
			"editable"	=> true,
            "editlink"	=> true,
            "searchable"=> false,
            "sufix_title" => "Nhập giá bắt đầu",
			"show_on_list"	=> true
	),    
	"max"	=> array(
			"title"		=> "Giá kết thúc",
			"type"		=> "input:int10",
			"required"	=> "Nhập giá kết thúc",
			"editable"	=> true,
            "searchable"=> false,
            "sufix_title" => "Nhập giá kết thúc",
			"show_on_list"	=> true
	)
);
$bg = new FishTable("tbl_price_filter",$column,"id");
$bg->name = "Lọc giá";
$bg->Cache = "CachePriceFilter";
$bg->eventHander();

?>