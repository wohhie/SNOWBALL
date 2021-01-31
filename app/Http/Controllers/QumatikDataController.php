<?php

namespace App\Http\Controllers;

use App\Jobs\BuoyCreateJob;
use App\Qumatik;
use App\QumatikData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Dropbox\Client;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;

class QumatikDataController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($imei){
        // AUTHENTICATE WITH DROPBOX
         $this->dispatch(new BuoyCreateJob());
        return "Completed";
    }




    public function show($id){
        // Fetch the qumatik dropbox dir information
        $qumatik = Qumatik::where('imei', $id)->first();




    }

}
