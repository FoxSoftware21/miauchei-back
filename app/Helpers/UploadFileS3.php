<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


class UploadFileS3
{
    public static function upload(Request $request, $type = 0)
    {
        $s3 = Storage::disk('s3');

        switch ($type) {
            case 1:
                $folder = 'users/';
                if ($request->hasFile('photo') && $request->photo->isValid()) {
                    $ext = $request->photo->extension();
                    $name = $folder . Str::uuid() . '.' . $ext;
                    $file = $request->file('photo');
                    $s3->put($name, file_get_contents($file));
                    $url = $s3->url($name);
                }
                break;
            case 2:
                $folder = 'pets/';
                if ($request->hasFile('foto') && $request->foto->isValid()) {
                    $ext = $request->foto->extension();
                    $name = $folder . Str::uuid() . '.' . $ext;
                    $file = $request->file('foto');
                    $s3->put($name, file_get_contents($file));
                    $url = $s3->url($name);
                }
                break;
            default:
        }

        return $url ?? null;
    }
}
