<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doc_inbound_order extends Model
{
    protected $table='doc_inbound_orders';

    protected $fillable=['dociord_ruta', 'id_doc','id_ciord'];

    protected $primaryKey = 'id_dociord';

    public function cab_inbound_orde()
    {
        return $this->belongsTo(Cab_inbound_order::class, 'id_ciord' );
    }

    public function document()
    {
        return $this->belongsTo(Document::class, 'id_doc' );
    }
}
