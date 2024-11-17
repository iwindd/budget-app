<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\BudgetAddress;
use App\Models\BudgetCompanion;
use App\Models\BudgetItem;
use App\Models\BudgetItemTravel;
use App\Models\Expense;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use PA\ProvinceTh\Factory;

class ExportBudgetController extends Controller
{
    public function document(Request $request, Budget $budget)
    {
        $user = $budget->user;
        $owner = $budget->user;
        $companions = null;
        $companions = $budget->companions()->where('user_id', '!=', $request->get('of'))->get();
        $of = $budget->companions()->where('user_id', $request->get('of'))->first();

        if ($of){
            $fakeCompanion = new BudgetCompanion();
            $fakeCompanion->user_id = $user->id;
            $fakeCompanion->budget_id = $budget->id;
            $companions->push($fakeCompanion);
            $user = $of->user;
        }

        $pdf = Pdf::loadView('exports.document.index', [
            'serial' => $budget->serial,
            'date' => $budget->date,
            'owner' => $owner->name,
            'name' => $user->name,
            'value' => $budget->value,
            'office' => $budget->office->label,
            'invitation' => $budget->invitation->label,
            'order' => $budget->order,
            'order_at' => $budget->date,
            'position' => $user->position->label,
            'owner_position' => $user->position->label,
            'affiliation' => $user->affiliation->label,
            'companions' => $companions,
            'header' => $budget->header,
            'subject' => $budget->subject,
            'addresses' => $budget->addresses,
            'locations' => BudgetAddress::list(),
            'hours' => Budget::getTotalHours($budget),
            'expenses' => $budget->expenses()
                ->whereHas('expense', function($query) {
                    $query->where('merge', false);
                    $query->where('default', false);
                })
                ->with('expense')
                ->orderBy('days', 'desc')->get(),
            'defaultExpense' => Expense::createDefaultBudgetItemExpense($budget)
        ]);

        return $pdf->stream();
    }

    public function evidence(Budget $budget) {
        $expenses = Budget::getExpenses($budget)
            ->where('merge', false)
            ->where('default', false)
            ->get(['id', 'label', 'merge']);
        $expenses->push(Expense::getDefault(['id', 'label', 'merge', 'default']));

        $users = $budget->companions;
        $owner = new BudgetCompanion();
        $owner->user_id = $budget->user_id;
        $owner->budget_id = $budget->id;
        $users->prepend($owner);

        $pdf = PDF::loadView('exports.evidence.index', [
            'office' => $budget->office->label,
            'province' => Factory::province()->find($budget->office->province)['name_th'],
            'name' => $budget->user->name,
            'position' => $budget->user->position->label,
            'value' => $budget->value,
            'expenses' => $expenses,
            'budgetExpenses' => $budget->expenses,
            'users' => $users,
            'serial' => $budget->serial,
            'date' => $budget->finish_at
        ]);
        $pdf->set_paper('a4', 'landscape');
        return $pdf->stream();
    }

    public function certificate(Budget $budget) {
        $pdf = PDF::loadView('exports.certificate.index', [
            'office' => $budget->office->label,
            'name' => $budget->user->name,
            'position' => $budget->user->position->label,
            'header' => $budget->header,
            'addresses' => $budget->addresses,
            'subject' => $budget->subject
        ]);

        return $pdf->stream();
    }

    public function travel(Budget $budget, BudgetItem $budgetItem) {
        $budgetItemTravel = BudgetItemTravel::where("budget_item_id", $budgetItem->id)->firstOrFail();
        $pdf = PDF::loadView('exports.travel.index', [
            'office' => $budget->office->label,
            'province' => Factory::province()->find($budget->office->province)['name_th'],
            'name' => $budgetItem->user->name,
            'position' => $budgetItem->user->position->label,
            'start' => $budgetItemTravel->start,
            'end' => $budgetItemTravel->end,
            'n' => $budgetItemTravel->n,
            'rows' => $budgetItemTravel->budgetItemTravelItems
        ]);
        $pdf->set_paper('a4', 'landscape');

        return $pdf->stream();
    }
}
