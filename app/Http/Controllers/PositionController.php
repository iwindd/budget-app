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
        if (request()->ajax()) {
            return datatables()->of(
                Position::withCount('users')
                    ->with('createdBy:id,name')
                    ->get()
            )
                ->addColumn('users_count', function (Position $position) {
                    return $position->users_count;
                })
                ->addColumn('created_by', function (Position $position) {
                    return $position->createdBy ? $position->createdBy->name : 'N/A';
                })
                ->addColumn("action", "components.positions.action")
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.positions.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePositionRequest $request)
    {
        $position = $this->auth()->positions()->create($request->validated());

        return Redirect::back()->with('alert', [
            'text' => "เพิ่มตำแหน่ง '{$position->label}' สำเร็จแล้ว",
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
            'text' => "แก้ไขตำแหน่ง '{$position->label}' สำเร็จแล้ว",
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
            'text' => "ลบตำแหน่ง '{$position->label}' สำเร็จแล้ว",
            'variant' => "success"
        ]);
    }
}
