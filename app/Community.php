<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Community extends Model{
    //

    protected $table = 'communities';
    protected $fillable = [
        'name', 'latitude', 'longitude'
    ];

    public function buoys(){

        return $this->hasMany('App\Buoy');
    }

}
