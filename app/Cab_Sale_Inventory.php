<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cab_Sale_Inventory extends Model
{
    protected $table='cab_sale_inventory';

    protected $fillable=['csaleinv_date', 'csaleinv_invoice', 'csaleinv_or_num','id_customer', 'csaleinv_tran_cust', 'csaleinv_transport', 'csaleinv_driver_name', 'csaleinv_driver_phone', 'csaleinv_date_pick_up', 'csaleinv_date_time','csaleinv_date_delivery', 'csaleinv_appointment_selet', 'csaleinv_appointment', 'id_delivery', 'csaleinv_deli_name', 'csaleinv_deli_phone', 'csaleinv_deli_email', 'csaleinv_deli_address', 'csaleinv_chep_pallet', 'csaleinv_shrink_wrap', 'csaleinv_palletization', 'id_users'];

    protected $primaryKey = 'id_csale_inventory';

    public function cust()
    {
        return $this->belongsTo(Customer::class, 'id_customer' );
    }

    public function trans()
    {
        return $this->belongsTo(Transport::class, 'csaleinv_transport' );
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_users' );
    }
    public function sucursal()
    {
        return $this->belongsTo(Customer::class, 'id_delivery' );
    }
}
