<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'outlet_id',
        'member_id',
        'user_id',
        'created_at',
        'kode_invoice',
        'tgl',
        'batas_waktu',
        'tgl_bayar',
        'tgl_diambil',
        'tgl_diantar',
        'tgl_selesai',
        'biaya_tambahan',
        'diskon',
        'pajak',
        'sub_total',
        'qty_total',
        'total_bayar',
        'cash',
        'kembalian',
        'status',
        'dibayar',
    ];
}
