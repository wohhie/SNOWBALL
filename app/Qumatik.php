<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qumatik extends Model{

    protected $table = "qumatiks";
    protected $fillable = ["imei", "latitude", "longitude", "status", "dropbox_dir", "community_id", "user_id"];

    public function community(){
        return $this->belongsTo('App\Community', 'community_id');
    }

}
