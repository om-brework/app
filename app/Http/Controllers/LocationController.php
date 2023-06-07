<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getLocations(Request $request)
    {
        $locations = Location::skip($request->skip)->take($request->limit)->get();
        $totalRecords = Location::all()->count();
        $message = "fetching success";
        $data = ['data' => $locations, 'totalRecords' => $totalRecords, 'message' => $message];
        return response()->json($data, 200);
    }
    public function store(Request $request)
    {
        try {
            $request->validate([]);
            $location = new Location;
        } catch (\Throwable $th) {
        }
    }
}
