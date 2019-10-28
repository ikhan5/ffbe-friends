<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Profile;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        $user_info = Profile::where('user_id', $user_id)->get();
       
       return $user_info;
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
    public function store(Request $request)
    {
        $user_id = Auth::id();
        $validated_update = $request->validate([
            'ign' => 'required',
            'friendCode' => 'required',
        ]);
        $form_input_sanitized = filter_var_array($validated_update, FILTER_SANITIZE_STRING);
        $form_input_sanitized['user_id'] = $user_id;
        Profile::create($form_input_sanitized);

        return (['message' => 'User Added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user_id = Auth::id();
        $profile = Profile::where('user_id', $user_id)->findorFail($id);
        $validated_update = $request->validate([
            'ign' => 'required',
            'friendCode' => 'required',
        ]);
        $form_input_sanitized = filter_var_array($validated_update, FILTER_SANITIZE_STRING);
        $form_input_sanitized['user_id'] = $user_id;
        $profile->update($form_input_sanitized);

        return (['message' => 'Profile Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
