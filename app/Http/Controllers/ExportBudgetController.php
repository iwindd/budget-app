<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\BudgetItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ExportBudgetController extends Controller
{
    public function document(BudgetItem $budget)
    {
        $budgetFromBack = BudgetItem::getFromBack($budget);

        $fromDate = Carbon::parse($budgetFromBack['from']);
        $backDate = Carbon::parse($budgetFromBack['back']);

        $pdf = Pdf::loadView('exports.document.index', [
            'serial' => $budget->budget->serial,
            'date' => $budget->budget->date,
            'name' => $budget->user->name,
            'value' => $budget->budget->value,
            'office' => $budget->budget->office->label,
            'invitation' => $budget->budget->invitation->label,
            'order_id' => $budget->budget->order_id,
            'order_at' => $budget->budget->order_at,
            'position' => $budget->user->position->label,
            'affiliation' => $budget->user->affiliation->label,
            'companions' => $budget->budget->budgetItems()->with('user')->where('user_id', '!=', $budget->user_id)->get(),
            'subject' => $budget->budget->subject, /* TODO:: place will change to subject later */
            'addresses' => $budget->budgetItemAddresses()->with(['from', 'back'])->get(),
            'days' => $fromDate->diffInDays($backDate),
            'hours' => $fromDate->diffInHours($backDate),
            'expenses' => $budget->budgetItemExpenses()->with('expense')->orderBy('days', 'desc')->get()
        ]);

        return $pdf->stream();
    }

    public function evidence(Budget $budget) {
        $pdf = PDF::loadView('exports.evidence.index', [

        ]);
        $pdf->set_paper('a4', 'landscape');
        return $pdf->stream();
    }
}
