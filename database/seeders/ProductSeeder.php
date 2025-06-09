<?php

namespace Database\Seeders;

use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $merk = DB::table('merks')->pluck('id', 'nama');

        DB::table('products')->insert([
            [
                'kategori' => 'Gaming',
                'merk_id' => $merk['ASUS'],
                'model' => 'ROG Strix G15',
                'harga' => 18500000,
                'bobot' => 2.30,
                'cpu_score' => 8.7,
                'gpu_score' => 8.2,
                'deskripsi' => '{"cpu": "AMD Ryzen 7 6800H", "gpu": "NVIDIA GeForce RTX 3060", "ram": "16GB DDR4", "penyimpanan": "512GB NVMe SSD"}'
            ],
            [
                'kategori' => 'Gaming',
                'merk_id' => $merk['Lenovo'],
                'model' => 'Legion 5 Pro',
                'harga' => 21000000,
                'bobot' => 2.50,
                'cpu_score' => 8.9,
                'gpu_score' => 8.5,
                'deskripsi' => '{"cpu": "AMD Ryzen 7 6800H", "gpu": "NVIDIA GeForce RTX 3070", "ram": "16GB DDR4", "penyimpanan": "1TB NVMe SSD"}'
            ],
            [
                'kategori' => 'Ultrabook',
                'merk_id' => $merk['Dell'],
                'model' => 'XPS 13',
                'harga' => 19000000,
                'bobot' => 1.20,
                'cpu_score' => 8.5,
                'gpu_score' => 6.8,
                'deskripsi' => '{"cpu": "Intel Core i7-1260P", "gpu": "Intel Iris Xe Graphics", "ram": "16GB LPDDR5", "penyimpanan": "512GB NVMe SSD"}'
            ],
            [
                'kategori' => 'Ultrabook',
                'merk_id' => $merk['HP'],
                'model' => 'Spectre x360 14',
                'harga' => 20000000,
                'bobot' => 1.30,
                'cpu_score' => 8.6,
                'gpu_score' => 7.0,
                'deskripsi' => '{"cpu": "Intel Core i7-1165G7", "gpu": "Intel Iris Xe Graphics", "ram": "16GB LPDDR4x", "penyimpanan": "1TB NVMe SSD"}'
            ],
            [
                'kategori' => 'Bisnis',
                'merk_id' => $merk['Lenovo'],
                'model' => 'ThinkPad X1 Carbon',
                'harga' => 22000000,
                'bobot' => 1.10,
                'cpu_score' => 8.6,
                'gpu_score' => 6.9,
                'deskripsi' => '{"cpu": "Intel Core i7-1260P", "gpu": "Intel Iris Xe Graphics", "ram": "16GB LPDDR5", "penyimpanan": "512GB NVMe SSD"}'
            ],
            [
                'kategori' => 'Bisnis',
                'merk_id' => $merk['Dell'],
                'model' => 'Latitude 7420',
                'harga' => 20000000,
                'bobot' => 1.20,
                'cpu_score' => 8.4,
                'gpu_score' => 6.8,
                'deskripsi' => '{"cpu": "Intel Core i7-1185G7", "gpu": "Intel Iris Xe Graphics", "ram": "16GB DDR4", "penyimpanan": "512GB NVMe SSD"}'
            ],
            [
                'kategori' => 'Entry-Level',
                'merk_id' => $merk['ASUS'],
                'model' => 'VivoBook 14',
                'harga' => 7000000,
                'bobot' => 1.60,
                'cpu_score' => 6.5,
                'gpu_score' => 5.0,
                'deskripsi' => '{"cpu": "Intel Core i3-1005G1", "gpu": "Intel UHD Graphics", "ram": "4GB DDR4", "penyimpanan": "256GB SSD"}'
            ],
            [
                'kategori' => 'Entry-Level',
                'merk_id' => $merk['HP'],
                'model' => '14s',
                'harga' => 6800000,
                'bobot' => 1.50,
                'cpu_score' => 6.3,
                'gpu_score' => 4.9,
                'deskripsi' => '{"cpu": "AMD Athlon Gold 3150U", "gpu": "AMD Radeon Graphics", "ram": "4GB DDR4", "penyimpanan": "256GB SSD"}'
            ],
            [
                'kategori' => 'Kreator Konten',
                'merk_id' => $merk['Apple'],
                'model' => 'MacBook Pro 16" (M1 Max)',
                'harga' => 35000000,
                'bobot' => 2.10,
                'cpu_score' => 9.5,
                'gpu_score' => 9.2,
                'deskripsi' => '{"cpu": "Apple M1 Max", "gpu": "Integrated 32-core GPU", "ram": "32GB Unified Memory", "penyimpanan": "1TB NVMe SSD"}'
            ],
            [
                'kategori' => 'Kreator Konten',
                'merk_id' => $merk['Dell'],
                'model' => 'XPS 15',
                'harga' => 25000000,
                'bobot' => 2.00,
                'cpu_score' => 8.8,
                'gpu_score' => 8.0,
                'deskripsi' => '{"cpu": "Intel Core i7-12700H", "gpu": "NVIDIA GeForce RTX 3050 Ti", "ram": "16GB DDR5", "penyimpanan": "512GB NVMe SSD"}'
            ],
            [
                'kategori' => 'Gaming',
                'merk_id' => $merk['ASUS'],
                'model' => 'TUF Gaming A15',
                'harga' => 14000000,
                'bobot' => 2.30,
                'cpu_score' => 7.8,
                'gpu_score' => 7.0,
                'deskripsi' => '{"cpu": "AMD Ryzen 5 4600H", "gpu": "NVIDIA GeForce GTX 1650", "ram": "8GB DDR4", "penyimpanan": "512GB NVMe SSD"}'
            ],
            [
                'kategori' => 'Ultrabook',
                'merk_id' => $merk['Lenovo'],
                'model' => 'Yoga 9i',
                'harga' => 18000000,
                'bobot' => 1.40,
                'cpu_score' => 8.4,
                'gpu_score' => 6.9,
                'deskripsi' => '{"cpu": "Intel Core i7-1185G7", "gpu": "Intel Iris Xe Graphics", "ram": "16GB LPDDR4x", "penyimpanan": "512GB NVMe SSD"}'
            ],
            [
                'kategori' => 'Bisnis',
                'merk_id' => $merk['HP'],
                'model' => 'EliteBook 840 G8',
                'harga' => 18000000,
                'bobot' => 1.30,
                'cpu_score' => 8.0,
                'gpu_score' => 6.5,
                'deskripsi' => '{"cpu": "Intel Core i5-1135G7", "gpu": "Intel Iris Xe Graphics", "ram": "8GB DDR4", "penyimpanan": "256GB NVMe SSD"}'
            ],
            [
                'kategori' => 'Entry-Level',
                'merk_id' => $merk['Lenovo'],
                'model' => 'IdeaPad Slim 3',
                'harga' => 6500000,
                'bobot' => 1.70,
                'cpu_score' => 6.2,
                'gpu_score' => 4.8,
                'deskripsi' => '{"cpu": "AMD Ryzen 3 3250U", "gpu": "AMD Radeon Graphics", "ram": "4GB DDR4", "penyimpanan": "256GB SSD"}'
            ],
            [
                'kategori' => 'Kreator Konten',
                'merk_id' => $merk['Apple'],
                'model' => 'MacBook Air (M2)',
                'harga' => 22000000,
                'bobot' => 1.20,
                'cpu_score' => 9.0,
                'gpu_score' => 7.5,
                'deskripsi' => '{"cpu": "Apple M2", "gpu": "Integrated 8-core GPU", "ram": "8GB Unified Memory", "penyimpanan": "256GB NVMe SSD"}'
            ]
        ]);
    }
}
