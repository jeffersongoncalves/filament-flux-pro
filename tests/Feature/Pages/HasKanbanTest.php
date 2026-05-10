<?php

use Illuminate\Support\Facades\Schema;
use Jeffersongoncalves\FilamentFluxPro\Tests\Fixtures\KanbanTask;
use Jeffersongoncalves\FilamentFluxPro\Tests\Fixtures\TasksKanbanPage;

beforeEach(function () {
    Schema::create('kanban_tasks', function ($table) {
        $table->id();
        $table->string('title');
        $table->string('description')->nullable();
        $table->string('status');
        $table->unsignedInteger('order')->default(0);
        $table->string('completed_at')->nullable();
    });
});

afterEach(function () {
    Schema::dropIfExists('kanban_tasks');
});

it('groups records by status into the configured columns', function () {
    KanbanTask::create(['title' => 'A', 'status' => 'todo', 'order' => 1]);
    KanbanTask::create(['title' => 'B', 'status' => 'todo', 'order' => 2, 'description' => 'second']);
    KanbanTask::create(['title' => 'C', 'status' => 'doing', 'order' => 0]);

    $data = (new TasksKanbanPage)->callGetKanbanData();

    expect($data)->toHaveCount(3);
    expect($data[0]['id'])->toBe('todo');
    expect($data[0]['cards'])->toHaveCount(2);
    expect($data[0]['cards'][0]['title'])->toBe('A');
    expect($data[1]['id'])->toBe('doing');
    expect($data[1]['cards'])->toHaveCount(1);
    expect($data[2]['id'])->toBe('done');
    expect($data[2]['cards'])->toBe([]);
});

it('orders cards by the order field within a column', function () {
    KanbanTask::create(['title' => 'second', 'status' => 'todo', 'order' => 5]);
    KanbanTask::create(['title' => 'first', 'status' => 'todo', 'order' => 1]);

    $data = (new TasksKanbanPage)->callGetKanbanData();

    expect($data[0]['cards'][0]['title'])->toBe('first');
    expect($data[0]['cards'][1]['title'])->toBe('second');
});

it('runs the meta closure for every card in the column', function () {
    KanbanTask::create(['title' => 'X', 'status' => 'done', 'order' => 1, 'completed_at' => 'yesterday']);

    $data = (new TasksKanbanPage)->callGetKanbanData();

    expect($data[2]['cards'][0]['meta'])->toBe('completed:yesterday');
});

it('moveKanbanCard updates status + order and fires onKanbanMove', function () {
    $task = KanbanTask::create(['title' => 'A', 'status' => 'todo', 'order' => 1]);

    $page = new TasksKanbanPage;
    $page->moveKanbanCard($task->id, 'done', 3);

    $task->refresh();

    expect($task->status)->toBe('done');
    expect($task->order)->toBe(3);
    expect($page->moves)->toHaveCount(1);
    expect($page->moves[0]['to'])->toBe('done');
    expect($page->moves[0]['order'])->toBe(3);
});
