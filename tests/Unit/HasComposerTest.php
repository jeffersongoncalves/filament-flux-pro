<?php

use Jeffersongoncalves\FilamentFluxPro\Pages\Concerns\HasComposer;

class FakeComposerPage
{
    use HasComposer;

    /**
     * @var array<int, array<string, mixed>>
     */
    public array $submitted = [];

    protected function onComposerSubmit(array $state): void
    {
        $this->submitted[] = $state;
    }
}

it('defaults composer state to empty', function () {
    $page = new FakeComposerPage;

    expect($page->composerState)->toBe([
        'text' => '',
        'attachments' => [],
        'mentions' => [],
    ]);
});

it('submits state, fires onComposerSubmit, and resets', function () {
    $page = new FakeComposerPage;

    $page->composerState = [
        'text' => 'hi',
        'attachments' => ['/tmp/a.png'],
        'mentions' => [42],
    ];

    $page->submitComposer();

    expect($page->submitted)->toHaveCount(1);
    expect($page->submitted[0]['text'])->toBe('hi');
    expect($page->composerState['text'])->toBe('');
    expect($page->composerState['attachments'])->toBe([]);
});
