<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table='unit';

    protected $fillable=['unit', 'id_status'];

    protected $primaryKey = 'id_unit';

    public function statu()
    {
        return $this->belongsTo(Status::class, 'id_status' );
    }
}
