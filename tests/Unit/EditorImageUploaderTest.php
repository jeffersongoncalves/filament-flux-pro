<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Jeffersongoncalves\FilamentFluxPro\Support\EditorImageUploader;

it('stores uploaded image on configured disk and directory and returns URL', function () {
    Storage::fake('public');

    $uploader = new EditorImageUploader('public', 'editor/images', 'public');
    $file = UploadedFile::fake()->image('photo.jpg');

    $url = $uploader->store($file);

    expect($url)->toBeString()->toContain('editor/images');
    expect(Storage::disk('public')->files('editor/images'))->toHaveCount(1);
});

it('exposes configured disk, directory and visibility', function () {
    $uploader = new EditorImageUploader('s3', 'uploads', 'private');

    expect($uploader->getDisk())->toBe('s3');
    expect($uploader->getDirectory())->toBe('uploads');
    expect($uploader->getVisibility())->toBe('private');
});
