<?php

namespace App\Http\Controllers;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.invitations.index');
    }
}
