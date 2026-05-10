<x-filament-panels::page>
    @php $kanbanData ??= $this->getKanbanData(); @endphp

    <x-flux::kanban wire:moved="moveKanbanCard($event.id, $event.to, $event.order)">
        @foreach ($kanbanData as $column)
            <x-flux::kanban.column
                :id="$column['id']"
                :title="$column['title']"
                :color="$column['color']"
            >
                @foreach ($column['cards'] as $card)
                    <x-flux::kanban.card :id="$card['id']" :heading="$card['title']">
                        @if ($card['description'])
                            <x-flux::text size="sm">{{ $card['description'] }}</x-flux::text>
                        @endif

                        @if ($card['meta'])
                            <x-slot name="footer">
                                <x-flux::badge size="sm" color="zinc">{{ $card['meta'] }}</x-flux::badge>
                            </x-slot>
                        @endif
                    </x-flux::kanban.card>
                @endforeach
            </x-flux::kanban.column>
        @endforeach
    </x-flux::kanban>
</x-filament-panels::page>
