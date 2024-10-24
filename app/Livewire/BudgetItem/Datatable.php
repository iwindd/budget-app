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
        $this->addAdditionalSelects(['budget_items.subject as subject']);
    }

    public function columns(): array
    {
        return [
            Column::make(trans('budgetitems.table-hasData'), 'id')
                ->format(fn ($val) => trans('budgetitems.table-hasData-'.(
                    BudgetItem::isHasData(BudgetItem::find($val)) ? 'true' : 'false'
                )))
                ->html(),
            Column::make(trans('budgetitems.table-serial'), "budget.serial")
                ->sortable(),
            Column::make(trans('budgetitems.table-subject'), "header")
                ->sortable()
                ->format(fn ($val, $row) => "{$val}/{$row->subject}"),
            Column::make(trans('budgetitems.table-date'), "date")
                ->sortable()
                ->format(fn ($val) => $this->formatter->date($val)),
            Column::make(trans('budgetitems.table-value'), "budget.value")
                ->format(fn ($value) => $this->formatter->number($value))
                ->sortable(),
            ButtonGroupColumn::make(trans('budgetitems.table-action'))
                ->setView("components.action")
                ->attributes(fn($row) => [
                    'label' => trans('budgetitems.table-action-text'),
                    'options' => [
                        [
                            'icon' => 'heroicon-o-pencil',
                            'label' => trans('budgetitems.action-edit'),
                            'attributes' => [
                                'href' => route('budgets.show', ['budget' => $row['budget.serial']])
                            ]
                        ],
                    ]
                ])
        ];
    }
}
