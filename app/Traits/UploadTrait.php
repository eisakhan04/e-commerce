<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadTrait
{
    /**
     * Upload a single file
     */
    public function upload(UploadedFile $file, string $folder = 'uploads', string $disk = 'public'): string
    {
        $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($folder, $filename, $disk);
    }

    /**
     * Upload multiple files
     */
    public function uploadMultiple(array $files, string $folder = 'uploads', string $disk = 'public'): array
    {
        $paths = [];
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $paths[] = $this->upload($file, $folder, $disk);
            }
        }
        return $paths;
    }

    /**
     * Delete a file from storage
     */
    public function deleteFile(string $path, string $disk = 'public'): bool
    {
        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }
        return false;
    }
}
