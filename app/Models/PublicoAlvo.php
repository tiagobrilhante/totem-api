<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicoAlvo extends Model
{

    protected $fillable = ['tipo', 'om_id','cor'];
    protected $appends = ['om'];
    protected $perPage = 10;

    public function getOmAttribute()
    {
        return

            Om::where('id', $this->om_id)->first();

    }


}
