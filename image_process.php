<?php
if(isset($_FILES['image_upload_file'])){
    $output['status'] = false;
    set_time_limit(0);
    $allowedImageType = array("image/png","image/jpg","image/jpeg");
    $path = "upload/";
   // $thumb_path = 'upload/thumb/';

    if ($_FILES['image_upload_file']['error'] > 0){
        $output['error'] = "Error in File";
    } elseif (!in_array($_FILES['image_upload_file']['type'],$allowedImageType)){
        $output['error'] = "You Can Only upload jpeg, png Image";
    } elseif (round($_FILES['image_upload_file']["size"] / 1024) > 4096) {
        $output['error']= "You can upload file size up to 4 MB";
    } else {
        $temp_path = $_FILES['image_upload_file']['tmp_name'];
        $file = pathinfo($_FILES['image_upload_file']['name']);
        $fileType = $file["extension"];
        $fileNameNew = rand(333, 999).time().".$fileType";

        move_uploaded_file($temp_path,$path.$fileNameNew);
        //createThumbs($path,$thumb_path,50,$fileNameNew);
        $output['image'] = $path.$fileNameNew;
        $output['status']=TRUE;
    }
    echo json_encode($output);
}
