<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table='inventory';

    protected $fillable=['inv_inborders', 'inv_pallet','inv_date', 'inv_lot','id_item', 'id_status'];

    protected $primaryKey = 'id_inv';

    public function statu()
    {
        return $this->belongsTo(Status::class, 'id_status' );
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item' );
    }
}
