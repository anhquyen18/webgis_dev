<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use stdClass;

class ExcludeRoadsController extends Controller
{


    public function insertExcludeRoads(Request $request)
    {
        DB::table('exclude_roads')->truncate();
        // $data = $request->data;
        $dataArray = request()->all();


        foreach ($dataArray as $value) {
            DB::table('exclude_roads')->insert([
                'target' => $value,
            ]);
        }
    }
}
