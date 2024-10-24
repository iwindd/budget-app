<?php

namespace App\Http\Controllers;

use App\Models\Affiliation;
use App\Http\Requests\StoreAffiliationRequest;
use App\Http\Requests\UpdateAffiliationRequest;
use Illuminate\Support\Facades\Redirect;

class AffiliationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.affiliations.index');
    }
}
