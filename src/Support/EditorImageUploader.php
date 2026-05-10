<?php

namespace Jeffersongoncalves\FilamentFluxPro\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class EditorImageUploader
{
    public function __construct(
        protected string $disk = 'public',
        protected string $directory = 'editor-uploads',
        protected string $visibility = 'public',
    ) {}

    public function store(UploadedFile $file): string
    {
        $path = $file->store($this->directory, [
            'disk' => $this->disk,
            'visibility' => $this->visibility,
        ]);

        return Storage::disk($this->disk)->url((string) $path);
    }

    public function getDisk(): string
    {
        return $this->disk;
    }

    public function getDirectory(): string
    {
        return $this->directory;
    }

    public function getVisibility(): string
    {
        return $this->visibility;
    }
}
