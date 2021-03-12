<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panel extends Model
{

    protected $fillable = ['ip', 'localizacao', 'cor', 'om_id'];
    protected $appends = ['om'];
    protected $perPage = 10;

    public function getOmAttribute()
    {
        return

            Om::where('id', $this->om_id)->first();

    }


}
