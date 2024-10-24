<?php

namespace App\Livewire\Invitations;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Invitation;
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
        return Invitation::query()
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
        $this->addAdditionalSelects(['invitations.id as id']);
        $this->setDefaultSort('updated_at', 'desc');
    }

    public function activated(Invitation $invitation)
    {
        $this->dispatch("alert", trans('invitations.alert-active', ['label' => $invitation->label]));
        return Invitation::setActive($invitation);
    }

    public function delete(Invitation $invitation) {
        $this->dispatch("alert", trans('invitations.alert-remove', ['label' => $invitation->label]));
        return $invitation->delete();
    }

    public function columns(): array
    {
        return [
            Column::make(trans('invitations.table-label'), "label")
                ->sortable(),
            BooleanColumn::make(trans('invitations.table-default'), "default")
                ->toggleable('activated')
                ->sortable(),
            Column::make(trans('invitations.table-created_by'), "user.name")
                ->format(fn($value) => $this->formatter->userName($value))
                ->sortable(),
            Column::make(trans('invitations.table-updated_at'), "updated_at")
                ->format(fn($value) => $this->formatter->dateDiffHumans($value))
                ->sortable(),
            ButtonGroupColumn::make(trans('invitations.table-action'))
                ->setView("components.action")
                ->attributes(fn($row) => [
                    'label' => trans('invitations.table-action-text'),
                    'options' => [
                        [
                            'icon' => 'heroicon-o-pencil',
                            'label' => trans('invitations.action-edit'),
                            'dispatch' => ['open-invitation-dialog', $row->only(['id', 'label', 'default'])]
                        ],

                        ...(!$row->default ? [
                            [
                                'icon' => 'heroicon-o-trash',
                                'label' => trans('invitations.action-delete'),
                                'attributes' => [
                                    'wire:confirmation' => trans('invitations.delete-confirmation', ['invitation' => $row->label]),
                                    'wire:click' => "delete({$row->id})"
                                ]
                            ],
                            [
                                'icon' => 'heroicon-o-arrows-up-down',
                                'label' => trans('invitations.action-enable'),
                                'attributes' => [
                                    'wire:confirmation' => trans('invitations.enabled-confirmation', ['invitation' => $row->label]),
                                    'wire:click.prevent' => "activated({$row->id})"
                                ]
                            ]
                        ] : [])
                    ]
                ])
        ];
    }
}
