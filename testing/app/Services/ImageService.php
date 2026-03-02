<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageService
{
    protected ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Resize, crop, convert to WebP, dan simpan file gambar.
     *
     * @param  UploadedFile  $file       File yang diupload
     * @param  string        $directory  Folder di dalam storage/app/public/
     * @param  int           $width      Lebar target (px)
     * @param  int|null      $height     Tinggi target (px), null = proportional
     * @return string                    Path relatif yang disimpan di DB
     */
    public function resizeAndSave(
        UploadedFile $file,
        string $directory,
        int $width,
        ?int $height = null
    ): string {
        $filename = uniqid('img_', true) . '.webp';
        $savePath = storage_path("app/public/{$directory}/{$filename}");

        // Pastikan folder ada
        if (! is_dir(dirname($savePath))) {
            mkdir(dirname($savePath), 0755, true);
        }

        $image = $this->manager->read($file->getRealPath());

        if ($height !== null) {
            // Crop ke ukuran persis (center)
            $image->cover($width, $height);
        } else {
            // Scale dengan mempertahankan rasio, maks lebar
            $image->scaleDown(width: $width);
        }

        $image->toWebp(quality: 85)->save($savePath);

        return "{$directory}/{$filename}";
    }

    /**
     * Resize foto profil anggota (400×400 center-crop, WebP).
     */
    public function saveMemberPhoto(UploadedFile $file): string
    {
        return $this->resizeAndSave($file, 'members/photos', 400, 400);
    }

    /**
     * Simpan gambar penuh karya (maks 1200px lebar, WebP).
     */
    public function saveWorkImage(UploadedFile $file): string
    {
        return $this->resizeAndSave($file, 'works/images', 1200);
    }

    /**
     * Simpan thumbnail karya (400×300 crop, WebP).
     */
    public function saveWorkThumbnail(UploadedFile $file): string
    {
        return $this->resizeAndSave($file, 'works/thumbnails', 400, 300);
    }

    /**
     * Hapus file dari storage.
     */
    public function delete(?string $path): void
    {
        if ($path && file_exists(storage_path("app/public/{$path}"))) {
            unlink(storage_path("app/public/{$path}"));
        }
    }
}
