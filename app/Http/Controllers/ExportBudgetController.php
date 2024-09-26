<?php

namespace App\Http\Controllers;

use App\Models\BudgetItem;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportBudgetController extends Controller
{
    public function document(BudgetItem $budget)
    {
        $pdf = Pdf::loadView('exports.document.index');

        return $pdf->stream();
    }
}
