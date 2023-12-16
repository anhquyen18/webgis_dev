<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

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
        //     "status_id" => "2",
        //     "birthday" => "2000-9-18"
        // ]);

        // DB::table("users")->insert([
        //     "username" => "anhquyendeptraivcl",
        //     "name" => "Anh Quyền đẹp trai",
        //     "email" => "anhquyendeptraivcl@gamil.com",
        //     "password" => Hash::make("admin"),
        //     "department_id" => "2",
        //     "status_id" => "1",
        //     "birthday" => "2000-9-18"
        // ]);

        // DB::table("users")->insert([
        //     "username" => "ttat",
        //     "name" => "Trần Thị Anh Thảo",
        //     "email" => "ttat@gamil.com",
        //     "password" => Hash::make("das213sddas"),
        //     "department_id" => "2",
        //     "status_id" => "2",
        //     "birthday" => "2000-9-18"
        // ]);

        // DB::table("users")->insert([
        //     "username" => "tan",
        //     "name" => "Trần Anh Nguyên",
        //     "email" => "tan@gamil.com",
        //     "password" => Hash::make("adasdas1111"),
        //     "department_id" => "2",
        //     "status_id" => "1",
        //     "birthday" => "2000-09-18"
        // ]);
        // DB::table("users")->insert([
        //     "username" => "dpjpgfdhgjgp123",
        //     "name" => "abc",
        //     "email" => "asdsadsa@gamil.com",
        //     "password" => Hash::make("adasdas1111"),
        //     "department_id" => "2",
        //     "status_id" => "3",
        //     "birthday" => "2000-09-18"
        // ]);
        // DB::table("users")->insert([
        //     "username" => "tsadsdsd1111",
        //     "name" => "tran van c",
        //     "email" => "dasdas111@gamil.com",
        //     "password" => Hash::make("adasdas1111"),
        //     "department_id" => "1",
        //     "status_id" => "3",
        //     "birthday" => "2000-09-18"
        // ]);
        // DB::table("users")->update(['geoserver_account_id' => '1']);
        // User::create([
        //     'name' => 'Chủ tịt AQ',
        //     'email' => 'anhquyen22222@gmail.com',
        //     'password' => Hash::make('anhquyen11'),
        //     'username' => 'chutichaq18',
        //     'birthday' => '2000-09-18',
        //     'department_id' => '3',
        //     'status_id' => '1',
        //     'geoserver_account_id' => '1'
        // ]);
        // for ($i = 0; $i < 1000; $i++) {
        //     User::create([
        //         'name' => Str::random(10), // Generate a random name
        //         'email' => Str::random(10) . '@example.com', // Generate a random email
        //         'password' => Hash::make('anhquyen11'), // Generate a random password
        //         'username' => Str::random(8), // Generate a random username
        //         'birthday' => now()->subYears(random_int(18, 30)), // Generate a random birthday for users between 18 and 30 years old
        //         // 'department_id' => random_int(1, 5), // Assuming you have 5 departments
        //         'status_id' => random_int(1, 3), // Assuming you have 3 status options
        //         'geoserver_account_id' => 1, // Assuming you have 10 geoserver accounts
        //     ]);
        // }
    }
}
