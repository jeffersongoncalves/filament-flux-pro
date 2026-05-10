<?php

namespace Jeffersongoncalves\FilamentFluxPro\Tests\Fixtures;

use Closure;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class TestForm extends Component implements HasSchemas
{
    use InteractsWithSchemas;

    /**
     * @var array<string, mixed>
     */
    public array $data = [];

    public static ?Closure $fieldsCallback = null;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        $components = static::$fieldsCallback ? (static::$fieldsCallback)() : [];

        return $schema
            ->components($components)
            ->statePath('data');
    }

    /**
     * @return array<string, mixed>
     */
    public function save(): array
    {
        return $this->form->getState();
    }

    public function render(): View
    {
        return view('test-form');
    }
}
