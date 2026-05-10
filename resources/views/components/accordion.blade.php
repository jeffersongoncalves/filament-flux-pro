@php
    $heading = $getHeading();
    $icon = $getIcon();
    $expanded = $isFluxExpanded();
@endphp

<x-flux::accordion>
    <x-flux::accordion.item :expanded="$expanded">
        <x-flux::accordion.heading :icon="$icon">
            {{ $heading }}
        </x-flux::accordion.heading>

        <x-flux::accordion.content>
            {{ $getChildSchema() }}
        </x-flux::accordion.content>
    </x-flux::accordion.item>
</x-flux::accordion>
