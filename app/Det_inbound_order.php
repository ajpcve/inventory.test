<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Det_inbound_order extends Model
{
    protected $table='det_inbound_orders';

    protected $fillable=['diord_pallet','diord_item_code', 'diord_lot','diord_qty','id_ciord','diord_expiration_date'];

    protected $primaryKey = 'id_diord';

    public function cab_inbound_orde()
    {
        return $this->belongsTo(Cab_inbound_order::class, 'id_ciord' );
    }

    public function items()
    {
        return $this->belongsTo(Item::class, 'diord_item_code' );
    }
}
