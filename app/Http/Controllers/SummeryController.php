<?php

namespace App\Http\Controllers;

use App\Data;
use App\Summary;
use App\Summery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SummeryController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        //
        return view('backend.pages.data');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        // generate the operationID
		
         

        Summery::create([
            'imei'          =>  $request->imei,
            'operationID'   =>  $request->operationID,
            'filename'      =>  $request->filename,
            'rmcDate'       =>  $request->rmcDate,
            'rmcTime'       =>  $request->rmcTime,
            'dataUsed'      =>  $request->dataUsed,
            'latitude'      =>  $request->latitude,
            'longitude'     =>  $request->longitude,
            'depth_of_snow' =>  $request->depth_of_snow,
            'ice_thickness' =>  $request->ice_thickness,
            'top_ice'       =>  $request->top_ice,
            'top_snow'      =>  $request->top_snow,
            'bottom_ice'    =>  $request->bottom_ice,
            'status '       =>  0,
            'user_id'       =>  $request->user_id,
        ]);


        // and update the status of both temperature and conductivity
        $data = Data::where('buoy_id', $request->imei)
            ->where('rmcDate', $request->rmcDate)
            ->where('rmcTime', $request->rmcTime)
            ->update([
                'status'    => 1
            ]);


        // Update Session Information with pendings and pendingCounts
        $pendings = Summery::where('status', '0')->get();
        $pendingCount = Summery::where('status', 0)->count();
        session()->put('pendings', $pendings);
        session()->put('pendingCount', $pendingCount);



        return redirect()->back();


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Summery  $summery
     * @return \Illuminate\Http\Response
     */
    public function show(Summery $summery){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Summery  $summery
     * @return \Illuminate\Http\Response
     */
    public function edit(Summery $summery){

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Summery  $summery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $operationID){

        $summary = Summery::where('operationID', $operationID)->first();
        Summery::where('operationID', $operationID)->update([
            'imei'          =>  $request->imei,
            'filename'      =>  $request->filename,
            'rmcDate'       =>  $request->rmcDate,
            'rmcTime'       =>  $request->rmcTime,
            'dataUsed'      =>  $request->dataUsed,
            'latitude'      =>  $request->latitude,
            'longitude'     =>  $request->longitude,
            'depth_of_snow' =>  $request->depth_of_snow,
            'ice_thickness' =>  $request->ice_thickness,
            'top_ice'       =>  $request->top_ice,
            'top_snow'      =>  $request->top_snow,
            'bottom_ice'    =>  $request->bottom_ice,
            'status'       =>  1,
            'user_id'       =>  $request->user_id,
        ]);


        $pendings = Summery::where('status', 0)->get();
        $pendingCount = Summery::where('status', 0)->count();
        session()->put('pendings', $pendings);
        session()->put('pendingCount', $pendingCount);


        return redirect('email/'. $request->imei);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Summery  $summery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Summery $summery){

    }


    public function updateApproval($imei, $operationID){

        $summary = Summery::where('operationID', $operationID)
            ->update([
                'status'          => 1,
            ]);

		if($summary) {
			Data::where('uniqueID', $operationID)
            ->update([
                'status'          => 4,
            ]);
		}

        // 4 is for approval
        


        // Update Session Information with pendings and pendingCounts
        $pendings = Summery::where('status', '0')->get();
        $pendingCount = Summery::where('status', 0)->count();
        session()->put('pendings', $pendings);
        session()->put('pendingCount', $pendingCount);

		flashy()->success($operationID . ' Approved and Forwarded to SIKU');
        return redirect('email/'. $imei);

    }





    public function summaryDate($date){
        $date = str_replace('-', '', $date);
        $rmcDate = substr($date, 6, 2) . substr($date, 4, 2) . substr($date, 2, 2);
        $results = Summery::select(
            'imei',
            'operationID',
            'rmcDate',
            'rmcTime',
            'latitude',
            'longitude',
            'depth_of_snow',
            'ice_thickness',
            'updated_at'
        )->where('status', 1)
            ->where('rmcDate', $rmcDate)
            ->get();

        return response()->json($results);
    }




    public function summaryIMEI($imei){
        $results = Summery::select(
            'imei',
            'operationID',
            'rmcDate',
            'rmcTime',
            'latitude',
            'longitude',
            'depth_of_snow',
            'ice_thickness',
            'updated_at'
        )->where('imei', $imei)->where('status', 1)->get();

        return response()->json($results);
    }

}
