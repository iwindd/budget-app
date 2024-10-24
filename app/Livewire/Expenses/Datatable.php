<?php

namespace App\Livewire\Expenses;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Expense;
use App\Services\FormatHelperService;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class Datatable extends DataTableComponent
{
    protected $formatter;

    public function __construct()
    {
        $this->formatter = app(FormatHelperService::class); // Resolve the service
    }

    public function builder(): Builder
    {
        return Expense::query()
            ->orderByRaw("
                CASE
                    WHEN `default` = 1 THEN 1
                    WHEN `default` = 0 THEN 2
                    WHEN `merge` = 1 THEN 3
                    WHEN `merge` = 0 THEN 4
                END
            ");
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->addAdditionalSelects(['expenses.id as id']);
        $this->setDefaultSort('updated_at', 'desc');
    }

    public function toggleMerge(Expense $expense)
    {
        $this->dispatch("alert", trans('expenses.alert-merge', ['label' => $expense->label]));
        $expense->merge = !$expense->merge;
        $expense->save();
    }

    public function toggleDefault(Expense $expense) {
        $this->dispatch("alert", trans('expenses.alert-default', ['label' => $expense->label]));
        return Expense::setDefault($expense);
    }


    public function delete(Expense $expense) {
        $this->dispatch("alert", trans('expenses.alert-remove', ['label' => $expense->label]));
        return $expense->delete();
    }

    public function columns(): array
    {
        return [
            Column::make(trans("expenses.table-label"), "label")
                ->sortable(),
            Column::make(trans("expenses.table-created_by"), "user.name")
                ->format(fn($value) => $this->formatter->userName($value))
                ->sortable(),
            BooleanColumn::make(trans('expenses.table-merge'), "merge")
                ->toggleable('toggleMerge')
                ->sortable(),
            BooleanColumn::make(trans('expenses.table-default'), "default")
                ->toggleable('toggleDefault')
                ->sortable(),
            Column::make(trans('expenses.table-updated_at'), "updated_at")
                ->format(fn($value) => $this->formatter->dateDiffHumans($value))
                ->sortable(),
            ButtonGroupColumn::make(trans('expenses.table-action'))
                ->setView("components.action")
                ->attributes(fn($row) => [
                    'label' => trans('expenses.table-action-text'),
                    'options' => [
                        [
                            'icon' => 'heroicon-o-pencil',
                            'label' => trans('expenses.action-edit'),
                            'dispatch' => ['open-expense-dialog', $row->only(['id', 'label', 'default', 'merge'])]
                        ],
                        ...(!$row->default ? [
                            [
                                'icon' => 'heroicon-o-trash',
                                'label' => trans('expenses.action-delete'),
                                'attributes' => [
                                    'wire:confirmation' => trans('expenses.delete-confirmation', ['expense' => $row->label]),
                                    'wire:click' => "delete({$row->id})"
                                ]
                            ]
                        ] : []),
                        [
                            'icon' => 'heroicon-o-arrow-down-on-square-stack',
                            'label' => trans('expenses.action-merge'),
                            'attributes' => [
                                'wire:confirmation' => trans('expenses.merge-confirmation', ['expense' => $row->label]),
                                'wire:click.prevent' => "toggleMerge({$row->id})"
                            ]
                        ],
                        ...(!$row->default ? [
                            [
                                'icon' => 'heroicon-o-square-2-stack',
                                'label' => trans('expenses.action-default'),
                                'attributes' => [
                                    'wire:confirmation' => trans('expenses.default-confirmation', ['expense' => $row->label]),
                                    'wire:click.prevent' => "toggleDefault({$row->id})"
                                ]
                            ]
                        ] : [])
                    ]
                ])
        ];
    }
}
