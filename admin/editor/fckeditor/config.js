/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
    config.filebrowserBrowseUrl      = base_url+'admin/editor/kcfinder/browse.php?type=files';
    config.filebrowserImageBrowseUrl =  base_url+'admin/editor/kcfinder/browse.php?type=images';
    config.filebrowserFlashBrowseUrl =  base_url+'admin/editor/kcfinder/browse.php?type=flash';
    config.filebrowserUploadUrl      =  base_url+'admin/editor/kcfinder/upload.php?type=files';
    config.filebrowserImageUploadUrl =  base_url+'admin/editor/kcfinder/upload.php?type=images';
    config.filebrowserFlashUploadUrl =  base_url+'admin/editor/kcfinder/upload.php?type=flash';
   
    config.language = 'vi';
    config.width = '100%';
    config.height = '800';
    config.entities = false;
    //config.toolbar = 'MyToolbar';
    config.toolbar = 'Full';        
    config.toolbar_MyToolbar =
    [
        ['Source','Style','JustifyLeft','JustifyCenter','JustifyRight','JustifyFull','Table'],        
        ['Image'],                                       
        ['Bold','Italic','Strike'],
        ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
        ['Link','Unlink','Anchor','RemoveFormat']
    ];
  
};


