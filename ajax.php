<?php

/**
 * @author duchanh
 * @copyright 2012
 */


include("config.php");

class ajax {    
    
    function ajax(){
        $cmd = CInput::get('cmd','txt','');
        
         switch($cmd){                    
            case "contact":                        
                $this->contact();          	                       
            break;
            
            case "register_email":                        
                $this->register_email();          	                       
            break;
            
            case "update_payment":                        
                $this->update_payment();          	                       
            break;
            
            case "buynow":                        
                $this->buynow();          	                       
            break;
            
            case "faqs":                        
                $this->faqs();          	                       
            break;
            
            case "add_to_cart":                        
                $this->addtoCart();          	                       
            break;
            
            case "order":                        
                $this->insertOrder();          	                       
            break;
            
            case "update_cart":                        
                $this->updateCart();          	                       
            break; 
            
            case "delAllCart":                        
                $this->delAllCart();          	                       
            break;
            
            case "del_cart":                        
                $this->delCart();          	                       
            break;
            
            case "comment":                        
                $this->productComment();          	                       
            break;
            
            case "get_product_comment":                        
                $this->getProductComment();          	                       
            break;
            
            case "updateCartNumber":                        
                $this->updateCartNumber();          	                       
            break;
            
            case "get_faqs":                        
                $this->get_faqs();          	                       
            break;
            
            case "reply_faqs":                        
                $this->reply_faqs();          	                       
            break;
            
            case "change_lang":
                $this->change_lang();
            break;
         }
    }
    
	function change_lang() {
        $lang = CInput::get('lang','txt','vi');
        $_SESSION['language'] = $lang;
        
        echo 'ss';
    }
    
    function contact(){
        if(isset($_POST)){    
            $fullname = CInput::get('fullname','txt','');
            if($fullname==''){
                echo 'EMPTY_FULLNAME';
                exit();
            }
            
            $company    = CInput::get('company','txt','');
            $address    = CInput::get('address','txt','');
            
            
            $email = CInput::get('email','txt','');
            if($email==''){
                echo 'EMPTY_EMAIL';
                exit();
            }            
            if(!checkValidEmail($email)){
                echo 'WRONG_EMAIL';
                exit();
            }
            
            $phone      = CInput::get('phone','txt','');
            $mobile     = CInput::get('mobile','txt','');
            $yahoo      = CInput::get('yahoo','txt','');
            $skype      = CInput::get('skype','txt','');
            $fax        = CInput::get('fax','txt','');
            
            $content = CInput::get('content','txt','');
            if($content==''){
                echo 'EMPTY_CONTENT';
                exit();
            }            
            
            
            $miniContact = new miniContact();
            $miniContact->fullname  = $fullname;
            $miniContact->company   = $company;
            $miniContact->address   = $address;
            $miniContact->email     = $email;
            $miniContact->phone     = $phone;
            $miniContact->mobile    = $mobile;
            $miniContact->yahoo     = $yahoo;
            $miniContact->skype     = $skype;
            $miniContact->fax       = $fax;
            $miniContact->content   = $content;
            $miniContact->status    = 1;
            $id = $miniContact->insert();
            if($id>0){                
                $html_sendmail = '
                <div>
                <h3>Liên hệ từ</h3>
                <table>
                    <tbody><tr>
                        <td></td>
                        <td>Họ tên</td>
                        <td>:</td>
                        <td>'.$fullname.'</td>
                    </tr>                   
                    <tr>
                        <td></td>
                        <td>Email</td>
                        <td>:</td>
                        <td><a target="_blank" href="mailto:'.$email.'">'.$email.'</a></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>N?i dung</td>
                        <td>:</td>
                        <td>'.$content.'</td>
                    </tr>
                </tbody></table></div>';
                
                $from = array(
                    'email' => 'contact@nguyenduchanh.com',
                    'name'  => 'Nguyen Duc Hanh'
                );
                $to = array(
                    'email' => 'hanhcoltech@gmail.com',
                    'name'  => 'Nguyen Duc Hanh'
                );
                $reply = $from;
                
                sendMail($from,$to,$reply,'Liên hệ từ Nguyen Duc Hanh',$html_sendmail);
                echo "SS";
            }
        }
    }
    
    
    function faqs(){
        global $_SESSION;
        $faqs_username  = CInput::get('faqs_username','txt','');
        if($faqs_username==''){
            echo 'EMPTY_USERNAME';
            exit();
        }
        
        $faqs_content   = CInput::get('faqs_content','txt','');
        if($faqs_content=='' || $faqs_content=='Câu hỏi của bạn...'){
            echo 'EMPTY_CONTENT';
            exit();
        }
        
        $faqs_captcha   = CInput::get('faqs_captcha','txt','');
        if($faqs_captcha==''){
            echo 'WRONG_CAPCHA';
            exit();
        }
        
        if( $_SESSION['security_code'] != $faqs_captcha  ) {
            echo 'WRONG_CAPCHA';
            exit();
        }
        
        $miniFAQ = new miniFAQ();
        $miniFAQ->table = 'tbl_faqs';
        
        $miniFAQ->parent_id    = 0;
        $miniFAQ->user_id      = -1;
        $miniFAQ->username     = $faqs_username;
        $miniFAQ->content      = $faqs_content;
        $miniFAQ->date         = date('Y-m-d H:i:s',time());
        $miniFAQ->ip_address   = getUserIp();
        $miniFAQ->status       = 1;
        
        
        $miniFAQ->insert();
        echo "SUCSESS";
        exit;
    }
    
    
    function addtoCart(){
        global $_SESSION;
        $id = CInput::get('pid','int',0);
        $num = CInput::get('num','int',1);
        $miniProduct = new miniProduct();
        $a  = $miniProduct->addProductToCart($id);
        
    }
    
