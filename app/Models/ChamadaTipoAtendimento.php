<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChamadaTipoAtendimento extends Model
{

    protected $fillable = ['tipo_atendimento_id', 'chamada_id'];
    protected $perPage = 10;


    public function chamada()
    {
        return $this->belongsTo( Chamada::class);

    }

    public function tipoAtendimento()
    {
        return $this->belongsTo( TipoAtendimento::class);

    }


}
