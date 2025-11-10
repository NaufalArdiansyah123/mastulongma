<?php

namespace Database\Seeders;

use App\Models\Help;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HelpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $helps = [
            [
                'user_id' => 3, // Budi Santoso (Kustomer)
                'category_id' => 7, // Pangan
                'city_id' => 1, // Jakarta
                'title' => 'Butuh Bantuan Makanan untuk Keluarga',
                'description' => 'Keluarga saya sedang mengalami kesulitan ekonomi. Kami membutuhkan bantuan berupa bahan makanan pokok seperti beras, minyak, dan telur untuk kebutuhan sehari-hari.',
                'location' => 'Kelurahan Cakung, Jakarta Timur',
                'status' => 'approved',
            ],
            [
                'user_id' => 3,
                'category_id' => 3, // Kesehatan
                'city_id' => 1,
                'title' => 'Bantuan Biaya Pengobatan Ibu',
                'description' => 'Ibu saya sedang sakit dan memerlukan perawatan medis. Kami membutuhkan bantuan untuk biaya pengobatan dan pembelian obat-obatan.',
                'location' => 'RS Harapan Kita, Jakarta Barat',
                'status' => 'approved',
            ],
            [
                'user_id' => 3,
                'category_id' => 1, // Rumah Tangga
                'city_id' => 1,
                'title' => 'Perbaikan Atap Rumah Bocor',
                'description' => 'Atap rumah kami bocor dan perlu diperbaiki segera. Kami membutuhkan bantuan tenaga dan bahan material untuk memperbaiki atap.',
                'location' => 'Kampung Melayu, Jakarta Timur',
                'status' => 'approved',
            ],
            [
                'user_id' => 3,
                'category_id' => 4, // Pendidikan
                'city_id' => 1,
                'title' => 'Bantuan Perlengkapan Sekolah Anak',
                'description' => 'Anak saya akan masuk sekolah tahun ajaran baru. Kami membutuhkan bantuan berupa seragam, sepatu, tas, dan perlengkapan sekolah lainnya.',
                'location' => 'SDN 01 Pagi, Menteng',
                'status' => 'approved',
            ],
            [
                'user_id' => 3,
                'category_id' => 5, // Transportasi
                'city_id' => 1,
                'title' => 'Bantuan Transportasi untuk Berobat',
                'description' => 'Saya perlu rutin ke rumah sakit untuk terapi fisik. Membutuhkan bantuan transportasi atau biaya transportasi karena jarak yang cukup jauh.',
                'location' => 'Cibubur - RSCM Kencana',
                'status' => 'approved',
            ],
        ];

        foreach ($helps as $help) {
            Help::create($help);
        }
    }
}
