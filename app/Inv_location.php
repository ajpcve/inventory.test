<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inv_location extends Model
{
    protected $table='inventory_location';

    protected $fillable=['inv_location_qty', 'id_warehouse', 'id_inv'];

    protected $primaryKey = 'id_inventory_location';

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'id_warehouse' );
    }
}