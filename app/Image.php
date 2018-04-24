<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Mockery\CountValidator\Exception;

class Image extends Model
{
    protected $fillable = ['file_size', 'original_name', 'name', 'path', 'image_type', 'file_type', 'storage','width', 'height'];

    /**
     * @param UploadedFile $file
     * @param string $image_type - purpose of image: avatar, document, photo
     */
    public function process(UploadedFile $file, $image_type = 'undefined')
    {
        if (self::is_supported_image($file)) {
            $this->file_size = $file->getSize();
            $this->original_name = $file->getClientOriginalName();
            $file_ext = $file->extension();
            $this->file_type = $file_ext;
            $this->image_type = $image_type;
            $this->storage = 'public';

            // Save to storage
            // Config in %APP_ROOT%/config/filesystems.php
            $this->path = $file->store('images', $this->storage);
            $path_array = explode('/', $this->path);
            $this->name = end($path_array);
            list($width, $height) = getimagesize($file->getPathname());
            $this->width = $width;
            $this->height = $height;
            $this->user_id = Auth::id();;
            $this->save();

            $img = \Intervention\Image\Facades\Image::make($file->getPathname());
            $img->fit(600, 400);
            $img->save(storage_path('app/public/images/600x400_' . $this->name));

            $img = \Intervention\Image\Facades\Image::make($file->getPathname());
            $img->fit(128, 128);
            $img->save(storage_path('app/public/images/128x128_' . $this->name));

            $img = \Intervention\Image\Facades\Image::make($file->getPathname());
            $img->fit(200, 160);
            $img->save(storage_path('app/public/images/200x160_' . $this->name));

            //TODO: Need to get storage dir some other way


        }
    }
    
    public function getResizedPath($size) {
	    return asset('storage/images/' . $size . '_' . $this->name);
    }

    public static function is_supported_image(UploadedFile $file)
    {
        $accepted_images = config('app.image_types');
        $mime_type = $file->getMimeType();
        if (!in_array($mime_type, $accepted_images)) {
            throw new Exception($file->getClientOriginalName() . ' is not supported image type.');
        } else {
            return true;
        }
    }

    public function getAssetPath()
    {
        return asset('storage/' . $this->path);
    }

}
