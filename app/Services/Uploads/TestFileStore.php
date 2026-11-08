<?php

namespace App\Services\Uploads;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Keeps the photos and PDFs of a teacher's test on the private disk.
 *
 * A photo is re-encoded before it is stored or sent anywhere: that drops its metadata (camera,
 * GPS position, time), turns it the right way up, and shrinks it to a size the AI reads well.
 */
class TestFileStore
{
    public const DIRECTORY = 'exercise-sources';

    private const MAX_SIDE = 2000;

    public function store(UploadedFile $file): string
    {
        $path = self::DIRECTORY.'/'.Str::uuid();

        if ($file->getMimeType() === 'application/pdf') {
            Storage::disk('local')->put("{$path}.pdf", $file->get());

            return "{$path}.pdf";
        }

        Storage::disk('local')->put("{$path}.jpg", $this->cleanImage($file));

        return "{$path}.jpg";
    }

    /**
     * The stored file as a data URL, the form the AI provider accepts inline.
     */
    public function dataUrl(string $path): string
    {
        $mime = str_ends_with($path, '.pdf') ? 'application/pdf' : 'image/jpeg';

        return "data:{$mime};base64,".base64_encode(Storage::disk('local')->get($path));
    }

    /**
     * @param  list<string>  $paths
     */
    public function delete(array $paths): void
    {
        Storage::disk('local')->delete($paths);
    }

    private function cleanImage(UploadedFile $file): string
    {
        $image = imagecreatefromstring($file->get());

        if ($image === false) {
            throw new \InvalidArgumentException('Not a readable image.');
        }

        $image = $this->upright($image, $file->getRealPath());

        $width = imagesx($image);
        $height = imagesy($image);
        $scale = min(1, self::MAX_SIDE / max($width, $height));

        if ($scale < 1) {
            $image = imagescale($image, (int) round($width * $scale), (int) round($height * $scale));
        }

        ob_start();
        imagejpeg($image, null, 85);

        return (string) ob_get_clean();
    }

    /**
     * Phones store the photo sideways and say how to turn it in EXIF, which re-encoding drops.
     */
    private function upright(\GdImage $image, string $path): \GdImage
    {
        $orientation = function_exists('exif_read_data') ? (@exif_read_data($path)['Orientation'] ?? 1) : 1;

        return match ((int) $orientation) {
            3 => imagerotate($image, 180, 0),
            6 => imagerotate($image, -90, 0),
            8 => imagerotate($image, 90, 0),
            default => $image,
        };
    }
}
