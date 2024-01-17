<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bkup extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'filename',
        'rotulo',
        'tipo',
        'mime',
        'path'
    ];

}
