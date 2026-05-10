@php
    $commands = $this->getFilteredCommands();
@endphp

<x-flux::modal name="flux-flux-pro-command-palette" :show="$isCommandPaletteOpen" wire:close="closeCommandPalette">
    <x-flux::command>
        <x-flux::command.input
            wire:model.live.debounce.150ms="commandSearch"
            placeholder="{{ __('Type a command…') }}"
        />

        <x-flux::command.items>
            @forelse ($commands as $key => $command)
                <x-flux::command.item
                    wire:click="executeCommand('{{ $key }}')"
                    @if (! empty($command['icon'])) icon="{{ $command['icon'] }}" @endif
                >
                    {{ $command['label'] }}

                    @if (! empty($command['shortcut']))
                        <x-slot name="trailing">
                            <x-flux::kbd>{{ $command['shortcut'] }}</x-flux::kbd>
                        </x-slot>
                    @endif
                </x-flux::command.item>
            @empty
                <x-flux::command.empty>
                    {{ __('No matching commands.') }}
                </x-flux::command.empty>
            @endforelse
        </x-flux::command.items>
    </x-flux::command>
</x-flux::modal>
