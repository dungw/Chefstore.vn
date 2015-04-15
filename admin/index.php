<?php		

/**
 * @author duchanh
 * @copyright 2012
 */ 
 
include('config.php');
include('fishtable.php');
include('ext.function.php');

if(((int)$_SESSION['admin']['id']==0)||((int)$_SESSION['admin']['level']<1)){
    $ref = curPageURL();
    $_SESSION['ref'] = $ref;
	@header("Location: login.php");
}
//load html header
include('header.php');
ini_set("display_error", "off");
ini_set('error_reporting', 0);
?>
<div id="banner">
<a href="index.php" title="Trang chủ" id="logo"><img src="images/logo.png" /></a>
</div>
<div class="quick_menu">
<b><?php echo $_SESSION['admin']['name']; ?></b>&nbsp; &nbsp; | <a href="index.php?f=doimatkhau">Đổi mật khẩu</a> | <a href="logout.php" onClick="return confirm('Bạn có chắc muốn thoát?');">Thoát</a>
</div>
<table width="100%" height="100%"><tr><td width="200" valign="top" class="menu" align="center">
<div class="nav">
<ol style="text-align:left;">
<?php
	if((int)$_SESSION['admin']['level']>=3){
?>

<!-- BEGIN san pham -->
<li><a href="index.php?f=aboutus" <?php echo (isset($_GET['f']) && $_GET['f']=="aboutus")?"class='mnu_select'":""; ?>><strong>Giới thiệu</strong></a></li>
<li><a href="javascript:void(0)"><strong style="font-size: 120%;">Sản phẩm</strong></a></li>
<li><a href="index.php?f=category" <?php echo (isset($_GET['f']) && $_GET['f']=="category")?"class='mnu_select'":""; ?>>-- Nhóm sản phẩm</a></li>
<li><a href="index.php?f=product" <?php echo (isset($_GET['f']) && $_GET['f']=="product")?"class='mnu_select'":""; ?>>-- Sản phẩm</a></li>
<li><a href="index.php?f=price_filter" <?php echo (isset($_GET['f']) && $_GET['f']=="price_filter")?"class='mnu_select'":""; ?>>-- Lọc giá</a></li>
<li><a href="index.php?f=order" <?php echo (isset($_GET['f']) && $_GET['f']=="order")?"class='mnu_select'":""; ?>>-- Order</a></li>
<li><a href="index.php?f=email" <?php echo (isset($_GET['f']) && $_GET['f']=="email")?"class='mnu_select'":""; ?>>-- Email</a></li>
<li><a href="index.php?f=product_comment" <?php echo (isset($_GET['f']) && $_GET['f']=="product_comment")?"class='mnu_select'":""; ?>>-- Bình luận</a></li>
<!-- END san pham -->

<!-- BEGIN tin tuc -->
<li><a href="javascript:void(0)"><strong style="font-size: 120%;">Tin tức</strong></a></li>
<li><a href="index.php?f=news_category" <?php echo (isset($_GET['f']) && $_GET['f']=="news_category")?"class='mnu_select'":""; ?>>-- Nhóm tin</a></li>
<li><a href="index.php?f=news" <?php echo (isset($_GET['f']) && $_GET['f']=="news")?"class='mnu_select'":""; ?>>-- Tin tức</a></li>
<!-- END tin tuc -->

<li><a href="javascript:void(0)"><strong style="font-size: 120%;">Liên hệ</strong></a></li>
<li><a href="index.php?f=contact" <?php echo (isset($_GET['f']) && $_GET['f']=="contact")?"class='mnu_select'":""; ?>>-- Liên hệ</a></li>
<li><a href="index.php?f=bank" <?php echo (isset($_GET['f']) && $_GET['f']=="bank")?"class='mnu_select'":""; ?>>-- Ngân hàng</a></li>


<!-- BEGIN user -->
<li><a href="javascript:void(0)"><strong style="font-size: 120%;">Người dùng</strong></a></li>
<li><a href="index.php?f=admin" <?php echo (isset($_GET['f']) && $_GET['f']=="admin")?"class='mnu_select'":""; ?>>-- Admin</a></li>
<li><a href="index.php?f=user" <?php echo (isset($_GET['f']) && $_GET['f']=="user")?"class='mnu_select'":""; ?>>-- User</a></li>
<!-- END user -->


<!-- BEGIN other -->
<li><a href="javascript:void(0)"><strong style="font-size: 120%;">Mục khác</strong></a></li>
<li><a href="index.php?f=banner" <?php echo (isset($_GET['f']) && $_GET['f']=="banner")?"class='mnu_select'":""; ?>>-- Banner</a></li>
<li><a href="index.php?f=config" <?php echo (isset($_GET['f']) && $_GET['f']=="config")?"class='mnu_select'":""; ?>>-- Cài đặt</a></li>
<li><a href="index.php?f=page" <?php echo (isset($_GET['f']) && $_GET['f']=="page")?"class='mnu_select'":""; ?>>-- SEO</a></li>
<li><a href="index.php?f=media" <?php echo (isset($_GET['f']) && $_GET['f']=="media")?"class='mnu_select'":""; ?>>-- Media</a></li>
<li><a href="index.php?f=faqs" <?php echo (isset($_GET['f']) && $_GET['f']=="faqs")?"class='mnu_select'":""; ?>>-- Hỏi đáp</a></li>
<li><a href="index.php?f=crawl" <?php echo (isset($_GET['f']) && $_GET['f']=="crawl")?"class='mnu_select'":""; ?>>-- Crawl</a></li>
<li><a href="index.php?f=link" <?php echo (isset($_GET['f']) && $_GET['f']=="link")?"class='mnu_select'":""; ?>>-- Link</a></li>
<!-- END other -->

<?php
	}
?>
</td><td class="content main_content_panel" valign="top">
<?php
	$page = isset($_GET['f']) ? $_GET['f']: "";
	/********************************** Demo ************************************/
	switch($page){
		
        case "category":
            include("include/category.php");
		break;
        
        case "link":
            include("include/link.php");
		break;
        
        case "crawl":
            include("include/crawl.php");
		break;
        
        case "product":
			include("include/product.php");
		break;
        
        case "product_comment":
			include("include/product_comment.php");
		break;
        
        case "order":
            include("include/order.php");
        break;        
        
        case "banner":
			include("include/banner.php");
		break;        
	    
        case "bank":
			include("include/bank.php");
		break;        
        
        case "email":
			include("include/email.php");
		break;
        
		case "news":
			include("include/news.php");
		break;
        
        case "news_category":
			include("include/news_category.php");
		break;
       
        case "contact":
			include("include/contact.php");
		break;
        
        case "aboutus":
			include("include/aboutus.php");
		break;
        
        case "footer":
			include("include/footer.php");
		break;
        
        case "config":
			include("include/config.php");
		break;
        
        case "dealer":
			include("include/dealer.php");
		break;
        
        case "page":
			include("include/page.php");
		break;
        
        case "admin":
			include("include/admin.php");
		break;
        
        case "user":
			include("include/user.php");
		break;
        
        case "media":
			include("include/media.php");
		break;
        
        case "doimatkhau":
			include("include/changepass.php");
		break;
        
        case "module":
			include("include/module.php");
		break;        
        
        case "price_filter":
			include("include/price_filter.php");
		break;
        
        case "faqs":
			include("include/faqs.php");
		break;
       
        default:
            include("include/home.php");
        break;
        
        
        case "test":
			include("include/test.php");
		break;      
	
	}
	?>
	
</td></tr></table>
