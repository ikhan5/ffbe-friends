<?php

namespace App\Http\Controllers;

use App\Rankings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RankingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ballots = Rankings::get();
        $rankings = [];

        foreach ($ballots as $ballot) {
            $ballot = unserialize($ballot->ballot);

            array_push($rankings, $ballot);
        }

        return $rankings;
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
        $validated_create = $request->validate(['ballot' => 'required', 'ballot_type' => 'required']);
        $form_input_sanitized = filter_var_array($validated_create, FILTER_SANITIZE_STRING);
        $form_input_sanitized['user_id'] = $user_id;
        $form_input_sanitized['ballot'] = serialize($request->ballot);
        Rankings::create($form_input_sanitized);

        return (['message' => 'User Voted']);
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
    public function update(Request $request)
    {
        // $user_id = Auth::id();
        // if ($request->ballot_type === 'overall') {
        //     $ballot = Rankings::where([
        //         ['user_id', '=', $user_id],
        //         ['ballot_type', '=', 'overall']
        //     ]);
        //     $validated_create = $request->validate(['ballot' => 'required', 'ballot_type' => 'required']);
        //     $form_input_sanitized = filter_var_array($validated_create, FILTER_SANITIZE_STRING);
        //     $form_input_sanitized['user_id'] = $user_id;
        //     $form_input_sanitized['ballot'] = serialize($request->ballot);
        //     $ballot->update($form_input_sanitized);
        // }

        // if ($request->ballot_type === 'role') {
        //     $ballot = Rankings::where([
        //         ['user_id', '=', $user_id],
        //         ['ballot_type', '=', 'role']
        //     ]);
        //     $validated_create = $request->validate(['ballot' => 'required', 'ballot_type' => 'required']);
        //     $form_input_sanitized = filter_var_array($validated_create, FILTER_SANITIZE_STRING);
        //     $form_input_sanitized['user_id'] = $user_id;
        //     $form_input_sanitized['ballot'] = serialize($request->ballot);
        //     $ballot->update($form_input_sanitized);
        // }

        // return (['message' => 'Ballot Updated']);
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

    public function checkOverallVoteStatus()
    {
        $user_id = Auth::id();
        $rankings = [];
        if (Rankings::where([
            ['user_id', '=', $user_id],
            ['ballot_type', '=', 'overall']
        ])->exists()) {
            $ballots = Rankings::where([
                ['user_id', '=', $user_id],
                ['ballot_type', '=', 'overall']
            ])->get();

            foreach ($ballots as $ballot) {
                $ballot = unserialize($ballot->ballot);

                array_push($rankings, $ballot);
            }
        }
        return $rankings;
    }

    public function checkRoleVoteStatus()
    {
        $user_id = Auth::id();
        $rankings = [];
        if (Rankings::where([
            ['user_id', '=', $user_id],
            ['ballot_type', '=', 'role']
        ])->exists()) {
            $ballots = Rankings::where([
                ['user_id', '=', $user_id],
                ['ballot_type', '=', 'role']
            ])->get();

            foreach ($ballots as $ballot) {
                $ballot = unserialize($ballot->ballot);
                array_push($rankings, $ballot);
            }
        }
        return $rankings;
    }
}
