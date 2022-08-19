<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table='customer';

    protected $fillable=['cust_company', 'cust_phone', 'cust_address' , 'cust_email', 'cust_sucursal', 'cust_num_sucursal', 'cust_tax', 'cust_contact', 'id_status'];

    protected $primaryKey = 'id_customer';

    public function statu()
    {
        return $this->belongsTo(Status::class, 'id_status' );
    }
}
