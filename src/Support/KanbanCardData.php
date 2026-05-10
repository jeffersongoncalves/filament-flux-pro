<?php

namespace Jeffersongoncalves\FilamentFluxPro\Support;

class KanbanCardData
{
    public function __construct(
        public string|int $id,
        public string $title,
        public ?string $description = null,
        public ?string $meta = null,
    ) {}

    /**
     * @return array{id: string|int, title: string, description: ?string, meta: ?string}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'meta' => $this->meta,
        ];
    }
}
