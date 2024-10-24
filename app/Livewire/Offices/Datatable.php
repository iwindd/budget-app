<?php

namespace App\Livewire\Offices;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Office;
use App\Services\FormatHelperService;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class Datatable extends DataTableComponent
{
    protected $formatter;

    public function __construct()
    {
        $this->formatter = app(FormatHelperService::class);
    }

    public function builder(): Builder
    {
        return Office::query()
            ->orderByRaw("
                CASE
                    WHEN `default` = 1 THEN 1
                    WHEN `default` = 0 THEN 2
                END
            ");
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->addAdditionalSelects(['offices.id as id']);
        $this->setDefaultSort('updated_at', 'desc');
    }

    public function activated(Office $office)
    {
        $this->dispatch("alert", trans('offices.alert-active', ['label' => $office->label]));
        return Office::setActive($office);
    }

    public function delete(Office $office) {
        $this->dispatch("alert", trans('offices.alert-remove', ['label' => $office->label]));
        return $office->delete();
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
            Column::make(trans('offices.table-updated_at'), "updated_at")
                ->format(fn($value) => $this->formatter->dateDiffHumans($value))
                ->sortable(),
            ButtonGroupColumn::make(trans('offices.table-action'))
                ->setView("components.action")
                ->attributes(fn ($row) => [
                    'label' => trans('offices.table-action-text'),
                    'options' => [
                        [
                            'icon' => 'heroicon-o-pencil',
                            'label' => trans('offices.action-edit'),
                            'dispatch' => ['open-office-dialog', $row->only(['id', 'label', 'province', 'default'])]
                        ],

                        ...(!$row->default ? [ [
                                'icon' => 'heroicon-o-trash',
                                'label' => trans('offices.action-delete'),
                                'attributes' => [
                                    'wire:confirmation'=> trans('offices.delete-confirmation', ['office' => $row->label]),
                                    'wire:click' => "delete({$row->id})"
                                ]
                            ], [
                                'icon' => 'heroicon-o-arrows-up-down',
                                'label' => trans('offices.action-enable'),
                                'attributes' => [
                                    'wire:confirmation'=> trans('offices.enabled-confirmation', ['office' => $row->label]),
                                    'wire:click.prevent' => "activated({$row->id})"
                                ]
                            ]
                        ]: [])
                    ]
                ])
        ];
    }
}
