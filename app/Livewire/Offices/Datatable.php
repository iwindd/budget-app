<?php

namespace App\Livewire\Offices;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Office;
use App\Services\FormatHelperService;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class Datatable extends DataTableComponent
{
    protected $model = Office::class;
    protected $formatter;

    public function __construct()
    {
        $this->formatter = app(FormatHelperService::class);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->addAdditionalSelects(['offices.id as id']);
    }

    public function activated(int $id)
    {
        $this->model::deactivated();
        $item = $this->model::find($id);
        $item->default = !$item->default;
        $item->save();
    }

    public function columns(): array
    {
        return [
            Column::make(trans('offices.table-label'), "label")
                ->sortable(),
            Column::make(trans('offices.table-province'), "province")
                ->format(fn($value) => $this->formatter->province($value))
                ->sortable(),
            BooleanColumn::make(trans('offices.table-default'), "default")
                ->toggleable('activated')
                ->sortable(),
            Column::make(trans('offices.table-created_by'), "user.name")
                ->format(fn($value) => $this->formatter->userName($value))
                ->sortable(),
            Column::make(trans('offices.table-created_at'), "created_at")
                ->format(fn($value) => $this->formatter->date($value))
                ->sortable(),
            ButtonGroupColumn::make('Actions')
                ->setView('components.offices.action')
        ];
    }
}
