<?php

namespace App\Utils;

class ImageResizeService {




    function imageResize($source, $destination, $thumb_max_width = 128, $thumb_max_height = 128, $thumb_quality = 70, $useprop = true, $usefilter=true)
    {
        $size = GetImageSize($source);
        $image_type = $size[2];
        $im_src["width"] = $size[0];
        $im_src["height"] = $size[1];

        if($useprop){
            if (($thumb_max_width / $im_src["width"]) < ($thumb_max_height / $im_src["height"])) {
                // if width is bigger
                $im_dst["width"] = $thumb_max_width < $im_src["width"] ? $thumb_max_width : $im_src["width"];
                $factor = $im_src["width"] / $im_src["height"];
                $im_dst["height"] = floor($im_dst["width"] / $factor);
            } else {
                // if height is bigger
                $im_dst["height"] = $thumb_max_height < $im_src["height"] ? $thumb_max_height : $im_src["height"];
                $factor = $im_src["height"] / $im_src["width"];
                $im_dst["width"] = floor($im_dst["height"] / $factor);
            }
        }else{

            $im_dst["height"] = $thumb_max_height;
            $im_dst["width"] = $thumb_max_width;
        }

            switch($image_type) {
                case 1: // GIF
                    $im_src["identifier"] = ImageCreateFromGif($source);
                    $im_dst["identifier"] = ImageCreateTrueColor($im_dst["width"], $im_dst["height"]);
                    ImageCopyResized(
                        $im_dst["identifier"], $im_src["identifier"],
                        0, 0, 0, 0,
                        $im_dst["width"], $im_dst["height"], $im_src["width"], $im_src["height"]);
                    ImageGIF ($im_dst["identifier"], $destination, $thumb_quality);
                    ImageDestroy($im_dst["identifier"]);
                    ImageDestroy($im_src["identifier"]);
                    break;
                case 2: // JPG
                    $im_src["identifier"] = ImageCreateFromJPEG($source);
                    $im_dst["identifier"] = ImageCreateTrueColor($im_dst["width"], $im_dst["height"]);
                    ImageCopyResized(
                        $im_dst["identifier"], $im_src["identifier"],
                        0, 0, 0, 0,
                        $im_dst["width"], $im_dst["height"], $im_src["width"], $im_src["height"]);
                    ImageJPEG ($im_dst["identifier"], $destination, $thumb_quality);
                    ImageDestroy($im_dst["identifier"]);
                    ImageDestroy($im_src["identifier"]);
                    break;

                case '3': //png
                    $im_src["identifier"] = ImageCreateFromPNG ($source);
                    $im_dst["identifier"] = ImageCreateTrueColor($im_dst["width"], $im_dst["height"]);
                    ImageCopyResized(
                        $im_dst["identifier"], $im_src["identifier"],
                        0, 0, 0, 0,
                        $im_dst["width"], $im_dst["height"], $im_src["width"], $im_src["height"]);
                    ImageJPEG ($im_dst["identifier"], $destination, $thumb_quality);
                    ImageDestroy($im_dst["identifier"]);
                    ImageDestroy($im_src["identifier"]);
                    break;
                default:
                    return false;
                    break;
            }

        return true;
    }

}

