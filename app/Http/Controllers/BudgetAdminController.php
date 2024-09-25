<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\BudgetItem;
use Illuminate\Http\Request;

class BudgetAdminController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(
                Budget::with('user')->withCount('budgetItems')->get()
            )
                ->addColumn("action", "components.budgets_admin.action")
                ->addColumn('hasData', function () {
                    return '-';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.budgets.index');
    }

}
