<?php

namespace Jeffersongoncalves\FilamentFluxPro\Pages;

use Filament\Pages\Page;
use Jeffersongoncalves\FilamentFluxPro\Pages\Concerns\HasKanban;

abstract class FluxKanbanPage extends Page
{
    use HasKanban;

    protected string $view = 'filament-flux-pro::pages.kanban';

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return [
            'kanbanData' => $this->getKanbanData(),
        ];
    }
}
