<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Om extends Model
{

    protected $fillable =['nome','sigla','cor'];
    protected $perPage = 10;
    protected $appends = ['panel'];


    public function users()
    {
        return $this->hasMany( User::class);

    }

    public function getPanelAttribute()
    {
        return

            Panel::where('om_id', $this->id)->get();

    }


}
