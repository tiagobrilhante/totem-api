<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panel extends Model
{

    protected $fillable = ['ip', 'localizacao', 'cor', 'om_id'];
    protected $perPage = 10;


    public function guiche()
    {
        return $this->hasMany(Guiche::class);
    }
    public function om()
    {
        return $this->belongsTo(Om::class);
    }




}
