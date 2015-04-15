CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:    
    config.filebrowserBrowseUrl      = base_url+'backend/editor/kcfinder/browse.php?type=files';
    config.filebrowserImageBrowseUrl =  base_url+'backend/editor/kcfinder/browse.php?type=images';
    config.filebrowserFlashBrowseUrl =  base_url+'backend/editor/kcfinder/browse.php?type=flash';
    config.filebrowserUploadUrl      =  base_url+'backend/editor/kcfinder/upload.php?type=files';
    config.filebrowserImageUploadUrl =  base_url+'cms/backend/editor/kcfinder/upload.php?type=images';
    config.filebrowserFlashUploadUrl =  base_url+'backend/editor/kcfinder/upload.php?type=flash';
    
    config.language = 'vi';
    config.uiColor = '#AADC6E';
    config.height = '800';
    config.width = '1100';
    config.toolbar = 'MyToolbar';
    config.toolbar_MyToolbar =
    [

        ['Style','FontFormat','FontName','FontSize'],['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
        ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Scayt'],['TextColor','BGColor'],
        ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
        ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Styles','Format'],                                       
        ['Bold','Italic','Strike'],
        ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
        ['Link','Unlink','Anchor'],
        ['Maximize','-','About']
    ];    

};