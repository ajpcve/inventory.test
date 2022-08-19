<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cab_inbound_order extends Model
{
    protected $table='cab_inbound_orders';

    protected $fillable=['ciord_date', 'ciord_export_date', 'ciord_guia_aerea', 'ciord_orden_compra', 'id_status', 'id_warehouse'];

    protected $primaryKey = 'id_ciord';

    public function statu()
    {
        return $this->belongsTo(Status::class, 'id_status' );
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'id_warehouse' );
    }
}
