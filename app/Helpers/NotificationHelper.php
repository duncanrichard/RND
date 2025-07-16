<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\NotificationForEngineering;
use App\Models\NotificationForProduction;
use App\Models\NotificationForQC;
use Illuminate\Support\Facades\Log;

class NotificationHelper
{
    protected static array $departmentModelMap = [
        'production' => NotificationForProduction::class,
        'quality_control' => NotificationForQC::class,
        'engineering' => NotificationForEngineering::class,
        // Tambahkan departemen lain jika ada
    ];

    public static function saveToDepartment(array $data, string $departemen)
    {
        $key = strtolower(str_replace(' ', '_', $departemen));

        if (!isset(self::$departmentModelMap[$key])) {
            Log::warning("Departemen '{$departemen}' tidak memiliki model notifikasi.");
            return null;
        }

        $model = self::$departmentModelMap[$key];

        try {
            return $model::create($data);
        } catch (\Throwable $e) {
            Log::error("Gagal menyimpan notifikasi ke departemen '$key': " . $e->getMessage());
            return null;
        }
    }
}
