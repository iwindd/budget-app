<?php

namespace App\Http\Controllers;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.offices.index');
    }
}
