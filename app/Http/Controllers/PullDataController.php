<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PullDataController extends Controller{
    //
    public function index(){
        // Check active buoys
        $buoys = DB::table('buoys')->get();



        return view('layouts.pulldata', compact('buoys'));
    }
}
