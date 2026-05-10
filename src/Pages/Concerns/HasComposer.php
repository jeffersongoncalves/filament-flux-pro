<?php

namespace Jeffersongoncalves\FilamentFluxPro\Pages\Concerns;

trait HasComposer
{
    /**
     * @var array{text: string, attachments: array<int, mixed>, mentions: array<int, int|string>}
     */
    public array $composerState = [
        'text' => '',
        'attachments' => [],
        'mentions' => [],
    ];

    public function resetComposer(): void
    {
        $this->composerState = [
            'text' => '',
            'attachments' => [],
            'mentions' => [],
        ];
    }

    public function submitComposer(): void
    {
        $state = $this->composerState;

        $this->onComposerSubmit($state);

        $this->resetComposer();
    }

    /**
     * @param  array{text: string, attachments: array<int, mixed>, mentions: array<int, int|string>}  $state
     */
    protected function onComposerSubmit(array $state): void
    {
        //
    }
}
