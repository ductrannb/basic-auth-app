<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ward;

class WardController extends Controller
{
    public function getList(Request $request) 
    {
        $wards = Ward::when($request->district_id != null, function ($q) use ($request) {
            return $q->where('district_id', $request->district_id);
        })->get(['id', 'name'])->toArray()
        return response()->json(['data' => $wards]);
    }
}
