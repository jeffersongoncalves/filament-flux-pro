<?php

namespace Jeffersongoncalves\FilamentFluxPro\Pages\Concerns;

use Illuminate\Database\Eloquent\Model;
use Jeffersongoncalves\FilamentFluxPro\Support\KanbanColumnDefinition;

trait HasKanban
{
    /**
     * @return array<int, KanbanColumnDefinition>
     */
    abstract protected function getKanbanColumns(): array;

    /**
     * @return class-string<Model>
     */
    abstract protected function getKanbanModel(): string;

    abstract protected function getKanbanStatusField(): string;

    protected function getKanbanOrderField(): string
    {
        return 'order';
    }

    public function moveKanbanCard(string|int $recordId, string $toColumn, int $newOrder): void
    {
        $model = $this->getKanbanModel();
        /** @var Model $record */
        $record = $model::query()->findOrFail($recordId);

        $record->forceFill([
            $this->getKanbanStatusField() => $toColumn,
            $this->getKanbanOrderField() => $newOrder,
        ])->save();

        $this->onKanbanMove($record, $toColumn, $newOrder);
    }

    protected function onKanbanMove(Model $record, string $toColumn, int $newOrder): void
    {
        //
    }

    /**
     * @return array<int, array{id: string, title: string, color: ?string, cards: array<int, array<string, mixed>>}>
     */
    protected function getKanbanData(): array
    {
        $model = $this->getKanbanModel();
        $statusField = $this->getKanbanStatusField();
        $orderField = $this->getKanbanOrderField();

        $cards = $model::query()
            ->orderBy($orderField)
            ->get()
            ->groupBy($statusField);

        $columns = [];

        foreach ($this->getKanbanColumns() as $column) {
            $columnCards = $cards->get($column->id, collect());

            $columns[] = [
                'id' => $column->id,
                'title' => $column->title,
                'color' => $column->color,
                'cards' => $columnCards->map(fn ($record) => [
                    'id' => $record->getKey(),
                    'title' => (string) $record->{$column->titleField},
                    'description' => $record->{$column->descriptionField} ?? null,
                    'meta' => $column->renderMeta !== null
                        ? ($column->renderMeta)($record)
                        : null,
                ])->values()->all(),
            ];
        }

        return $columns;
    }
}
