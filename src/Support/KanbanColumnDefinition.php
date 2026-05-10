<?php

namespace Jeffersongoncalves\FilamentFluxPro\Support;

use Closure;

class KanbanColumnDefinition
{
    public ?Closure $renderMeta = null;

    public function __construct(
        public string $id,
        public string $title,
        public ?string $color = null,
        public string $titleField = 'title',
        public string $descriptionField = 'description',
    ) {}

    public static function make(string $id, string $title): self
    {
        return new self(id: $id, title: $title);
    }

    public function color(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function titleField(string $field): self
    {
        $this->titleField = $field;

        return $this;
    }

    public function descriptionField(string $field): self
    {
        $this->descriptionField = $field;

        return $this;
    }

    public function meta(Closure $callback): self
    {
        $this->renderMeta = $callback;

        return $this;
    }
}
