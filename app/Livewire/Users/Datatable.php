<?php

namespace App\Livewire\Users;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use App\Services\FormatHelperService;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class Datatable extends DataTableComponent
{
    protected $formatter;

    public function __construct()
    {
        $this->formatter = app(FormatHelperService::class);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->addAdditionalSelects(['affiliations.label as affiliation.label']);
    }

    public function builder(): Builder
    {
        return User::query()
            ->join('affiliations', 'affiliations.id', '=', 'users.affiliation_id');
    }

    public function columns(): array
    {
        return [
            Column::make(trans('users.table-id'), "id")
            ->setSortingPillTitle('Full Name')
            ->sortable(),


            Column::make(trans('users.table-name'), "name")
                ->sortable(),
            Column::make(trans('users.table-email'), "email")
                ->sortable(),
            Column::make(trans('users.table-role'), "role")
                ->format(fn ($value) => $this->formatter->role($value))
                ->html()
                ->sortable(),
            Column::make(trans('users.table-position/affiliation'), "position.label")
                ->format(fn ($value, $row) => "$value/{$row['affiliation.label']}")
                ->sortable(),
            ButtonGroupColumn::make('Actions')
                ->setView('components.users.action')
        ];
    }
}
