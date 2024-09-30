<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    // Users
    public function index()
    {
        return view('admin.users.index');
    }

    public function companion()
    {
        $search = request()->get('q');
        $query = User::select("id", "name")
            ->where('role', 'user')
            ->where('id', '!=' , $this->auth()->id);

        if (!empty($search)) {
            $query->where('name', 'LIKE', "%$search%");
        }

        $data = $query->take(5)->get();

        return response()->json($data);
    }
}
