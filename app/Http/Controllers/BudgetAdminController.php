<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\BudgetItem;
use Illuminate\Http\Request;

class BudgetAdminController extends Controller
{
    public function index()
    {
        return view('admin.budgets.index');
    }

    public function show(Request $request) {
        $budget = Budget::where('serial', $request->budget)->firstOrFail();
        $budgetItem = $budget->budgetItems()->findOrFail($request->budgetItem);
        $travel = $budgetItem->budgetItemTravel();

        return view('user.budgets.create.index', [
            'budgetItemId' => BudgetItem::isHasData($budgetItem) ? $budgetItem->id : 0,
            'budgetItemTravelId' => $travel->id ?? 0
        ]);
    }
}
