<?php
require_once 'database.php';
require_once 'PHPExcel.php';
require_once 'functions.php';

$query = "SELECT * FROM tbl_category";
$db = new db_query($query);

$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);

	$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'id');
	$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'name');
    $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'parent_id');
    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'description');
	$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'url');

$rowCount = 2;
while ($row = mysql_fetch_assoc($db->result)) {
	
	$urlDetail = 'http://'. $_SERVER['HTTP_HOST'] .'/san-pham/'. $row['id'] . '/' . title_url($row['name']) . '.html';
	
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['id']);
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['name']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['parent_id']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row['description']);
	$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $urlDetail);
    $rowCount++;
} 

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Category_'. $_SERVER['HTTP_HOST'] .'.xls"'); 
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');











