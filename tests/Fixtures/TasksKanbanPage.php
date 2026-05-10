<?php

namespace Jeffersongoncalves\FilamentFluxPro\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Jeffersongoncalves\FilamentFluxPro\Pages\Concerns\HasKanban;
use Jeffersongoncalves\FilamentFluxPro\Support\KanbanColumnDefinition;

class TasksKanbanPage
{
    use HasKanban;

    /**
     * @var array<int, array{record: Model, to: string, order: int}>
     */
    public array $moves = [];

    protected function getKanbanModel(): string
    {
        return KanbanTask::class;
    }

    protected function getKanbanStatusField(): string
    {
        return 'status';
    }

    protected function getKanbanColumns(): array
    {
        return [
            KanbanColumnDefinition::make('todo', 'A fazer')->color('zinc'),
            KanbanColumnDefinition::make('doing', 'Em andamento')->color('amber'),
            KanbanColumnDefinition::make('done', 'Concluído')->color('lime')
                ->meta(fn (KanbanTask $task): string => 'completed:'.($task->completed_at ?? 'no')),
        ];
    }

    protected function onKanbanMove(Model $record, string $toColumn, int $newOrder): void
    {
        $this->moves[] = compact('record', 'toColumn', 'newOrder') + [
            'to' => $toColumn,
            'order' => $newOrder,
        ];
    }

    public function callGetKanbanData(): array
    {
        return $this->getKanbanData();
    }
}
