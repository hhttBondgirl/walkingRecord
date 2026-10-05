<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // --------------------------------------------------
        // 1日目（例: 2026年8月19日）
        // --------------------------------------------------
        DB::table('walking_records')->insert([
            'walking_date' => '2026-08-19',
            'time_zone'    => '朝',
            'minutes'      => 30,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        DB::table('walking_records')->insert([
            'walking_date' => '2026-08-19',
            'time_zone'    => '夕',
            'minutes'      => 20,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        // --------------------------------------------------
        // 2日目（例: 2026年8月20日）
        // --------------------------------------------------
        DB::table('walking_records')->insert([
            'walking_date' => '2026-08-20',
            'time_zone'    => '朝',
            'minutes'      => 35,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        DB::table('walking_records')->insert([
            'walking_date' => '2026-08-20',
            'time_zone'    => '夕',
            'minutes'      => 18,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        // --------------------------------------------------
        // 3日目（例: 2026年8月21日）
        // --------------------------------------------------
        DB::table('walking_records')->insert([
            'walking_date' => '2026-08-21',
            'time_zone'    => '朝',
            'minutes'      => 35,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);
        DB::table('walking_records')->insert([
            'walking_date' => '2026-08-21',
            'time_zone'    => '夕',
            'minutes'      => 20,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);
    }
}