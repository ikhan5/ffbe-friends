<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Results;

class ResultController extends Controller
{

    public function index()
    {
        $results = Results::orderBy('overall', 'DESC')->get();

        return $results;
    }

    public function updateOverall(Request $request)
    {
        $names = $request->input('unit');
        $points = 15;
        foreach ($names as $name) {
            $score = 0;
            $unit = Results::where('unit', $name['name'])->first();
            $score += ($points--) + $unit->overall;

            $unit->update(['overall' => $score]);
        }
        return ['message' => 'update successful'];
    }

    public function updateRole(Request $request)
    {
        $role = '';
        if ($request->input('role') === 'support') {
            $buffers = $request->input('buffers');
            $breakers = $request->input('breakers');
            $healers = $request->input('healers');
            $role = 'support';
        } elseif ($request->input('role') === 'damage') {
            $physDPS = $request->input('physDPS');
            $magDPS = $request->input('magDPS');
            $hybrids = $request->input('hybrids');
            $finishers = $request->input('finishers');
            $role = 'damage';
        } elseif ($request->input('role') === 'tank') {
            $role = 'tank';
        }

        return $role;
    }
}
