<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use Illuminate\Support\Facades\Redirect;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.positions.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePositionRequest $request)
    {
        $position = $this->auth()->positions()->create($request->validated());

        return Redirect::back()->with('alert', [
            'text' => trans("positions.controller-store", ["label" => $position->label]),
            'variant' => "success"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePositionRequest $request, Position $position)
    {
        $position->update($request->validated());

        return Redirect::back()->with('alert', [
            'text' => trans("positions.controller-update", ["label" => $position->label]),
            'variant' => "success"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position)
    {
        $position->delete();

        return Redirect::back()->with('alert', [
            'text' => trans("positions.controller-destroy", ["label" => $position->label]),
            'variant' => "success"
        ]);
    }
}
