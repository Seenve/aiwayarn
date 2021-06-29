<?php 
    //phpinfo();

    require 'libs/image/vendor/autoload.php';

    use Intervention\Image\ImageManager;

    $manager = new ImageManager(array('driver' => 'imagick'));

    function waterCheck($imageWatermark, $type) {
        $result = true;
        if($imageWatermark) {
            if($type == 'default' || $type == 'thumb') {
                $result = false;
            }
        } else {
            $result = false;
        }
        return $result;
    }

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
        4 => array(
            'type' => 'default',
            'width' => 448,
            'height' => 256,
            'quality' => 90,
        ),
    );

    $typeArr = array(
        'jpeg',
        'webp',
        'png'
    );
    
    $imageNameOld = $nameimage.$ext;
    $imageName = $nameimage;
    $tempDir = '../uploads/images/original';
    $uploadsDir = '../uploads/images';

    //$image = $manager->make($tempDir.'/'.$imageNameOld);

    foreach ($typeArr as $k => $val) {
        $imageFormat = $val;
        foreach ($sizeArr as $key => $value) {
            
            $imageUrl = $uploadsDir.'/'.$imageFormat.'/'.$imageName.'-'.$value['width'].'x'.$value['height'].'.'.$imageFormat;

            if(waterCheck($imageWatermark, $value['type'])) {
                if($value['type'] == 'full') {
                    $watermark = $manager->make('../ap/stamp_full.png');
                    $image = $manager->make($tempDir.'/'.$imageNameOld)->resize($value['width'], $value['height'], function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->insert($watermark, 'bottom-right', 10, 10)->encode($imageFormat, 90)->save($imageUrl, $value['quality']);
                } else if($value['type'] == 'middle') {
                    $watermark = $manager->make('../ap/stamp_middle.png');
                    $image = $manager->make($tempDir.'/'.$imageNameOld)->resize($value['width'], $value['height'], function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->insert($watermark, 'center')->encode($imageFormat, 90)->save($imageUrl, $value['quality']);
                } else {
                    $watermark = $manager->make('../ap/stamp_small.png');
                    $image = $manager->make($tempDir.'/'.$imageNameOld)->resize($value['width'], $value['height'], function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->insert($watermark, 'center')->encode($imageFormat, 90)->save($imageUrl, $value['quality']);
                }
            } else {
                $image = $manager->make($tempDir.'/'.$imageNameOld)->resize($value['width'], $value['height'], function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode($imageFormat, 90)->save($imageUrl, $value['quality']);
            }
        }
    }

?>