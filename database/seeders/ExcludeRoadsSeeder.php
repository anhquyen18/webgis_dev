<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExcludeRoadsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("exclude_roads")->insert([
            ["target" => "73184"],
            ["target" => "73185"],
            ["target" => "73183"],
            ["target" => "73182"],
            ["target" => "73186"],
            ["target" => "21777"],
            ["target" => "66201"],
        ]);
    }

    public function test(): void
    {
    }
}
