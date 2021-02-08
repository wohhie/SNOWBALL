<?php

namespace App\Http\Controllers;

use App\Jobs\BuoyCreateJob;
use App\QumatikData;
use FarhanWazir\GoogleMaps\GMaps;

class QumatikDataController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index($imei){
        // AUTHENTICATE WITH DROPBOX
         $this->dispatch(new BuoyCreateJob($imei));
        return "Completed";
    }




    public function show($qumatikId){
        // Fetch the qumatik dropbox dir information
        $qumatikDatas = QumatikData::where('qumatik_id', $qumatikId)->get();
        return view('layouts.qumatiks.qumatikdata', compact('qumatikDatas'));
    }






    public function location(QumatikData $id){
        $qumatikDatas = json_decode($id->datas);

        $coordinates = array();
        foreach($qumatikDatas as $index => $data) {
            array_push($coordinates,$data->latitude . ',' .$data->longitude  );
        }


        $config['center'] = $coordinates[0];
        $config['zoom'] = 'auto';
        $config['map_height'] = '1000px';
        $config['scrollwheel'] = false;

        $gmap = new GMaps();
        $gmap->initialize($config);

        $marker['position'] = $coordinates[0];
        $marker['infowindow_content'] = 'Starting Point';
        $marker['icon'] = 'http://maps.google.com/mapfiles/kml/paddle/red-circle.png';
        $gmap->add_marker($marker);

        $marker['position'] =  $coordinates[1];
        $marker['infowindow_content'] = 'Ending Point';
        $marker['icon']='http://maps.google.com/mapfiles/kml/paddle/grn-circle.png';
        $gmap->add_marker($marker);


        $polyline = array();
        $polyline['points'] = $coordinates;
        $gmap->add_polyline($polyline);



        $map = $gmap->create_map();

        return view('layouts.qumatiks.map', compact('map'));
    }

}
