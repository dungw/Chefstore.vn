<?php

/**
 * @author duchanh
 * @copyright 2012
 */
 
class module_news extends Module{
    function module_news(){
        $this->file = 'news.html';
        parent::module();
    }
    function draw(){
        global $skin, $title, $keywords, $description, $lang, $pathway;            
        $xtpl = new XTemplate($this->tpl);
        $miniNews = new miniNews();
        $miniCategory = new miniCategory();
        $miniCategoryNew = new miniCategoryNew();
        $skin_path  = base_url().'skin/'.$skin.'/';
        $xtpl->assign('link_home', base_url());
        $xtpl->assign('skin_path', $skin_path);
        
        // Condition of query string
        $con = ' AND status = 1 ';
        $cid = CInput::get('cnid','int',0);
        if($cid){
            $allNewsCategory = $miniCategory->getCatByType(1);
            $list_cid = $miniCategory->getListSubCategory($allNewsCategory,$cid);
            $list_cid = trim($list_cid,',');
            $con .= " AND cat_id = $cid ";
            
            $xtpl->assign('category_name', 'Tin tức');
        }else{
            $xtpl->assign('category_name',$lang['search']);
        }
        
        // search
        $keyword = CInput::get('keyword','txt','');
        if($keyword){
            $con .= " AND ( `title` LIKE '%$keyword%' OR `author` LIKE '%$keyword%' OR `brief` LIKE '%$keyword%' ) ";
        }
        
        $miniNews->num_per_page = 12;        
        $p = CInput::get('p','int',1);
        $total_row = $miniNews->count($con);    
        $total_page = ceil($total_row/$miniNews->num_per_page);
        $pagging = pagging($p,$total_page,curPageURL());
      
        $xtpl->assign('pagging',$pagging);
        
        $order = CInput::get('order','txt','DESC');
        $sort  = CInput::get('sort','txt','ordering');        
        $listNews = $miniNews->getNews($con,$sort,$order,$p);
        if(count($listNews)>0){
            foreach($listNews as $key=>$value){
                $link = createLink('news_detail',array('id'=>$value['id'],'title'=>$value['title']));
                $xtpl->assign('link_detail',$link);
                $xtpl->assign('title',$value['title']);
                $xtpl->assign('author',$value['author']);
                $xtpl->assign('brief',$value['brief']);
                $xtpl->assign('date',date('d/m/Y',$value['date']));
                $xtpl->assign('author',$value['author']);
                if($value['img']){
                    $xtpl->assign('img','<img alt="'.$value['title'].'" src="'.base_url().$value['img'].'" />');                
                }else{
                    $xtpl->assign('img','');
                }
                
                $xtpl->parse('main.news');            
            }
        }
        $pathway = array(
            0=> array(
                'type'  => '',
                'link'  =>'javascript:void(0)',
                'name'  => "Tin tức"
                )
        );
        
        
        
        $xtpl->parse('main');
        return $xtpl->out('main');        
    }
}

