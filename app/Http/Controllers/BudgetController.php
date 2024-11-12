<?php

namespace App\Http\Controllers;

use App\Http\Requests\FindBudgetRequest;
use App\Models\Budget;
use App\Models\BudgetItemTravel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.budgets.index');
    }

    /**
     * Find budget to create or edit
     */
    public function find(FindBudgetRequest $request)
    {
        return Redirect::route("budgets.show", ['budget' => $request->validated()['serial']]);
    }

    public function getBudgetItem(String $serial) {
        try {
            $budget = Budget::where("serial", $serial)->firstOrFail();

            return ($budget->budgetItems()->where('user_id', Auth::user()->id)->first('id'))->id;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public function getBudgetItemTravel(String $serial) {
        try {
            $travel = BudgetItemTravel::where("budget_item_id", $this->getBudgetItem($serial))
                ->firstOrFail();

            return $travel->id;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return view('user.budgets.create.index', [
            'budgetItemId' => $this->getBudgetItem($request->budget),
            'budgetItemTravelId' => $this->getBudgetItemTravel($request->budget)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        //
    }
}
