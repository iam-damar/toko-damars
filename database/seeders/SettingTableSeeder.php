<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->insert([

            'id_setting' => 1,
            'nama_perusahaan' => 'Toko Damar',
            'alamat' => 'Jl. Jalak Perumnas Blora',
            'telepon' => '08112345678',
            'tipe_nota' => 1, // 1 kecil, 2 besar
            'diskon' => 5,
            'path_logo' => '/img/toko-logo.png',
            'path_kartu_member' => '/img/card.jpg',
        ]);
    }
}
