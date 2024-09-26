<?php

namespace App\Http\Controllers;

use App\Models\BudgetItem;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportBudgetController extends Controller
{
    public function document(BudgetItem $budget)
    {
        $pdf = Pdf::loadView('exports.document.index', [
            'serial' => $budget->budget->serial,
            'date' => $budget->budget->date,
            'name' => $budget->user->name,
            'value' => $budget->budget->value,
            'office' => $budget->budget->office->label,
            'invitation' => $budget->budget->invitation->label,
            'order_id' => $budget->budget->title,
            'order_at' => $budget->budget->order_at,
            'position' => $budget->user->position->label,
            'affiliation' => $budget->user->affiliation->label,
            'companions' => '',
            'subject' => $budget->user->subject,
        ]);

        return $pdf->stream();
    }
}
