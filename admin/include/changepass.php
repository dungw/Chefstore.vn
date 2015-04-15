<?php

/**
 * @author duchanh
 * @copyright 2012
 */
 
if($_POST['pwdOld']!=""){
	if($_SESSION['admin']['id']!=0){
		if($_POST['pwdNew'] != $_POST['pwdNew_cf']){
			echo "<center><font color='red'>Mật khẩu mới không trùng nhau!</font></center>";
		}else{
			$pass = md5(md5(md5($_POST['pwdOld'])));
			$new_pass = md5(md5(md5($_POST['pwdNew'])));
			$admin_rs = $oDb->query("select * from tbl_admin where `name`='". addslashes($_SESSION['admin']['name']) ."' and `pass`='". $pass ."'");
			if((int)$oDb->numRows($admin_rs)>0){
				//thanh cong
				$oDb->query("update ". $tbl_prefix ."admin set `pass`='". $new_pass ."' where `id`='". $_SESSION['admin']['id'] ."'");
				echo "<center><font color='green'>Chúc mừng, mật khẩu đã được thay đổi!</font></center>";
			}else{
				//mat khau cu khong dung
				echo "<center><font color='red'>Mật khẩu cũ không đúng!</font></center>";
			}
		}		
	}else{
		@header("Location: login.php");
	}
}
?>
<form name='frm' id='frm' action='index.php?f=doimatkhau' method='post'>
<h2 class="broad-title">Khu vực cá nhân</h2>
<div class="add-bar"><span>Đổi mật khẩu</span></div>
<div class="table-list table-form">
<table>
<tr><td width="30%"><b>Mật khẩu cũ</b></td>
	<td><input type="password" name="pwdOld" size="30" class="{required:true,messages:{required:'Nhập mật khẩu cũ!'}}" /><span class="error"></span></td>
</tr>	
<tr><td width="30%">Mật khẩu mới</td>
	<td><input type="password" name="pwdNew"  id="pwdNew" size="30" class="{required:true,messages:{required:'Nhập mật khẩu mới!'}}" /><span class="error"></span></td>
</tr>	
<tr><td width="30%">Gõ lại mật khẩu mới</td>
	<td><input type="password" name="pwdNew_cf"  size="30"  class="{required:true,equalTo: '#pwdNew',messages:{required:'Nhập lại mật khẩu mới!',equalTo:'Mật khẩu mới không trùng nhau!'}}" class="required" /><span class="error"></span></td>
</tr>	
<tr><td width="30%">&nbsp;</td>
	<td><input type="submit" name="btnSubmit" value="Hoàn thành" /></td>
</tr>	

</table>
</div>
</form>	