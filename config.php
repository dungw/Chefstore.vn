<?php



/**
 * @author duchanh
 * @copyright 2012
 */

session_start();

ob_start();

ini_set("display_error", "off");

ini_set('error_reporting',0);

ini_set('safe_mode','0');

date_default_timezone_set('Asia/Saigon');

// global variable about template

global $base_url, $skin, $layout, $pathway, $arrPrice;

$skin = 'default';

$layout = 'home';



$arrPrice = array(

    0   =>  'Chưa rõ',

    1   =>  'USD',

    3   =>  'VNĐ',

    2   =>  'ER'

);





// global variable about info, error, title, keyword, description 

global $info, $error, $title, $keywords, $description, $lang, $global_arr_product_by, $global_arr_price;

$title = 'Trang chủ';

$keywords = 'Trang chủ';

$description = 'Trang chủ';







// get site path

$ffc_ar = explode( "/", $_SERVER['PHP_SELF'] );

$ffc_ar_count = count( $ffc_ar );

$ffc_ar2 = array();

for( $i = 0; $i < $ffc_ar_count - 1; $i++ ) {

	$ffc_ar2[$i] = $ffc_ar[$i];

}



$ffc_webFolderName = implode( "/", $ffc_ar2 );

if( strpos( $_SERVER['SERVER_SOFTWARE'], "IIS" ) ) {

	$sPhysicPath = substr( $_SERVER['SCRIPT_FILENAME'], 0, strrpos( $_SERVER['SCRIPT_FILENAME'], '\\' ) + 1 );

} else {

	$sPhysicPath = substr( $_SERVER['SCRIPT_FILENAME'], 0, strrpos( $_SERVER['SCRIPT_FILENAME'], '/' ) + 1 );

}

$sProtocol = ( strpos( $_SERVER['SERVER_PROTOCOL'], "HTTPS" ) ) ? "https" : "http";

$sProtocol .= "://";



$sHostName 	= $_SERVER['HTTP_HOST'];

$sitePath 	= $sProtocol . $sHostName . $ffc_webFolderName . "/";

/*
// config for localhost
if(strpos(strtolower($sitePath),"localhost:2014")> 0 ){	
    // config duong dan cua site
    $base_url = "http://localhost:2014/";
	$ar = array("127.0.0.1", "root", "", "chiefstore.vn", "");
}

// config for site
if(strpos(strtolower($sitePath),"chefstore.vn")> 0 ){	
    // config duong dan cua site
    $base_url = "http://chefstore.vn/";
	$ar = array("localhost", "chefstor", "sopten105HVT", "chefstor_micro", "");
}
*/

/************ config for localhost **************/
if (strpos(strtolower($sitePath),"chefstore.loc") > 0 ) {
    $base_url = "http://chefstore.loc/";
	$ar = array("127.0.0.1", "root", "", "chefstore", "");
    $ar_en = array("127.0.0.1", "root", "", "chefstore_en", "");
}

/**************** config for web *************************/
if (strpos(strtolower($sitePath),"chefstore.vn") > 0 ) {	
    // config duong dan cua site
    $base_url = "http://chefstore.vn/";
	$ar = array("localhost", "chefstor", "chef!@$$", "chefstor_vi", "");
    $ar_en = array("localhost", "chefstor", "chef!@$$", "chefstor_en", "");
}

/** LANGUAGE */
if($_SESSION['language']=='' || $_SESSION['language']==NULL) $_SESSION['language'] = 'vi';
$language = isset($_REQUEST['language'])? $_REQUEST['language'] : $_SESSION['language'];

switch ($language){   
    case "en":    
        $dbinfo['dbHost']	= $ar_en[0];
        $dbinfo['dbUser']	= $ar_en[1];
        $dbinfo['dbPass']	= $ar_en[2];
        $dbinfo['dbName']	= $ar_en[3];
        $dbinfo['dbSesName']= $ar_en[4];
        $dbinfo['dbHostRead']	= $ar_en[0];
		$_SESSION['language'] = 'en';
    break;  
    
    case "vi":
    default:
        $dbinfo['dbHost']	= $ar[0];
        $dbinfo['dbUser']	= $ar[1];
        $dbinfo['dbPass']	= $ar[2];
        $dbinfo['dbName']	= $ar[3];
        $dbinfo['dbSesName']= $ar[4];
        $dbinfo['dbHostRead']	= $ar[0];
		$_SESSION['language'] = 'vi';
    break;
}

// file chua cac hang so
include('constant.php');

include(INC_PATH.'lang_'.$_SESSION['language'].'.php');

// load function
include(INC_PATH."function.php");

// class database
include(INC_PATH."classes/CMysqlDB.class.php");

$oDb = new CMysqlDB( $dbinfo );

// class pagging
include(INC_PATH."classes/Pagination.class.php");

// class CIinput
include(INC_PATH."classes/CInput.class.php");

// xtemplate 
include(INC_PATH."classes/xtemplate.class.php");

// class Base
include(INC_PATH."classes/Base.class.php");

// class Base
include(INC_PATH."classes/Cms.class.php");

// class Module
include(INC_PATH."classes/Module.class.php");

// class miniUser
include(INC_PATH."classes/miniUser.class.php");

// class miniUser
include(INC_PATH."classes/miniCategoryNew.class.php");

// class miniNews
include(INC_PATH."classes/miniNews.class.php");

// class upload
include(INC_PATH."classes/miniComment.class.php");

// class miniProduct
include(INC_PATH."classes/miniProduct.class.php");

// class miniProductImages
include(INC_PATH."classes/miniProductImages.class.php");

// class miniNews
include(INC_PATH."classes/miniCategory.class.php");

// class miniContact
include(INC_PATH."classes/miniContact.class.php");

// class miniBanner
include(INC_PATH."classes/miniBanner.class.php");

// class miniInfo
include(INC_PATH."classes/miniInfo.class.php");

// class tag
include(INC_PATH."classes/miniTags.class.php");

// class miniFAQ
include(INC_PATH."classes/miniFAQ.class.php");

// class upload
include(INC_PATH."classes/upload.class.php");

// class Page
include(INC_PATH."classes/miniPage.class.php");

// class Images
include(INC_PATH."classes/miniImages.class.php");

// class Order
include(INC_PATH."classes/miniOrder.class.php");

// class Bank
include(INC_PATH."classes/miniBank.class.php");

// class language
/*
global $_SESSION;

$_REQUEST['language'] = 'vi';
$language = isset($_REQUEST['language'])? $_REQUEST['language'] : $_SESSION['language'];

switch ($language) {
    case "in":
        $_SESSION['language'] = 'in';
    break;    

    case "en":
		$_SESSION['language'] = 'en';
    break;

    case "vi":
    default:
		$_SESSION['language'] = 'vi';
    break;
}
*/







