<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommunityController extends Controller{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $communities = Community::all();
        return view('layouts.communities.index', compact('communities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('layouts.communities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name'              =>  'required|unique:communities',
            'latitude'          =>  'required|numeric',
            'longitude'         =>  'required|numeric',

        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('communities.create')
                ->withErrors($validator)
                ->withInput();
        }

        Community::create([
                'name'      => $request->name,
                'latitude'      => $request->latitude,
                'longitude'     => $request->longitude,

        ]);

        notify()->success( $request->name ." created successfully!", "Community", "topRight");
        return redirect()
            ->route('communities.index')
            ->with('success', 'Community is successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function show(Community $community){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\\ModelsCommunity  $community
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Community $community){
        $community = Community::find($community->id);
        return view('layouts.communities.edit', compact('community'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\\ModelsCommunity  $community
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Community $community){
        $community->update($request->all());
        notify()->info($community->name . " updated successfully", "Community", "topRight");
        return redirect()
            ->route('communities.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\\ModelsCommunity  $community
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Community $community){
        $community->delete();
        notify()->success($community->name . " deleted successfully", "Community", "topRight");
        return redirect()->route('communities.index');
    }
}
