<?php

namespace App\Models;

use App\Events\BuoyCreated;
use App\Events\BuoyDeleted;
use App\Events\BuoyUpdated;
use Illuminate\Database\Eloquent\Model;

class Buoy extends Model{
    //
    protected $table = 'buoys';
    protected $fillable = ['imei', 'communityID', 'serialNo', 'latitude', 'longitude', 'plan', 'back_office', 'status', 'user_id'];

    protected $dispatchesEvents = [
        'created' =>    BuoyCreated::class,
        'updated' =>    BuoyUpdated::class,
        'deleted' =>    BuoyDeleted::class,
    ];


    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function community(){
        return $this->belongsTo('App\Models\Community', 'communityID', 'id');
    }


}
