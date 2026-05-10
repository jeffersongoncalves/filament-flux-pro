@php
    $heightPx = $height.'px';
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        @if ($heading)
            <x-slot name="heading">{{ $heading }}</x-slot>
        @endif

        @if ($description)
            <x-slot name="description">{{ $description }}</x-slot>
        @endif

        <x-flux::chart :value="$data" :style="'height: '.$heightPx">
            @if (! empty($options['showAxis']))
                <x-flux::chart.axis axis="x" />
                <x-flux::chart.axis axis="y" />
            @endif

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

            @if (! empty($options['showLegend']))
                <x-flux::chart.legend />
            @endif
        </x-flux::chart>
    </x-filament::section>
</x-filament-widgets::widget>
