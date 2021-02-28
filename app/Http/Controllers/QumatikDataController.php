<?php

namespace App\Http\Controllers;

use App\Models\Cursor;
use App\Jobs\BuoyCreateJob;
use App\Models\Qumatik;
use App\Models\QumatikData;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Request;
use Spatie\Dropbox\Client;

class QumatikDataController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index($imei){
        // AUTHENTICATE WITH DROPBOX
//         $this->dispatch(new BuoyCreateJob($imei));


        $client = new Client(["fu65xsevq0k1zkj", "h4ys4vbczp1hpjd"]);
        $client = new Client('bShfayt_zd4AAAAAAAAAAURN6GZduPItQV_UkmoeFUwzTesqkp8-7xcNt-xbNkCM');

        // GET the exact qumatik information
        $qumatik = Qumatik::where("imei", $imei)->firstOrFail();


        // FIND THE LIST OF FOLDERS
        if (!Cursor::where('qumatik_id', $qumatik->id)->exists()){
            $folders = $client->listFolder($qumatik->dropbox_dir);
            dd(Cursor::create([
                "entries"       =>  count($folders["entries"]),
                "cursor"        =>  $folders["cursor"],
                "qumatik_id"    =>  $qumatik->id,
            ]));
//            Cursor::create();


        }else{
            $cursor = Cursor::where('qumatik_id', $qumatik->id)->firstOrFail();
            $folders = $client->listFolderContinue($cursor->cursor);

            dd($folders);

        }



        dd("Done");



        dd("Done");

        foreach ($folders['entries'] as $index => $folder){
            // fetch all the files in that folder
            $files = $client->listFolder($folder['path_display']);

            $file_index = array_column($files['entries'], 'name');
            $index = key(preg_grep( '([Log])', array_values($file_index)));


            $log_file_path = $files['entries'][$index]['path_display'];
            $download = $client->contentEndpointRequest('files/download', ['path' => $log_file_path]);


            // fetch the content
            $content = $download->getBody()->getContents();

            // start_time, end_time, average ice thickness
            $content = explode("\r\n", $content);
            array_pop($content);


            /*
            Fetching the settings data from contents
            ===========================================================
            Params: contents first line. (string)
            */
            $settings = $this->getingRH0data(
                $files['entries'][$index]['name'],
                $files['entries'][$index]['path_display'],
                $content[1]);

            // unsetting/deleting 0 - 2 rows
            unset($content[0], $content[1], $content[2]);
            $content = (array) array_values($content);
            $datas = $this->gettingData($settings, $content);

            // Decode the Data json
            $data = json_decode($datas);

            QumatikData::insert([
                "filename"              =>  $data->filename,
                "filepath"              =>  $data->filepath,
                "rho0"                  =>  $data->rho0,
                "rho1"                  =>  $data->rho1,
                "rho2"                  =>  $data->rho2,
                "em31Height"            =>  $data->em31Height,
                "avg_ice_thickness"     =>  $data->avg_ice_thickness,
                "min_ice_thickness"     =>  $data->min_ice_thickness,
                "max_ice_thickness"     =>  $data->max_ice_thickness,
                "datas"                 =>  NULL,
                "start_time"            =>  $data->start_time,
                "end_time"              =>  $data->end_time,
                "filesize"              =>  $files["entries"][$index]["size"],
                'qumatik_id'            =>  (int) $qumatik->id,
                'created_at'            =>  now()->toDateTimeString(),
                'updated_at'            =>  now()->toDateTimeString(),
            ]);
        }

