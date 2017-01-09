<?php
if(isset($_FILES['image_upload_file'])){
    $output['status'] = false;
    set_time_limit(0);
    $allowedImageType = array("image/png","image/jpg","image/jpeg");
    $path = "upload/";

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
        $upload_image = $path.basename($fileNameNew);
        $thumb_width = '50';
        $thumb_height = '50';
        $thumb = false;
        print_r($thumb);
        die();

        if(move_uploaded_file($_FILES['image_upload_file']['tmp_name'],$upload_image))
        {
            //thumbnail creation
            if($thumb == TRUE)
            {
                $thumbnail = $path.$fileNameNew;
                list($width,$height) = getimagesize($upload_image);
                $thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
                switch($fileType){
                    case 'jpg':
                        $source = imagecreatefromjpeg($upload_image);
                        break;
                    case 'jpeg':
                        $source = imagecreatefromjpeg($upload_image);
                        break;

                    case 'png':
                        $source = imagecreatefrompng($upload_image);
                        break;
                    default:
                        $source = imagecreatefromjpeg($upload_image);
                }

                imagecopyresized($thumb_create,$source,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
                switch($fileType){
                    case 'jpg' || 'jpeg':
                        imagejpeg($thumb_create,$thumbnail,100);
                        break;
                    case 'png':
                        imagepng($thumb_create,$thumbnail,100);
                        break;

                    default:
                        imagejpeg($thumb_create,$thumbnail,100);
                }

            }

            return $fileNameNew;
        }
        else
        {
            return false;
        }
        //move_uploaded_file($temp_path,$path.$fileNameNew);
        $output['image'] = $path.$fileNameNew;
        $output['status']=TRUE;
    }
    echo json_encode($output);
}