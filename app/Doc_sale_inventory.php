<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doc_sale_inventory extends Model
{
    protected $table='doc_sale_inventory';

    protected $fillable=['docsinven_ruta', 'id_doc','id_csale_inventory'];

    protected $primaryKey = 'id_docsinven';

    public function cab_sale_inventory()
    {
        return $this->belongsTo(Cab_Sale_Inventory::class, 'id_csale_inventory' );
    }

    public function document()
    {
        return $this->belongsTo(Document::class, 'id_doc' );
    }
}
