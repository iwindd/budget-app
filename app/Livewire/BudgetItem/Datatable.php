<?php

namespace App\Livewire\BudgetItem;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\BudgetItem;
use App\Services\FormatHelperService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
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
        /** @var User $user */
        $user = Auth::user();

        return $user->budgetItems()->getQuery();
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make(trans('budgetitems.table-id'), "id")
                ->sortable(),
            Column::make(trans('budgetitems.table-serial'), "budget.serial")
                ->sortable(),
            Column::make(trans('budgetitems.table-subject'), "budget.subject")
                ->sortable(),
            Column::make(trans('budgetitems.table-value'), "budget.value")
                ->format(fn ($value) => $this->formatter->number($value))
                ->sortable(),
            Column::make(trans('budgetitems.table-created_by'), "budget.user.name")
                ->format(fn ($value) => $this->formatter->userName($value))
                ->sortable(),
            Column::make(trans('budgetitems.table-created_at'), "created_at")
                ->format(fn ($value) => $this->formatter->date($value))
                ->sortable(),
            ButtonGroupColumn::make('Actions')
                ->setView('components.budgets.action')
        ];
    }
}
