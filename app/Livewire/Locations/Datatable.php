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
        $this->addAdditionalSelects(['locations.id as id']);
        $this->setDefaultSort('updated_at', 'desc');
    }

    public function delete(Location $location) {
        $this->dispatch("alert", trans('locations.alert-remove', ['label' => $location->label]));
        return $location->delete();
    }

    public function columns(): array
    {
        return [
            Column::make(trans("locations.table-label"), "label")
                ->sortable(),
            Column::make(trans("locations.table-created_by"), "user.name")
                ->format(fn($value) => $this->formatter->userName($value))
                ->sortable(),
            Column::make(trans('locations.table-updated_at'), "updated_at")
                ->format(fn($value) => $this->formatter->dateDiffHumans($value))
                ->sortable(),
            ButtonGroupColumn::make(trans('locations.table-action'))
                ->setView("components.action")
                ->attributes(fn ($row) => [
                    'label' => trans('locations.table-action-text'),
                    'options' => [
                        [
                            'icon' => 'heroicon-o-pencil',
                            'label' => trans('locations.action-edit'),
                            'dispatch' => ['open-location-dialog', $row->only(['id', 'label'])]
                        ],
                        [
                            'icon' => 'heroicon-o-trash',
                            'label' => trans('locations.action-delete'),
                            'attributes' => [
                                'wire:confirmation'=> trans('locations.delete-confirmation', ['location' => $row->label]),
                                'wire:click' => "delete({$row->id})"
                            ]
                        ]
                    ]
                ])
        ];
    }
}
