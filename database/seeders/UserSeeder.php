<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('users')->insert([
            [
                'name' => 'Андрей',
                'email' => 'andrey@gmail.com',
                'password' => Hash::make('andreyPassword'),
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Сергей',
                'email' => 'sergey@gmail.com',
                'password' => Hash::make('sergeyPassword'),
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Михаил',
                'email' => 'mikhail@gmail.com',
                'password' => Hash::make('mikhailPassword'),
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Стас',
                'email' => 'stas@gmail.com',
                'password' => Hash::make('stasPassword'),
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Артем',
                'email' => 'artem@gmail.com',
                'password' => Hash::make('artemPassword'),
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Татьяна',
                'email' => 'tatyana@gmail.com',
                'password' => Hash::make('tatyanaPassword'),
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Евгений',
                'email' => 'evgenij@gmail.com',
                'password' => Hash::make('evgenijPassword'),
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Катя',
                'email' => 'kate@gmail.com',
                'password' => Hash::make('katePassword'),
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Борис',
                'email' => 'boris@gmail.com',
                'password' => Hash::make('borisPassword'),
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
