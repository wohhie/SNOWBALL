<?php

namespace App\Http\Controllers;

use App\Data;
use App\Summery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Sodium\add;

class DataController extends Controller{


    public static function approvedBy($operationID){

    }


    public static function checkStatus($operationID){

        // check the database if the value is existed or not
        $operationIDExists = Summery::where('operationID', $operationID)->exists();
        if ($operationIDExists){
            // summary exists
            $status = Summery::where('operationID', $operationID)->first()->status;
        }else{
            $status = -1;
        }
        return $status;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        //
        $results = Data::all();
        return view('layouts.emails.blank2');
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
    public function store(Request $request){

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function show($buoyID){
		
		// Pending for Approvals
        $pendingsForApproval = DB::table('data')
                    ->where('buoy_id', $buoyID)
                    ->where('status', 1)
                    ->where('numBoardFound', '>', 3)
                    ->groupBy('uniqueID')
                    ->havingRaw("count('uniqueID') > 1")
                    ->orderBy('rmcDate', 'DESC')
                    ->get();


        $unProcessed = DB::table('data')
                    ->where('buoy_id', $buoyID)
                    ->where('status', 0)
                    ->where('numBoardFound', '>', 3)
                    ->groupBy('uniqueID')
                    ->havingRaw("count('uniqueID') > 1")
                    ->orderBy('rmcDate', 'DESC')
                    ->get();


		$dataInfos = $pendingsForApproval->merge($unProcessed);
		$dataInfos = $dataInfos->all();

        // 5 is for the flagged information
        $flagged = DB::table('data')
                    ->where('buoy_id', $buoyID)
                    ->where('status',5)
                    ->where('numBoardFound', '>', 3)
                    ->groupBy('uniqueID')
                    ->havingRaw("count('uniqueID') > 1")
                    ->orderBy('rmcDate', 'DESC')
                    ->get();


        // 4 is for the approved information
        $approved = DB::table('data')
                    ->where('buoy_id', $buoyID)
                    ->where('status', 4)
                    ->where('numBoardFound', '>', 3)
                    ->groupBy('uniqueID')
                    ->havingRaw("count('uniqueID') > 1")
                    ->orderBy('rmcDate', 'DESC')
                    ->get();



        $yesterday = date('Y/m/d',strtotime("-1 days"));
        $dayB4yesterday = date('Y/m/d',strtotime("-2 days"));
        $today = date('Y-m-d');

        return view('layouts.emails.show', compact(
                    'buoyID',
                        'dataInfos',
                             'flagged',
                            'approved',
                            'today',
                            'yesterday',
                            'dayB4yesterday'
        ))->with('no', 1);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function edit(Data $data)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Data $data)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function destroy(Data $data)
    {
        //
    }


    public function simplifyBuoyData($dataInfos){
        $temperatures = array();
        $conductivities = array();


        foreach ($dataInfos as $dataInfo){

            unset($dataInfo->id);
            unset($dataInfo->buoy_id);

            unset($dataInfo->status);
            unset($dataInfo->filename);
            unset($dataInfo->deviceID);
            unset($dataInfo->bootID);
            unset($dataInfo->battery);

            unset($dataInfo->rmcTime);
            unset($dataInfo->rmcDate);
            unset($dataInfo->lat1);
            unset($dataInfo->lat2);
            unset($dataInfo->lon1);
            unset($dataInfo->lon2);

            unset($dataInfo->gotfix);
            unset($dataInfo->gps2);
            unset($dataInfo->xxx);
            unset($dataInfo->yyy);
            unset($dataInfo->zzz);
            unset($dataInfo->numBoardFound);

            unset($dataInfo->created_at);
            unset($dataInfo->updated_at);


            if ($dataInfo->messageID == 1):
                $temperature = array();
                array_push($temperature,
                    ((581-$dataInfo->data1)/12.16),
                    ((581-$dataInfo->data2)/12.16),
                    ((581-$dataInfo->data3)/12.16),
                    ((581-$dataInfo->data4)/12.16),
                    ((581-$dataInfo->data5)/12.16),
                    ((581-$dataInfo->data6)/12.16),
                    ((581-$dataInfo->data7)/12.16),
                    ((581-$dataInfo->data8)/12.16),
                    ((581-$dataInfo->data9)/12.16),

                    ((581-$dataInfo->data10)/12.16),
                    ((581-$dataInfo->data11)/12.16),
                    ((581-$dataInfo->data12)/12.16),
                    ((581-$dataInfo->data13)/12.16),
                    ((581-$dataInfo->data14)/12.16),
                    ((581-$dataInfo->data15)/12.16),
                    ((581-$dataInfo->data16)/12.16),
                    ((581-$dataInfo->data17)/12.16),
                    ((581-$dataInfo->data18)/12.16),
                    ((581-$dataInfo->data19)/12.16),
                    ((581-$dataInfo->data20)/12.16),

                    ((581-$dataInfo->data21)/12.16),
                    ((581-$dataInfo->data22)/12.16),
                    ((581-$dataInfo->data23)/12.16),
                    ((581-$dataInfo->data24)/12.16),
                    ((581-$dataInfo->data25)/12.16),
                    ((581-$dataInfo->data26)/12.16),
                    ((581-$dataInfo->data27)/12.16),
                    ((581-$dataInfo->data28)/12.16),
                    ((581-$dataInfo->data29)/12.16),
                    ((581-$dataInfo->data30)/12.16),

                    ((581-$dataInfo->data31)/12.16),
                    ((581-$dataInfo->data32)/12.16),
                    ((581-$dataInfo->data33)/12.16),
                    ((581-$dataInfo->data34)/12.16),
                    ((581-$dataInfo->data35)/12.16),
                    ((581-$dataInfo->data36)/12.16),
                    ((581-$dataInfo->data37)/12.16),
                    ((581-$dataInfo->data38)/12.16),
                    ((581-$dataInfo->data39)/12.16),
                    ((581-$dataInfo->data40)/12.16),
                    ((581-$dataInfo->data41)/12.16),
                    ((581-$dataInfo->data42)/12.16),
                    ((581-$dataInfo->data43)/12.16),
                    ((581-$dataInfo->data44)/12.16),
                    ((581-$dataInfo->data45)/12.16),
                    ((581-$dataInfo->data46)/12.16),
                    ((581-$dataInfo->data47)/12.16),
                    ((581-$dataInfo->data48)/12.16),
                    ((581-$dataInfo->data49)/12.16),
                    ((581-$dataInfo->data50)/12.16),

                    ((581-$dataInfo->data51)/12.16),
                    ((581-$dataInfo->data52)/12.16),
                    ((581-$dataInfo->data53)/12.16),
                    ((581-$dataInfo->data54)/12.16),
                    ((581-$dataInfo->data55)/12.16),
                    ((581-$dataInfo->data56)/12.16),
                    ((581-$dataInfo->data57)/12.16),
                    ((581-$dataInfo->data58)/12.16),
                    ((581-$dataInfo->data59)/12.16),
                    ((581-$dataInfo->data60)/12.16)
                    );
                array_push($temperatures, $temperature);

            elseif($dataInfo->messageID == 6):

                $conductivity = array();
                array_push($conductivity,
                    $dataInfo->data1,
                    $dataInfo->data2,
                    $dataInfo->data3,
                    $dataInfo->data4,
                    $dataInfo->data5,
                    $dataInfo->data6,
                    $dataInfo->data7,
                    $dataInfo->data8,
                    $dataInfo->data9,
                    $dataInfo->data10,
                    $dataInfo->data11,
                    $dataInfo->data12,
                    $dataInfo->data13,
                    $dataInfo->data14,
                    $dataInfo->data15,
                    $dataInfo->data16,
                    $dataInfo->data17,
                    $dataInfo->data18,
                    $dataInfo->data19,
                    $dataInfo->data20,
                    $dataInfo->data21,
                    $dataInfo->data22,
                    $dataInfo->data23,
                    $dataInfo->data24,
                    $dataInfo->data25,
                    $dataInfo->data26,
                    $dataInfo->data27,
                    $dataInfo->data28,
                    $dataInfo->data29,
                    $dataInfo->data30,
                    $dataInfo->data31,
                    $dataInfo->data32,
                    $dataInfo->data33,
                    $dataInfo->data34,
                    $dataInfo->data35,
                    $dataInfo->data36,
                    $dataInfo->data37,
                    $dataInfo->data38,
                    $dataInfo->data39,
                    $dataInfo->data40,
                    $dataInfo->data41,
                    $dataInfo->data42,
                    $dataInfo->data43,
                    $dataInfo->data44,
                    $dataInfo->data45,
                    $dataInfo->data46,
                    $dataInfo->data47,
                    $dataInfo->data48,
                    $dataInfo->data49,
                    $dataInfo->data50,
                    $dataInfo->data51,
                    $dataInfo->data52,
                    $dataInfo->data53,
                    $dataInfo->data54,
                    $dataInfo->data55,
                    $dataInfo->data56,
                    $dataInfo->data57,
                    $dataInfo->data58,
                    $dataInfo->data59,
                    $dataInfo->data60
                );

                array_push($conductivities, $conductivity);
            endif;

        }


        return array(
            'temperatures'  =>  $temperatures,
            'conductivities' => $conductivities
        );

    }





    public function singleData($operationID){

        // todo checking number of data

        // check the summery table with the rmcDate and rmcTIme
        $summaries = Summery::where('operationID', $operationID)->first();


        $datas = DB::table('data')
            ->where('uniqueID', $operationID)
            ->get();



        $dataInfos = DB::table('data')
            ->where('uniqueID', $operationID)
            ->get();




        $results = $this->simplifyBuoyData($datas);

        $temperatures = array_values($results['temperatures'][0]);
        $conductivities = array_values($results['conductivities'][0]);

        return view('layouts.emails.single', compact(['dataInfos', 'temperatures', 'conductivities', 'summaries', 'operationID']))->with('no', 1);
    }

    public function editData($operationID){
        // todo checking number of data

        // check the summery table with the rmcDate and rmcTIme
        $summaries = Summery::where('operationID', $operationID)->first();
        $datas = DB::table('data')
            ->where('uniqueID', $operationID)
            ->get();



        $dataInfos = DB::table('data')
            ->where('uniqueID', $operationID)
            ->get();

        $results = $this->simplifyBuoyData($datas);

        $temperatures = array_values($results['temperatures'][0]);
        $conductivities = array_values($results['conductivities'][0]);


        return view('layouts.emails.edit', compact(['dataInfos', 'temperatures', 'conductivities', 'summaries']))->with('no', 1);
    }


    public function flagData($operationID){
        // flagged ID is '5'
        Data::where('uniqueID', $operationID)
            ->update([
                'status'          => 5,
            ]);

        flashy()->success($operationID . ' has been flagged!!!');
        return back();
    }


}
