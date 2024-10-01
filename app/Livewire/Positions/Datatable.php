<?php

namespace App\Livewire\Positions;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Position;
use App\Services\FormatHelperService;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\CountColumn;

class Datatable extends DataTableComponent
{
    protected $model = Position::class;
    protected $formatter;

    public function __construct()
    {
        $this->formatter = app(FormatHelperService::class);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make(trans('positions.table-id'), "id")
                ->sortable(),
            Column::make(trans('positions.table-label'), "label")
                ->sortable(),
            Column::make(trans('positions.table-created_by'), "user.name")
                ->format(fn($value) => $this->formatter->userName($value))
                ->sortable(),
            Column::make(trans('positions.table-created_at'), "created_at")
                ->format(fn($value) => $this->formatter->date($value))
                ->sortable(),
            CountColumn::make(trans('positions.table-users'))
                ->setDataSource('users')
                ->sortable(),
            ButtonGroupColumn::make('Actions')
                ->setView('components.positions.action')
        ];
    }
}
