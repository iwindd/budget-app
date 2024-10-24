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

    public function delete($id) {
        return $this->model::find($id)->delete();
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
                        [
                            'icon' => 'heroicon-o-trash',
                            'label' => trans('offices.action-delete'),
                            'attributes' => [
                                'wire:confirmation'=> trans('offices.delete-confirmation', ['office' => $row->label]),
                                'wire:click' => "delete({$row->id})"
                            ]
                        ],
                        ...(!$row->default ? [[
                            'icon' => 'heroicon-o-arrows-up-down',
                            'label' => trans('offices.action-enable'),
                            'attributes' => [
                                'wire:confirmation'=> trans('offices.enabled-confirmation', ['office' => $row->label]),
                                'wire:click.prevent' => "activated({$row->id})"
                            ]
                        ]]: [])
                    ]
                ])
        ];
    }
}
