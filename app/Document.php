<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table='documents';

    protected $fillable=['doc_description', 'doc_tabla', 'id_status'];

    protected $primaryKey = 'id_doc';

    public function statu()
    {
        return $this->belongsTo(Status::class, 'id_status' );
    }
}
