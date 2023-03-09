<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File as Files;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image as Images;

class File
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
    function resize($path)
    {
        $path = storage_path("app/$path");

        $extFile = ['png', 'jpg', 'gif'];
        // get mime type
        $ext = Files::extension($path);
        if (!in_array($ext, $extFile)) {
            throw new \Error('Extension file doe not match with '.implode(', ', $extFile));
        }

        // according to path your image file
        $img = Images::make($path);

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

    /**
     * stream file
     *
     * @param $path
     * @return \Illuminate\Http\Response
     */
     function stream($path)
     {
         $path = storage_path("app/$path");

         // check file exist
         if (!Files::exists($path)) {
             abort(404);
         }

         // file decode
         $file = Files::get($path);
         // get mime type
         $type = Files::mimeType($path);

         $response = Response::make($file, 200);
         $response->header("Content-Type", $type);

         return $response;
     }

    /**
     * download file
     *
     * @param $path
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
     function download($path)
     {
         $path = storage_path("app/$path");

         // check file exist
         if (!Files::exists($path)) {
             abort(404);
         }

         return response()->download($path);
     }

}
