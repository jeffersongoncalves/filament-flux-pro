<?php

namespace Jeffersongoncalves\FilamentFluxPro\Widgets;

use Filament\Widgets\Widget;

abstract class FluxChartWidget extends Widget
{
    protected string $view = 'filament-flux-pro::widgets.chart';

    protected static ?string $heading = null;

    protected ?string $description = null;

    protected int $height = 240;

    /**
     * @var array<int, string>
     */
    protected array $colors = ['accent'];

    protected bool $showLegend = true;

    protected bool $showGrid = true;

    protected bool $showAxis = true;

    /**
     * @return array<int, array<string, mixed>>
     */
    abstract protected function getData(): array;

    abstract protected function getType(): string;

    /**
     * @return array<string, mixed>
     */
    protected function getOptions(): array
    {
        return [
            'colors' => $this->colors,
            'showLegend' => $this->showLegend,
            'showGrid' => $this->showGrid,
            'showAxis' => $this->showAxis,
        ];
    }

    public static function getHeading(): ?string
    {
        return static::$heading;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return [
            'type' => $this->getType(),
            'data' => $this->getData(),
            'options' => $this->getOptions(),
            'height' => $this->getHeight(),
            'heading' => static::getHeading(),
            'description' => $this->getDescription(),
        ];
    }
}
