<?php

namespace App\Livewire\Users;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
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

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->addAdditionalSelects(['users.id as users.id']);
        $this->addAdditionalSelects(['users.position_id as position.id']);
        $this->addAdditionalSelects(['users.affiliation_id as affiliation.id']);
        $this->addAdditionalSelects(['affiliations.label as affiliation.label']);
    }

    public function builder(): Builder
    {
        return User::query()
            ->join('affiliations', 'affiliations.id', '=', 'users.affiliation_id')
            ->selectRaw('(select count(*) from `budgets` where `users`.`id` = `budgets`.`user_id`) as `budgetitems_count`')
            ->selectRaw('(select count(*) from `expenses` where `users`.`id` = `expenses`.`user_id`) as `expenses_count`');
    }

    public function formatBudgetExpenseCount($row) {
        return trans('users.table-budgetitems/expenses-format', [
            'budget' => $this->formatter->number($row['budgetitems_count']),
            'expense' => $this->formatter->number($row['expenses_count'])
        ]);
    }

    public function loginAs(User $user) {
        Auth::loginUsingId($user->id);
        return redirect()->route('dashboard');
    }

    public function columns(): array
    {
        return [
            Column::make(trans('users.table-name'), "name")
                ->sortable(),
            Column::make(trans('users.table-email'), "email")
                ->sortable(),
            Column::make(trans('users.table-role'), "role")
                ->format(fn ($value) => $this->formatter->role($value))
                ->html()
                ->sortable(),
            Column::make(trans('users.table-position/affiliation'), "position.label")
                ->format(fn ($value, $row) => "$value/{$row['affiliation.label']}")
                ->sortable(),
            Column::make(trans('users.table-budgetitems/expenses-total'))
                ->sortable()
                ->label(fn ($row) => $this->formatBudgetExpenseCount($row)),
            ButtonGroupColumn::make(trans('users.table-action'))
                ->setView("components.action")
                ->attributes(fn($row) => [
                    'label' => trans('users.table-action-text'),
                    'options' => [
                        [
                            'icon' => 'heroicon-o-pencil',
                            'label' => trans('users.action-edit'),
                            'dispatch' => ['open-users-dialog', $row->toArray()]
                        ],
                        ...($row->role != 'banned' ? [
                            [
                                'icon' => 'heroicon-o-arrow-left-end-on-rectangle',
                                'label' => trans('users.action-login-as-user'),
                                'attributes' => [
                                    'wire:confirmation' => "คุณต้องการเข้าสู่ระบบในฐานะผู้ใช้งาน {$row->name} หรือไม่?",
                                    'wire:click' => "loginAs({$row['users.id']})"
                                ]
                            ]
                        ] : [])
                    ]
                ])
        ];
    }
}
