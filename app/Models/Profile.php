<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model{
    // table information
    protected $table = 'profiles';


    // gurard information
    protected $guarded = [
        'id',
    ];


    // fillable information
    protected $fillable = [
        'user_id',
        'position',
        'other_email',
        'address',
        'city',
        'state',
        'zipcode',
        'personal_phone',
        'office_phone',
        'avatar',
        'avatar_status',
    ];


    public function getLocationAttribute(){
        $address = ucfirst($this->address) .",\n ". ucfirst($this->city) . ', ' . ucfirst($this->state);
        return $address;

    }



    public function user(){
        return $this->belongsTo('App\Models\User');
    }


}
