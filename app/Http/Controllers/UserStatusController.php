<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class UserStatusController extends Controller
{
    public function index()
    {
        $data = DB::table('user_status')->select('id as value', 'name as label')->get();
        return response()->json($data);
        // return response()->json(compact('userData', 'geoserverAccount'));
    }
}
