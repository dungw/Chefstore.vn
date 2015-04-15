<?php
ini_set('memory_limit', '512M');

require_once 'database.php';
require_once 'PHPExcel.php';
require_once 'functions.php';

// COUNT
$page = 2000;
$sqlCount = 'SELECT id FROM tbl_product';
$dbCount = new db_query($sqlCount);
$total = mysql_num_rows($dbCount->result);
if ($total > $page) {
	Generation(true, $total, $page);
} else {
	Generation();
}
unset($dbCount);


/** FUNCTION GENERATION */
function Generation($multi=false, $total, $page) {
	$query = "SELECT id,name,description,price,manufacturer FROM tbl_product";
	if ($multi) {
		if ($total > $page) {
			$a = $total % $page;
			if ($a) {
				$num = intval($total/$page) + 1;
			} else {
				$num = intval($total/$page);
			}
			
			// GET $p
			$p = intval(trim($_GET['p']));
			if ($p >= $num) die('Done!'); 
			if (!$p) $p = 0;
			$start = $p + 1;
			$end = $p + 3;
			$p = $end;
			
			for ($i=$start; $i<=$end; $i++) {
				$query = "SELECT id,name,description,price,manufacturer FROM tbl_product LIMIT ". ($i-1)*$page . ',' . $page;
				$db = new db_query($query);
				
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->setActiveSheetIndex(0);
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'name');
				$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'description');
				$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'price');
				$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'manufacturer');
				$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'url');
				
				$rowCount = 2;
				while ($row = mysql_fetch_assoc($db->result)) {
					
					$urlDetail = 'http://chefstore.vn/san-pham/'. $row['id'] . '-' . title_url($row['name']) . '.html';
					
				    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['name']);
				    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['description']);
				    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['price']);
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row['manufacturer']);
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $urlDetail);
				    $rowCount++;
				}
				
				$filename = 'Products_chefstore_'. $i .'.xls';
				
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				if (!is_dir('temp/'. date('Y_m_d'))) {
					mkdir('temp/'. date('Y_m_d'));
				}
				$objWriter->save('temp/'. date('Y_m_d') . '/' . $filename);
				$arName[] = $filename;
				
				unset($objPHPExcel);
				unset($objWriter);
				unset($db);
			}
		}
		
		if (!empty($arName)) {
			
			// ZIP FILES
			/*
			$zipname = 'Product_'. time() .'.zip';
			$zip = new ZipArchive;
			$zip->open($zipname, ZipArchive::CREATE);
			foreach ($arName as $file) {
				$zip->addFile('temp/' . $file);
			}
			$zip->close();
			
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'. $zipname .'"'); 
			header('Cache-Control: max-age=0');
			*/
			var_dump($arName);
			print '<meta http-equiv="refresh" content="1;url=http://'. $_SERVER['HTTP_HOST'] .'/service/sv_product.php?p='. ($p-1) .'" />';
		}
	} else {
		$db = new db_query($query);
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'name');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'description');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'price');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'manufacturer');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'url');
		
		$rowCount = 2;
		while ($row = mysql_fetch_assoc($db->result)) {
			
			$urlDetail = 'http://chefstore.vn/san-pham/'. $row['id'] . '-' . title_url($row['name']) . '.html';
			
		    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['name']);
		    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['description']);
		    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['price']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row['manufacturer']);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $urlDetail);
		    $rowCount++;
		}
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Products_'. $_SERVER['HTTP_HOST'] .'_'. time() .'.xls"'); 
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		
		unset($objPHPExcel);
		unset($objWriter);
		unset($db);
	}
}









