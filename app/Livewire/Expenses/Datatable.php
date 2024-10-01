<?php

namespace App\Livewire\Expenses;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Expense;
use App\Services\FormatHelperService;
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
    }

    public function columns(): array
    {
        return [
            Column::make(trans("expenses.table-label"), "label")
                ->sortable(),
            Column::make(trans("expenses.table-created_by"), "user.name")
                ->format(fn($value) => $this->formatter->userName($value))
                ->sortable(),
            Column::make(trans('expenses.table-created_at'), "created_at")
                ->format(fn($value) => $this->formatter->date($value))
                ->sortable(),
            ButtonGroupColumn::make('Actions')
                ->setView('components.expenses.action')
        ];
    }
}
