<?php

/**
 * @author duchanh
 * @copyright 2012
 */

include('config.php');

$user = isset($_POST['txtName'])? addslashes($_POST['txtName']):'';
$pass = isset($_POST['pwdPass'])?addslashes($_POST['pwdPass']):'';
$code = isset($_POST['security_code'])?addslashes($_POST['security_code']):'';
$msg = "";

if(isset($_SESSION['numError']) && ((int)$_SESSION['numError']>2)&&($_SESSION['security_code']!=$code)){
	$msg = "Mã xác nhận không chính xác!";        
}else{	   
	if($user && $pass){		   
		$checkLogin = LoginAdmin($user,$pass);
        
		if($checkLogin){
			$_SESSION['numError'] = 0;
            $ref = isset($_SESSION['ref'])?$_SESSION['ref']:NULL;
            if($ref){
                header("Location: $ref");    
            }else{
                header("Location: index.php");
            }
			
			$msg = "";
		}else{
			$msg = "Tên đăng nhập hoặc mật khẩu không đúng!";
			$_SESSION['numError'] = (int)$_SESSION['numError'] + 1;
		}
	}
}

function LoginAdmin($user,$pass_in){
	global $tbl_prefix, $oDb;
	$pass = md5(md5(md5($pass_in)));
	$admin_rs = $oDb->query("select * from ". $tbl_prefix ."admin where `name`='". addslashes($user) ."' and `pass`='". $pass ."'");
	if((int)$oDb->numRows($admin_rs)>0){
		$admin = $oDb->fetchArray($admin_rs);
		$_SESSION['admin']['id'] = (int)$admin['id'];
		$_SESSION['admin']['name'] = $admin['name'];
		$_SESSION['admin']['level'] = (int)$admin['level'];
		return true;
	}else{
		return false;
	}
}
?>
<body>
<br /><br />
<center>
	<form name="frm" id="frm" action="login.php" method="post">	
	<table width="400" style="border-collapse:collapse;font-size:11px;font-family:tahoma;border-color:#CCC;border: 1px #CCC solid;background-color:#FFF;padding-bottom:10px;" border="1">
	<caption style="font-size: 11px; font-family:tahoma;color:#FF0000;"><?php echo $msg; ?></caption>
	<tr><td colspan="2" style="font-weight: bold; color:#FFF; background-color:#1788C8;padding:3px;text-align: center;" >Đăng nhập</td></tr>
	<tr><td>&nbsp;Tài khoản</td><td><input name="txtName" type="text" size="20" class="{required:true,messages:{required:'Nhập tài khoản!'}}"  /><span class="error"></span></td></tr>
	<tr><td>&nbsp;Mật khẩu</td><td><input name="pwdPass" type="password" size="20"  class="{required:true,messages:{required:'Nhập mật khẩu!'}}"/><span class="error"></span></td></tr>
	<?php if(isset($_SESSION['numError']) && (int)$_SESSION['numError']>2){?>
	<tr><td>Mã xác nhận</td><td><input name="security_code" type="text" size="9" maxlength="4" class="{required:true,minlength:4,messages:{required:'Nhập mã xác nhận!'}}"/><img title="Đổi mã khác" src="captcha/captcha.php?width=60&height=20&characters=4" id="imageCaptcha" /><span class="error"></span></td></tr>
	<?php
		}
	?>
	<tr><td>&nbsp;</td><td style="padding:3px;"><input type="submit" name="btnSubmit" value="Login" /></td></tr>
	</table>
	</form>
</center>
</body>
</html>