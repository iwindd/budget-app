<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Http\Requests\StoreInvitationRequest;
use App\Http\Requests\UpdateInvitationRequest;
use Illuminate\Support\Facades\Redirect;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.invitations.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvitationRequest $request)
    {
        if ($request->validated()['default']) Invitation::deactivated();

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
        if ($request->validated()['default']) Invitation::deactivated();
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
