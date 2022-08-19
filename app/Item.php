<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table='item';

    protected $fillable=['item_code', 'item_name', 'item_ruta', 'id_unit', 'id_status'];

    protected $primaryKey = 'id_item';

    public function statu()
    {
        return $this->belongsTo(Status::class, 'id_status' );
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'id_unit' );
    }
}
