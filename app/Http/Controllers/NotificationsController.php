<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Profile;
use App\Notification;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        $notifs = Notification::where('user_id', $user_id)->orWhere('receiving_id', $user_id)->get();
        foreach ($notifs as $request) {
            if ($request->receiving_id === Auth::id()) {
                $request['received'] = true;
                $profile = Profile::where('user_id', $request->user_id)->first();
                if ($profile === null) {
                    $profile = ['ign'=>"User hasn't completed their profile.", 'friendCode' => '0'];
                }
            } else {
                $request['received'] = false;
                $profile = Profile::where('user_id', $request->receiving_id)->first();
            }
            $request['profile'] = $profile;
        }
        return $notifs;
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
        $request_check = Notification::where('user_id', $user_id)->where('receiving_id', $request->receiving_id)->count();
        if ($request_check === 0) {
            $validated_update = $request->validate([
                'receiving_id' => 'required',
            ]);
            $validated_update['status'] = 'default';
            $validated_update['user_id'] = $user_id;
            Notification::create($validated_update);
        }
        return (['message' => $request_check]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $notifs = Notification::findOrFail($id);
        $validated_update = $request->validate(['status' => 'required']);
        $form_input_sanitized = filter_var_array($validated_update, FILTER_SANITIZE_STRING);
        $notifs->update($form_input_sanitized);

        return (['message' => 'Notifcation Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Notification::destroy($id);
        return (['message' => 'Notification Deleted']);
    }
}
