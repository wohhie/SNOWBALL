<?php

namespace App\Http\Controllers;

use App\Jobs\BuoyCreateJob;
use App\Qumatik;
use App\QumatikData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Dropbox\Client;

class QumatikDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        // AUTHENTICATE WITH DROPBOX
//        $this->dispatch(new BuoyCreateJob());



        $client = new Client(["fu65xsevq0k1zkj", "h4ys4vbczp1hpjd"]);
        $client = new Client('bShfayt_zd4AAAAAAAAAAURN6GZduPItQV_UkmoeFUwzTesqkp8-7xcNt-xbNkCM');



        // GET THE LIST OF QUMATIKS INFORMATION
        $qumatiks = Qumatik::all();

        // LOOP THROUGH ALL THE QUMATIKS AND FETCH DATA FROM THAT FOLDER
        // FIND THE LIST OF FOLDERS
        $folders = $client->listFolder($qumatiks[0]->dropbox_dir);
        dd($folders);
        foreach ($folders['entries'] as $index => $folder){
                // fetch all the files in that folder
                $files = $client->listFolder($folder['path_display']);

        }
        return "Done";
    }




    /**
     * @param array $settings
     * @param array $datas
     */
    private function gettingData(array $settings, array $datas) {

        $ice_thickness = 0;
        $count = 0;
        foreach ($datas as $index => $data){
            $data = explode(";", $data);

            $ice_thickness += isset($data[4]) ? (float) $data[4] : 0;
            $count++;


            $settings['datas'][] = array(
                'timestamps'            =>  isset($data[0]) ? $data[0] : '',
                'raw_conductivity'      =>  isset($data[1]) ? $data[1] : '',
                'raw_in_phase'          =>  isset($data[2]) ? $data[2] : '',
                'em31_byte'             =>  isset($data[3]) ? $data[3] : '',
                'ice_thickness'         =>  isset($data[4]) ? $data[4] : 0,
                'latitude'              =>  isset($data[5]) ? $data[5] : '',
                'longitude'             =>  isset($data[6]) ? $data[6] : '',
                'fix_quality'           =>  isset($data[7]) ? $data[7] : '',
                'number_of_satellites'  =>  isset($data[8]) ? $data[8] : '',
                'msl_height'            =>  isset($data[9]) ? $data[9] : '',
                'geoidal_separation'    =>  isset($data[10]) ? $data[10] : '',
                'age_of_differential'   =>  isset($data[11]) ? $data[11] : '',
                'reference_station_id'  =>  isset($data[12]) ? $data[12] : ''
            );

        }

        $settings['avg_ice_thickness'] = $ice_thickness / $count;
        $settings['start_time'] = min(array_column($settings['datas'], 'timestamps'));
        $settings['end_time'] = max(array_column($settings['datas'], 'timestamps'));
        $settings['min_ice_thickness'] = (float) min(array_column($settings['datas'], 'ice_thickness'));
        $settings['max_ice_thickness'] = (float) max(array_column($settings['datas'], 'ice_thickness'));

        return json_encode($settings);
    }

    /**
     * Fetching and converted to JSON from contents
     * @param $contents (string)
     * @return array
     */
    private function getingRH0data(string $filename, string $filepath, $contents){
        $contents = explode(";", str_replace('# settings: ', '', $contents));

        $settings = array();
        $settings['filename'] = $filename;
        $settings['filepath'] = $filepath;
        foreach ($contents as $content){
            $rho = explode('=', $content);
            $settings[$rho[0]] = isset($rho[1]) ? (float) $rho[1] : 0.0;
        }
        return $settings;
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\QumatikData  $qumatikData
     * @return \Illuminate\Http\Response
     */
    public function show(QumatikData $qumatikData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\QumatikData  $qumatikData
     * @return \Illuminate\Http\Response
     */
    public function edit(QumatikData $qumatikData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\QumatikData  $qumatikData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QumatikData $qumatikData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\QumatikData  $qumatikData
     * @return \Illuminate\Http\Response
     */
    public function destroy(QumatikData $qumatikData)
    {
        //
    }

}
