<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Unit;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Unit::all();
        return $units;
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
            'name' => 'required',
            'rarity' => 'required',
            'build' => 'required',
            'atk' => 'required',
            'def' => 'required',
            'mag' => 'required',
            'spr' => 'required',
        ]);
        $form_input_sanitized = filter_var_array($validated_create, FILTER_SANITIZE_STRING);
        $form_input_sanitized['user_id'] = $user_id;

        Unit::create($form_input_sanitized);
        return (['message' => 'Unit Added']);
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
        $user_id = Auth::id();

        $unit = Unit::where('user_id', $user_id)->findOrFail($id);
        $validated_create = $request->validate([
            'name' => 'required',
            'build' => 'required',
            'atk' => 'required',
            'def' => 'required',
            'mag' => 'required',
            'spr' => 'required',
        ]);
        $form_input_sanitized = filter_var_array($validated_create, FILTER_SANITIZE_STRING);
        $form_input_sanitized['user_id'] = $user_id;
        $unit->update($form_input_sanitized);

        return (['message' => 'Unit Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_id = Auth::id();

        $unit = Unit::where('user_id', $user_id)->findorfail($id);
        unit::destroy($unit->id);
        return (['message' => 'Unit Deleted']);
    }
}
