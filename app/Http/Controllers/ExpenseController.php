<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.expenses.index');
    }

    public function expenses(Request $request)
    {
        return $this->select($request, Expense::class, [
            ['id', '!=', 4]
        ]);
    }
}
