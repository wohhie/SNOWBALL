<?php

namespace App\Http\Controllers;

use App\Community;
use App\Qumatik;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class QumatikController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(){
        if (!Redis::exists('qumatiks:all')){
            $qumatiks = Qumatik::with('community')->get();
            serialize(Redis::set('qumatiks:all', $qumatiks));
        }else{
            $qumatiks = unserialize(Redis::get('qumatiks:all'));
        }

        return view('layouts.qumatiks.index', compact('qumatiks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $communities = Community::all();
        return view('layouts.qumatiks.create', compact('communities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'imei'              => 'required|unique:qumatiks',
            'community_id'      => 'required',
            'latitude'          => 'required|numeric',
            'longitude'         => 'required|numeric',
            'status'            => 'required',
            'dropbox_dir'       => 'required'
        ]);

        if ($validator->fails()) {
            notify()->error("Duplicate IMEI!!", "SmartQUMATIK","topRight");
            return redirect('qumatiks/create')
                ->withInput();
        }

        Qumatik::create([
            'imei'              => $request->imei,
            'latitude'          => $request->latitude,
            'longitude'         => $request->longitude,
            'status'            => $request->status,
            'dropbox_dir'       => $request->dropbox_dir,
            'community_id'      => $request->community_id,
            'user_id'           => Auth::id()
        ]);


        // information updated.
        // todo: change the database
        notify()->success("SmartQUMATIK created","SmartQUMATIK","topRight");
        return redirect()->route('qumatiks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Qumatik $qumatik
     * @return \Illuminate\Http\Response
     */
    public function show(Qumatik $qumatik){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Qumatik $qumatik
     * @return \Illuminate\Http\Response
     */
    public function edit(Qumatik $qumatik){
        //
        $communities = Community::all();
        $qumatik = Qumatik::find($qumatik->id);
        return view('layouts.qumatiks.edit', compact('communities', 'qumatik'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Qumatik $qumatik
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Qumatik $qumatik){
        $qumatik->update($request->all());
        notify()->info(" updated successfully!!","SmartQUMATIK","topRight");
        return redirect()->route('qumatiks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Qumatik $qumatik
     * @return \Illuminate\Http\Response
     */
    public function destroy(Qumatik $qumatik){
        $qumatik->delete();
        notify()->warning("SmartQUMATIK deleted successfully!!", "SmartQUMATIK", "toRight");
        return redirect()->route('qumatiks.index');
    }
}
