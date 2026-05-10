<?php

namespace Jeffersongoncalves\FilamentFluxPro\Support;

class HtmlSanitizer
{
    /**
     * @var array<int, string>
     */
    protected array $allowedTags = [
        'p', 'br', 'hr', 'strong', 'em', 'u', 's',
        'a', 'img',
        'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'ul', 'ol', 'li',
        'blockquote', 'code', 'pre',
        'span', 'div',
        'table', 'thead', 'tbody', 'tr', 'th', 'td',
    ];

    /**
     * @var array<int, string>
     */
    protected array $allowedAttributes = [
        'href', 'src', 'alt', 'title', 'class', 'id',
        'colspan', 'rowspan', 'target', 'rel',
    ];

    public function sanitize(?string $html): ?string
    {
        if ($html === null || $html === '') {
            return $html;
        }

        $clean = preg_replace('#<script\b[^>]*>.*?</script>#is', '', $html) ?? $html;
        $clean = preg_replace('#<style\b[^>]*>.*?</style>#is', '', $clean) ?? $clean;
        $clean = preg_replace('#<iframe\b[^>]*>.*?</iframe>#is', '', $clean) ?? $clean;
        $clean = preg_replace('#<object\b[^>]*>.*?</object>#is', '', $clean) ?? $clean;
        $clean = preg_replace('#<embed\b[^>]*/?>#is', '', $clean) ?? $clean;

        $clean = preg_replace('#\son[a-z]+\s*=\s*"[^"]*"#i', '', $clean) ?? $clean;
        $clean = preg_replace("#\son[a-z]+\s*=\s*'[^']*'#i", '', $clean) ?? $clean;
        $clean = preg_replace('#\son[a-z]+\s*=\s*[^\s>]+#i', '', $clean) ?? $clean;

        $clean = preg_replace('#(href|src)\s*=\s*"\s*javascript:[^"]*"#i', '$1="#"', $clean) ?? $clean;
        $clean = preg_replace("#(href|src)\s*=\s*'\s*javascript:[^']*'#i", '$1="#"', $clean) ?? $clean;

        return strip_tags($clean, $this->allowedTags);
    }

    /**
     * @param  array<int, string>  $tags
     */
    public function withAllowedTags(array $tags): static
    {
        $clone = clone $this;
        $clone->allowedTags = $tags;

        return $clone;
    }
}