        return "Completed";
    }




    public function show($qumatikId){
        // Fetch the qumatik dropbox dir information
        $qumatikDatas = QumatikData::where('qumatik_id', $qumatikId)->get();
        return view('layouts.qumatiks.qumatikdata', compact('qumatikDatas'));
    }




    public function location(Request $request){
        $filepath = Request::get('filepath');


        // Connecting to dropbox
        $client = new Client('bShfayt_zd4AAAAAAAAAAURN6GZduPItQV_UkmoeFUwzTesqkp8-7xcNt-xbNkCM');
        $download = $client->contentEndpointRequest('files/download', ['path' => $filepath]);

        // fetch the content
        $content = $download->getBody()->getContents();
        $content = explode("\r\n", $content);
        array_pop($content);


        // unsetting/deleting 0 - 2 rows
        unset($content[0], $content[1], $content[2]);
        $content = (array) array_values($content);
        $datas = $this->gettingLocationData($content);
        return response()->json($datas);



//        $coordinates = array();
//        foreach($datas as $index => $data) {
//            array_push($coordinates,$data->latitude . ',' .$data->longitude  );
//        }
//
//        return $coordinates;
//
//
//        $config['center'] = $coordinates[0];
//        $config['zoom'] = 'auto';
//        $config['map_height'] = '1000px';
//        $config['scrollwheel'] = false;
//
//        $gmap = new GMaps();
//        $gmap->initialize($config);
//
//        $marker['position'] = $coordinates[0];
//        $marker['infowindow_content'] = 'Starting Point';
//        $marker['icon'] = 'http://maps.google.com/mapfiles/kml/paddle/red-circle.png';
//        $gmap->add_marker($marker);
//
//        $marker['position'] =  $coordinates[1];
//        $marker['infowindow_content'] = 'Ending Point';
//        $marker['icon']='http://maps.google.com/mapfiles/kml/paddle/grn-circle.png';
//        $gmap->add_marker($marker);
//
//
//        $polyline = array();
//        $polyline['points'] = $coordinates;
//        $gmap->add_polyline($polyline);
//
//        $map = $gmap->create_map();
//
//        return $map;
    }


    public function download(QumatikData $id){
        $file_path = $id->filepath;
        $client = new Client('bShfayt_zd4AAAAAAAAAAURN6GZduPItQV_UkmoeFUwzTesqkp8-7xcNt-xbNkCM');
        $download = $client->contentEndpointRequest('files/download', ['path' => $file_path]);

        // fetch the content
        $content = $download->getBody()->getContents();

        // start_time, end_time, average ice thickness
        $content = explode("\r\n", $content);
        array_pop($content);

        /*
        Fetching the settings data from contents
        ===========================================================
        Params: contents first line. (string)
        */
        $settings = $this->getingRH0data(
            $id->filename,
            $id->filepath,
            $content[1]);

        // unsetting/deleting 0 - 2 rows
        unset($content[0], $content[1], $content[2]);
        $content = (array) array_values($content);
        $datas = $this->gettingData($settings, $content);

        // Decode the Data json
        $data = json_decode($datas);
        // INSETING INTO THE DATABASE


        QumatikData::where('filename', $id->filename)
            ->where('filepath', $id->filepath)
            ->update([
                "filename"              =>  $data->filename,
                "filepath"              =>  $data->filepath,
                "rho0"                  =>  $data->rho0,
                "rho1"                  =>  $data->rho1,
                "rho2"                  =>  $data->rho2,
                "em31Height"            =>  $data->em31Height,
                "avg_ice_thickness"     =>  $data->avg_ice_thickness,
                "min_ice_thickness"     =>  $data->min_ice_thickness,
                "max_ice_thickness"     =>  $data->max_ice_thickness,
                "datas"                 =>  json_encode($data->datas),
                "start_time"            =>  $data->start_time,
                "end_time"              =>  $data->end_time,
                "filesize"              =>  $id->filesize,
                "qumatik_id"            =>  $id->qumatik_id,
                "updated_at"            =>  now()->toDateTimeString(),
            ]);

        return redirect()->back();




    }


    public function downloadBackground(){
        $sdatas = QumatikData::select('filename', 'filepath', 'rho0', 'rho1', 'rho2', 'em31Height', 'qumatik_id')->get();
        $counter = 1;
        foreach ($sdatas as $sdata){
            if (empty($sdata->rho0) &&
                empty($sdata->rho1) &&
                empty($sdata->rho2) &&
                empty($sdata->em31Height)){

                $counter++;
                $client = new Client('bShfayt_zd4AAAAAAAAAAURN6GZduPItQV_UkmoeFUwzTesqkp8-7xcNt-xbNkCM');
                $download = $client->contentEndpointRequest('files/download', ['path' => $sdata->filepath]);

                // fetch the content
                $content = $download->getBody()->getContents();

                // start_time, end_time, average ice thickness
                $content = explode("\r\n", $content);
                array_pop($content);

                /*
                Fetching the settings data from contents
                ===========================================================
                Params: contents first line. (string)
                */
                $settings = $this->getingRH0data(
                    $sdata->filename,
                    $sdata->filepath,
                    $content[1]);

                // unsetting/deleting 0 - 2 rows
                unset($content[0], $content[1], $content[2]);
                $content = (array) array_values($content);
                $datas = $this->gettingData($settings, $content);

                // Decode the Data json
                $data = json_decode($datas);
                // INSETING INTO THE DATABASE

                QumatikData::where('filename', $sdata->filename)
                    ->where('filepath', $sdata->filepath)
                    ->update([
                        "filename"              =>  $data->filename,
                        "filepath"              =>  $data->filepath,
                        "rho0"                  =>  $data->rho0,
                        "rho1"                  =>  $data->rho1,
                        "rho2"                  =>  $data->rho2,
                        "em31Height"            =>  $data->em31Height,
                        "avg_ice_thickness"     =>  $data->avg_ice_thickness,
                        "min_ice_thickness"     =>  $data->min_ice_thickness,
                        "max_ice_thickness"     =>  $data->max_ice_thickness,
                        "datas"                 =>  json_encode($data->datas),
                        "start_time"            =>  $data->start_time,
                        "end_time"              =>  $data->end_time,
                        "filesize"              =>  $sdata->filesize,
                        "qumatik_id"            =>  $sdata->qumatik_id,
                        "updated_at"            =>  now()->toDateTimeString(),
                    ]);

                dd("Inserted successfully" . $sdata->filename);

            }

        }




        dd("complete");
    }


    private function gettingLocationData(array $datas){
        foreach ($datas as $index => $data){
            $data = explode(";", $data);


            $settings[] = array(
                'lat'             =>  isset($data[5]) ? (double) $data[5] : 0,
                'lng'             =>  isset($data[6]) ? (double) $data[6] : 0,


            );
        }
        return json_encode($settings);
    }



    /**
     * @param array $settings
     * @param array $datas
     */
    private function gettingData(array $settings, array $datas) {

        $ice_thickness = 0;
        $count = 0;
        ini_set('memory_limit', '-1');
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
            );

        }

        $settings['articbay'][] = array(

        );


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

}
