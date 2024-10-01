<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Http\Requests\StoreOfficeRequest;
use App\Http\Requests\UpdateOfficeRequest;
use Illuminate\Support\Facades\Redirect;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.offices.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOfficeRequest $request)
    {
        if ($request->validated()['default']) Office::deactivated();

        $office = $this->auth()->offices()->create($request->validated());

        return Redirect::back()->with('alert', [
            'text' => trans("offices.controller-store", ["label" => $office->label]),
            'variant' => "success"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOfficeRequest $request, Office $office)
    {
        if ($request->validated()['default']) Office::deactivated();
        $office->update($request->validated());

        return Redirect::back()->with('alert', [
            'text' => trans("offices.controller-update", ["label" => $office->label]),
            'variant' => "success"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Office $office)
    {
        $office->delete();

        return Redirect::back()->with('alert', [
            'text' => trans("offices.controller-destroy", ["label" => $office->label]),
            'variant' => "success"
        ]);
    }
}
