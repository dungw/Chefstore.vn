<?php
include("config.php");

// class openid
include(INC_PATH."classes/openid.class.php");

$user = array();
try {
    if(!isset($_GET['openid_mode'])) {
    	$lg = $_GET['login'];
        if(isset($_GET['login'])) {
	            $openid = new LightOpenID;
	            $openid->identity = $lg;
	            $openid->required = array('namePerson/friendly', 'contact/email', 'namePerson', 'person/gender','contact/postalCode/home','pref/language','pref/timezone','birthDate');
	            header('Location:' . $openid->authUrl());
        }
    }elseif($_GET['openid_mode'] == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
        $openid = new LightOpenID;                
 		$result =  $openid->getAttributes();       
        $openid_identity  = $openid->validate() ? $openid->identity : 'NA';        
        if(strpos($openid_identity,'google') && $openid_identity != 'NA'){            
            $openid_identity = str_replace('https://www.google.com/accounts/o8/id?id=','',$openid_identity);
            $fullname = ($result['namePerson']=='')?'':$result['namePerson'];
            $user = array(
                'email'             => $result['contact/email'],
                'fullname'          => $fullname,
                'avatar'            => '',
                'openid_identity'   => $openid_identity              
            );
            
        }else if(strpos($openid_identity,'yahoo') && $openid_identity != 'NA'){            
            $openid_identity = str_replace('https://me.yahoo.com/a/','',$openid_identity);
            $fullname = ($result['namePerson']=='')?'':$result['namePerson'];
            $user = array(
                'email'             =>  $result['contact/email'],
                'fullname'          =>  $fullname,
                'avatar'            => 'http://img.msg.yahoo.com/avatar.php?yids=hanhnguyen_rav&format=jpg',
                'openid_identity'   =>  $openid_identity                
            );
        }
    }
    
} catch(ErrorException $e) {
    echo $e->getMessage();
}

// insert to database
if(count($user)>0){
    $miniUser = new miniUser();
    $exist_user = $miniUser->getUserByEmail($user['email']);
    if(count($exist_user)>0){ // neu da ton tai rui
        global $_SESSION;
        $_SESSION['user'] = $exist_user;
    }else{ // neu chua
        $miniUser->username = $user['email'];
        $miniUser->email    = $user['email'];
        $miniUser->password = createMd5Password($user['email']);
        $miniUser->avatar   = "";
        $miniUser->phone    = "";
        $miniUser->fullname = $user['fullname'];
        $miniUser->address  =  "address";
        $miniUser->gender   = 1;
        $miniUser->date_register    = date('Y-m-d H:i:s',time());
        $miniUser->birthday         = "";
        $miniUser->desc     = "";
        $miniUser->website  = "";
        $miniUser->last_login_time  = "";
        $miniUser->last_login_ip    = "";
        $miniUser->group_id         = "1";
        $miniUser->status         = 1;
        $miniUser->insert();
        
        $exist_user = $miniUser->getUserByEmail($user['email']);
        global $_SESSION;
        $_SESSION['user'] = $exist_user;
        
    }
    
}

?>
<script type="text/javascript">
window.close();
window.opener.location.reload();
</script>