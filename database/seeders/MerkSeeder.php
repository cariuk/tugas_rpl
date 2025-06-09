<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MerkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('merks')->insert([
            ['nama' => 'ASUS'],
            ['nama' => 'Lenovo'],
            ['nama' => 'HP'],
            ['nama' => 'Dell'],
            ['nama' => 'Apple'],
            ['nama' => 'Acer'],
            ['nama' => 'MSI'],
            ['nama' => 'Razer'],
            ['nama' => 'Alienware'],
            ['nama' => 'Gigabyte'],
            ['nama' => 'LG'],
            ['nama' => 'Microsoft'],
            ['nama' => 'Samsung'],
            ['nama' => 'Dynabook'],
            ['nama' => 'Huawei'],
            ['nama' => 'Fujitsu'],
            ['nama' => 'Axioo'],
            ['nama' => 'Advan'],
            ['nama' => 'Xiaomi'],
            ['nama' => 'Infinix'],
            ['nama' => 'Realme'],
            ['nama' => 'Tecno'],
            ['nama' => 'Qualcomm']
        ]);
    }
}
