$(document).ready(function(){
    
            $(window).scroll(function () {
    			if ($(this).scrollTop() > 292) {
    				$('#navigation').addClass('pin').fadeIn();
    			} else {
    				$('#navigation').removeClass('pin');
    			}
    		});
            
            
			$('.checkAll').click(function(){
				var checked = $(this).attr('checked')?true:false;
				$('.idItem').each(function(){
						if(checked){
							$(this).parent('td').parent('tr').css('background-color','#fff6b9');
						}else{
							$(this).parent('td').parent('tr').css('background-color','');
						}
						$(this).attr('checked',checked);
				});
			});
			
			$('.idItem').click(function(){
				var hasChecked = ($('.idItem:not(:checked)').length>0)?false:true;
				$('#checkAll').attr('checked',hasChecked);
				if($(this).attr('checked')){
					$(this).parent('td').parent('tr').css('background-color','#fff6b9');
				}else{
					$(this).parent('td').parent('tr').css('background-color','');
				}
			});
			
			$('.btnDelete').click(function(){
				if($('.idItem:checked').length==0){
					alert("Chưa có "+ $('#listName').val() +" nào được chọn!");
					return false;
				}
				var idList = "0";
				$('.idItem:checked').each(function(){
					idList += "," + $(this).val();
				});
				$('#listID').val(idList);
				$('#action').val("del");
				if(confirm('Xóa bỏ các '+ $('#listName').val() +' đang được chọn?',false)==true){
					$('#frm').submit();
				}
			});
			
			$('.btnNew').click(function(){
				$('#action').val("new");
				$('#frm').submit();
			});
			
			//css
			$('.row').each(function(){
				$(this).mouseover(function(){
					$(this).find('td').css('background-color','#ffffaa');
				});
				$(this).mouseout(function(){
					$(this).find('td').css('background-color','');
				});
			});
			
			
			//menu
			$('.nav li a.parent_link').each(function(){
				$(this).click(function(){
					if($(this).parent('li').hasClass('parent_menu')){
						$(this).parent('li').removeClass('parent_menu');
						$(this).parent('li').addClass('parent_selected');
					}else if($(this).parent('li').hasClass('parent_selected')){
						$(this).parent('li').addClass('parent_menu');
						$(this).parent('li').removeClass('parent_selected');
					}
				});
				
			});
			
			
	// su kien cua nhung input-price
	$('.price-input').each(function(){
			var ichars = "!@#$%^&*()+=[]\\\';/{}|\":<>?~`.- ABCDEFGHIJKLMNOPQRSTUVWXYZÉÈẺẸẼÊẾỂỀỆỄÝỶỲỴỸÚỦÙỤŨƯỨỬỰỪỮÓỎÒỌÕÔỐỔỘỒỖƠỚỞỜỢỠÂẤẦẨẬẪĂẮẲẶẰẴĐabcdefghijklmnopqrstuvwxyzéèẻẹẽêếểềệễýỷỳỵỹúủùụũưứửựừữóỏòọõôốổộồỗơớởờợỡâấầẩậẫăắẳặằẵđ";
			s = "0123456789".split('');
			for ( i=0;i<s.length;i++) if (ichars.indexOf(s[i]) != -1) s[i] = "\\" + s[i];
			var allow = s.join('|');
			
			var reg = new RegExp(allow,'gi');
			var ch = ichars;
			ch = ch.replace(reg,'');
			
			$(this).keypress
						(
							function (e)
								{
									if(e.charCode==0){
										$(this).val('');
									}else{
										if (!e.charCode) k = String.fromCharCode(e.which);
											else k = String.fromCharCode(e.charCode);
										
										if(($(this).val()=="")&&(k=='0')) e.preventDefault();
										else{
										if (ch.indexOf(k) != -1) e.preventDefault();
										else {
											var arr = $(this).val()+k;
											arr = arr.replace(/[^0-9]/g,'');
											arr = arr.split('');
											var result = "";
											var count = 0;
											for(i=arr.length-1;i>=0;i--){
												if(arr[i]!=""){
												count++;
												result = arr[i] + result;
												if((count >= 3)&&(i>0)){
													count = 0;
													result = "," + result;
												}
												}
											}
											
											$(this).val(result);
											$('#' +$(this).attr('valto')).val(result.replace(/[^0-9]/g,''));
										}
										
										}
										if (e.ctrlKey&&k=='v') e.preventDefault();
										e.preventDefault();
									}
								}
								
								
						);
		// su kien thay doi gia tri o price				
		$(this).change(function(){
			var arr = $(this).val();
			arr = arr.replace(/[^0-9]/g,'');
			arr = arr.split('');
			var result = "";
			var count = 0;
			for(i=arr.length-1;i>=0;i--){
				if(arr[i]!=""){
				count++;
				result = arr[i] + result;
				if((count >= 3)&&(i>0)){
					count = 0;
					result = "," + result;
				}
				}
			}
			
			$(this).val(result);
			
		});
		
		$(this).val($(this).attr('rel'));				
		
		$(this).blur(function(){
			if($(this).val()==""){
				$(this).val('0');
			}
			$('#' +$(this).attr('valto')).val($(this).val().replace(/[^0-9]/g,''));
		});
		
		$(this).focus(function(){
			if($(this).val()=="0"){
				$(this).val('');
			}
		});
		
	});
	
	
	$('.inputdate').each(function(){
		$(this).datetimepicker({
			closeText: 'Xong',
			prevText: 'Lùi',
			nextText: 'Tiến',
			currentText: 'Hiện tại',
			monthNames: ['T1','T2','T3','T4','T5','T6',
			'T7','T8','T9','T10','T11','T12'],
			dayNamesShort: ['CN','T2','T3','T4','T5','T6','T7'],
			dayNamesMin: ['CN','T2','T3','T4','T5','T6','T7'],
			weekHeader: 'Не',
			dateFormat: 'yy-mm-dd',
			timeFormat: 'hh:mm:ss',
			showMonthAfterYear: false,
			yearSuffix: '',
			timeText: 'Thời gian',
			hourText: 'Giờ',
			minuteText: 'Phút',
			secondText: 'Giây'
		});
	});
			
		});
		
		//del
		function del(id){
			if(confirm('Xóa bỏ '+ $('#listName').val() +' này?')){
				$('#action').val("del");
				$('#listID').val(id);
				$('#frm').submit();
			}
		}
		
		function edit(id){
			$('#action').val("edit");
				$('#listID').val(id);
				$('#frm').submit();
		}
		
		function order(orderby, dir){
			$('#current_page').val(1);
			$('#orderby').val(orderby);
			$('#orderby_dir').val(dir);
			$('#action').val("order");
			$('#frm').submit();
		}
		
		function change_page(){
			$('#current_page').val($('#pagination').val());
			$('#action').val("view");
			$('#frm').submit();
		}
		
		function set_rop(){
			$('#current_page').val(1);
			$('#action').val("set_rop");
			$('#frm').submit();
		}
		
		function save(field){
			$('#field').val(field);
			
			var idList = "0";
			$('.idItem').each(function(){
				idList += "," + $(this).val();
			});
			$('#listID').val(idList);
				
			$('#action').val("save");
			$('#frm').submit();
		}
		
		function switchval(field, id, val){
			$('#action').val("switchval");
			$('#field').val(field);
			$('#singleid').val(id);
			$('#singleval').val(val);
			$('#frm').submit();
		}