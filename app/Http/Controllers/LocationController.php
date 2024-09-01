<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use Illuminate\Support\Facades\Redirect;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(
                Location::with('createdBy:id,name')
                    ->get()
            )
                ->addColumn('created_by', function (Location $location) {
                    return $location->createdBy ? $location->createdBy->name : 'N/A';
                })
                ->addColumn("action", "components.locations.action")
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.locations.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocationRequest $request)
    {
        $location = $this->auth()->locations()->create($request->validated());

        return Redirect::back()->with('alert', [
            'text' => trans("locations.controller-store", ["label" => $location->label]),
            'variant' => "success"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLocationRequest $request, Location $location)
    {
        $location->update($request->validated());

        return Redirect::back()->with('alert', [
            'text' => trans("locations.controller-update", ["label" => $location->label]),
            'variant' => "success"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        $location->delete();

        return Redirect::back()->with('alert', [
            'text' => trans("locations.controller-destroy", ["label" => $location->label]),
            'variant' => "success"
        ]);
    }
}
