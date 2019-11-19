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
            $createdTime = new Carbon($unit_req->created_at);
            $difference = Carbon::parse($createdTime)->diffInHours($today);
            if ($difference < 48) {
                $profile = Profile::where('user_id', $unit_req->user_id)->first();
                $unit_req['profile'] = $profile;
                $unit_req['status'] = unserialize($unit_req->status);
                $unit_req['elemental'] = unserialize($unit_req->elemental);
                $unit_req['killers'] = unserialize($unit_req->killers);
                $unit_req['difference']= $difference;
                array_push($show_requests, $unit_req);
            } else {
                $this->destroy($unit_req->id);
            }
        }
        return $show_requests;
    }


    public function getUserRequests()
    {
        $user_id = Auth::id();

        $user_reqs = UnitRequest::where('user_id', $user_id)->get();
        $today = Carbon::now('America/Toronto');
        foreach ($user_reqs as $user_req) {
            $createdTime = new Carbon($user_req->created_at);
            $difference = Carbon::parse($createdTime)->diffInHours($today);
            $user_req['difference'] = $difference;
            if ($difference >= 48) {
                $this->destroy($user_req->id);
            }
        }
        return $user_reqs;
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
        $active_requests = UnitRequest::where('user_id', $user_id)->get();
        $request_count = $active_requests->count();
        if ($request_count < 2) {
            $validated_create = $request->validate([
                'unit_name' => 'required',
                'weapon_ele' => 'required',
                'details' => 'nullable',
                'killers' => 'nullable',
                'elemental' => 'nullable',
                'status' => 'nullable',
                'trial_name' => 'nullable',
            ]);

            $form_input_sanitized = filter_var_array($validated_create, FILTER_SANITIZE_STRING);
            $form_input_sanitized['user_id'] = $user_id;
            $form_input_sanitized['killers'] = serialize($request->killers);
            $form_input_sanitized['elemental'] = serialize($request->elemental);
            $form_input_sanitized['status'] = serialize($request->status);

            UnitRequest::create($form_input_sanitized);
            return (['message' => 'Request Added']);
        } elseif ($request_count >= 2) {
            return (response(1, 500)); // requests more than 1
        } else {
            return (response(2, 500)); //server error
        }
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
        $unit_req = UnitRequest::findorfail($id);
        UnitRequest::destroy($unit_req->id);
        return (['message' => 'Request Deleted']);
    }
}
