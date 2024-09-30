<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use Illuminate\Support\Facades\Redirect;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.expenses.index');
    }

    public function expenses()
    {
        $search = request()->get('q');
        $query = Expense::select("id", "label");

        if (!empty($search)) {
            $query->where('label', 'LIKE', "%$search%");
        }

        $data = $query->take(5)->get();

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request)
    {
        $expense = $this->auth()->budgetItemExpenses()->create($request->validated());

        return Redirect::back()->with('alert', [
            'text' => trans("expenses.controller-store", ["label" => $expense->label]),
            'variant' => "success"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        $expense->update($request->validated());

        return Redirect::back()->with('alert', [
            'text' => trans("expenses.controller-update", ["label" => $expense->label]),
            'variant' => "success"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return Redirect::back()->with('alert', [
            'text' => trans("expenses.controller-destroy", ["label" => $expense->label]),
            'variant' => "success"
        ]);
    }
}
