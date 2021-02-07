<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Summery extends Model{
    //

    protected $table = 'summeries';

    protected $fillable = [
        'imei', 'operationID', 'filename', 'rmcDate', 'rmcTime', 'dataUsed', 'latitude', 'longitude', 'depth_of_snow', 'ice_thickness','top_ice', 'top_snow', 'bottom_ice', 'status', 'user_id'
    ];
}



