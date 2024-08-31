<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    // Users
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(
                User::all()
            )
                ->addColumn("action", "components.users.action")
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.users.index');
    }
}
