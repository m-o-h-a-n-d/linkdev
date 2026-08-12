<?php

namespace App\Utility;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageManager
{
    public function upload(
        UploadedFile $file,
        string $path,
        string $disk = 'public',
        ?string $oldPath = null
    ): string {
        if ($oldPath) {
            $this->delete($oldPath, $disk);
        }

        return $this->store($file, $path, $disk);
    }

    private function store(
        UploadedFile $image,
        string $path,
        string $disk
    ): string {
        $fileName = Str::uuid().'.'.$image->extension();

        return $image->storeAs("uploads/{$path}", $fileName, $disk);
    }

    public function delete(
        ?string $imagePath,
        string $disk = 'public'
    ): void {
        if ($imagePath) {
            Storage::disk($disk)->delete($imagePath);
        }
    }
}
