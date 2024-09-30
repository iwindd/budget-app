<?php

namespace App\Livewire\Locations;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Location;
use App\Services\FormatHelperService;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class Datatable extends DataTableComponent
{
    protected $model = Location::class;
    protected $formatter;

    public function __construct()
    {
        $this->formatter = app(FormatHelperService::class); // Resolve the service
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make(trans("locations.table-id"), "id")
                ->sortable(),
            Column::make(trans("locations.table-label"), "label")
                ->sortable(),
            Column::make(trans("locations.table-created_by"), "user.name")
                ->format(fn($value) => $this->formatter->userName($value))
                ->sortable(),
            Column::make(trans('locations.table-created_at'), "created_at")
                ->format(fn($value) => $this->formatter->date($value))
                ->sortable(),
            ButtonGroupColumn::make('Actions')
                ->setView('components.locations.action')
        ];
    }
}
