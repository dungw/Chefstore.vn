<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title><?php echo $admin_title;?> - Administration</title>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/lf.1.0.2.js?dfsd=sdsdf"></script>
	
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<script type="text/javascript" src="js/jquery.maskedinput-1.0.js"></script>
	<script type="text/javascript" src="js/jquery.metadata.js"></script>
	<script type="text/javascript" src="js/jquery.alphanumeric.js"></script>
	<script type="text/javascript" src="js/ajaxupload.js"></script>
    <script type="text/javascript" src="js/fileuploader.js"></script>    
    
	<link rel="stylesheet" href="css/style.css?sds=sddd" />
	<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.6.custom.css" rel="stylesheet" />
	<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
	
    
    <!--------- Editor ------------->
    <script type="text/javascript" src="editor/fckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="editor/ckfinder/ckfinder.js"></script>
	<script type="text/javascript">
    base_url = "<?php echo base_url();?>"
    
	function ajaxfilemanager(field_name, url, type, win) {
			var ajaxfilemanagerurl = "tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php";
			switch (type) {
				case "image":
					break;
				case "media":
					break;
				case "flash": 
					break;
				case "file":
					break;
				default:
					return false;
			}
            tinyMCE.activeEditor.windowManager.open({
                url: "tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php",
                width: 782,
                height: 440,
                inline : "yes",
                close_previous : "no"
            },{
                window : win,
                input : field_name
            });
 
		}
</script>


	<script language="javascript" type="text/javascript">			
		$(document).ready(function(){
			$('.input-image').each(function(){
				var id = $(this).parent('td').find('a').attr('id');
				var button = $(this).parent('td').find('a');
				var label = $(this).parent('td').find('span');
				new AjaxUpload(id, {
		            action: 'upload-handler.php',
					data : {
						'key1' : "This data won't",
						'key2' : "be send because",
						'key3' : "we will overwrite it"
					},
					onSubmit : function(file , ext){
		                // Allow only images. You should add security check on the server-side.
						if (ext && /^(jpg|png|jpeg|gif|JPG|PNG|JPEG|GIF)$/.test(ext)){
							/* Setting data */
							this.setData({
								'key': 'This string will be send with the file',
                                'type': '<?php echo isset($_REQUEST['f'])?$_REQUEST['f']:'';?>'                                
							});					
								
							interval = window.setInterval(function(){
								var text =label.text();
								if (text.length < 13){
									label.text(text + '.');					
								} else {
									label.text('Đang tải');				
								}
							}, 200);
						
						} else {					
							// extension is not allowed
							label.html('<font color=red>Lỗi: Chỉ hỗ trợ định dạng (jpg|png|jpeg|gif)</font>');
							// cancel upload
							return false;				
						}		
					},
					onComplete : function(file,response){
						window.clearInterval(interval);
						label.html('(<i>'+ file +'</i>)');			
						button.text('Đổi ảnh khác');
						button.parent('td').find('input').val(response);
						button.parent('td').find('img').attr('src','..'+response);
						
					}		
				});
			});
			
			
			var validator = $("#frm").validate({
				errorElement: "em",
				errorPlacement: function(error, element) {
					//error.appendTo( element.parent("td").next("td") );
					error.appendTo( element.parent("td").find("span.error") );
					element.parent("td").find("span.error").show();
				},
				success: function(label) {
					label.text("Ok!").addClass("success");
				}
			});
			
			
            
            $('.input-image-product').each(function(){
				var id = $(this).parent('td').find('a').attr('id');
				var button = $(this).parent('td').find('a');
				var label = $(this).parent('td').find('span');
				new AjaxUpload(id, {
		            action: 'upload-handler.php',
					data : {
						'key1' : "This data won't",
						'key2' : "be send because",
						'key3' : "we will overwrite it"
					},
					onSubmit : function(file , ext){
		                // Allow only images. You should add security check on the server-side.
						if (ext && /^(jpg|png|jpeg|gif|JPG|PNG|JPEG|GIF)$/.test(ext)){
							/* Setting data */
							this.setData({
								'key': 'This string will be send with the file',
                                'type': '<?php echo isset($_REQUEST['f'])?$_REQUEST['f']:'';?>'                                
							});					
								
							interval = window.setInterval(function(){
								var text =label.text();
								if (text.length < 13){
									label.text(text + '.');					
								} else {
									label.text('Đang tải');				
								}
							}, 200);
						
						} else {					
							// extension is not allowed
							label.html('<font color=red>Lỗi: Chỉ hỗ trợ định dạng (jpg|png|jpeg|gif)</font>');
							// cancel upload
							return false;				
						}		
					},
					onComplete : function(file,response){
                        _imgdelete = '<img src="images/close.gif" class="images_close" onclick="deleteProductImages(-1)">';
					    _img = '<div class="wrap_pimages" id="pimg_1"><img src="..'+response+'" width="50" />'+_imgdelete+'</div>'
                        old_response = button.parent('td').find('input').val();
                        new_response = old_response + '|'+response;
                                                
						window.clearInterval(interval);
						label.html('(<i>'+ file +'</i>)');			
						button.text('Chọn thêm ảnh');
						button.parent('td').find('input').val(new_response);
						button.parent('td').find('#wrap_pdoruct_images').append(_img);
						$(this).parent('td').find('#wrap_pdoruct_images').append(_img);
						
					}		
				});
			});
            
            
            
            	
			});
		

		

		
	</script>
	
	<script type="text/javascript">
		$(document).ready(function(){
			$('#btnAddSubmit').click(function(){
				$('.txa').each(function(){
					$(this).val(tinyMCE.get($(this).attr('id')).getContent());
				});
			});
			
			$('.input-number').each(function(){
				$(this).numeric();
			});
			
			//update image in add
			$('.input-image').each(function(){
				$(this).blur(function(){
					//$(this).next('.image_review').attr('src',$(this).val());
					if($(this).val()==""){
						$(this).parent('td').find('.image_review').attr('src','images/noimage.jpg');
					}else{
						$(this).parent('td').find('.image_review').attr('src','../images/uploaded/'+$(this).val());
					}	
				});
			});
		});
	</script>
    
    <script type="text/javascript">
    function deleteProductImages(id){
        if(confirm('Bạn có chắc muốn xóa?')){
            $.ajax({
        		type: "POST",
        		url: "ajax.php?cmd=delete_product_images&id="+id,
        		success: function(response) {
        		  if(response=='ss'){
        		      $("#pimg_"+id).remove();
        		  }
        		}
        	});
        }        
    }
    </script>
	
</head>
<body>