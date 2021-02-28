<?php

namespace App\Http\Controllers;

use App\Models\Buoy;
use App\Models\Community;
use App\Models\Summery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class BuoyController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        if (!Redis::exists('buoys:all')){
            $buoys = Buoy::with('community')->get();
            Redis::set('buoys:all', serialize($buoys));
        }else{
            $buoys = unserialize(Redis::get('buoys:all'));
        }


        return view('layouts.buoys.index', compact('buoys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

        $communities = Community::all();
        return view('layouts.buoys.create', compact('communities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request){
        //

        // I have no idea what I am doing right now.!
        // just typing randomly and spending my time doing useless stuff
        // shit she is hot btw

        $validator = Validator::make($request->all(), [
            'imei' =>  'required|min:15',
            'serialNo'        =>  'required',
            'communityID'    =>     'required',
            'latitude'          =>  'required|numeric',
            'longitude'         =>  'required|numeric',
            'status'            =>  'required'
        ]);

        if ($validator->fails()) {
            return redirect('buoys/create')
                ->withErrors($validator)
                ->withInput();
        }

        $buoy = Buoy::create([
            'imei'          => $request->imei,
            'communityID'   => $request->communityID,
            'serialNo'      => $request->serialNo,
            'latitude'      => $request->latitude,
            'longitude'     => $request->longitude,
            'plan'          => $request->plan,
            'back_office'   => $request->back_office,
            'status'        => $request->status,
            'user_id'       => Auth::id()
        ]);

        // information updated.
        // todo: change the database

        return redirect('/buoys')->with('success', 'Buoys is successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Buoy  $buoy
     * @return \Illuminate\Http\Response
     */
    public function show(Buoy $buoy){
        // showing information from the user input and everything

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Buoy  $buoy
     * @return \Illuminate\Http\Response
     */
    public function edit(Buoy $buoy){
        $communities = Community::all();

        $buoy = Buoy::find($buoy->id);
        return view('layouts.buoys.edit', compact('communities', 'buoy'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Buoy  $buoy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Buoy $buoy){

        $buoy->update($request->all());

        return redirect()->route('buoys.index')->with('success','Buoys updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Buoy  $buoy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Buoy $buoy){
        $buoy->delete();
        return redirect()->route('buoys.index')->with('success','Buoy deleted successfully.');
    }




    public function summary($imei){
		$currentDate = date("m");

        $getMonths = [];
        foreach (range(1, 12) as $m) {
            $getMonths[] = date('F', mktime(0, 0, 0, $m, 1));
        };

        $summaries = Summery::where('imei', $imei)
            ->orderBy('rmcDate')
            ->groupBy('rmcDate')
            ->get(['rmcDate','ice_thickness']);

        $jsonData = [];
        foreach ($summaries as $summary){

            // check summary month
            if(substr($summary->rmcDate, 2, 2) == (int) $currentDate){
                $json_summaries = array(
                    "rmcDate" => $summary->rmcDate,
                    "ice_thickness" => (int) $summary->ice_thickness
                );
                array_push($jsonData, $json_summaries);
            }
        }



		$json = json_encode($jsonData);



        return view('layouts.buoys.summary', compact('imei', 'json', 'getMonths'));
    }


    public function updateSummary($imei, $month, $year){
        $uyear = substr($year, 2, 2);
        $search = "%" . (string) $month .(string) $uyear;


        $summaries = Summery::where('imei', $imei)
            ->where('rmcDate', 'like', $search)
            ->orderBy('rmcDate')
            ->get(['rmcDate','ice_thickness']);


        $jsonData = [];
        foreach ($summaries as $summary){
            $json_summaries = array(
                "rmcDate" => $summary->rmcDate,
                "ice_thickness" => (int) $summary->ice_thickness
            );
            array_push($jsonData, $json_summaries);
        }

        $json = json_encode($jsonData);
        return $json;
    }



}
