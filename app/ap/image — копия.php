<?php 
    //phpinfo();

    require 'libs/image/vendor/autoload.php';

    use Intervention\Image\ImageManager;

    $manager = new ImageManager(array('driver' => 'imagick'));

    $sizeArr = array(
        0 => array(
            'type' => 'full',
            'width' => 1920,
            'height' => 1080,
            'quality' => 90,
        ),
        1 => array(
            'type' => 'middle',
            'width' => 768,
            'height' => 512,
            'quality' => 90,
        ),
        2 => array(
            'type' => 'small',
            'width' => 300,
            'height' => 200,
            'quality' => 90,
        ),
        3 => array(
            'type' => 'thumb',
            'width' => 100,
            'height' => 100,
            'quality' => 90,
        ),
    );

    $typeArr = array(
        'jpeg',
        'webp',
        'png'
    );

    $watermark = $manager->make('../ap/stamp_small.png');
    //$img->insert($watermark, 'center');
    $imageWatermark = false;

    $imageNameOld = $nameimage.$ext;
    $imageName = $nameimage;
    //$imageFormat = 'webp';
    $tempDir = '../uploads/images/original';
    $uploadsDir = '../uploads/images';

    foreach ($typeArr as $k => $val) {
        $imageFormat = $val;
        foreach ($sizeArr as $key => $value) {
            //echo $value['type'].'<br>';

            $imageUrl = $uploadsDir.'/'.$imageFormat.'/'.$imageName.'-'.$value['width'].'x'.$value['height'].'.'.$imageFormat;

            if($imageWatermark) {
                $image = $manager->make($tempDir.'/'.$imageNameOld)->insert($watermark, 'center')->encode($imageFormat, 90)->resize($value['width'], $value['height'], function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($imageUrl, $value['quality']);
            } else {
                $image = $manager->make($tempDir.'/'.$imageNameOld)->encode($imageFormat, 90)->resize($value['width'], $value['height'], function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($imageUrl, $value['quality']);
            }

            //$imagesArr[] = $imageName;

            //echo $imageUrl.'<br>';

        }
    }

?>