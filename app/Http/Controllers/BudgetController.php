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
        if (request()->ajax()) {
            return datatables()->of(
                $this->auth()->budgetItems()->with('budget')->with('budget.user')
            )
                ->addColumn("action", "components.budgets.action")
                ->addColumn('hasData', function (BudgetItem $item) {
                    return BudgetItem::isHasData($item);
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

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

    public function parseCompanion(array $items){
        return collect($items)->map(function($val){
            return [
                'user_id' => $val
            ];
        });
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBudgetRequest $request) {
        $payload = $request->validated();
        $serial = $payload['serial'];
        $budget = Budget::where('serial', $serial)->first();

        if ($budget) return $this->update($request, $budget);

        $payload['office_id'] = Office::getOffice('id')->id;
        $payload['invitation_id'] = Invitation::getInvitation('id')->id;

        $budget = $this->auth()->budgets()->create($payload);
        $budget->budgetItems()->create(['user_id' => $this->auth()->id]);

        return Redirect::back()->with('alert', [
            'text' => trans("budget.controller-create", ["label" => $budget->serial]),
            'variant' => "success"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($budget)
    {
        $data = Budget::where('serial', $budget)->with(['user', 'office', 'invitation'])->first();
        $office = $data->office ?? Office::getOffice('label');
        $invitation = $data->invitation ?? Invitation::getInvitation('label');
        $isOwner = ($data && $this->isOwnerBudget($data)) || !$data;

        return view('user.budgets.create.index', [
            'serial' => $budget,
            'invitation' => $invitation->label,
            'office' => $office->label,
            'data' => $data,
            'isOwner' => $isOwner
        ]);
    }

    public function isOwnerBudget(Budget $budget) : Bool {
        $owner = $budget->user()->get('id')->first();

        return $owner && $owner->id == $this->auth()->id;
    }

    public function getBudgetItem(Budget $budget) : BudgetItem {
        return $budget->budgetItems()->where('user_id', $this->auth()->id)->first();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBudgetRequest $request, Budget $budget)
    {
        if ($this->isOwnerBudget($budget)) {
            $budget->update($request->safe(['title', 'place', 'date', 'order_at', 'value']));
        };

        return Redirect::back()->with('alert', [
            'text' => trans("budget.controller-update", ["label" => $budget->serial]),
            'variant' => "success"
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
