<?php

/**
 * @author duchanh
 * @copyright 2012
 */
 
class module_news_detail extends Module{
    
    function module_news_detail(){
        $this->file = 'news_detail.html';
        parent::module();
    }
    
    function draw(){
        global $skin, $title, $keywords, $description, $lang, $pathway;        
        $xtpl = new XTemplate($this->tpl);
        $miniNews = new miniNews();
        
        $skin_path  = base_url().'skin/'.$skin.'/';
        $xtpl->assign('link_home', base_url());    
        $xtpl->assign('skin_path', $skin_path);    
            
        $id = CInput::get('id','int',0);
        if($id){
            $miniNews->read($id);
            $miniNews->hits($id); // update view                    
            
            $xtpl->assign('title', $miniNews->title);			            if (date('d/m/Y',$miniNews->date) == '01/01/1970') {
            	$xtpl->assign('date', date('d/m/Y',$miniNews->date));            } else {				$xtpl->assign('date', 'Đang cập nhật');			}
            $xtpl->assign('hits', $miniNews->hits);
            $xtpl->assign('author', $miniNews->author);
            $xtpl->assign('date_edit', date('d/m/Y',$miniNews->date_edit));
            $xtpl->assign('content',$miniNews->content);
            $xtpl->assign('cur_link',curPageURL());
            
            
            // share  social net word           
            $xtpl->assign('link_share_facebook','http://www.facebook.com/share.php?src=bm&u='.curPageURL());
            $xtpl->assign('link_share_twitter','http://twitter.com/home/?status='.curPageURL().'<--'.$miniNews->title);
            $xtpl->assign('link_share_google','http://www.google.com/bookmarks/mark?op=edit&bkmk='.curPageURL().'&title='.$miniNews->title);                    
            
            $cid = $miniNews->cat_id;
            $miniNews->num_per_page = 5;
			$otherNews = $miniNews->getNews(" AND status = 1 AND cat_id = $cid AND id != $id ",'ordering','desc',1);    
            if(count($otherNews)>0){
                foreach($otherNews as $key=>$value){
                    $link = createLink('news_detail',array('id'=>$value['id'],'title'=>$value['title']));
                    $xtpl->assign('other_link',$link);
                    $xtpl->assign('other_title',$value['title']);
                    $xtpl->assign('other_title',$value['title']);                    
                    $xtpl->assign('other_date',date('H:i:s d/m/Y',$value['date']));                    
                    $xtpl->assign('other_brief',$value['brief']);                    
                    $xtpl->parse('main.other');
                }
            }else{
                $xtpl->assign('display','none');
            }
            
            // news commment
            /*
            $miniComment = new miniComment();
            $miniComment->num_perpage = 10;
            $listComment = $miniComment->getComment($id,1,'id');
            if(count($listComment)>0){
                foreach($listComment as $key=>$value){                    
                    $xtpl->assign('comment_title',$value['title']);
                    $xtpl->assign('comment_username',$value['username']);
                    $xtpl->assign('comment_date',date('H:i:s d/m/Y',$value['date']));                    
                    $xtpl->assign('comment_content',$value['content']);                    
                    $xtpl->parse('main.comment');  
                }
            }
            */
            
            $xtpl->parse('main');            
            
            $title = $miniNews->title;
            $keywords = $miniNews->meta_keyword;
            $description = $miniNews->meta_description;    
        }else{
            $title = $lang['msg_content_update'];
            $keywords = $lang['msg_content_update'];
            $description = $lang['msg_content_update'];
            $xtpl->assign('none','<p>'.$lang['msg_content_update'].'<p>');
            $xtpl->parse('main');            
        }       
        
        
        $pathway = array(
            0=> array(
                'type'  => 'link',
                'link'  => base_url().'tin-tuc',///createLink('news',array('cid'=>$miniNews->cat_id,'name'=>'tin-tuc')),
                'name'  => 'Tin tức'
                ),
            1=> array(
                'type'  => '',
                'link'  =>'javascript:void(0)',
                'name'  => $miniNews->title
                )
        );
        return $xtpl->out('main');        
    }
}

