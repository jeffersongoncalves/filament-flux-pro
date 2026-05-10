@php
    $data = $getFluxData($getRecord());
    $type = $getFluxType();
    $color = $getFluxColor();
    $height = $getFluxHeight();
    $minWidth = $getFluxMinWidth();

    $style = "height: {$height}px; min-width: {$minWidth}px;";

    if ($color !== null) {
        $style .= "color: var(--color-{$color}, currentColor);";
    }
@endphp

<x-flux::chart :value="$data" :style="$style">
    @switch($type)
        @case('area')
            <x-flux::chart.area />
            @break
        @case('bar')
            <x-flux::chart.bar />
            @break
        @default
            <x-flux::chart.line />
    @endswitch
</x-flux::chart>
