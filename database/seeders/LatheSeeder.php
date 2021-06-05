<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LatheSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('lathes')->insert([
            [
                'id' => 44,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 56,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 23,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 78,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 102,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
