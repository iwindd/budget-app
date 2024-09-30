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
        return view('admin.locations.index');
    }

    public function locations()
    {
        $search = request()->get('q');
        $query = Location::select("id", "label");

        if (!empty($search)) {
            $query->where('label', 'LIKE', "%$search%");
        }

        $data = $query->take(5)->get();

        return response()->json($data);
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
