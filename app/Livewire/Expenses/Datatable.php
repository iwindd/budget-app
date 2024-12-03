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
    protected $model = Expense::class;
    protected $formatter;

    public function __construct()
    {
        $this->formatter = app(FormatHelperService::class); // Resolve the service
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->addAdditionalSelects(['expenses.id as id']);
        $this->setDefaultSort('id', 'asc');
    }

    public function delete(Expense $expense) {
        if ($expense->id <= 4) return;
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
                            'dispatch' => ['open-expense-dialog', $row->only(['id', 'label'])]
                        ],
                        ...($row->id > 4 ? [
                            [
                                'icon' => 'heroicon-o-trash',
                                'label' => trans('expenses.action-delete'),
                                'attributes' => [
                                    'wire:confirmation' => trans('expenses.delete-confirmation', ['expense' => $row->label]),
                                    'wire:click' => "delete({$row->id})"
                                ]
                            ]
                        ] : []),
                    ]
                ])
        ];
    }
}
