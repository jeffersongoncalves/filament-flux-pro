<?php

namespace Jeffersongoncalves\FilamentFluxPro\Forms\Components;

use Closure;
use Filament\Forms\Components\Field;

class FluxComposer extends Field
{
    protected string $view = 'filament-flux-pro::components.composer';

    protected bool|Closure $fluxAllowAttachments = false;

    protected ?Closure $fluxMentionsResolver = null;

    protected string|Closure|null $fluxPlaceholder = null;

    protected bool|Closure $fluxSubmitOnEnter = false;

    protected string|Closure $fluxVariant = 'default';

    public function fluxAllowAttachments(bool|Closure $allow = true): static
    {
        $this->fluxAllowAttachments = $allow;

        return $this;
    }

    public function fluxAllowMentions(?Closure $resolver): static
    {
        $this->fluxMentionsResolver = $resolver;

        return $this;
    }

    public function fluxPlaceholder(string|Closure|null $placeholder): static
    {
        $this->fluxPlaceholder = $placeholder;

        return $this;
    }

    public function fluxSubmitOnEnter(bool|Closure $submit = true): static
    {
        $this->fluxSubmitOnEnter = $submit;

        return $this;
    }

    public function fluxVariant(string|Closure $variant): static
    {
        $this->fluxVariant = $variant;

        return $this;
    }

    public function shouldFluxAllowAttachments(): bool
    {
        return (bool) $this->evaluate($this->fluxAllowAttachments);
    }

    public function hasFluxMentionsResolver(): bool
    {
        return $this->fluxMentionsResolver !== null;
    }

    /**
     * @return array<string|int, string>
     */
    public function getFluxMentions(string $search): array
    {
        if ($this->fluxMentionsResolver === null) {
            return [];
        }

        $resolved = $this->evaluate($this->fluxMentionsResolver, ['search' => $search]);

        return is_array($resolved) ? $resolved : [];
    }

    public function getFluxPlaceholder(): ?string
    {
        return $this->evaluate($this->fluxPlaceholder);
    }

    public function shouldFluxSubmitOnEnter(): bool
    {
        return (bool) $this->evaluate($this->fluxSubmitOnEnter);
    }

    public function getFluxVariant(): string
    {
        return (string) $this->evaluate($this->fluxVariant);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->dehydrateStateUsing(function ($state) {
            if (blank($state)) {
                return null;
            }

            if (is_string($state)) {
                return $state;
            }

            if (! is_array($state)) {
                return $state;
            }

            $text = (string) ($state['text'] ?? '');

            if ($text === ''
                && empty($state['attachments'] ?? [])
                && empty($state['mentions'] ?? [])
            ) {
                return null;
            }

            return [
                'text' => $text,
                'attachments' => array_values($state['attachments'] ?? []),
                'mentions' => array_values($state['mentions'] ?? []),
            ];
        });
    }
}
