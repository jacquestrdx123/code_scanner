<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for ($x = 1; $x <= 10000; $x++) {
            $int= mt_rand(1262055681,1262055681);
            $string = date("Y-m-d H:i:s",$int);
            DB::table('scans')->insert([
                'code' => $x,
                'created_at' => $string
            ]);
        }

    }
}
