<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;

class ProvinceController extends Controller
{
    public function getList() 
    {
        return response()->json(['data' => Province::get(['id', 'name'])->toArray()]);
    }
}
