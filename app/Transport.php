<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    protected $table='transport';

    protected $fillable=['trans_company', 'trans_phone', 'trans_address', 'trans_email', 'trans_contact', 'id_status'];

    protected $primaryKey = 'id_transport';

    public function statu()
    {
        return $this->belongsTo(Status::class, 'id_status' );
    }
}
