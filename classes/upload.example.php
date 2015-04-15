<?
include "upload.inc.php";

// Defining Class
$yukle = new upload;

// Set Max Size
$yukle->set_max_size(180000);

// Set Directory
$yukle->set_directory("data");

// Do not change
// Set Temp Name for upload, $_FILES['file']['tmp_name'] is automaticly get the temp name
$yukle->set_tmp_name($_FILES['file']['tmp_name']);

// Do not change
// Set file size, $_FILES['file']['size'] is automaticly get the size
$yukle->set_file_size($_FILES['file']['size']);

// Do not change
// Set File Type, $_FILES['file']['type'] is automaticly get the type
$yukle->set_file_type($_FILES['file']['type']);

// Set File Name, $_FILES['file']['name'] is automaticly get the file name.. you can change
$yukle->set_file_name($_FILES['file']['name']);

// Start Copy Process
$yukle->start_copy();

// If uploaded file is image, you can resize the image width and height
// Support gif, jpg, png
$yukle->resize(0,0);

// Control File is uploaded or not
// If there is error write the error message
if($yukle->is_ok())
 echo "Yüklendi";
else
 echo $yukle->error()."<br>";

// Set a thumbnail name
$yukle->set_thumbnail_name("hatice");

// create thumbnail
$yukle->create_thumbnail();

// change thumbnail size
$yukle->set_thumbnail_size(0, 250);

$yukle->set_thumbnail_name("hatice2");
$yukle->create_thumbnail();
$yukle->set_thumbnail_size(50, 0);

$yukle->set_thumbnail_name("hatice3");
$yukle->create_thumbnail();
$yukle->set_thumbnail_size(62, 150);
?>