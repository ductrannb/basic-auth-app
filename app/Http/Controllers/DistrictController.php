<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\District;

class DistrictController extends Controller
{
    public function getList(Request $request) 
    {
        $districts = District::when($request->province_id != null, function ($q) use ($request) {
            return $q->where('province_id', $request->province_id);
        })->get('id', 'name')->toArray()
        return response()->json(['data' => $districts]);
    }
}
