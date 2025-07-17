<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestPerbaikanTeknikTindakan extends Model
{
    use HasFactory;

    protected $connection = 'engineering';

    protected $table = 'request_perbaikan_teknik_tindakan';

    protected $fillable = [
        'request_perbaikan_detail_id',
        'tindakan_sementara',
        'tanggal_waktu_sementara',
        'id_teknisi_sementara',
        'dokumentasi_perbaikan_sementara',
        'tindakan_lanjutan',
        'tanggal_waktu_lanjutan',
        'id_teknisi_lanjutan',
        'dokumentasi_perbaikan_lanjutan',
    ];

    public function Detail()
    {
        return $this->belongsTo(RequestPerbaikanTeknikDetail::class, 'request_perbaikan_detail', 'id');
    }

    public function Sparepart()
    {
        return $this->hasMany(RequestPerbaikanTeknikSparepart::class, 'request_perbaikan_tindakan_id', 'id');
    }

    // Accessor: Decode JSON ke array saat diakses
    public function getDokumentasiPerbaikanSementaraAttribute($value)
    {
        return json_decode($value, true);
    }

    // Mutator: Encode array ke JSON saat disimpan
    public function setDokumentasiPerbaikanSementaraAttribute($value)
    {
        $this->attributes['dokumentasi_perbaikan_sementara'] = json_encode($value);
    }

    // Accessor: Decode JSON ke array saat diakses
    public function getDokumentasiPerbaikanLanjutanAttribute($value)
    {
        return json_decode($value, true);
    }

    // Mutator: Encode array ke JSON saat disimpan
    public function setDokumentasiPerbaikanLanjutanAttribute($value)
    {
        $this->attributes['dokumentasi_perbaikan_lanjutan'] = json_encode($value);
    }
}
