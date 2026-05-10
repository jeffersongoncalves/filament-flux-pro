@php
    $statePath = $getStatePath();
    $variant = $getFluxVariant();
@endphp

<div data-flux-pro-tabs>
    <x-flux::tabs :variant="$variant">
        @foreach ($getChildSchema()->getComponents() as $tab)
            <x-flux::tab :name="$tab->getId()">{{ $tab->getLabel() }}</x-flux::tab>
        @endforeach
    </x-flux::tabs>

    @foreach ($getChildSchema()->getComponents() as $tab)
        <x-flux::tab.panel :name="$tab->getId()">
            {{ $tab->getChildSchema() }}
        </x-flux::tab.panel>
    @endforeach
</div>
