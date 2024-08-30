<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    // Users
    public function index()
    {

        return view('admin.users.index');
    }
}
