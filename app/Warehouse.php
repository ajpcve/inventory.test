<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table='warehouse';

    protected $fillable=['house_name','house_address', 'house_phone','house_phone_two', 'house_person', 'house_description', 'house_email', 'house_email_two', 'house_email_three', 'id_status', 'house_activity', 'house_step'];

    protected $primaryKey = 'id_warehouse';

    public function statu()
    {
        return $this->belongsTo(Status::class, 'id_status' );
    }
}
