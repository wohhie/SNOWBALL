<?php

namespace App\Http\Controllers;

use App\Buoy;
use App\Qumatik;
use App\Role;
use App\Summery;
use App\User;
use DemeterChain\B;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');

        $pendings = Summery::where('status', '0')->get();
        $pendingCount = Summery::where('status', 0)->count();
        session()->put('pendings', $pendings);
        session()->put('pendingCount', $pendingCount);
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request){
        $request->user()->authorizeRoles(['operator', 'manager']);

        // per page fetch 10 items
        $buoys = Buoy::all();
        $qumatiks = Qumatik::all();



        // Check active buoys and qumatiks
        $active_buoys = Buoy::where('status', 1)->count();
        $active_qumatiks = Qumatik::where('status', 1)->count();

        // Check inactive buoys and qumatiks
        $inactive_buoys = Buoy::where('status', 0)->count();
        $inactive_qumatiks = Qumatik::where('status', 0)->count();

        // Dashboard total information
        $total_buoys = Buoy::all()->count();
        $total_qumatiks = Qumatik::all()->count();
        // for pagination
        // $index = $buoys->currentPage() * $buoys->perPage() - $buoys->perPage() + 1;

        // Getting user information
        $users = User::all()->count();


        return view('backend.pages.index', compact(
            'total_buoys',
            'total_qumatiks',
            'active_buoys',
            'active_qumatiks',
            'inactive_buoys',
            'inactive_qumatiks',
            'buoys',
            'qumatiks',
            'users'));
    }



    public function register(){
        $roles = Role::all();
        return view('layouts.users.register', compact('roles'));
    }


    public static function getBuoyTotalOperation($buoyID, $flag = 3){
        // total operation = 0
        if($flag === 0){
            // Flag === 0: Total Processed!
            $processed_operations = DB::table('data')
                ->where('buoy_id', $buoyID)
                ->groupBy('deviceID', 'rmcTime', 'rmcDate')
                ->havingRaw("count('rmcDate') > 1")
                ->get()->count();

            return $processed_operations;

        }else if($flag === 1){
            // Flag === 1: Processed!
            // database 'status' == 1
            $processed_operations = DB::table('data')
                ->where('buoy_id', $buoyID)
                ->where('status', 4)
                ->groupBy('deviceID', 'rmcTime', 'rmcDate')
                ->havingRaw("count('rmcDate') > 1")
                ->get()->count();

            return $processed_operations;

        }else if($flag === 2){
            // Flag === 2: Unprocessed!
            // database 'status' == 0
            $processed_operations = DB::table('data')
                ->where('buoy_id', $buoyID)
                ->where('status', 5)
                ->groupBy('deviceID', 'rmcTime', 'rmcDate')
                ->havingRaw("count('rmcDate') > 1")
                ->get()->count();

            return $processed_operations;

        }else if($flag === 3){
            // Flag === 2: Unprocessed!
            // database 'status' == 0
            $processed_operations = DB::table('data')
                ->where('buoy_id', $buoyID)
                ->where('status', 1)
                ->groupBy('deviceID', 'rmcTime', 'rmcDate')
                ->havingRaw("count('rmcDate') > 1")
                ->get()->count();

            return $processed_operations;
        }


    }

}
