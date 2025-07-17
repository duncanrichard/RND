<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestPerbaikanTeknikDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'engineering';

    protected $table = 'request_perbaikan_teknik_detail';

    protected $fillable = [
        'request_perbaikan_id',
        'kode_aset',
        'nama_aset',
        'kategori_aset',
        'deskripsi_kerusakan',
        'dokumentasi_kerusakan',
        'status_permohonan',
        'tanggal_confirmed',
        'approval_status',
        'tanggal_approval',
        'approval_by',
        'status_perbaikan',
        'tanggal_open',
        'tanggal_progress',
        'input_tindakan_status',
        'tanggal_close',
        'close_by',
    ];

    public function Request()
    {
        return $this->belongsTo(RequestPerbaikanTeknik::class, 'request_perbaikan_id', 'id');
    }

    public function Tindakan()
    {
        return $this->hasOne(RequestPerbaikanTeknikDetail::class, 'request_perbaikan_detail_id', 'id');
    }

    // Accessor: Decode JSON ke array saat diakses
    public function getDokumentasiKerusakanAttribute($value)
    {
        return json_decode($value, true);
    }

    // Mutator: Encode array ke JSON saat disimpan
    public function setDokumentasiKerusakanAttribute($value)
    {
        $this->attributes['dokumentasi_kerusakan'] = json_encode($value);
    }
}
