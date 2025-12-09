<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\BalanceTransaction;
use App\Notifications\NewTopupRequest;
use Illuminate\Support\Facades\Notification;

class AdminNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user
        $admin = User::where('role', 'admin')->first();
        
        if (!$admin) {
            $this->command->warn('No admin user found. Run UserSeeder first.');
            return;
        }

        // Create some test notifications for admin
        $notifications = [
            [
                'type' => 'App\Notifications\CustomNotification',
                'data' => [
                    'type' => 'new_topup_request',
                    'customer_name' => 'Budi Santoso',
                    'customer_id' => 1,
                    'amount' => 100000,
                    'request_code' => 'TOP-' . strtoupper(uniqid()),
                    'message' => 'Request top-up baru menunggu persetujuan Anda'
                ],
                'read_at' => null
            ],
            [
                'type' => 'App\Notifications\CustomNotification',
                'data' => [
                    'type' => 'new_registration',
                    'message' => 'Pendaftaran mitra baru perlu verifikasi KTP'
                ],
                'read_at' => null
            ],
            [
                'type' => 'App\Notifications\CustomNotification',
                'data' => [
                    'type' => 'help_taken',
                    'message' => 'Mitra telah mengambil bantuan "Butuh Angkut Barang"'
                ],
                'read_at' => now()->subHours(2)
            ],
            [
                'type' => 'App\Notifications\CustomNotification',
                'data' => [
                    'type' => 'new_topup_request',
                    'customer_name' => 'Siti Rahma',
                    'customer_id' => 2,
                    'amount' => 250000,
                    'request_code' => 'TOP-' . strtoupper(uniqid()),
                    'message' => 'Request top-up baru menunggu persetujuan Anda'
                ],
                'read_at' => now()->subDay()
            ],
        ];

        foreach ($notifications as $notificationData) {
            \Illuminate\Support\Facades\DB::table('notifications')->insert([
                'id' => \Illuminate\Support\Str::uuid(),
                'type' => $notificationData['type'],
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $admin->id,
                'data' => json_encode($notificationData['data']),
                'read_at' => $notificationData['read_at'],
                'created_at' => now()->subMinutes(rand(1, 120)),
                'updated_at' => now()->subMinutes(rand(1, 120)),
            ]);
        }

        $this->command->info('Admin test notifications created successfully!');
    }
}
