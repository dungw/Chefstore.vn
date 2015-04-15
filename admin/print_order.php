<?php

/**
 * @author duchanh
 * @copyright 2012
 */


include('config.php');

if(((int)$_SESSION['admin']['id']==0)||((int)$_SESSION['admin']['level']<1)){
	@header("Location: login.php");
}
ini_set("display_error", "off");
ini_set('error_reporting', 0);


$id = CInput::get('id','int',0);
$base = new Base();
$base->table = 'tbl_order';

$order = $base->get('*','AND id = '.$id);
$order = $order[0];
$list_product = json_decode($order['list_product'],true);
$miniProduct = new miniProduct();
$order_info = $miniProduct->getProductCartInfo($list_product);

$txt_thanhtoan  = 'Giao hàng thanh toán tiền';

$html = '
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>In hóa đơn vattunhanh.com</title>
<link rel="stylesheet" href="css/print_order.css" type="text/css" media="screen" title="default" />
<body>    
<div class="orderPrint">
        <h1>Phiếu báo giá kiêm biên bản bàn giao thiết bị</h1>
        <p>Ngày '.date('d',time()).' háng '.date('m',time()).' năm '.date('Y',time()).'</p>
        <h3>Số '.$id.'</h3>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <td colspan="2">Đơn vị mua:  </td><td colspan="3"><strong>'.$order['company'].'</strong></td>
                </tr>
                <tr>
                    <td colspan="2">Người đại diện:  </td><td colspan="3"><strong>'.$order['fullname'].'</strong></td>
                </tr>
                <tr>
                    <td colspan="2">Địa chỉ:  </td><td colspan="3"><strong>'.$order['address'].'</strong></td>
                </tr>
                <tr>
                    <td colspan="2">Điện thoại:   </td><td colspan="3"><strong>'.$order['phone'].'</strong></td>
                </tr>
                <tr>
                    <td colspan="2">Mobile:   </td><td colspan="3"><strong>'.$order['mobile'].'</strong></td>
                </tr>
                <tr>
                    <td colspan="2">Email:   </td><td colspan="3"><strong>'.$order['email'].'</strong></td>
                </tr>
                <tr>
                    <td colspan="2">Phương thức thanh toán: <span>'.$order['payment_type'].'</span></td>
                    <td colspan="3">Mã số thuế: <span>'.$order['tax_code'].'</span></td>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td align="right" colspan="4">Cộng</td>
                    <td align="right"><b>'.formatPrice($order_info['total_cart_price']/10).'</b></td>
                </tr>
                <tr>
                    <td align="right" colspan="4">VAT</td>
                    <td align="right"><b>10%</b></td>
                </tr>
                <tr>
                    <td align="right" colspan="4">Tổng thanh toán</td>
                    <td align="right"><b>'.formatPrice($order_info['total_cart_price'] + $order_info['total_cart_price']/10).'</b></td>
                </tr>
                <tr>
                    <td align="left" colspan="5">Số tiền viết bằng chữ:</td>
                </tr>
                <tr>
                    <td colspan="5" class="signature">
                    	<strong style="display:block; width:48%; float:left;">Người mua</strong>
                        <strong style="display:block; width:48%; float:right;">Người bán</strong>
                    </td>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <th width="5%">TT</th>
                    <th width="50%">Tên hàng hoá/ Mã sản phẩm</th>
                    <th width="15%">Đơn giá (VNĐ)</th>
                    <th width="10%">Số lượng</th>
                    <th width="20%">Thành tiền (VNĐ)</th>
                </tr>';
                $i = 1;
                foreach($order_info as $key=>$value){
                    if($i==count($order_info)) break;
                    $html.= '
                    <tr>
                        <td align="center"><p>'.$i.'</p></td>
                        <td align="left">
                        	<p>'.$value['name'].'</p>
                            <p>Mã: <b>FBB_'.$value['id'].'</b></p>
                        </td>
                        <td align="right"><p><strong>'.formatPrice($value['price']).'</strong></p></td>
                        <td align="center"><p>  x   <strong>'.$value['number'].'</strong></p></td>
                        <td align="right"><p> = <strong>'.formatPrice($value['cart_price']).'</strong></p></td>
                    </tr>';
                    $i++;
                }
                $html.= '
            </tbody>
        </table>
        <input type="button" value="In hoá đơn" class="submit" style="padding:2px;" onclick="JavaScript:window.print();" />        
    </div>    
</body>';

echo $html;
exit;

include("MPDF/mpdf.php");
$mpdf = new mPDF();
$mpdf->useAdobeCJK = true;
$mpdf->SetAutoFont(AUTOFONT_ALL);
$mpdf->WriteHTML($html);
$save_file = $dir_bill.$filename.'.pdf';
$mpdf->Output(); //Neu xuat ra file $mpdf->Output('dir/ten_file_pdf', 'F');


?>
