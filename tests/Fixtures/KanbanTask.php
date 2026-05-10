<?php

namespace Jeffersongoncalves\FilamentFluxPro\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

class KanbanTask extends Model
{
    protected $table = 'kanban_tasks';

    protected $guarded = [];

    public $timestamps = false;
}
