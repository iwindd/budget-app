<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Users
    public function index()
    {
        return view('admin.users.index');
    }

    public function companion(Request $request)
    {
        return $this->select($request, User::class, [
            ['role', 'user'],
            ['id', '!=', auth()->id()]
        ]);
    }
}
