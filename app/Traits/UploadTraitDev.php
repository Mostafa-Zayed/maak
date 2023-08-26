<?php 

namespace App\Traits;

trait UploadTraitDev
{
    public function uploadFile($request, $file_name, $dir_name, $file_type = 'document')
    {
        if ($request->hasFile($file_name) && $request->file($file_name)->isValid()) {
        }
    }
}