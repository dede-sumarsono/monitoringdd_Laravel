<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Posts3 extends Model
{
    use HasFactory;

    protected $fillable =[
        'id_pembuat','id_untuk_user','username_untuk_user','jenis_layanan','jenis_pesanan','keterangan','status','dokumen'
    ];


    /**
     * Get the writer that owns the Posts3
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function writer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pembuat', 'id');
    }
}
