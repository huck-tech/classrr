<?php

namespace App\Http\Controllers;

use App\Image;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class ImageUploadController extends Controller
{
    public function store(Request $request)
    {
        $file = $request->file('image');
        $image_type = $request->get('image_type', 'undefined');

//        //echo 'no';
//        exit();
//        $file = Input::file('file');

        $image = new Image;

        try {
            $image->process($file, $image_type);
            $response = [
                'id' => $image->id,
                'name' => $file->getClientOriginalName(),
                'path' => $image->path,
                'type' => $file->getMimeType(),
                'size' => $file->getSize(),
            ];
            return response()->json($response, 200);
        } catch(Exception $exception){
            // Something went wrong. Log it.
            Log::error($exception->getMessage());
            $error = array(
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'error' => $exception->getMessage(),
            );
            // Return error
            return response()->json($error, 400);
        }

    }
}
