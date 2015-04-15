
var swfu;
window.onload = function () {
	swfu = new SWFUpload({
		// Backend Settings
		upload_url: "upload.php?type="+ type_upload,
		post_params: {"PHPSESSID": "<?php echo session_id(); ?>"},

		// File Upload Settings
		file_size_limit : "3 MB",	// 3MB
		file_types : "*.jpg",
		file_types_description : "JPG Images",
		file_upload_limit : "0",

		// Event Handler Settings - these functions as defined in Handlers.js
		//  The handlers are not part of SWFUpload but are part of my website and control how
		//  my website reacts to the SWFUpload events.
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,

		// Button Settings
		button_image_url : "images/button_Upload.png",
		button_placeholder_id : "spanButtonPlaceholder",
		button_width: 200,
		button_height: 40,
		button_text : '<span class="button">Chọn ảnh Upload</span>',
		button_text_style : '.button { font-family: Tahoma, Arial, sans-serif; font-size: 14pt; font-weight: bold; }',
		button_text_top_padding: 10,
		button_text_left_padding: 20,
		button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
		button_cursor: SWFUpload.CURSOR.HAND,
		
		// Flash Settings
		flash_url : "swf/swfupload.swf",

		custom_settings : {
			upload_target : "divFileProgressContainer"
		},
		
		// Debug Settings
		debug: false
	});
};
