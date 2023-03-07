<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image as Images;

class Image
{
    /**
     * generate image with auto resize
     * request {
     *   width
     *   height
     * }
     *
     * @param $path
     * @return \Illuminate\Http\Response
     */
    static function resize($path)
    {
        // according to path your image file
        $img = Images::make(storage_path("app/$path"));

        $width = request('width');
        if (empty($width)) {
            $width = null;
        }
        $height = request('height');
        if (empty($height)) {
            $height = null;
        }

        //manipulate image
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });

        // create response and add encoded image data
        $response = Response::make($img->encode('jpg'));

        // set content-type
        return $response->header('Content-Type', 'image/jpg');
    }

}
