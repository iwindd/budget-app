<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\BudgetItem;
use Illuminate\Http\Request;

class BudgetAdminController extends Controller
{
    public function index(){
        return view('admin.budgets.index');
    }

    public function show(Budget $budget) {
        return view('user.budgets.create.index', [
            'serial' => $budget->serial
        ]);
    }
}
