<?php

namespace Jeffersongoncalves\FilamentFluxPro\Components;

use Closure;
use Illuminate\Support\HtmlString;

class FluxContextMenu
{
    /**
     * @var array<int, array{label: string, icon: ?string, action: Closure|string|null, danger: bool}>
     */
    protected array $items = [];

    public static function make(): self
    {
        return new self;
    }

    public function item(
        string $label,
        Closure|string|null $action = null,
        ?string $icon = null,
        bool $danger = false,
    ): self {
        $this->items[] = compact('label', 'icon', 'action', 'danger');

        return $this;
    }

    public function separator(): self
    {
        $this->items[] = ['label' => '__separator__', 'icon' => null, 'action' => null, 'danger' => false];

        return $this;
    }

    /**
     * @return array<int, array{label: string, icon: ?string, action: Closure|string|null, danger: bool}>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function render(): HtmlString
    {
        $rendered = '<flux:context-menu>';

        foreach ($this->items as $item) {
            if ($item['label'] === '__separator__') {
                $rendered .= '<flux:menu.separator />';

                continue;
            }

            $label = htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8');
            $iconAttr = $item['icon'] !== null
                ? ' icon="'.htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8').'"'
                : '';
            $variant = $item['danger'] ? ' variant="danger"' : '';
            $wireAction = is_string($item['action'])
                ? ' wire:click="'.htmlspecialchars($item['action'], ENT_QUOTES, 'UTF-8').'"'
                : '';

            $rendered .= "<flux:menu.item{$iconAttr}{$variant}{$wireAction}>{$label}</flux:menu.item>";
        }

        $rendered .= '</flux:context-menu>';

        return new HtmlString($rendered);
    }

    public function __toString(): string
    {
        return (string) $this->render();
    }
}
