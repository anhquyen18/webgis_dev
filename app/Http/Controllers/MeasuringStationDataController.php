<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MeasuringStationDataController extends Controller
{
    public function getData(Request $request)
    {
        $data = $request->json()->all();

        $measureingData = DB::table('measuring_station_data')
            ->select(
                DB::raw('Extract(MONTH FROM measure_at) as month'),
                DB::raw('Extract(YEAR FROM measure_at) as year'),
                'rainfall as rainfall',
                'temperature as temp'
            )
            ->where('station_id', '=', 1)
            ->get();


        return response()->json($measureingData);

        // return $data['year'];
        // echo 'anhquyendeptraivcl';
    }
}
