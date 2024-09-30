<?php

namespace App\Livewire\Invitations;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Invitation;
use App\Services\FormatHelperService;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class Datatable extends DataTableComponent
{
    protected $model = Invitation::class;
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
            Column::make(trans('invitations.table-id'), "id")
                ->sortable(),
            Column::make(trans('invitations.table-label'), "label")
                ->sortable(),
            BooleanColumn::make(trans('invitations.table-default'), "default")
                ->sortable(),
            Column::make(trans('invitations.table-created_by'), "user.name")
                ->format(fn($value) => $this->formatter->userName($value))
                ->sortable(),
            Column::make(trans('invitations.table-created_at'), "created_at")
                ->format(fn($value) => $this->formatter->date($value))
                ->sortable(),
            ButtonGroupColumn::make('Actions')
                ->setView('components.invitations.action')
        ];
    }
}
