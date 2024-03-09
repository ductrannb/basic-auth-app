<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Province;

class ProvinceController extends Controller
{
    public function getList() 
    {
        return response()->json(['data' => Provice::get('id', 'name')->toArray()]);
    }
}
