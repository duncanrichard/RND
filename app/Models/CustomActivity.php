<?php

namespace App\Models;

use Spatie\Activitylog\Models\Activity as SpatieActivity;

class CustomActivity extends SpatieActivity
{
    protected $table = 'activity_log';

    /**
     * Field yang bisa diisi secara massal
     */
    protected $fillable = [
        'log_name',
        'description',
        'subject_id',
        'subject_type',
        'causer_id',
        'causer_type',
        'properties',
        'batch_uuid',
        'created_at',
        'updated_at',
        'id_user',
    ];

    /**
     * Konversi otomatis field ke tipe data
     */
    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
