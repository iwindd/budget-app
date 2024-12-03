<?php

namespace App\Http\Controllers;

use App\Models\Affiliation;
use Illuminate\Http\Request;

class AffiliationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.affiliations.index');
    }

    public function affiliations(Request $request)
    {
        return $this->select($request, Affiliation::class);
    }
}
