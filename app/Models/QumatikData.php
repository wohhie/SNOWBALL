<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QumatikData extends Model{
    //
    protected $table = 'qumatik_data';

    protected $fillable = [
        'filename',
        'filepath',
        'rho0',
        'rho1',
        'rho2',
        'em31Height',
        'avg_ice_thickness',
        'min_ice_thickness',
        'max_ice_thickness',
        'datas',
        'start_time',
        'end_time',
        'filesize',
        'qumatik_id'
    ];
}
