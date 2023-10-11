<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeoserverAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("geoserver_account")->insert([
            [
                "account" => "U2FsdGVkX1/3c8GB7SykHsyl3mzyTbLP4yiIcc0N1YZtYm9I4kBvfEMDgzUhKwtR",
                "key" => "U2FsdGVkX19aLU1PUqojVrNILMYtEUTPG/qesUz8pKRoIMdrwrh+si2XXvqQPkOr",
            ]
        ]);
    }
}
