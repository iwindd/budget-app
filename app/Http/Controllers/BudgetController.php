<?php

namespace App\Http\Controllers;

use App\Http\Requests\FindBudgetRequest;
use App\Models\Budget;
use App\Models\Invitation;
use App\Models\Office;
use App\Http\Requests\StoreBudgetRequest;
use App\Models\BudgetItem;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

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

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return view('user.budgets.create.index');
/*         $data = Budget::where('serial', $budget)->first('user_id');

        return view('user.budgets.create.index', [
            'serial' => $budget,
            'isNew' => !$data,
            'isOwner' => !$data || $data->user_id == $this->auth()->id,
        ]); */
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        //
    }
}
