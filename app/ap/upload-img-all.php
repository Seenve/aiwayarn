<?php

    function rndstr($len) { 
        $all = "abcdefghijklmnopqrstuvwxyz"; 
        $cnt = strlen($all) - 1; 
        srand((double)microtime()*1000000); 
        for($i=0; $i<$len; $i++) $pass .= $all[rand(0, $cnt)]; 
        return $pass; 
    }

    $pathImages = "../uploads/images/original";
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');
    $imagesArr = array();
    $imageWatermark = false;

    if($_GET['watermark'] == 'true') {
        $imageWatermark = true;
    }
    
    $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';
    if(!empty(array_filter($_FILES['files']['name']))){
        foreach($_FILES['files']['name'] as $key => $val){

            $nameimage = rndstr(6).'_'.time();

            $ext = substr($_FILES['files']['name'][$key],strpos($_FILES['files']['name'][$key],
            '.'),strlen($_FILES['files']['name'][$key])-1);

            $ext = mb_strtolower($ext);
            $fileName = basename($nameimage.$ext);
            $targetFilePath = $pathImages.'/'.$fileName;
            
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
            if(in_array($fileType, $allowTypes)){
                if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)){
                    $new_name_image = $fileName;
                    include 'image.php';
                    array_push($imagesArr, $nameimage);
                } else {
                    $errorUpload .= $_FILES['files']['name'][$key].', ';
                }
            } else {
                $errorUploadType .= $_FILES['files']['name'][$key].', ';
            }
        }
        
        if(!empty($insertValuesSQL)){
            $insertValuesSQL = trim($insertValuesSQL,',');

            $errorUpload = !empty($errorUpload)?'Upload Error: '.$errorUpload:'';
            $errorUploadType = !empty($errorUploadType)?'File Type Error: '.$errorUploadType:'';
            $errorMsg = !empty($errorUpload)?'<br/>'.$errorUpload.'<br/>'.$errorUploadType:'<br/>'.$errorUploadType;
            $statusMsg = "Files are uploaded successfully.".$errorMsg;
        }
    }else{
        $statusMsg = 'Please select a file to upload.';
    }
    
    // Display status message
    echo json_encode($imagesArr);
?>