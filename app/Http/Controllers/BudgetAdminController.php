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
                BudgetItem::with('budget')->with('user')
            )
                ->addColumn("action", "components.budgets_admin.action")
                ->addColumn('owner', function (BudgetItem $item) {
                    return $item->budget->user_id == $item->user_id;
                })
                ->addColumn('hasData', function (BudgetItem $item) {
                    return BudgetItem::isHasData($item);
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.budgets.index');
    }

}
