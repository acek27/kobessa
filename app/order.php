<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $table = 'pesanansaprodi';
    protected $primaryKey = 'idpesanan';
    public $timestamps = false;
    protected $fillable = ['PO', 'nik', 'idsuplier', 'idsaprodi', 'jumlah', 'tglpesan', 'tglkirim', 'status', 'jumlah kirim', 'DO'];
}
