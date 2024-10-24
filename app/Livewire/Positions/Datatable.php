<?php

namespace App\Livewire\Positions;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Position;
use App\Services\FormatHelperService;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\CountColumn;

class Datatable extends DataTableComponent
{
    protected $model = Position::class;
    protected $formatter;

    public function __construct()
    {
        $this->formatter = app(FormatHelperService::class);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->addAdditionalSelects(['positions.id as positions.id']);
        $this->setDefaultSort('updated_at', 'desc');
    }

    public function delete(Position $position) {
        $this->dispatch("alert", trans('positions.alert-remove', ['label' => $position->label]));
        return $position->delete();
    }

    public function columns(): array
    {
        return [
            Column::make(trans('positions.table-label'), "label")
                ->sortable(),
            Column::make(trans('positions.table-created_by'), "user.name")
                ->format(fn($value) => $this->formatter->userName($value))
                ->sortable(),
            Column::make(trans('positions.table-updated_at'), "updated_at")
                ->format(fn($value) => $this->formatter->dateDiffHumans($value))
                ->sortable(),
            CountColumn::make(trans('positions.table-users'))
                ->setDataSource('users')
                ->sortable(),
            ButtonGroupColumn::make(trans('positions.table-action'))
                ->setView("components.action")
                ->attributes(fn($row) => [
                    'label' => trans('positions.table-action-text'),
                    'options' => [
                        [
                            'icon' => 'heroicon-o-pencil',
                            'label' => trans('positions.action-edit'),
                            'dispatch' => ['open-position-dialog', $row->only(['id', 'label'])]
                        ],
                        [
                            'icon' => 'heroicon-o-trash',
                            'label' => trans('positions.action-delete'),
                            'attributes' => [
                                'wire:confirmation' => trans('positions.delete-confirmation', ['affiliation' => $row->label]),
                                'wire:click' => "delete({$row->id})"
                            ]
                        ]
                    ]
                ])
        ];
    }
}
