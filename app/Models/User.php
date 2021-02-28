<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getFullNameAttribute(){
        return ucfirst($this->firstname) . ' ' . ucfirst($this->lastname);
    }

    public function generateToken(){
        $this->api_token = Str::random(60);
        $this->save();

        return $this->api_token;
    }



    public function buoys(){
        return $this->hasMany('App\Buoys');
    }


    public function profile(){
        return $this->hasOne('App\Profile');
    }


    public function roles(){
        return $this->belongsToMany(Role::class);
    }


    public function authorizeRoles($roles){

        if (is_array($roles)) {
            return $this->hasAnyRole($roles) ||
                abort(401, 'This action is unauthorized.');
        }
        return $this->hasRole($roles) ||
            abort(401, 'This action is unauthorized.');

    }


    /**
     * check multiple roles
     * @param $roles array
     * @return bool
     */
    public function hasAnyRole($roles){
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }


    /**
     * check one roles
     * @param $role
     * @return bool
     */
    public function hasRole($role){
        return null !== $this->roles()->where('name', $role)->first();
    }

}
