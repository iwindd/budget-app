<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Http\Requests\StoreOfficeRequest;
use App\Http\Requests\UpdateOfficeRequest;
use Illuminate\Support\Facades\Redirect;

class OfficeController extends Controller
{
    /**
     * deactiveOffice
     *
     * @return void
     */
    private function deactiveOffice(){
        Office::where('default', true)->update(['default' => false]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(
                Office::with('createdBy:id,name')
                    ->get()
            )
                ->addColumn('created_by', function (Office $office) {
                    return $office->createdBy ? $office->createdBy->name : 'N/A';
                })
                ->addColumn("action", "components.offices.action")
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.offices.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOfficeRequest $request)
    {
        if ($request->validated()['default']) $this->deactiveOffice();

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
        if ($request->validated()['default']) $this->deactiveOffice();
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
