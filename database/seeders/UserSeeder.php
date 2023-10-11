<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table("users")->insert([
        //     "username" => "abcxyz",
        //     "name" => "Nguyên Văn B",
        //     "email" => "asdasd@gamil.com",
        //     "password" => Hash::make("a5trrtfgf"),
        //     "department_id" => "2",
        //     "status_id" => "2"
        // ]);

        // DB::table("users")->insert([
        //     "username" => "anhquyendeptraivcl",
        //     "name" => "Anh Quyền đẹp trai",
        //     "email" => "anhquyendeptraivcl@gamil.com",
        //     "password" => Hash::make("admin"),
        //     "department_id" => "2",
        //     "status_id" => "1"
        // ]);

        // DB::table("users")->insert([
        //     "username" => "ttat",
        //     "name" => "Trần Thị Anh Thảo",
        //     "email" => "ttat@gamil.com",
        //     "password" => Hash::make("das213sddas"),
        //     "department_id" => "2",
        //     "status_id" => "2"
        // ]);

        // DB::table("users")->insert([
        //     "username" => "tan",
        //     "name" => "Trần Anh Nguyên",
        //     "email" => "tan@gamil.com",
        //     "password" => Hash::make("adasdas1111"),
        //     "department_id" => "2",
        //     "status_id" => "1"
        // ]);
        // DB::table("users")->insert([
        //     "username" => "dpjpgfdhgjgp123",
        //     "name" => "abc",
        //     "email" => "asdsadsa@gamil.com",
        //     "password" => Hash::make("adasdas1111"),
        //     "department_id" => "2",
        //     "status_id" => "3"
        // ]);
        // DB::table("users")->insert([
        //     "username" => "tsadsdsd1111",
        //     "name" => "tran van c",
        //     "email" => "dasdas111@gamil.com",
        //     "password" => Hash::make("adasdas1111"),
        //     "department_id" => "1",
        //     "status_id" => "3"
        // ]);
        // DB::table("users")->update(['geoserver_account_id' => '1']);
    }
}
