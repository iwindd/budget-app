<?php

namespace App\Livewire\Affiliations;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Affiliation;
use App\Services\FormatHelperService;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\CountColumn;

class Datatable extends DataTableComponent
{
    protected $model = Affiliation::class;
    protected $formatter;

    public function __construct()
    {
        $this->formatter = app(FormatHelperService::class);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->addAdditionalSelects(['affiliations.id as affiliations.id']);
    }

    public function columns(): array
    {
        return [
            Column::make(trans('affiliations.table-label'), "label")
                ->sortable(),
            Column::make(trans('affiliations.table-created_by'), "user.name")
                ->format(fn($value) => $this->formatter->userName($value))
                ->sortable(),
            Column::make(trans('affiliations.table-created_at'), "created_at")
                ->format(fn($value) => $this->formatter->date($value))
                ->sortable(),
            CountColumn::make(trans('affiliations.table-users'))
                ->setDataSource('users')
                ->sortable(),
            ButtonGroupColumn::make('Actions')
                ->setView('components.affiliations.action')
        ];
    }
}
