<?php

/**
 * @author duchanh
 * @copyright 2012
 */ 
 
class miniFAQ extends Base{
    var $pk = 'id';
	var $pk_auto = true;//Primary key auto increment
	var $fields = array("user_id","username","parent_id","content","date","ip_address","status"); //fields in table (excluding Primary Key)	
	var $table = "tbl_faq";
    var $key_prefix = "miniFAQ_";//cache key prefix
    var $Cache = 'CacheFAQ';    
    var $info = false;
    
    
    /**
     * @Desc get FAQ
     * @param string $con: condition
     * @param string $sort: field want to sort     
     * @return array
     */
    function getFAQ($page, $numrow = 30){
        global $oDb;
        $start = ($page-1)*$numrow;
        $list_faq =  $this->get('id, user_id, username, parent_id, content, date', ' AND status = 1 AND parent_id = 0 ','id DESC',$start,$numrow);
        $list_id = '';
        if(count($list_faq)>0){
            foreach($list_faq as $key=>$value){
                $list_id .= $value['id'].',';
            }
        }        
        $list_id = trim($list_id,',');
        
        if($list_id){            
            $list_answer = $this->getAnswer($list_id);
            foreach($list_faq as &$value){
                if(isset($list_answer[$value['id']])){
                    $value['answer'] = $list_answer[$value['id']];
                }   
            }            
        }
        
        return $list_faq; 
        
    }
    
    
    function getAnswer($list_id){
        $answer = array();
        $result =  $this->get("id, user_id, username, parent_id, content, date"," AND parent_id IN ($list_id) AND `status` = 1 "," ID DESC ");
        if(count($result)>0){
            foreach($result as $key=>$value){
                $answer[$value['parent_id']] = $value;
            }
        }
        return $answer;
    }
   
}