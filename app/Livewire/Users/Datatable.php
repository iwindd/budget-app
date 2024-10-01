<?php

namespace App\Livewire\Users;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use App\Services\FormatHelperService;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class Datatable extends DataTableComponent
{
    protected $model = User::class;
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
            Column::make(trans('users.table-id'), "id")
                ->sortable(),
            Column::make(trans('users.table-name'), "name")
                ->sortable(),
            Column::make(trans('users.table-email'), "email")
                ->sortable(),
            Column::make(trans('users.table-role'), "role")
                ->format(fn ($value) => $this->formatter->role($value))
                ->html()
                ->sortable(),
            Column::make(trans('users.table-position'), "position.label")
                ->sortable(),
            Column::make(trans('users.table-affiliation'), "affiliation.label")
                ->sortable(),
            ButtonGroupColumn::make('Actions')
                ->setView('components.users.action')
        ];
    }
}
