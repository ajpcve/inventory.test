<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Det_Sale_Inventory extends Model
{
    protected $table='det_sale_inventory';

    protected $fillable=['id_item', 'dsaleinv_lot', 'dsaleinv_qty', 'id_csale_inventory', 'id_warehouse'];

    protected $primaryKey = 'id_dsale_inventory';

    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item' );
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'id_warehouse' );
    }
}
