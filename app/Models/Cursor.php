<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cursor extends Model{
    //
    protected $table = "cursors";
    protected $fillable = ['entries', 'cursor', 'qumatik_id'];
    public $timestamps = true;
}
