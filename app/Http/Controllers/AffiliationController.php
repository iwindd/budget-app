<?php

namespace App\Http\Controllers;

use App\Models\Affiliation;
use App\Http\Requests\StoreAffiliationRequest;
use App\Http\Requests\UpdateAffiliationRequest;
use Illuminate\Support\Facades\Redirect;

class AffiliationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.affiliations.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAffiliationRequest $request)
    {
        $affiliation = $this->auth()->affiliations()->create($request->validated());

        return Redirect::back()->with('alert', [
            'text' => trans("affiliations.controller-store", ["label" => $affiliation->label]),
            'variant' => "success"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAffiliationRequest $request, Affiliation $affiliation)
    {
        $affiliation->update($request->validated());

        return Redirect::back()->with('alert', [
            'text' => trans("affiliations.controller-update", ["label" => $affiliation->label]),
            'variant' => "success"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Affiliation $affiliation)
    {
        $affiliation->delete();

        return Redirect::back()->with('alert', [
            'text' => trans("affiliations.controller-destroy", ["label" => $affiliation->label]),
            'variant' => "success"
        ]);
    }
}
