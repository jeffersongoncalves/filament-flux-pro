<?php

use Jeffersongoncalves\FilamentFluxPro\Support\HtmlSanitizer;

it('strips script tags', function () {
    $sanitizer = new HtmlSanitizer;

    $clean = $sanitizer->sanitize('<p>ok</p><script>alert(1)</script><p>end</p>');

    expect($clean)->not->toContain('<script>');
    expect($clean)->toContain('<p>ok</p>');
    expect($clean)->toContain('<p>end</p>');
});

it('strips inline event handlers', function () {
    $sanitizer = new HtmlSanitizer;

    $clean = $sanitizer->sanitize('<a href="/x" onclick="alert(1)">x</a>');

    expect($clean)->not->toContain('onclick');
    expect($clean)->toContain('href="/x"');
});

it('rewrites javascript: URLs', function () {
    $sanitizer = new HtmlSanitizer;

    $clean = $sanitizer->sanitize('<a href="javascript:alert(1)">x</a>');

    expect($clean)->not->toContain('javascript:');
});

it('preserves allowed tags by default', function () {
    $sanitizer = new HtmlSanitizer;

    $clean = $sanitizer->sanitize(
        '<p><strong>bold</strong> <em>em</em> <a href="/x">link</a></p><h2>title</h2><ul><li>li</li></ul>'
    );

    expect($clean)
        ->toContain('<strong>bold</strong>')
        ->toContain('<em>em</em>')
        ->toContain('<a href="/x">link</a>')
        ->toContain('<h2>title</h2>')
        ->toContain('<li>li</li>');
});

it('returns null/empty unchanged', function () {
    $sanitizer = new HtmlSanitizer;

    expect($sanitizer->sanitize(null))->toBeNull();
    expect($sanitizer->sanitize(''))->toBe('');
});
