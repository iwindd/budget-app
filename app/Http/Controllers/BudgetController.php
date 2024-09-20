<?php

namespace App\Http\Controllers;

use App\Http\Requests\FindBudgetRequest;
use App\Models\Budget;
use App\Models\Invitation;
use App\Models\Office;
use App\Http\Requests\StoreBudgetRequest;
use App\Http\Requests\UpdateBudgetRequest;
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
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('user.budgets.create');
    }

    /**
     * Find budget to create or edit
     */
    public function find(FindBudgetRequest $request)
    {
        return Redirect::route("budgets.show", ['budget' => $request->validated()['serial']]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBudgetRequest $request) {}

    /**
     * Display the specified resource.
     */
    public function show($budget)
    {
        $office = Office::getOffice('label');
        $invitation = Invitation::getInvitation('label');

        return view('user.budgets.create.index', [
            'serial' => $budget,
            'invitation' => $invitation->label,
            'office' => $office->label
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Budget $budget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBudgetRequest $request, Budget $budget)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        //
    }
}
