<?php

namespace App\Helpers;
use Image;

/**
 * This is a helper class to provide some facilty to the whole application
 */

class Helper
{
    public static function uploadFile($file,$model,$business_id)
    {
        $file_name = null;
        $type = null;
        if ($file) {
            $extname = $file->getClientOriginalExtension();
            $extensions = ['jpg','jpeg','png'];
            if (in_array($extname,$extensions)){
                $type='image';
            }else
            {
                $type='file';
            }
            $file_name = substr(md5(uniqid(rand(1, 6))) . microtime(true), 0, 15) . '.' . $extname;
            $file->move(public_path('uploads'), $file_name);
            $model->media()->create([
                'name' =>  $file_name,
                'type' => $type,
                'business_id' => $business_id
            ]);
        }
        return $file_name;
    }

    public static function uploadImage($image,$model,$business_id)
    {
        $file_name = null;
        if ($image) {
            $photo=$image['path'];
            $photoname = substr(md5(uniqid(rand(1, 6))) . microtime(true), 0, 10) . '.' . explode('/', explode(':', substr($photo, 0, strpos($photo, ';')))[1])[1];
            Image::make($image['path'])->resize(350, 350, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            })->save(public_path('uploads/') . $photoname);

            $model->media()->create([
                'name' =>  $photoname,
                'type' => 'image',
                'business_id' => $business_id
            ]);
        }
        return $file_name;
    }
}
