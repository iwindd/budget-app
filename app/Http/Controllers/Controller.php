<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * auth
     *
     * @return User
     */
    protected function auth() : User{
        return Auth::user();
    }

    protected function select(Request $request, $modelClass, $filters = null) {
        if (!class_exists($modelClass)) return response()->json(['error' => 'Invalid model class'], 400);

        $model = new $modelClass;
        $find = $request->get('find');
        $valueField = $request->get('value') ?? 'id';
        $labelField = $request->get('label') ?? 'label';
        // Apply additional filters if provided
        if ($filters) $model = $model->where($filters);

        if ($find) return response()->json($model->findOrFail($find, [$valueField, $labelField]));
        $search = $request->get('q');
        $query = $model->select([$valueField, $labelField]);
        if (!empty($search)) $query->where($labelField, 'LIKE', "%$search%");
        $data = $query->take(5)->get();

        return response()->json($data);
    }
}
