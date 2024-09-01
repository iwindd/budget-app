<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Http\Requests\StoreInvitationRequest;
use App\Http\Requests\UpdateInvitationRequest;
use Illuminate\Support\Facades\Redirect;

class InvitationController extends Controller
{
    /**
     * deactiveInvitation
     *
     * @return void
     */
    private function deactiveInvitation(){
        Invitation::where('default', true)->update(['default' => false]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(
                Invitation::with('createdBy:id,name')
                    ->get()
            )
                ->addColumn('created_by', function (Invitation $invitation) {
                    return $invitation->createdBy ? $invitation->createdBy->name : 'N/A';
                })
                ->addColumn("action", "components.invitations.action")
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.invitations.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvitationRequest $request)
    {
        if ($request->validated()['default']) $this->deactiveInvitation();

        $invitation = $this->auth()->invitations()->create($request->validated());

        return Redirect::back()->with('alert', [
            'text' => trans("invitations.controller-store", ["label" => $invitation->label]),
            'variant' => "success"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvitationRequest $request, Invitation $invitation)
    {
        if ($request->validated()['default']) $this->deactiveInvitation();
        $invitation->update($request->validated());

        return Redirect::back()->with('alert', [
            'text' => trans("invitations.controller-update", ["label" => $invitation->label]),
            'variant' => "success"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invitation $invitation)
    {
        $invitation->delete();

        return Redirect::back()->with('alert', [
            'text' => trans("invitations.controller-destroy", ["label" => $invitation->label]),
            'variant' => "success"
        ]);
    }
}
