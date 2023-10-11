<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use stdClass;


class MapController extends Controller
{
    public function getCrs()
    {
        // $crs = DB::table('spatial_ref_sys')->select(DB::raw("CONCAT(SUBSTRING_INDEX(SUBSTRING_INDEX(srtext, '\"', 2), '\"', -1),' | ', CONCAT(auth_name,':',srid)) AS name"), DB::raw("CONCAT(auth_name,':',srid) as code"), "proj4text as proj4")->distinct()->get();
        //mysql
        // $crs = DB::table('spatial_ref_sys')->select(DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(srtext, '\"', 2), '\"', -1) AS subtracted_string "))->get();
        // nghiên cứu cái regexp này~~~~~~~~~~~~~~~
        //postgres sql
        $crs = DB::table('spatial_ref_sys')->select(
            DB::raw("CONCAT(TRIM( both '\"' from (REGEXP_MATCHES(srtext, '\".*?\"'))[1]),' | ', auth_name || ':' || srid) AS name"),
            DB::raw("auth_name || ':' || srid as code"),
            "proj4text as proj4"
        )
            ->distinct()->get();

        // $crs = DB::table('spatial_ref_sys')->get();
        return response()->json($crs);
        // phpinfo();
    }

    public function test()
    {
        // $url = "http://127.0.0.1:8000/api/test2";
        // $ch = curl_init($url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // $response = curl_exec($ch);
        // if ($response !== false) {
        //     // Process the response
        //     return $response;
        // } else {
        //     // Handle error
        //     echo "Error: " . curl_error($ch);
        // }

        // curl_close($ch);
        return "nothing happens";
    }

    public function test2()
    {
        return "anhquyendeptraivcl";
    }
}
