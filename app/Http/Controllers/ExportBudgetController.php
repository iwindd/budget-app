<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\BudgetItem;
use App\Models\BudgetItemTravel;
use App\Models\Expense;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use PA\ProvinceTh\Factory;

class ExportBudgetController extends Controller
{
    public function document(Budget $budget, BudgetItem $budgetItem)
    {
        $budgetFromBack = BudgetItem::getFromBack($budgetItem);

        $fromDate = Carbon::parse($budgetFromBack['from']);
        $backDate = Carbon::parse($budgetFromBack['back']);

        $pdf = Pdf::loadView('exports.document.index', [
            'serial' => $budget->serial,
            'date' => $budget->date,
            'owner' => $budget->user->name,
            'name' => $budgetItem->user->name,
            'value' => $budget->value,
            'office' => $budget->office->label,
            'invitation' => $budget->invitation->label,
            'order' => $budgetItem->order,
            'order_at' => $budget->date,
            'position' => $budgetItem->user->position->label,
            'owner_position' => $budget->user->position->label,
            'affiliation' => $budgetItem->user->affiliation->label,
            'companions' => $budget->budgetItems()->with('user')->where('user_id', '!=', $budget->user_id)->get(),
            'header' => $budgetItem->header,
            'subject' => $budgetItem->subject,
            'addresses' => $budgetItem->budgetItemAddresses()->with(['from', 'back'])->get(),
            'days' => $fromDate->diffInDays($backDate),
            'hours' => $fromDate->diffInHours($backDate),
            'expenses' => $budgetItem->budgetItemExpenses()
                ->whereHas('expense', function($query) {
                    $query->where('merge', false);
                    $query->where('default', false);
                })
                ->with('expense')
                ->orderBy('days', 'desc')->get(),
            'defaultExpense' => Expense::createDefaultBudgetItemExpense($budgetItem)
        ]);

        return $pdf->stream();
    }

    public function evidence(Budget $budget) {
        $expenses = Budget::getExpenses($budget)
            ->where('merge', false)
            ->where('default', false)
            ->get(['id', 'label', 'merge']);

        $expenses->push(Expense::getDefault());

        $pdf = PDF::loadView('exports.evidence.index', [
            'office' => $budget->office->label,
            'province' => Factory::province()->find($budget->office->province)['name_th'],
            'name' => $budget->user->name,
            'position' => $budget->user->position->label,
            'listExpenses' => $expenses,
            'items' => $budget->budgetItems,
            'serial' => $budget->serial,
            'date' => $budget->date
        ]);
        $pdf->set_paper('a4', 'landscape');
        return $pdf->stream();
    }

    public function certificate(Budget $budget, BudgetItem $budgetItem) {
        $pdf = PDF::loadView('exports.certificate.index', [
            'office' => $budget->office->label,
            'expenses' => $budgetItem->budgetItemExpenses()->with('expense')->orderBy('days', 'desc')->get(),
            'total' => BudgetItem::getBudgetExpenseTotal($budgetItem),
            'name' => $budgetItem->user->name,
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
