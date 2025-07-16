<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class BroadcastHelper
{
    // Daftar departemen yang diizinkan menerima notifikasi
    protected static array $allowedDepartments = [
        'production',
        'quality_control',
        'qa',
        'engineering',
        'research_and_development'
    ];

    public static function broadcastToDepartment(string $departemen, string $eventClass, array $payload)
    {
        // Ubah nama departemen ke lowercase dan ganti spasi dengan underscore
        $normalized = strtolower(str_replace(' ', '_', $departemen));

        // Validasi departemen
        if (!in_array($normalized, self::$allowedDepartments)) {
            Log::warning("Departemen '$departemen' tidak terdaftar sebagai penerima notifikasi.");
            return;
        }

        // Pastikan class event valid
        if (!class_exists($eventClass)) {
            Log::error("Event class $eventClass tidak ditemukan.");
            return;
        }

        // Tambahkan channel ke payload
        $payload['channel'] = $normalized . '-channel';

        Log::info('channel : ' . $payload['channel']);

        // Kirim broadcast
        try {
            broadcast(new $eventClass($payload));
        } catch (\Throwable $e) {
            Log::error("Gagal broadcast event $eventClass ke $normalized-channel: " . $e->getMessage());
        }
    }
}
