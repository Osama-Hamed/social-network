<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UploadBase64Images
{
    public function uploadMultiple($images)
    {
        if (! $images) return [];

        $imagesNames = [];

        foreach ($images as $image) {
            $extension = $this->extractExtension($image);
            $imageName = $this->generateImageName($extension);
            $imagesNames[] = $imageName;
            $this->saveToPublicDisk($image, $imageName, $extension);
        }

        return $imagesNames;
    }

    private function extractExtension($image)
    {
        return explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
    }

    private function generateImageName($extension)
    {
        return Carbon::now()->timestamp . '_' . uniqid() . '.' . $extension;
    }

    private function saveToPublicDisk($image, $imageName, $extension)
    {
        Storage::disk('public')
            ->put("posts/$imageName", Image::make($image)
            ->encode($extension));
    }
}