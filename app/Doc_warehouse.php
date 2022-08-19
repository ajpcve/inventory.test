<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doc_warehouse extends Model
{
    protected $table='doc_warehouse';

    protected $fillable=['docware_ruta', 'docware_pallet','docware_lot', 'docware_inborders', 'id_doc'];

    protected $primaryKey = 'id_docwarehouse';

    public function document()
    {
        return $this->belongsTo(Document::class, 'id_doc' );
    }
}
