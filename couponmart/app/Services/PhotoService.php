<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PhotoService
{
    protected $errors = [];
    protected $maxFileSize = 5000000; // 5MB
    protected $allowedMime = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp'];

    public function getErrors()
    {
        return $this->errors;
    }

    public function changeName(string $originalName): string
    {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        return round(microtime(true)) . '.' . $extension;
    }

    public function attachFile(array $file): ?string
    {
        if (empty($file) || !isset($file['tmp_name'])) {
            $this->errors[] = "No file was uploaded.";
            return null;
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $this->errors[] = "Upload error code: {$file['error']}";
            return null;
        }

        if (!in_array($file['type'], $this->allowedMime)) {
            $this->errors[] = "Invalid file type.";
            return null;
        }

        if ($file['size'] > $this->maxFileSize) {
            $this->errors[] = "File too large.";
            return null;
        }

        return $file['tmp_name'];
    }

    public function save(string $tmpPath, string $targetDir, string $newFileName): bool
    {
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $targetPath = rtrim($targetDir, '/') . '/' . $newFileName;

        if (file_exists($targetPath)) {
            $this->errors[] = "File already exists.";
            return false;
        }

        return move_uploaded_file($tmpPath, $targetPath);
    }

    public function delete(string $filePath): bool
    {
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }

    public function decodeBase64(string $code, string $folder): ?string
    {
        $data = explode(',', $code);
        if (count($data) !== 2) {
            $this->errors[] = "Invalid base64 string.";
            return null;
        }

        $decoded = base64_decode($data[1]);
        $filename = round(microtime(true)) . '.jpg';

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        file_put_contents($folder . '/' . $filename, $decoded);
        return $filename;
    }

    public function makeThumbnail(string $sourcePath, string $targetPath, int $width, int $height): bool
    {
        if (!file_exists($sourcePath)) {
            $this->errors[] = "Source file not found.";
            return false;
        }

        $image = Image::make($sourcePath)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $image->save($targetPath);
        return true;
    }
}
