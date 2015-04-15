
function show_alert_msg(_msg){
    $("#alert_msg").html(_msg).show();
}


function hide_alert_msg(){
    $("#alert_msg").html('');
}


function _showAlertMsg(_id,_msg){    
    $("#"+_id).show().html(_msg);
    var t=setTimeout("hideMsg("+_id+")",3000);    
}

function hideMsg(_id){
    $("#"+_id).slideUp(500);
}



function _redirect_order(){
    window.location = base_url + "order.html";
}

function _register_email(){
    $.ajax({            
        url : base_url + "ajax.php?cmd=register_email",
        type : "POST",
        data : {
            name    :   $("#register_name").val(),
            email   : $("#register_email").val()
        },
        beforeSend : function(xhr){
            $("#alert_email_msg").html('Loading...');
        },                
        timeout : 10000,            
        success : function(response, status){		    
            switch(response){                    
                case "EMPTY_EMAIL":                        
                    $("#alert_email_msg").removeClass("done").addClass("error").html('Bạn chưa nhập email').show();
                    return false;          	                       
                break;
                
                case "WRONG_EMAIL":                        
                    $("#alert_email_msg").removeClass("done").addClass("error").html('Email chưa đúng định dạng').show();
                    return false;          	                       
                break;                                      
                             
                case "SUCSESS": 
                    $("#alert_email_msg").removeClass("error").addClass("done").html('Bạn đăng ký thành công').show();
                    $("#register_name").val('');
                    $("#register_email").val('');
                    return false;                      
                break; 
                default:
                    $("#alert_email_msg").html("Có lỗi, vui lòng thủ lại sau").show();
                    return false;
                break;
            }
        }
    });
    return false;
    
}


function _register_email_main(){
    $.ajax({            
        url : base_url + "ajax.php?cmd=register_email",
        type : "POST",
        data : {
            name    :   $("#register_name_main").val(),
            email   : $("#register_email_main").val()
        },
        beforeSend : function(xhr){
            $("#alert_email_msg_main").html('Loading...');
        },                
        timeout : 10000,            
        success : function(response, status){		    
            switch(response){                    
                case "EMPTY_EMAIL":                        
                    $("#alert_email_msg_main").removeClass("done").addClass("error").html('Bạn chưa nhập email').show();
                    return false;          	                       
                break;
                
                case "WRONG_EMAIL":                        
                    $("#alert_email_msg_main").removeClass("done").addClass("error").html('Email chưa đúng định dạng').show();
                    return false;          	                       
                break;                                      
                             
                case "SUCSESS": 
                    $("#alert_email_msg_main").removeClass("error").addClass("done").html('Bạn đăng ký thành công').show();
                    $("#register_name_main").val('');
                    $("#register_email_main").val('');
                    return false;                      
                break; 
                default:
                    $("#alert_email_msg_main").html("Có lỗi, vui lòng thủ lại sau").show();
                    return false;
                break;
            }
        }
    });
    return false;
    
}


function _contact(){
    $.ajax({            
        url : base_url + "ajax.php?cmd=contact",
        type : "POST",
        data : {
            fullname            : $("#contact_fullname").val(),
            mobile              : $("#contact_mobile").val(),             
            email               : $("#contact_email").val(),            
            content             : $("#contact_content").val(),
        },
        beforeSend : function(xhr){            
        },                
        timeout : 10000,            
        success : function(response, status){		    
            switch(response){                    
                case "EMPTY_FULLNAME":                        
                    _showAlertMsg('msg_fullname','please enter your fullname');          	                       
                break;                 
                case "EMPTY_EMAIL":
                    _showAlertMsg('msg_email','please enter email');    
                break;
                case "WRONG_EMAIL":
                    _showAlertMsg('msg_email','please enter a valid email');    
                break;
                case "EMPTY_CONTENT":
                    _showAlertMsg('msg_content','lease enter content');    
                break;                          
                case "SUCSESS":
                    //_showAlertMsg('SUCSESS');
                    history.go(0);    
                break; 
            }
        }
    });
}

function _forgotpass(){
    $.ajax({            
        url : base_url + "ajax.php?cmd=forgot_pass",
        type : "POST",
        data : {                       
            email: $("#user_email").val()
        },
        beforeSend : function(xhr){
            _showAlertMsg('loading...');
        },                
        timeout : 10000,            
        success : function(response, status){		    
            switch(response){                              
                case "EMPTY_EMAIL":
                    _showAlertMsg('please enter email');    
                break;
                case "WRONG_EMAIL":
                    _showAlertMsg('please enter a valid email');    
                break;                                        
                case "SUCSESS":
                    _showAlertMsg('SUCSESS');    
                break; 
            }
        }
    });
}

