<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guiche extends Model
{

    protected $fillable = ['ip', 'localizacao', 'nome_ref', 'cor', 'om_id'];
    protected $appends = ['om'];
    protected $perPage = 10;

    public function getOmAttribute()
    {
        return

            Om::where('id', $this->om_id)->first();

    }


}
