<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts3 extends Model
{
    use HasFactory;

    protected $fillable =[
        'id_pembuat','id_untuk_user','username_untuk_user','jenis_layanan','jenis_pesanan','keterangan','status','dokumen'
    ];
}
