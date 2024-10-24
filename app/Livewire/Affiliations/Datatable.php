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
        $this->setDefaultSort('updated_at', 'desc');
    }

    public function delete(Affiliation $affiliation) {
        $this->dispatch("alert", trans('affiliations.alert-remove', ['label' => $affiliation->label]));
        return $affiliation->delete();
    }

    public function columns(): array
    {
        return [
            Column::make(trans('affiliations.table-label'), "label")
                ->sortable(),
            Column::make(trans('affiliations.table-created_by'), "user.name")
                ->format(fn($value) => $this->formatter->userName($value))
                ->sortable(),
            Column::make(trans('locations.table-updated_at'), "updated_at")
                ->format(fn($value) => $this->formatter->dateDiffHumans($value))
                ->sortable(),
            CountColumn::make(trans('affiliations.table-users'))
                ->setDataSource('users')
                ->sortable(),
            ButtonGroupColumn::make(trans('affiliations.table-action'))
                ->setView("components.action")
                ->attributes(fn ($row) => [
                    'label' => trans('affiliations.table-action-text'),
                    'options' => [
                        [
                            'icon' => 'heroicon-o-pencil',
                            'label' => trans('affiliations.action-edit'),
                            'dispatch' => ['open-affiliation-dialog', $row->only(['id', 'label'])]
                        ],
                        [
                            'icon' => 'heroicon-o-trash',
                            'label' => trans('affiliations.action-delete'),
                            'attributes' => [
                                'wire:confirmation'=> trans('affiliations.delete-confirmation', ['affiliation' => $row->label]),
                                'wire:click' => "delete({$row->id})"
                            ]
                        ]
                    ]
                ])
        ];
    }
}
