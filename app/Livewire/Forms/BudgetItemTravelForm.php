<?php

namespace App\Livewire\Forms;

use App\Models\BudgetItem;
use App\Models\BudgetItemTravel;
use Livewire\Form;

class BudgetItemTravelForm extends Form
{
    public $start;
    public $end;
    public $n;
    public $rows = [];

    public function setBudgetItemTravel(BudgetItem $budgetItem) {
        $travel = $budgetItem->budgetItemTravel;

        if ($travel && $travel->exists){
            $this->start = $travel->start;
            $this->end = $travel->end;
            $this->n = $travel->n;
            $this->rows = $travel->budgetItemTravelItems->toArray();
        }
    }

    public function save(BudgetItem $budgetItem) {
        $validated = $this->validate([
            'start' => ['required', 'date'],
            'end' => ['required', 'date', 'after:start'],
            'n' => ['required', 'string', 'max:255'],
            'rows' => ['required', 'array'],
            'rows.*.plate' => ['required', 'string', 'max:15'],
            'rows.*.start' => ['required', 'date'],
            'rows.*.driver' => ['required', 'string', 'max:255'],
            'rows.*.location' => ['required', 'string', 'max:255'],
            'rows.*.end' => ['required', 'date'],
            'rows.*.distance' => ['required', 'integer', 'min:0'],
            'rows.*.round' => ['required', 'integer', 'min:1']
        ]);

        if (!$budgetItem->exists){
            return;
        }

        $budgetItemTravelValues = [
            'budget_item_id' => $budgetItem->id,
            'start' => $validated['start'],
            'end' => $validated['end'],
            'n' => $validated['n']
        ];
        $travel = BudgetItemTravel::updateOrCreate([
            'budget_item_id' => $budgetItemTravelValues['budget_item_id']
        ], $budgetItemTravelValues);

        $travel->budgetItemTravelItems()->delete();
        $travel->budgetItemTravelItems()->createMany($validated['rows']);
    }
}
