<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware('auth');
    }

    public function getUserByID($id){
        return User::with('profile')->where('id', $id)->firstOrFail();
    }

    public function index(){
        $users = User::all();
        return view('layouts.users.index', compact('users'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show($userID){
        //
        try{
            $user = $this->getUserByID($userID);
        }catch (ModelNotFoundException $exception){
            abort(404);
        }


        // get the userinformation
        return view('layouts.users.profile');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile){
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile){
        // check request information
        $request->validate([
            'firstname'         =>  'required',
            'lastname'          =>  'required',
            'address'          =>  'required',
            'city'              =>  'required',
            'state'             =>  'required',
            'zipcode'           =>  'required',
        ]);



        $profile->update([
            'position'          =>  $request->position,
            'other_email'       =>  $request->other_email,
            'office_phone'      =>  $request->office_phone,
            'personal_phone'    =>  $request->personal_phone,
            'address'           =>  $request->address,
            'city'              =>  $request->city,
            'state'             =>  $request->state,
            'zipcode'           =>  $request->zipcode
        ]);


        return view('layouts.users.profile');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
