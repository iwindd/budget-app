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
                User::with('position:id,label')->get()
            )
                ->addColumn('position', function (User $user) {
                    return $user->position ? $user->position->label : 'N/A';
                })
                ->addColumn("action", "components.users.action")
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.users.index');
    }
}