function openPage(_page){
    window.open(_page);
}


function _comment(_id){
    $.ajax({            
        url : base_url + "ajax.php?cmd=comment",
        type : "POST",
        data : {            
            item_id : _id,
            type    : 2,
            username: $("#comment_username").val(),
            content : $("#comment_content").val(),
            captcha : $("#comment_captcha").val()
        },
        beforeSend : function(xhr){
            show_alert_msg('loading...');
        },                
        timeout : 10000,            
        success : function(response, status){            
            switch(response){   
                case "EMPTY_CONTENT":
                    show_alert_msg('Xin mời nhập nội dung');
                break; 
                
                case "WRONG_CAPTCHA":
                    show_alert_msg('Sai mã xác nhận');
                    reloadCapcha('captcha');
                break;
                
                case "SUCSESS":
                    hide_alert_msg();
                    $("#wrap_comment").append('<div class="comment"><p class="info"><b>'+$("#comment_username").val()+'</b> <span>(2 giây trước)</span></p><div class="sprite"><p class="status clearfix">'+$("#comment_content").val()+'</p></div></div>');
                    $("#comment_username").val('');
                    $("#comment_content").val('');
                    $("#comment_captcha").val('');
                break; 
            }
        }
    });  
    return false;  
}


function _loadComment(_id, _page){
    $.ajax({            
        url : base_url + "ajax.php?action=show_blog_comment",
        type : "POST",
        data : {                       
            news_id : _id,
            page : _page
        },
        beforeSend : function(xhr){
            //_showAlertMsg('loading...');
        },                
        timeout : 10000,            
        success : function(response, status){
            $("#show_blog_comment").html(response);
        }
    });    
}



function _cancelComment(){
    $("#blog_content").val('');    
}


function delComment(_id){
    if(confirm('Do you wanna delete this comment?')){
        $.ajax({            
            url : base_url + "ajax.php?action=delete_blog_comment",
            type : "POST",
            data : { comment_id : _id },
            beforeSend : function(xhr){},                
            timeout : 10000,            
            success : function(response, status){
                switch(response){                
                    case "SUCSESS":
                        $("#comment_detail_"+_id).remove();                                                                       
                    break;
                    default :
                        _showAlertMsg(response);
                        //_showAlertMsg('Error, pleate try again later...');
                    break; 
                }
            }
        });    
    }
}


function pageFAQ(page,itemeachpage){  
    request = "ajax.php?cmd=faq&p="+page+"&itemeachpage="+itemeachpage;
    $.get(request,function(result){
       $("#content_faq").html(result);
    }); 
}

function reloadCapcha(_id){
    _link_captcha = base_url + "captcha.php?width=50&height=23&characters=3r=" + Math.random();
    $("#"+_id).attr('src',_link_captcha);
}


function deleteProductCart(_pid){
    request = base_url + "ajax.php?cmd=del_cart&pid=" + _pid;
    $.get(request,function(result){
        //alert(result)
        $("#product_cart_"+_pid).remove();           
    }); 
}


$(function(){
    $(".addtocart").click(function(){
        _cur_product = $("#_number_product_cart").html();
        _product_id = $("#product_detail_id").val();
        
        request = base_url + "ajax.php?cmd=add_to_cart&pid="+_product_id+"&num=1";
        $.post(request,function(result){
           $("#content_faq").html(result);
        });
        
        _cur_product++; 
        $("#_number_product_cart").html(_cur_product);
        $("#_number_product_cart").attr('disabled','disabled');
        alert('Đã thêm vào giỏ hàng');
        
    })
    
})

function getFaqs(page, num, txt){
    request = base_url + "ajax.php?cmd=get_faqs&page="+page+"&num="+num;
    $.post(request,function(result){
       $("#wrapfaqs").html(result);
    });
}


function replyComment(_id){
    $(".replycontent").not('#replycontent_'+_id).hide();
    $("#replycontent_"+_id).show();
    _reply_content = $("#replycontent_"+_id).val();
    if(_reply_content!=''){
        request = base_url + "ajax.php?cmd=reply_faqs&id="+_id+"&content="+_reply_content;
        _current_page = $("#wrapfaqs ul.pagination li.active a").html();
        if(_current_page==null){
            _current_page = 1;
        }
        
        $.post(request,function(result){
            getFaqs(_current_page,5);
        });
    }    
}