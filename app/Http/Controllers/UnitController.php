<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Unit;
use App\Profile;
use App\User;
use Illuminate\Support\Carbon;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Unit::orderByDesc('updated_at')->get();
        $show_units = [];
        $today = Carbon::now('America/Toronto');
        foreach ($units as $unit) {
            $user = User::select('last_login')->where('id', $unit->user_id)->first();
            if ($unit->user_id === Auth::id()) {
                $unit['my_unit'] = 1; //true
            } elseif (Auth::id() === null || Auth::id() === '') {
                $unit['my_unit'] = 2; //not logged in
            } else {
                $unit['my_unit'] = 3; //false
            }
            $difference = Carbon::parse($user->last_login)->diffInDays($today);
            if ($difference < 15) {
                $profile = Profile::where('user_id', $unit->user_id)->first();
                $unit['profile'] = $profile;
                $unit['status'] = unserialize($unit->status);
                $unit['elemental'] = unserialize($unit->elemental);
                $unit['physkillers'] = unserialize($unit->physkillers);
                $unit['magkillers'] = unserialize($unit->magkillers);
                array_push($show_units, $unit);
            }
        }
        return $show_units;
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
        $profileCreated = Profile::where('user_id', $user_id)->first();
        $units_added = Unit::where('user_id', $user_id)->get();
        $unit_count = $units_added->count();

        if ($profileCreated && $unit_count < 10) {
            $validated_create = $request->validate([
                'name' => 'required',
                'rarity' => 'required',
                'build' => 'required',
                'atk' => 'required',
                'def' => 'required',
                'mag' => 'required',
                'spr' => 'required',
                'hp' => 'required',
                'mp' => 'required',
                'pevade' => 'required',
                'max_rarity' => 'required',
                'slot' => 'nullable',
                'element_weapon' => 'nullable',
                'lb_damage'=> 'nullable',
                'built_for'=> 'nullable'
            ]);

            $form_input_sanitized = filter_var_array($validated_create, FILTER_SANITIZE_STRING);
            $form_input_sanitized['user_id'] = $user_id;
            $form_input_sanitized['physkillers'] = serialize($request->physkillers);
            $form_input_sanitized['magkillers'] = serialize($request->magkillers);
            $form_input_sanitized['elemental'] = serialize($request->elemental);
            $form_input_sanitized['status'] = serialize($request->status);

            Unit::create($form_input_sanitized);
            return (['message' => 'Unit Added']);
        } elseif ($unit_count >= 10) {
            return (response(1, 500)); //unit count greater than 10
        } elseif (!$profileCreated) {
            return (response(2, 500)); // user hasnt created their profile
        } else {
            return (response(3, 500)); // server error
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
        $user_id = Auth::id();
        $units = Unit::where('user_id', $user_id)->get();
        return $units;
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
            'hp' => 'required',
            'mp' => 'required',
            'pevade' => 'required',
            'rarity' => 'required',
            'slot'=> 'nullable',
            'element_weapon'=>'nullable',
            'lb_damage' => 'nullable',
            'built_for'=> 'nullable'
        ]);
        $form_input_sanitized = filter_var_array($validated_create, FILTER_SANITIZE_STRING);
        $form_input_sanitized['user_id'] = $user_id;
        $form_input_sanitized['physkillers'] = serialize($request->physkillers);
        $form_input_sanitized['magkillers'] = serialize($request->magkillers);
        $form_input_sanitized['elemental'] = serialize($request->elemental);
        $form_input_sanitized['status'] = serialize($request->status);
        $unit->update($form_input_sanitized);

        return ($form_input_sanitized);
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
        Unit::destroy($unit->id);
        return (['message' => 'Unit Deleted']);
    }
}
