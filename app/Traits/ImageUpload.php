<?php

namespace App\Traits;



use Illuminate\Http\UploadedFile;


trait ImageUpload
{
    public function uploadImage(UploadedFile $image, string $folder = 'uploads'): string
    {
        return $image->storePublicly($folder, ['disk' => 'public']);
    }
}