    function updateCart(){
        global $_SESSION;
        $arr_id = $_REQUEST['pid'];
        $arr_num = $_REQUEST['num'];
        foreach($arr_id as $key=>$pid){            
            $_SESSION['cart'][$pid] = $arr_num[$key];
        }
        $link_redirect = createLink('cart');
        redirect($link_redirect);
    }
    
    
    
    function delAllCart(){
        global $_SESSION;
        unset($_SESSION['cart']);
        echo 'SS';
    }
    
    function delCart(){
        global $_SESSION;
        $pid = CInput::get('pid','int',0);
        if($pid){
            unset($_SESSION['cart'][$pid]);
            echo 'SS';    
        }
    }
    
    
    function updateCartNumber(){
        $pid = CInput::get('pid','int',0);
        $num = CInput::get('num','int',1);
        $_SESSION['cart'][$pid] = $num;
        echo 'ss';
        
    }
    
    
    
    function productComment(){
        global $_SESSION;        
        
        $captcha    =   CInput::get('captcha','txt','');
        $item_id    =   CInput::get('item_id','int',0);
        $type       =   CInput::get('type','int',2);
        $username   =   CInput::get('username','txt','');
        $content    =   CInput::get('content','txt','');
        
        if($content=='Gửi ý kiến của bạn...'){
            echo 'EMPTY_CONTENT';
            exit();
        }
        if( $_SESSION['security_code'] != $captcha  ) {
            echo 'WRONG_CAPTCHA';
            exit();
        }
        
        if($item_id){
            $miniComment = new miniComment();
            $miniComment->item_id   = $item_id;
            $miniComment->type      = $type;
            $miniComment->user_id   = -1;
            $miniComment->username  = $username;
            $miniComment->user_ip   = getUserIp();
            $miniComment->date      = date('Y-m-d H:i:s',time());
            $miniComment->content   = $content;            
            $miniComment->status    = 1;
            $miniComment->insert();
            echo 'SUCSESS';
            exit();
        }
        echo 'UNSUCSESS';
        exit();
    }
    
    
    // ham tra ve ket qua tim kiem search product code
    function searchAutoComplete(){
        $q = strtoupper(trim($_REQUEST['q']));
        $limit = $_REQUEST['limit'];
        if($q){
            $miniProduct = new miniProduct();
            $result = $miniProduct->searchAutoComplete($q,$limit);
            if($result){
                foreach($result as $key=>$value){
                    $suggest = $value['name'];
                    echo "$suggest.<span style=\"float:right\"><img src=".$value['thumb']." width=\"50\" height=\"50\"></span>\n" ;
                }
            }
        }
    }
    
    
    function register_email(){
        global $oDb;
        $email = CInput::get('email','txt','');
        if($email=='' || $email=='Email'){
            echo 'EMPTY_EMAIL';
            exit();
        }
        if(!checkValidEmail($email)){
            echo 'WRONG_EMAIL';
            exit();
        }
        $name = CInput::get('name','txt','');
        $date = date('Y-m-d H:i:s',time());
        
        $sql = "INSERT INTO `tbl_email` (`id`, `name`, `email`,`date`) VALUES (NULL, '$name', '$email','$date')";
        $oDb->query($sql);
        echo 'SUCSESS';
        exit();
        
    }
    
    
    function buynow(){
        $pid = CInput::get('pid','int',0);
        $number =   CInput::get('number','int',1);
        if($pid){
            $miniProduct = new miniProduct();
            for($i=0;$i<$number;$i++){
                $miniProduct->addProductToCart($pid);    
            }
        }
        $link_redirect = createLink('cart');
        redirect($link_redirect);
                
    }
    
    
    function insertOrder(){
        global $_SESSION;
        $miniOrder = new  miniOrder();
        //$billing    = CInput::get('billing','int',1);
        $fullname   = CInput::get('fullname','txt','');
        $company    = CInput::get('company','txt','');
        $tax_code   = CInput::get('tax_code','txt','');
        $address    = CInput::get('address','txt','');
        $phone      = CInput::get('phone','txt','');
        $mobile     = CInput::get('mobile','txt','');
        $email      = CInput::get('email','txt','');
        $notes      = CInput::get('notes','txt','');
        
        //$miniOrder->billing     = $billing;
        $miniOrder->fullname    = $fullname;
        $miniOrder->company     = $company;
        $miniOrder->tax_code    = $tax_code;
        $miniOrder->address     = $address;
        $miniOrder->phone       = $phone;
        $miniOrder->mobile      = $mobile;
        $miniOrder->email       = $email;
        $miniOrder->notes       = $notes;
        $miniOrder->list_product       = json_encode($_SESSION['cart']);
        $miniOrder->status      = 0;
        $miniOrder->date        = date('Y-m-d H:i:s',time());
        $id = $miniOrder->insert();
        $_SESSION['order'] = $id;
        if($id){
            $link_redirect = createLink('order_payment');
            redirect($link_redirect);    
        }
        
    }
    
    
    function update_payment(){
        $id = CInput::get('order_id','int',0);
        $payment_type = CInput::get('payment_type','txt','');
        
        $miniOrder = new miniOrder();
        $miniOrder->payment_type    = $payment_type;
        $miniOrder->update($id,array('payment_type'));
        
        $link_redirect = createLink('order_sucess');
        unset($_SESSION['cart']);
        redirect($link_redirect);  
        
    }
    
    
    function get_faqs(){
        $page = CInput::get('page','int',1);
        $num_per_page = CInput::get('num','int',5);
        
        $faqs = getHtmlFaqs($page,$num_per_page);
        echo $faqs['html'].$faqs['pagging'];
    }
    
    
    function reply_faqs(){
        $id = CInput::get('id','int',0);
        $content = CInput::get('content','txt','');
        $miniFaqs = new miniFAQ();
        $miniFaqs->parent_id = $id;
        $miniFaqs->user_id = 0;
        $miniFaqs->username = 'VatTuNhanh';
        $miniFaqs->content = $content;
        $miniFaqs->date = date('Y-m-d H:i:s',time());
        $miniFaqs->ip_address = getUserIp();
        $miniFaqs->status = 1;
        $miniFaqs->insert();
        echo 'SS';
        
    }
    
    
    
    
}

new ajax();