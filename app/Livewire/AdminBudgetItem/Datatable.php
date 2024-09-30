<?php

namespace App\Livewire\AdminBudgetItem;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\BudgetItem;
use App\Services\FormatHelperService;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class Datatable extends DataTableComponent
{
    protected $model = BudgetItem::class;
    protected $formatter;

    public function __construct()
    {
        $this->formatter = app(FormatHelperService::class);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make(trans('budgetitems.table-serial'), "budget.serial")
                ->sortable(),
            Column::make(trans('budgetitems.table-order_id'), "budget.order_id")
                ->sortable(),
            Column::make(trans('budgetitems.table-subject'), "budget.subject")
                ->sortable(),
            Column::make(trans('budgetitems.table-owner'), "user.name")
                ->format(fn($value) => $this->formatter->userName($value))
                ->sortable(),
            Column::make(trans('budgetitems.table-created_at'), "created_at")
                ->format(fn($value) => $this->formatter->date($value))
                ->sortable(),
            ButtonGroupColumn::make('Actions')
                ->setView('components.budgets_admin.action')
        ];
    }
}
