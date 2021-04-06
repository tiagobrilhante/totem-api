<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{

    protected $fillable = ['mensagem','responsavel', 'om_id'];
    protected $appends = ['om'];
    protected $perPage = 10;

    public function getOmAttribute()
    {
        return

            Om::where('id', $this->om_id)->first();

    }


}
