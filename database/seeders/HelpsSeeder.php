<?php

namespace Database\Seeders;

use App\Models\Help;
use App\Models\User;
use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class HelpsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Simple curated titles and short descriptions to keep text tidy
        $items = [
            ['title' => 'Perbaikan Atap Bocor', 'desc' => 'Butuh tukang untuk memperbaiki atap rumah yang bocor.'],
            ['title' => 'Bantuan Obat', 'desc' => 'Membutuhkan obat untuk pengobatan harian.'],
            ['title' => 'Transportasi ke Rumah Sakit', 'desc' => 'Butuh biaya atau tumpangan ke rumah sakit.'],
            ['title' => 'Bantuan Makanan Pokok', 'desc' => 'Mencari bantuan bahan makanan untuk keluarga.'],
            ['title' => 'Bantuan Belanja Sekolah', 'desc' => 'Membutuhkan perlengkapan sekolah untuk anak.'],
            ['title' => 'Perbaikan Pipa Air', 'desc' => 'Pipa air pecah, butuh teknisi plumbing.'],
            ['title' => 'Cuci Karpet', 'desc' => 'Butuh jasa cuci karpet rumah ukuran sedang.'],
            ['title' => 'Pemasangan Lampu', 'desc' => 'Mencari teknisi untuk memasang lampu dan kabel.'],
            ['title' => 'Bantuan Bayar Listrik', 'desc' => 'Kesulitan membayar tagihan listrik bulan ini.'],
            ['title' => 'Jasa Kirim Barang', 'desc' => 'Perlu bantuan mengantar paket kecil ke kota tetangga.'],
            ['title' => 'Bantuan Pembersihan Rumah', 'desc' => 'Mencari orang untuk membersihkan rumah selama setengah hari.'],
            ['title' => 'Perbaikan Kulkas', 'desc' => 'Kulkas tidak dingin, membutuhkan servis teknisi.'],
            ['title' => 'Jasa Pengecatan', 'desc' => 'Butuh tukang cat untuk mengecat satu kamar.'],
            ['title' => 'Bantuan Modal Usaha', 'desc' => 'Permintaan bantuan modal kecil untuk usaha rumahan.'],
            ['title' => 'Pertolongan Darurat', 'desc' => 'Butuh bantuan cepat untuk keadaan darurat keluarga.'],
            ['title' => 'Bantuan Kesehatan Anak', 'desc' => 'Perlu biaya pemeriksaan dan obat untuk anak.'],
            ['title' => 'Perbaikan Motor', 'desc' => 'Motor mogok, cari montir keliling.'],
            ['title' => 'Bantuan Pakaian', 'desc' => 'Mencari bantuan pakaian layak untuk keluarga.'],
            ['title' => 'Jasa Antar Jemput', 'desc' => 'Perlu antar jemput anak ke sekolah selama seminggu.'],
            ['title' => 'Perbaikan Kamar Mandi', 'desc' => 'Toilet bocor, butuh tukang ledeng.'],
            ['title' => 'Bantuan Konsultasi Hukum', 'desc' => 'Perlu nasihat hukum sederhana terkait dokumen.'],
            ['title' => 'Pembuatan CV', 'desc' => 'Mencari bantuan pembuatan CV dan surat lamaran.'],
            ['title' => 'Bantuan Tanam Kebun', 'desc' => 'Butuh tenaga untuk menanam sayuran di pekarangan.'],
            ['title' => 'Pembersihan Saluran', 'desc' => 'Got tersumbat, butuh pembersihan saluran air.'],
            ['title' => 'Jasa Fotokopi', 'desc' => 'Perlu fotokopi dokumen dalam jumlah kecil.'],
        ];

        $userIds = User::pluck('id')->toArray();
        $cityIds = City::pluck('id')->toArray();

        if (empty($userIds)) {
            $userIds = [1];
        }
        if (empty($cityIds)) {
            $cityIds = [1];
        }

        $hasCategory = Schema::hasColumn('helps', 'category_id');

        foreach ($items as $idx => $item) {
            $data = [
                'user_id' => $userIds[$idx % count($userIds)],
                'city_id' => $cityIds[$idx % count($cityIds)],
                'title' => $item['title'],
                'description' => $item['desc'],
                'location' => '',
                'amount' => rand(10000, 150000),
                'photo' => null,
                'status' => 'menunggu_mitra',
            ];

            if ($hasCategory) {
                $categoryIds = \DB::table('categories')->pluck('id')->toArray();
                if (!empty($categoryIds)) {
                    $data['category_id'] = $categoryIds[$idx % count($categoryIds)];
                }
            }

            Help::create($data);
        }
    }
}
