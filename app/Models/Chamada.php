<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chamada extends Model
{

    protected $fillable = [
        'panel_id',
        'tipo',
        'tipo_atendimento',
        'publico_alvo',
        'publico_alvo_id',
        'guiche_id',
        'numero_ref',
        'nome_ref',
        'chamador',
        'cor',
        'rechamada',
        'status'
    ];
    protected $appends = ['panel', 'guiche'];
    protected $perPage = 10;

    public function getPanelAttribute()
    {
        return

            Panel::where('id', $this->panel_id)->first();

    }

    public function getGuicheAttribute()
    {
        return

            Guiche::where('id', $this->guiche_id)->first();

    }

    public function chamadaTipoAtendimento()
    {
        return $this->hasMany( ChamadaTipoAtendimento::class);

    }


}
