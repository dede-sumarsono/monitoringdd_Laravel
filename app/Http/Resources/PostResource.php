<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);

        return [
            'id' => $this->id,
            "id_pembuat" => $this -> id_pembuat,
            "id_untuk_user" => $this-> id_untuk_user,
            "username_untuk_user" => $this-> username_untuk_user,
            "jenis_layanan" => $this-> jenis_layanan,
            "jenis_pesanan" => $this-> jenis_pesanan,
            "keterangan" => $this-> keterangan,
            "status" => $this-> status,
            "dokumen" => $this-> dokumen,
            "created_at" => date_format($this -> created_at,"Y/m/d H:i:s"),
            "updated_at" => $this-> updated_at,
            
        ];
    }
}
