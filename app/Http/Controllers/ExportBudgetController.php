<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\BudgetItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

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
            'expenses' => $budgetItem->budgetItemExpenses()->with('expense')->orderBy('days', 'desc')->get()
        ]);

        return $pdf->stream();
    }

    public function evidence(Budget $budget) {
        $pdf = PDF::loadView('exports.evidence.index', [
            'listExpenses' => Budget::getExpenses($budget)->get(['id', 'label']),
            'items' => $budget->budgetItems,
            'serial' => $budget->serial,
            'date' => $budget->date
        ]);
        $pdf->set_paper('a4', 'landscape');
        return $pdf->stream();
    }

    public function certificate(BudgetItem $budget) {
        $pdf = PDF::loadView('exports.certificate.index', [
            'office' => $budget->budget->office->label,
            'expenses' => $budget->budgetItemExpenses()->with('expense')->orderBy('days', 'desc')->get(),
            'total' => BudgetItem::getBudgetExpenseTotal($budget),
            'name' => $budget->user->name,
            'position' => $budget->user->position->label,
        ]);

        return $pdf->stream();
    }

    public function travel(Budget $budget) {
        $pdf = PDF::loadView('exports.travel.index', []);
        $pdf->set_paper('a4', 'landscape');

        return $pdf->stream();
    }
}
