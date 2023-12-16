<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    public function index()
    {
        $data = DB::table('departments')->select('id as value', 'name as label')->get();
        return response()->json($data);
        // return response()->json(compact('userData', 'geoserverAccount'));
    }
}
