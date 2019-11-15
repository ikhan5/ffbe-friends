<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UnitRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Profile;

class UnitRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unit_requests = UnitRequest::get();
        $show_requests = [];
        $today = Carbon::now('America/Toronto');
        foreach ($unit_requests as $unit_req) {
            $difference = Carbon::parse($unit_req->created_at)->diffInDays($today);
            if ($difference < 2) {
                $profile = Profile::where('user_id', $unit_req->user_id)->first();
                $unit_req['profile'] = $profile;
                $unit_req['status'] = unserialize($unit_req->status);
                $unit_req['elemental'] = unserialize($unit_req->elemental);
                $unit_req['killers'] = unserialize($unit_req->killers);
                array_push($show_requests, $unit_req);
            }
        }
        return $show_requests;
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
        $validated_create = $request->validate([
            'unit_name' => 'required',
            'weapon_ele' => 'required',
            'details' => 'nullable',
            'killers' => 'nullable',
            'elemental' => 'nullable',
            'status' => 'nullable',
        ]);

        $form_input_sanitized = filter_var_array($validated_create, FILTER_SANITIZE_STRING);
        $form_input_sanitized['user_id'] = $user_id;
        $form_input_sanitized['killers'] = serialize($request->killers);
        $form_input_sanitized['elemental'] = serialize($request->elemental);
        $form_input_sanitized['status'] = serialize($request->status);

        UnitRequest::create($form_input_sanitized);
        return (['message' => 'Request Added']);
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
        //
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
