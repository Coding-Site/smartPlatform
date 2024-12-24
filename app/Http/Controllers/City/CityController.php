<?php

namespace App\Http\Controllers\City;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\City\CityResource;
use App\Models\City\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(){
        $cities = City::get();
        return ApiResponse::sendResponse(200,'All Cityies',CityResource::collection($cities));
    }
}
