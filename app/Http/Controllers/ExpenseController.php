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
        if (request()->ajax()) {
            return datatables()->of(
                Expense::with('createdBy:id,name')
                    ->get()
            )
                ->addColumn('created_by', function (Expense $expense) {
                    return $expense->createdBy ? $expense->createdBy->name : 'N/A';
                })
                ->addColumn("action", "components.expenses.action")
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.expenses.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request)
    {
        $expense = $this->auth()->expenses()->create($request->validated());

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
